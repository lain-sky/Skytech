<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

define('CHAT_AKTIV_LIMIT',300);


class chat{
	
	function addSzoba($nev,$leiras){
		if(!empty($nev)){
			$sql="insert into chat_szoba(nev,leiras) values('%s','%s')";
			db::futat($sql,$nev,$leiras);
		}
	}
	
	function delSzoba($id){
		if(!empty($id) && is_numeric($id)){
			$sql="delete from chat_szoba where cszid='%d'";
			db::futat($sql,$id);
			
			$sql="delete from chat where cszid='%d'";
			db::futat($sql,$id);
		}
	}
	
	function getSzoba($id=null){
		if($id===null){
			$sql="select * from chat_szoba order by nev";
			db::futat($sql);
			return db::tomb();
		}
		else{
			$sql="select * from chat_szoba where cszid='%d' order by nev";
			db::futat($sql,$id);
			return db::elso_sor();
		}			
	}
	
	function updateSzoba($id,$nev,$leiras){
		if(!empty($id) && is_numeric($id) && !empty($nev) ){
			$sql="update chat_szoba set nev='%s', leiras='%s' where cszid='%d'";
			db::futat($sql,$nev,$leiras,$id);
		}	
	}
	
	function getSzobaListaAjax(){
		//$sql="select *, (select count( distinct( c.uid)  ) from chat c where c.cszid=sz.cszid and UNIX_TIMESTAMP(c.datum)>'%d') as userek from chat_szoba sz order by sz.nev";
		$sql="select *, (select count( distinct( c.uid)  ) from chat c where c.cszid=sz.cszid and UNIX_TIMESTAMP(c.datum)> ( UNIX_TIMESTAMP( now() ) -  600) )as userek from chat_szoba sz WHERE cszid !=14 order by sz.nev";
		
		
		db::futat($sql);
		
		//d::addText('Chat',db::$parancs);
		//d::send(true);
		
		return db::tomb();
	}
	
	function getUserInSzoba($id){
		$sql="select (select name from users u where u.uid=c.uid ) as name from chat c where cszid='%d' and UNIX_TIMESTAMP(datum)>'%d' group by c.uid";
		db::futat($sql,$id,(time() - CHAT_AKTIV_LIMIT ));
		return db::tomb();
	}
	
	function getHsz($id, $limit=false ){		
		$tol=&$_SESSION['chat'][$id];		
		$sql="select *,UNIX_TIMESTAMP(datum) as moddatum,
		(select name from users u where u.uid=c.uid ) as name,
		(select rang from users u where u.uid=c.uid ) as rang 
		from chat c where cszid='%d'";		
		
		if( $limit !== false ){
			$sql.=" order by cid desc ";
			$sql.=" limit  " . $limit;
		}
		elseif(is_numeric($tol)){
			$sql.=" and cid > ".$tol;
			$sql.=" order by cid desc ";
		}
		else{
			$sql.=" order by cid desc ";
			$sql.=" limit 1 ";
		}
		
		db::futat($sql,$id);
		$tomb=db::tomb();
		
		if(count($tomb)>0){
			$tol=$tomb[0]['cid'];			
		}
		return $tomb;		
	}
	
	function addHsz($id,$text){
		$sql="insert into chat(cszid,uid,text,datum) values('%d','%d','%s','%s')";
		db::futat($sql,$id,$GLOBALS['USER']['uid'],$text,date('Y.m.d H:i:s'));
	}
	
	function addBelepes($id){
		$ki=$GLOBALS['USER']['name'];
		$text='##automatikus_uzi##[color=green][b]'.$ki.' belépett a szobába :!: [/b][/color]';
		chat::addHsz($id,$text);	
	}
	
	function delHsz( $id ){
		$sql=" delete from chat where cid='%d' ";
		db::futat( $sql,$id);
	}
	
	function szobaKiurit( $id ){
		$sql=" delete from chat where cszid='%d' ";
		db::futat( $sql,$id);
	}







}


?>