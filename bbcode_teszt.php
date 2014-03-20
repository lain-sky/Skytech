<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése

if(!empty($p['text'])){
	$smarty->assign('teszt_text',bb::bbdecode($p['text']));
	$smarty->assign('text',$p['text']);
}

if($USER['rang']>8 ){
	$smarty->assign('admin_link','true');
}

db::futat("select cim,text,cid from cikk where cid='33'");
$segedlet=array();
foreach(db::elso_sor() as $key=>$val){
	$segedlet[$key]=($key=='text')? bb::bbdecode($val) : $val;
}
$smarty->assign('segedlet',$segedlet);

$smarty->assign('OLDAL',$OLDAL);
$smarty->display('bbcode_teszt.tpl');
ob_end_flush ();
?>