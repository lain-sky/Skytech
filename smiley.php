<?php
define('SZINT',666);
require_once('../rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése


$img = preg_replace('/(?<!\\\\)\[smyle(?::\w+)?=(.*?)(?::\w+)?\]/si', '\\1', bb::getImg());
$code=bb::getCode();
$kesz=array();
foreach($code as $key => $val){
	$kesz[]=array('kep'=>$img[$key],'kod'=>$code[$key]);
}

$smarty->assign('kodok',$kesz);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('smiley.tpl');
?>