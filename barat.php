<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


if($g['akcio'] == 'add' && is_numeric($g['uid'])) {
	$sql = "INSERT INTO barat (tulaj_uid, barat_uid) VALUES ('%d', '%d')";
	if(db::futat($sql, $USER['uid'], $g['uid']))
		$_SESSION['jelentes'] = nyugta('A barát felvétele sikeres volt!');
	else
		$_SESSION['jelentes'] = hiba_uzi('A barát felvétele sikertelen');

	header('Location:barat.php');
}

if($g['akcio'] == 'del' && is_numeric($g['uid'])) {
	$sql = "DELETE FROM barat WHERE tulaj_uid = '%d' AND barat_uid = '%d'";
	if(db::futat($sql, $USER['uid'], $g['uid']))
		$_SESSION['jelentes'] = nyugta('A barát törlése sikeres volt!');
	else
		$_SESSION['jelentes'] = hiba_uzi('A barát törlése sikertelen');

	header('Location:barat.php');
}

$sql = "SELECT barat_uid FROM barat WHERE tulaj_uid = '%d'";
db::futat($sql, $USER['uid']);

$baratok = array();
foreach(db::tomb() as $key => $val) {
	$baratok[$key] = User::load($val['barat_uid']);
	$baratok[$key]['barat'] = isBarat($val['barat_uid']);
}

$smarty->assign('baratok', $baratok);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('barat.tpl');
ob_end_flush();

?>
