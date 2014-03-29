<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');


if(!empty($_GET['mod'])) {
	$hiba = urldecode(base64_decode($_GET['mod']));
	unset($_GET['mod']);
} else {
	$hiba = '';
}

if(isset($_GET['logout'])) {
	belep::logout();
	exit;
}

if($_GET['emlekez'] == 'teto') {
	$smarty->assign('modul','emlekez');
}

unset($_GET);

if(!empty($_POST['nev'])) {
	if(logs::getCountFalidLogin() < BELEP_HIBA_NAPI_LIMIT) {
		$nev = &$_POST['nev'];
		$post_pass = &$_POST['jelszavacska'];
		unset($USER['formtoken']);
		$ipCheck = (empty($_POST['lowsecu'])) ? true : false;
		belep::login($nev, $post_pass, $ipCheck);
	} else {
		$_SESSION['uzenet'] = hiba_uzi('Elérted az egy napra rendelt hibás bejelentkezési limetet!');
		header('Location: belep.php');
		exit;
	}
} elseif(!empty($_POST['emailcim'])) {
	if(!empty($USER['formtoken']) && !empty($_POST[$USER['formtoken']])) {
		$name = $_POST[$USER['formtoken']];
		$email = $_POST['emailcim'];

		db::futat("SELECT uid FROM users WHERE name = '%s' AND email = '%s'", $name, $email);
		$eUid = db::egy_ertek('uid');

		if(is_numeric($eUid)) {
			$ellenor = veletlen_ellenor();
			$vadat = veletlen_adat($pname);

			db::futat("INSERT INTO regisztral (uid, date, type, tema, ellenor) VALUES ('%d', '%d', 'emlekez', '%s', '%s')", $eUid, time(), $vadat['password'], md5($ellenor));
			$loadUser = User::load($eUid);
			
			require_once(CLASS_DIR . 'mailer.class.php');
			if(sendEmail($loadUser['email'], $loadUser['email'], OLDAL_NEVE . ' - elfelejtett jelszó', elfelejtet_jelszo_mail(array('name' => $loadUser['name'], 'ellenor' => $ellenor, 'jelszo' => $vadat['password']))))
				$_SESSION['uzenet'] = nyugta('A levelet kiküldtük! Amennyiben nem kapnád meg kérlek jelezd a staff@sky-tech.hu címen');
			else
				$_SESSION['uzenet'] = hiba_uzi('A levélkiküldés sikertelen, próbáld meg újra! Amennyiben nem kapnád meg kérlek jelezd a staff@sky-tech.hu címen');
		} else {
			$_SESSION['uzenet'] = hiba_uzi('Hiányos adatok!');
		}
	} else {
		$_SESSION['uzenet'] = hiba_uzi('Hiányos adatok!!');
	}

	header('Location:' . $_SERVER['SCRIPT_NAME']);
	exit;
}

$smarty->assign('formtoken', $USER['formtoken']);
$smarty->assign('hiba', $hiba);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('belep.tpl');
ob_end_flush();

?>
