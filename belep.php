<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');


//a hibaüzidekodolása és beállítása a megjelenítéshez
if(!empty($_GET['mod'])){
	$hiba=urldecode(base64_decode($_GET['mod']));
	unset($_GET['mod']);
}
else{
	$hiba='';
}

if(isset($_GET['logout'])){
	belep::logout();
	exit;
}

if($_GET['emlekez']=='teto'){

	$smarty->assign('modul','emlekez');
}



unset($_GET);

//bejelentkezési kérelem feldolgozása
if(!empty($_POST['nev'])){
	/*
	if(!empty($USER['formtoken']) AND !empty($_POST[$USER['formtoken']])) {
		$nev = &$_POST['nev'];
		$post_pass = &$_POST[$USER['formtoken']];
		unset($USER['formtoken']);
		$ipCheck=( empty($_POST['lowsecu']) )? true:false;
		belep::login($nev,$post_pass,$ipCheck);
	}
	*/
	if( logs::getCountFalidLogin() < BELEP_HIBA_NAPI_LIMIT){
		$nev = &$_POST['nev'];
		$post_pass = &$_POST['jelszavacska'];
		unset($USER['formtoken']);
		$ipCheck=( empty($_POST['lowsecu']) )? true:false;
		belep::login($nev,$post_pass,$ipCheck);
	}
	else{
		$_SESSION['uzenet']=hiba_uzi('Elérted az egy napra rendelt hibás bejelentkezési limetet!');
		header("Location: belep.php");
		exit;
	}
	
}
elseif( !empty($_POST['emailcim']) ){
	
	if(!empty($USER['formtoken']) AND !empty($_POST[$USER['formtoken']])) {
		
		$name=$_POST[$USER['formtoken']];
		$email=$_POST['emailcim'];
		
		db::futat("select uid from users where name='%s' and email='%s' ", $name ,$email  );
		$eUid=db::egy_ertek('uid');
		
		if( is_numeric($eUid) ){
			
			$ellenor=veletlen_ellenor();
			$vadat= veletlen_adat($pname);
			
			
			//az ellenõrzõ adatok rogzítése
			db::futat("insert into regisztral(uid,date,type,tema,ellenor) values('%d','%d','emlekez','%s','%s')",$eUid,time(),$vadat['password'], md5($ellenor) );
			
			$loadUser=User::load( $eUid );
			
			//indul a mail
			require_once( CLASS_DIR . 'mailer.class.php');
			$mail=new Mailer();
			$mail->address = $loadUser['email'];
			$mail->body = elfelejtet_jelszo_mail(array('name'=>$loadUser['name'],'ellenor'=>$ellenor,'jelszo'=>$vadat['password']));
			$mail->subject = OLDAL_NEVE . " - elfelejtett jelszó";
			
			if( $mail->send() ==true ){
				$_SESSION['uzenet']=nyugta('A levelet kiküldtük! Amennyiben nem kapnád meg kérlek jelezd a staff@sky-tech.hu címen');
			
			}
			else{
				$_SESSION['uzenet']=hiba_uzi('A levélkiküldés sikertelen, próbáld meg újra! Amennyiben nem kapnád meg kérlek jelezd a staff@sky-tech.hu címen');
			}
			
			/*
			$m_subject = Oldal_neve." - elfelejtett jelszó";
			$m_headers  = "From: ".Oldal_vakmail."\r\nContent-type: text/html\r\n";
			$mail_szoveg=elfelejtet_jelszo_mail(array('name'=>$loadUser['name'],'ellenor'=>$ellenor,'jelszo'=>$vadat['password']));
			mail($loadUser['email'], $m_subject, $mail_szoveg, $m_headers);		
			*/
			
			
			
		}
		else{
			$_SESSION['uzenet']=hiba_uzi('Hiányos adatok!');
		}
	}
	else{
		$_SESSION['uzenet']=hiba_uzi('Hiányos adatok!!');
	}
	
	header('Location:'.$_SERVER['SCRIPT_NAME']);
	exit;
	
}


$smarty->assign('formtoken',$USER['formtoken']);
$smarty->assign('hiba',$hiba);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('belep.tpl');
ob_end_flush ();
?>