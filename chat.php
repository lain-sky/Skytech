<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése

/*
$belephet=array(1,2,438);
if(in_array($USER['uid'],$belephet) !==true){
	$OLDAL[]=hiba_uzi('Most fejlesztem idén meglesz<br />szicsu');
	$smarty->assign('mehet',false);
}
else{
	$smarty->assign('mehet',true);
}
*/
$smarty->assign('mehet',true);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('chat.tpl');
ob_end_flush ();
?>