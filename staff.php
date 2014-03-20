<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');
require_once( CLASS_DIR . 'staff.class.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése
	

	if(!empty($p['text'])){
		$subject = OLDAL_NEVE ." - Staff értesítõ";
		$headers  = "Content-type: text/plain\r\n";
		$mail_szoveg ="Hi!\nA(z) ".$USER['name']." user (".$USER['uid'].") ezt az üzit küldte:\n\n";
		$mail_szoveg.=$p['text'];
		mail('szicsu.debug@gmail.com', $subject, $mail_szoveg, $headers);		
		
		if( $p['valasz']=='igen' ){
			Staff::addValasz( $p['text'], $p['tema'], $p['parent'] );
		}
		else{
			Staff::addLevel( $p['text'], $p['tema']);
		}
		//level::staffLevel( $mail_szoveg );

		$_SESSION['uzenet']=nyugta('A levelet kiküldtük!');
		header('Location: staff.php');
		exit;
	}

	
	//staff tagok lekérdezése
	$sql="SELECT uid,name,vizit,rang FROM users where rang in(10,9,8,7,5) order by rang desc , name";
	db::futat($sql);
	$tomb=db::tomb();
	$staff=array();

	foreach($tomb as $val){
		$line=time()-$val['vizit'];

		if($line<(10*60)){
			$statusz='ONLINE';
			$kep='menu_bullet_online.png';
		}
		elseif($line<(20*60)){
			$statusz='NINCS GÉPNÉL';
			$kep='menu_bullet_inaktiv.png';
		}
		else{
			$statusz='OFFLINE';
			$kep='menu_bullet_offline.png';
		}

		//$staff[$val['rang']]['csoport']=$RANGOK[$val['rang']];
		//$staff[$val['rang']]['tagok'][]=array('nev'=>$val['name'],'uid'=>$val['uid'],'statusz'=>$statusz,'kep'=>$kep);

		$staff[$val['rang']][]=array('nev'=>$val['name'],'uid'=>$val['uid'],'statusz'=>$statusz,'kep'=>$kep);
		$staff2[$RANGOK[$val['rang']]][]=array('nev'=>$val['name'],'uid'=>$val['uid'],'statusz'=>$statusz,'kep'=>$kep);
	}
	//d($staff);
	$smarty->assign('tulaj',$staff[10]);
	$smarty->assign('admin',$staff[9]);
	$smarty->assign('modi',$staff[8]);
	$smarty->assign('feltolto',$staff[7]);
	$smarty->assign('vip',$staff[5]);
	$smarty->assign('staff',$staff2);
	
	
	
	
	/** Uzenetek **/
	if( $USER['rang'] >= STAFF_MAIL_MIN_RANG ){
	
		$smarty->assign('staffAdmin',true);
		
		$levelek=Staff::getLevelek();
		$smarty->assign('levelek',$levelek);
		
		
	
	
	}
	


$smarty->assign('OLDAL',$OLDAL);
$smarty->display('staff.tpl');
ob_end_flush ();
?>