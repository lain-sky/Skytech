<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság


/****************************************/
/* Adatbázis feladatokat végzóõ osztály */
/****************************************/
class db{
	public static $kapcsolat=false;
	public static $eredmeny=false;	
	public static $sorok=false;
	public static $sorok2=false;
	public static $id=false;
	public static $sql_time=0;
	public static $sql_num=0;
	public static $parancs=false;
	public static $querys = array() ;
	
	protected static $reConnect=0;
	
	private function __construct(){}
	
	/**
	*kapcsolodik az adabázishoz
	*
	*@return bool treu/false
	*/
	public function kapcsolodas(){
		if(self::$kapcsolat===false){
			self::$kapcsolat=mysql_connect(DB_host, DB_user,DB_pass);
			if(!mysql_select_db(DB_data,self::$kapcsolat)){
				
				if( self::$reConnect < 10 ){
					sleep(2);
					self::$reConnect++;
					return self::kapcsolodas();
				}
				else{
					return self::hiba(" reConnect:" . self::$reConnect);
				}		
			}
			self::futat("SET NAMES LATIN2");
			//self::futat("SET COLLATION_CONNECTION=LATIN2_GENERAL_CI");
			return (self::hiba('betuk')===true)? true:false;			
		}
		return true;
	}
	
	/**
	* hibákat kezeli
	*/
	public function hiba($mit){
		if(mysql_error()){
			if(SQL_MAIL===true){
				self::sqlMail($mit,mysql_error());
			}
			if(SQL_LOGS===true){
				self::sqlLogs($mit,mysql_error());
			}
			
			if(SQL_DEBUG===true){
				echo $mit."<br />";
				echo mysql_error();
				exit;
			}
			else{
				die(OLDAL_HIBA);
			}
			self::$eredmey=false;
			return false;
		}
		return true;	
	}

	/**
	* sql parancs futatása
	*
	* example: "Select * from table where year='2007' and name='bob'"
	*			or
	*			"Select * from table year='%d' and name='%s',$year,$name"
	*/	
	public function futat(){
		self::$sorok=false;
		self::$sorok2=false;
		self::$eredmeny=false;
		self::$id=false;
		if( !is_resource( self::$kapcsolat ) ) self::kapcsolodas();
		$args  = func_get_args();
		$query = array_shift($args);
		if(count($args)!=0){
			$args  = array_map('addslashes', $args);
			array_unshift($args, $query);
			$query = call_user_func_array('sprintf', $args);
		}
		$start = microtime(TRUE);	
		$ered=mysql_query($query);	
		$end = microtime(TRUE);	
		if(self::hiba($query)===false) return false;
		self::$parancs=$query;
		self::$sorok= @mysql_num_rows($ered);
		self::$sorok2=@mysql_affected_rows();
		self::$id= @mysql_insert_id();
		self::$sql_time += ($end - $start);
		self::$sql_num++;
		self::$eredmeny=$ered;

		if( SQL_DEBUG == true ){
			self::$querys[] = array( "query" => $query, "time"=> ($end - $start) );
		}
		
		self::sqlFileLog();
		return true;
	}

	/**
	* Az adatokat kinyaerjük az az erõforásból
	*
	*@return array or object
	*/
	public function tomb($mit='mind'){
		if(self::$eredmeny===false) return false;
		$tomb=array();
		while($sor=mysql_fetch_assoc(self::$eredmeny)){
			foreach($sor as $key=>$val){
				$sor[$key]=stripslashes($val);
			}	
			$tomb[]=($mit=='mind')? $sor:$sor[$mit];
		}	
		return $tomb;
	}
	
	/**
	* egy értéket add vissza az ADATBÁZISBÓL
	*
	*/
	public function egy_ertek($mit='ez'){
		$value=false;
		$row = self::tomb();
		$value=$row[0][$mit];
		return $value;
	}

	public function sor($x=0,$y='id'){
		$tomb=self::tomb();
		return $tomb[$x][$y];
	}

	public function elso_sor(){
		$tomb=self::tomb();
		return $tomb[0];
	}
	
	public function getRow(){
		$args  = func_get_args();
		call_user_func_array(array('db','futat'), $args );
		return self::elso_sor();
	}
	
	public function getAll(){
		$args  = func_get_args();
		call_user_func_array(array('db','futat'), $args );
		return self::tomb();
	}
	
	public function getOne(){
		$args  = func_get_args();
		call_user_func_array(array('db','futat'), $args );
		$return = array_values( self::elso_sor() );
		return $return[0];		
	}
	
	
	public function bezar(){
		mysql_close(self::$kapcsolat);
		self::$kapcsolat=false;
	}

	 function __destruct(){
		//mysql_close(self::$kapcsolat);
		//self::$kapcsolat=false;
	}
	
	function hardClose(){
		@mysql_close(self::$kapcsolat);
		self::$kapcsolat=false;
	}

	function sqlMail($parancs,$error){
		$subject="SkyTech SQL hiba";
		$cim=DEBUG_MAIL;
		$uzi ="Parancs:\n".$parancs;
		$uzi.="\nOldalon a hibas parancs:".(self::$sql_num-1)." -dik\n";
		$uzi.="\n\nError\n:".$error;
		$uzi.="\n\n_GET\n";
		$uzi.=var_export($_GET,true);
		$uzi.="\n\n_POST\n";
		$uzi.=var_export($_POST,true);
		$uzi.="\n\n_SERVER\n";
		$uzi.=var_export($_SERVER,true);
		$uzi.="\n\n_SESSION\n";
		$uzi.=var_export($_SESSION,true);
		mail($cim,$subject,$uzi);	
	}

	function sqlLogs($parancs,$error){
		$uzi ="Tracker hiba";
		$uzi.="Parancs:\n".$parancs;
		$uzi.="\n\nError\n:".$error;
		$uzi.="\n\n_GET\n";
		$uzi.=var_export($_GET,true);
		$uzi.="\n\n_SERVER\n";
		$uzi.=var_export($_SERVER,true);
	}
	
	
	function sqlFileLog(){
		$logolni=false;
		
		if(SQL_QUERY_LOG == true){
			if( strpos( self::$parancs, 'update' ) !== false ){
				$logolni = true;
			}
		}
		
		
		if($logolni == true){
			
			$file=ROOT_DIR . 'logs/sql/' . date('Ymd') . '.txt';
			$content= date('H:i:s') . '-' . $GLOBALS['USER']['uid'] . ' - ' .  self::$parancs ."\n";
			@error_log( $content , 3 , $file );		
			
		}
		
	}

}//end class



?>