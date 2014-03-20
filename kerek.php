<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése
$kerek=new Kerek();


if( !empty( $_GET['modul']) && !empty($_GET['kid']) && is_numeric($_GET['kid']) ){
	switch( $_GET['modul'] ){
		case 'keres_del' :
			if( $kerek->isModified( (int)$_GET['kid'] ) == true ){
				$kerek->del( "kid='". $_GET['kid'] ."'" );
			}
		
		break;
		
		case 'keres_csat' :
			$pont=(int)$_GET['pont'];
			if($pont < 1 ) die('Egy Sky-Pontnál kevesebbel nem lehet csatlakozni egy kéréshez!');
			if( $kerek->pontCheck( $pont ) != true ) die('Nincs elegendõ Sky-Pontod!');
			$kerek->addItem( $_GET['kid'], $pont );
			die('Csatlakoztál a kéréshez ' . $pont . ' Sky-Ponttal' );

		break;
		
		default:
			die('Modulhiba');
		break;
	}

}

if( !empty( $_POST['name']) && !empty($_POST['kat']) && is_numeric($_POST['kat']) ){
	$insert['uid']=(int)$USER['uid'];
	$insert['kat_id']=(int)$_POST['kat'];
	$insert['name']=$_POST['name'];
	$insert['text']=$_POST['text'];
	$insert['datum']=date('Y-m-d H:i:s');
	
	if( !empty( $_POST['modId'] ) && is_numeric( $_POST['modId'] ) ){
		//modositas	
		if( $kerek->isModified( (int)$_POST['modId'] ) ){
			unset( $insert['uid'], $insert['datum'] );
			$insert['mod_datum']=date('Y-m-d H:i:s');
			$insert['mod_uid']=(int)$USER['uid'];
			$kerek->update( 'kid=' . (int)$_POST['modId'] ,$insert );
			$_SESSION['uzenet']=nyugta('Sikeres módosítás');
		}
		else{
			$_SESSION['uzenet']=hiba_uzi('Más kérését nem szerkeztheted!');
		}
	}
	else{
		//uj mentese
		if( $kerek->pontCheck() == true && $kerek->pontLevon() == true ){
			$kerek->add( $insert );		
			$_SESSION['uzenet']=nyugta('Sikeres beküldés');
		}
		else{
			$_SESSION['uzenet']=hiba_uzi('Nincs elegendo Sky-Pontod!');
		}
	}
	
	header('Location:'.$_SERVER['SCRIPT_NAME']);
	exit;
}
elseif( !empty( $_GET['modosit'] ) && is_numeric( $_GET['modosit'] ) )
	$data=$kerek->getById( (int)$_GET['modosit'] );
	$smarty->assign( 'data', $data );
	$smarty->assign('cim','Kérés szerkesztése');
}
else{
	$smarty->assign('cim','Új kérés');
}

$smarty->assign('kats',kategoria::getAll('kid,nev'));
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('kerek.tpl');
ob_end_flush ();
?>