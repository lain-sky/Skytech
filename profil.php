<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();


if(!empty($_POST)) {
	$p = &$_POST;

	db::futat("SELECT uid FROM users WHERE uid = '%d' AND pass = '%s'", $USER['uid'], md5($USER['name'] . $p['confirmation']));
	if(db::$sorok == 0) {
		$OLDAL[] = hiba_uzi('A jelszavadat helytelenül adtad meg!');
	} elseif(db::$sorok == 1) {
		$perold = array(
			0 => (is_numeric($p['torrperold']) && $p['torrperold'] >= 10 && $p['torrperold'] <= 100) ? $p['torrperold'] : 20,
			1 => (is_numeric($p['hszperold']) && $p['hszperold'] >= 10 && $p['hszperold'] <= 100) ? $p['hszperold'] : 20,
			2 => (is_numeric($p['mailperold']) && $p['mailperold'] >= 10 && $p['mailperold'] <= 100) ? $p['mailperold'] : 20
		);

		$perold = implode('|', $perold);
		$megjelen = implode('|', $p['megjelen']);
		$avatar = (!empty($p['avatar'])) ? $p['avatar'] : 'avatar.png';
		$smink = 'alap';//$p['smink'];
		$kat = (!empty($p['kategoriak'])) ? implode(',', $p['kategoriak']) : NULL;

		$user_data_pari = "UPDATE user_data SET privat = '%s', nem = '%s', orszag = '%d', varos = '%s', avatar = '%s', ladad = '%s', ladad_text = '%s', megjelen = '%s', perold = '%s', smink = '%s', kategoriak = '%s' WHERE uid = '%d'";
		if(db::futat($user_data_pari, $p['privat'], $p['nemed'], $p['orszag'], $p['varos'], $avatar, $p['ladad'], $p['ladad_text'], $megjelen, $perold, $smink, $kat, $USER['uid']) === true)
			$OLDAL[] = nyugta('Az opcionális adatok módosítva');
		else
			$OLDAL[] = hiba_uzi('Hiba az adatrögzítés közben');

		//biztonsági beállítások
		if(!empty($p['pw1']) && !empty($p['pw2'])) {
			if($p['pw1'] !== $p['pw2']) {
				$OLDAL[] = hiba_uzi('A megadott jelszavak nem egyeznek meg!');
			} else {
				if(strlen($p['pw1']) < 5) {
					$OLDAL[] = hiba_uzi('Az jelszavadnak legalább 5 karakternek kell lennie!!');
				} else {
					$ellenor = veletlen_ellenor();
					$pari = "INSERT INTO regisztral (uid, date, type, tema, ellenor) VALUES ('%d', '%d', '%s', '%s', '%s')";
					if(db::futat($pari, $USER['uid'], time(), 'new_pass', $p['pw1'], md5($ellenor)) !== true) {
						$OLDAL[] = hiba_uzi('Adatrögzítési hiba! Próbáld újra!');
					} else {
						require_once(CLASS_DIR . 'mailer.class.php');
						if(sendEmail($USER['email'], $USER['email'], OLDAL_NEVE . ' - jelszócsere megerõsítése', uj_jelszo_mail(array('name' => $USER['name'], 'pass' => $p['pw1'], 'ellenor' => $ellenor))))
							$OLDAL[] = nyugta('Címedre (<span class="highlight">' . $USER['email'] . '</span>) megerõsítõ e-mailt küldtünk. Jelszavad csak a megerõsítés után változik meg! Ha nem kapnád meg a levelet kérlek jelezd a staffnak!');
						else
							$OLDAL[] = hiba-uzi('Levélkiküldési hiba! Próbáld meg újra, ha nem sikerülne kérlek jelezd a staffnak!');
					}
				}
			}
		}

		if($p['newpasskey'] == 'yes') {
			$pari = "UPDATE users SET tor_pass = '%s' WHERE uid = '%d'";
			if(db::futat($pari, veletlen_torrent_pass(), $USER['uid']) === true)
				$OLDAL[] = nyugta('Új azonosítót (passkey-t) kaptál! <span class="highlight">Minden le- és feltöltés alatt álló .torrent fájlt újra le kell töltened!</span>');
			else
				$OLDAL[]=hiba_uzi('A passkeye cseréje sikertelen');
		}

		if($p['email'] !== $USER['email']) {
			if(!empty($p['pw1']) && !empty($p['pw2'])) {
				$OLDAL[] = hiba_uzi('Nem történt e-mail cím csere, mert jelszó cserét is kértél!');
			} else {
				$OLDAL[] = nyugta('Ez a funkció jelenleg nem elérhetõ');
			}
		}
	} else {
		$OLDAL[] = hiba_uzi('Ismeretlen hiba!');
	}

	$userAdat = User::load($USER['uid']);
	foreach($userAdat as $key => $val) {
		$USER[$key] = $val;
	}

	$_SESSION['uzenet'] = end($OLDAL);
	header('Location: ' . $_SERVER['SCRIPT_NAME']);
}

$old = new old();
$sql = "SELECT privat, nem, orszag, varos, ladad, ladad_text FROM user_data WHERE uid = '%d'";
db::futat($sql, $USER['uid']);
$t = db::elso_sor();

if(!empty($_SESSION['uzenet'])) {
	$OLDAL[] = $_SESSION['uzenet'];
	unset($_SESSION['uzenet']);
}

$privat_uzi = array(
	'mindenki' => 'Mindenkitõl',
	'staff' => 'Csak barátoktól, és a Stafftól',
	'barat' => 'Csak a Stafftól'	
);
$privat_uzi_old = $t['privat'];
$smarty->assign('privat_uzi', $privat_uzi);
$smarty->assign('privat_uzi_old', $privat_uzi_old);

$nem = array(
	'fiu' => 'Férfi',
	'lany' => 'Nõ',
	'mas' => 'Egyéb',
	'titok' => 'Nem árulom el'
);
$nem_old = $t['nem'];
$smarty->assign('nem', $nem);
$smarty->assign('nem_old', $nem_old);

$orszag_ertek = range(0,192);
$orszag_old = $t['orszag'];
$smarty->assign('orszag', $ORSZAGTOMB);
$smarty->assign('orszag_ertek', $orszag_ertek);
$smarty->assign('orszag_old', $orszag_old);

$varos_old = $t['varos'];
$smarty->assign('varos_old', $varos_old);

$avatar_url = ($USER['avatar'] == 'avatar.png') ? 'kinezet/' . $USER['smink'] . '/avatar.png' : $USER['avatar'];
$avatar_text = ($USER['avatar'] == $avatar_url) ? $USER['avatar'] : '';
$smarty->assign('avatar_url', $avatar_url);
$smarty->assign('avatar_text', $avatar_text);

$kategoriak = array();
foreach(kategoria::getAll() as $key => $val) {
	$kategoriak[$key]['id'] = $val['kid'];
	$kategoriak[$key]['nev'] = $val['nev'];
	$kategoriak[$key]['title'] = $val['leir'];
	$kategoriak[$key]['checked'] = in_array($val['kid'], $USER['kategoriak_tomb']);
}
$smarty->assign('kategoriak', $kategoriak);

$ladad = $t['ladad'];
$ladad_text = $t['ladad_text'];
$smarty->assign('ladad', $ladad);
$smarty->assign('ladad_text', $ladad_text);

$megjelen_old = $USER['megjelen'];
$smarty->assign('megjelen_old', $megjelen_old);

$megjelen = array(
	'avatar' => 'Avatarok megjelenítése',
	'ujtorr' => '"Új torrent" jelzések kézi törlése',
	'modi' => 'Moderátor jelzések',
	'gui' => 'GUI animációk engedélyezése'
);
$smarty->assign('megjelen', $megjelen);

$perold = array(
	'torr' => $USER['perold'][0],
	'hsz' => $USER['perold'][1],
	'mail' => $USER['perold'][2]
);
$smarty->assign('perold', $perold);

foreach($sminkek_tomb as $key => $tomb){
	if($tomb['ert'] == $USER['smink']) {
		$sminkek_tomb[$key]['check'] = true;
	}
}
$smarty->assign('sminkek_tomb', $sminkek_tomb);
$smarty->assign('email_cim', $USER['email']);

$smarty->assign('OLDAL', $OLDAL);
$smarty->display('profil.tpl');
ob_end_flush();

?>
