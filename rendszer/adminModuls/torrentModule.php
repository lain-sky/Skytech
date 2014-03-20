<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{

	case 'torrent_setting':
		$smarty->assign('modulnev','Torrent beállítások');
		$smarty->assign('modul','torrent_setting');		
		$smarty->assign('kategoriak',kategoria::getForOption());	
	break;	

	case 'torrent_save'  :
		if( $SUPER_ADMIN_ALLAT == true ){
			
			switch(true){
				case $p['kategoria']=='mind':
					//ide egyenlõre nem jönn semmi :)
					$where=' ';
				break;
				case is_numeric($p['kategoria']):
					$where= " where kid='".$p['kategoria']."'";
				break;
				default:
					$_SESSION['uzenet']=hiba_uzi('Nem volt kiválasztva kategória');
					header('Location:'.$_SERVER['SCRIPT_NAME']);
					exit;	
				break;
			}		

			switch($p['feladat']){
				case 'ingyen_yes':
					$sql="update torrent set ingyen='yes' ".$where;
				break;
				case 'ingyen_no':
					$sql="update torrent set ingyen='no' ".$where;
				break;
				default:
					$_SESSION['uzenet']=hiba_uzi('Nem volt kiválasztva feladat');
					header('Location:'.$_SERVER['SCRIPT_NAME']);
					exit;	
				break;	
			}
			db::futat($sql);	
			$_SESSION['uzenet']=nyugta('Sikeres módosítások!');
			header('Location:'.$_SERVER['SCRIPT_NAME']);
			exit;
		}		
	break;
}
?>