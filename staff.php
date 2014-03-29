<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
require_once(CLASS_DIR . 'staff.class.php');
$belep = new belep();
$old = new old();


if(!empty($p['text'])) {
	require_once(CLASS_DIR . 'mailer.class.php');
	$mail_szoveg = "Hi!\nA(z) " . $USER['name'] . " user (" . $USER['uid'] . ") ezt az üzit küldte:\n\n";
	$mail_szoveg .= $p['text'];
	sendEmail('dave666.david@gmail.com', 'dave666.david@gmail.com', OLDAL_NEVE . ' - Staff értesítõ', $mail_szoveg);

	if($p['valasz'] == 'igen')
		Staff::addValasz($p['text'], $p['tema'], $p['parent']);
	else
		Staff::addLevel($p['text'], $p['tema']);

	$_SESSION['uzenet'] = nyugta('A levelet kiküldtük!');
	header('Location: staff.php');
	exit;
}

$sql = "SELECT uid, name, vizit, rang FROM users WHERE rang IN(10,9,8,7,5) ORDER BY rang DESC, name";
db::futat($sql);
$tomb = db::tomb();
$staff = array();

foreach($tomb as $val) {
	$line = time() - $val['vizit'];

	if($line < (10 * 60)) {
		$statusz = 'ONLINE';
		$kep = 'menu_bullet_online.png';
	} elseif($line < (20 * 60)) {
		$statusz = 'NINCS GÉPNÉL';
		$kep = 'menu_bullet_inaktiv.png';
	} else {
		$statusz = 'OFFLINE';
		$kep = 'menu_bullet_offline.png';
	}

	$staff[$val['rang']][] = array('nev' => $val['name'], 'uid' => $val['uid'], 'statusz' => $statusz, 'kep' => $kep);
	$staff2[$RANGOK[$val['rang']]][] = array('nev' => $val['name'], 'uid' => $val['uid'], 'statusz' => $statusz, 'kep' => $kep);
}

$smarty->assign('tulaj', $staff[10]);
$smarty->assign('admin', $staff[9]);
$smarty->assign('modi', $staff[8]);
$smarty->assign('feltolto', $staff[7]);
$smarty->assign('vip', $staff[5]);
$smarty->assign('staff', $staff2);

if($USER['rang'] >= STAFF_MAIL_MIN_RANG) {
	$smarty->assign('staffAdmin', true);
	$levelek=Staff::getLevelek();
	$smarty->assign('levelek', $levelek);
}

$smarty->assign('OLDAL', $OLDAL);
$smarty->display('staff.tpl');
ob_end_flush();

?>
