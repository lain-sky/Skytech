<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése

$smarty->assign('mehet',true);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('chat.tpl');
ob_end_flush ();
?>