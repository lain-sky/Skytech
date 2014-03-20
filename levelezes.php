<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése


if(!empty($g['uid'])){
	$getUser=User::getNameById($g['uid']);
	if(!is_bool($getUser)){
		$smarty->assign('userpara',1);
		$smarty->assign('modul','uj');
		$smarty->assign('cimzet',$getUser);
	}
	else{
		$OLDAL[]=hiba_uzi('Címzet azonosítás sikertelen!');
	}
}

if(!empty($p['text']) && !empty($p['tema'])){
	switch(true){
		case $p['tipus']=='k' && $USER['rang']>8:
		break;

		case $p['tipus']=='r' && $USER['rang']>8:
			if($cimzetId=User::getIdByName($p['cimzet'])){
			}
			else{
				$smarty->assign('tema',$p['tema']);
				$smarty->assign('text',$p['text']);
				$smarty->assign('userpara',1);
				$smarty->assign('modul','uj');
				$OLDAL[]=hiba_uzi('Nincs ilyen tagunk: "'.$p['cimzet'].'"');
			}

		break;

		default:
			if($cimzetId=User::getIdByName($p['cimzet'])){
				if(level::felad($cimzetId,$USER['uid'],$p['tema'],$p['text'])){
					$OLDAL[]=nyugta('A levelet kiküldtük!');
					if($p['level_mentes']==1){
						level::felad($USER['uid'],$cimzetId,$p['tema'],$p['text'],'n','e');
					}
				}
				else{
					$OLDAL[]=hiba_uzi('A kiküldés sikertelen');
				}	
			}
			else{
				$smarty->assign('tema',$p['tema']);
				$smarty->assign('text',$p['text']);
				$smarty->assign('userpara',1);
				$smarty->assign('modul','uj');
				$OLDAL[]=hiba_uzi('Nincs ilyen tagunk: "'.$p['cimzet'].'"');
			}
		break;
	}
}

$smarty->assign('OLDAL',$OLDAL);
$smarty->display('levelezes.tpl');
ob_end_flush ();
?>