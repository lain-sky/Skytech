<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság 



class Kerek extends baseModel {

	protected $table='kerek';
	protected $idName='kid';


	function pontLevon( $pontDB=false ){
		$pont= new Pont();
		return $pont->addPont( $GLOBALS['USER']['uid'], 40 , $pontDB);
	}
	
	function pontCheck( $pontDB=false ){
		
		if( !empty($pontDB) ){
			$min=$pontDB;
		}
		else{
			$min=abs( $GLOBALS['PONT_EVENTS'][40]['value'] );
		}		
		$pont= new Pont();
		return $pont->checkPont( $GLOBALS['USER']['uid'], $min );
	}
	
	function addItem( $kid, $pont){
		
		$uid=$GLOBALS['USER']['uid'];
		
		$sql="insert into kerek_item(kid,uid,pont) values('%d', '%d', '%d')";
		db::futat($sql, $kid, $uid, $pont );
		
		$this->pontLevon( ($pont * (-1) ) );
	}
	
	
	function getList( $where=array(),$order='',$limit='' ){
		
		$sql="select SQL_CALC_FOUND_ROWS k.*,u.name as username ,u.rang, kat.nev,kat.leir,kat.kep, 
		(select count(*) from kerek_item k1 where k1.kid=k.kid group by k1.kid ) as kertek,	
		(select sum(pont) from kerek_item k1 where k1.kid=k.kid group by k1.kid ) as pontok
		FROM kerek k 
		LEFT JOIN users u on u.uid=k.uid
		LEFT JOIN  kategoria kat on kat.kid=k.kat_id		
		";
		
		if( count( $where ) > 0 ){
			$sql.= ' where ' . implode(' and ' , $where );
		}
		
		if(!empty($order))
			$sql.=" order by " . $order;
		
		if(!empty($limit)){
			$sql.=" limit " . $limit;
		}
		
		
		
		$kesz=array();
		foreach( db::getAll( $sql ) as $key=>$val){	
					
			foreach($val as $k=>$v){
				switch( $k ){
					
					case 'text':
						$kesz[$key]['megjegyzes']=bb::bbdecode($v);
						$kesz[$key][$k]= $v;
					break;
					
					case 'kertek':
						$kesz[$key][$k]= (int)$v + 1;
					break;
					
					case 'pontok' :
						$kesz[$key][$k]= (int)$v + abs( $GLOBALS['PONT_EVENTS'][40]['value'] );
					break;
					
					case 'datum':
						$kesz[$key]['kerve']= current( explode(' ', $v) );
						$kesz[$key][$k]= $v;
					break;
					
					case 'uid':
						if( $GLOBALS['USER']['uid'] == $v ){
							$kesz[$key]['sajat']= true;
						}
						$kesz[$key][$k]= $v;
					break;
					
					default:
						$kesz[$key][$k]= $v;
					break;
				}				
			}				
		}
		
		return $kesz;	
	}
	
	
	
	function isModified( $kid ){
	
		$keres = $this->getById( $kid );
		
		if( $GLOBALS['USER']['rang'] >= KERESEK_ADMIN_MIN_RANG || $GLOBALS['USER']['uid'] == $keres['uid'] ){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function pontJovair( $tid ){
		$kid = db::getOne("select keres_id from torrent where tid='%d' ", $tid );
		if( !empty( $kid ) && is_numeric( $kid ) ){
		
			if( db::getOne("select status from kerek where kid='%d'", $kid ) == 'aktiv'  ){
				
				$sumPont = db::getOne("select sum(pont) from kerek_item  where kid='%d'", $kid ) + abs( $GLOBALS['PONT_EVENTS'][40]['value'] ) ;
				$pontUser = db::getOne("select uid from torrent where tid='%d' ", $tid );
				
				$pont= new Pont();
				$pont->addPont( $pontUser , 42 ,$sumPont);
				
				db::futat("update kerek set  status = 'teljesitve' where kid='%d' ", $kid );
				db::futat("update torrent set  keres_jovairva = 'yes' where tid='%d' ", $tid );
			}
		}
	}
	

}//end class
?>