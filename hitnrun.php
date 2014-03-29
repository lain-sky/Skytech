<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();
$hnr = new hitnrun();

if($g['showall'] == 'true') {
	$seed = $hnr->getall();//megjelenik
	$seed2 = $hnr->gethr();
	$smarty->assign('osszdb', count($seed));
	$smarty->assign('hrdb', $seed2['hr']);
	$smarty->assign('db', count($seed));
} else {
	$seed = $hnr->getReq(); //megjelenik
	$seed2 = $hnr->getossz();
	$smarty->assign('osszdb', $seed2['ossz']);
	$smarty->assign('hrdb', count($seed));
	$smarty->assign('db', count($seed));
}

$smarty->assign('seed', $seed);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('hitnrun.tpl');
ob_end_flush();

?>
