<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság


class Staff{
	
	
	function addLevel( $torzs ,$targy ){
		$tulaj=OLDAL_MAIL_USER_ID;
		$partner=$GLOBALS['USER']['uid'];
		level::felad($tulaj,$partner,$targy,$torzs);
	}
	
	
	function addValasz( $torzs ,$targy, $parent ){
		$sql="select partner from levelek where lid='%d'";
		db::futat($sql,$parent);
		$partner=db::egy_ertek('partner');
		
		$sql="insert into levelek(tulaj,partner,parent,datum,targy,torzs,status) values('%d','%d','%d','%d','%s','%s','%s')";
		db::futat($sql,$partner,OLDAL_MAIL_USER_ID,$parent,time(),$targy,$torzs,'u');
		db::futat($sql,OLDAL_MAIL_USER_ID,$partner,0 ,time(),$targy,$torzs,'n');
	
	}
	
	
	
	
	/*
	function getLevelek(){
		$sql="select lid from levelek  where tulaj='%d' order by datum desc limit 50";		
		db::futat($sql, OLDAL_MAIL_USER_ID );
		foreach( db::tomb() as $row ) $ids[]=$row['lid'];
		return self::loadLevel( $ids,  'order by datum desc limit 50'  );		
	}
	*/
	function getLevelek(){
		$sql="select l.*,
				(select count(*) from levelek l2 where l.lid=l2.parent ) as valaszok,
				(select u.name from users u where l.partner= u.uid ) as partner_nev
			from levelek l where l.tulaj='%d' and l.status='u' order by datum desc limit 50";
		
		db::futat($sql, OLDAL_MAIL_USER_ID );	
		//d(db::$parancs);
		return self::processLevel( db::tomb() );		
	}
	
	
	function getChilden( $levelId ){
		$sql="select lid from levelek where parent='%d'";
		db::futat($sql, $levelId);
		foreach( db::tomb() as $row ) $ids[]=$row['lid'];
		return self::loadLevel( $ids,  'order by datum '  );		
	}
	
	
	
	
	function loadLevel( $lid, $desc='order by l.lid'){
		
		if( is_numeric($lid) ){
			$modLid=$lid;
		}
		elseif( is_array($lid) ){
			$modLid=implode(',',$lid);
		}
		else{
			return false;
		}
		
		$sql="select l.*,
				(select count(*) from levelek l2 where l2.lid=l.parent ) as valaszok,
				(select u.name from users u where l.partner= u.uid ) as partner_nev,
				(select u2.name from users u2 where l.tulaj= u2.uid ) as tulaj_nev
			from levelek l where (l.tulaj='%d' or l.partner='%d') and l.lid in( %s ) " .$desc;
		db::futat($sql, OLDAL_MAIL_USER_ID, OLDAL_MAIL_USER_ID, $modLid );	
		return self::processLevel( db::tomb() );
	}
	
	
	
	private function processLevel( $tomb ){
		$kesz=array();
		foreach( $tomb as $i=>$row ){
			foreach( $row as $key=>$val){
				switch($key){
					
					case 'datum':
						$kesz[$i][$key]=date('Y-m-d H:i:s', $val);
					break;
					
					case 'torzs':
						$kesz[$i]['torzsKonvert']=bb::bbdecode( $val );
						$kesz[$i]['lead']= htmlspecialchars( str_replace( '<br/>',' ', substr( $val, 0, 75) ) ) . '...';
						$kesz[$i][$key]=$val;
					break;		
					case 'tulaj':
					case 'partner':
						//$kesz[$i][$key.'_avatar']=user::getAvatarById( $val );
									
						if( $val != OLDAL_MAIL_USER_ID ){
							$kesz[$i]['luser']=$val;
							$kesz[$i]['luser_avatar']=user::getAvatarById( $val );
						}
						else{
							$kesz[$i]['rendszer']=$val;
							$kesz[$i]['rendszer_avatar']=user::getAvatarById( $val );
						}
						$kesz[$i][$key]=$val;
					break;	
					
					default:
						$kesz[$i][$key]=$val;
					break;				
				}
			}
		}
		//d($kesz);
		return $kesz;
	}
	
	
	function levelTorol( $levelId ){
		$pari="update levelek set status='n' where tulaj='%d' and lid='%d' ";
		db::futat($pari,OLDAL_MAIL_USER_ID,$levelId);
	}
	
	
	


}//end class
?>