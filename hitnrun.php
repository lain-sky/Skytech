<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése
$hnr=new hitnrun(); //hitnrun osztály

if($g['showall'] == 'true')
	$seed = $hnr->getall();
else
	$seed = $hnr->getReq();
$db = count($seed);

$smarty->assign('seed',$seed);
$smarty->assign('db',$db);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('hitnrun.tpl');
ob_end_flush ();
?>