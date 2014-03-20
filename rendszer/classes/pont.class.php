<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság 



class Pont extends baseModel {

	protected $table='pontok';
	protected $idName='pid';
	
	
	
	
	function addPont( $uid, $event, $pont=false ){
		
		$data['uid']=$uid;
		$data['event']=$event;
		
		if( !empty($pont) && is_numeric($pont) ){
			$data['pont']=(int)$pont;
		}
		else{
			$data['pont']=$GLOBALS['PONT_EVENTS'][$event]['value'];
		}
		$data['date']=date('Y-m-d H:i:s');
		
		return $this->add( $data );
	}
	
	
	
	
	
	function evenCountChecker( $event , $uid ){
		$sql="select count(*) as ez from " .$this->table. " where event in( %s ) and date = '%s' and uid='%d'";
		
		if( is_numeric( $event ) ){
			$eventMod = $event;
		}
		elseif( is_array( $event ) ){
			$eventMod = implode(',', $event);
		}
		else{
			return 100;
		}
		
		db::futat($sql,$eventMod,date('Y-m-d'),$uid );
		return db::egy_ertek();
	}
	
	
	function addBelep(){
		$event=0;
		$uid=$GLOBALS['USER']['uid'];
		if( $this->evenCountChecker( $event, $uid) < 1 ){
			$this->addPont( $uid, $event );
		}
		return;
	}
	
	function addTorrentFeltolt( $meret ){
	
		if( $meret > (800 * 1024 * 1024) ){
			$event=12;
		}
		elseif( $meret > (200 * 1024 * 1024) ){
			$event=11;
		}
		else{
			$event=10;
		}
		$uid=$GLOBALS['USER']['uid'];
		
		if( $this->evenCountChecker( array(10,11,12), $uid ) < 3){
			
			$this->addPont( $uid, $event );
			
		}
		
		return ;	
	
	}
	
	
	
	function addTrackerFeltolt( $meret, $uid ){
		//meret > 500MB
		if( $meret > (500 * MB) ){
			$this->addTrackerFeltoltAdmin( 1, $uid );
		}
		
		//meret > 1GB
		if( $meret > ( 1 * GB) ){
			$this->addTrackerFeltoltAdmin( 2, $uid );
		}
		
		//meret > 3GB
		if( $meret > ( 3 * GB) ){
			$this->addTrackerFeltoltAdmin( 3, $uid );
		}
		
		return;
	}
	
	function addTrackerFeltoltAdmin( $event, $uid ){
		if( $this->evenCountChecker( $event, $uid) < 1 ){
			$this->addPont( $uid, $event );
		}
		return;	
	}
	
	function addBan( $uid ){
		return self::addPont( $uid, 31 );
	}
	
	function addWarn( $uid ){
		return self::addPont( $uid, 30 );
	}
	
	
	function checkPont( $uid, $min ){
		
		$sql="select sum( pont ) from pontok  where uid='%d' ";
		$pont=db::getOne( $sql, (int)$uid );
		
		if( $pont >= $min ){
			return true;
		}
		else{
			return false;
		}	
	}
	
	



}//end class
?>