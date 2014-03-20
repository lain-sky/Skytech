<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése

	
			
	//barat hozzaadasa
	if($g['akcio']=='add' && is_numeric($g['uid'])){
		$sql="insert into barat(tulaj_uid,barat_uid) values('%d','%d')";
		if(db::futat($sql,$USER['uid'],$g['uid'])){
			$_SESSION['jelentes']=nyugta('A barát felvétele sikeres volt!');
		}
		else{
			$_SESSION['jelentes']=hiba_uzi('A barát felvétele sikertelen');
		}
		header("Location:barat.php");
	}
	
	//barat delete
	if($g['akcio']=='del' && is_numeric($g['uid'])){
		$sql="delete from barat where tulaj_uid='%d' and barat_uid='%d'";
		if(db::futat($sql,$USER['uid'],$g['uid'])){
			$_SESSION['jelentes']=nyugta('A barát törlése sikeres volt!');
		}
		else{
			$_SESSION['jelentes']=hiba_uzi('A barát törlése sikertelen');
		}
		header("Location:barat.php");
	}
	
	
	//barat lista
	$sql="select barat_uid from barat where tulaj_uid='%d'";
	db::futat($sql,$USER['uid']);
	
	$baratok=array();
	foreach(db::tomb() as $key=>$val){
		$baratok[$key]=User::load($val['barat_uid']);
		$baratok[$key]['barat']=isBarat($val['barat_uid']);
			}
	//d($baratok);
	$smarty->assign('baratok',$baratok);
	

$smarty->assign('OLDAL',$OLDAL);
$smarty->display('barat.tpl');
ob_end_flush ();
?>