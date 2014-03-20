<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése	

	if(!empty($p["fogado_user"]) && !empty($p["mennyiseg"]) && is_numeric($p["mennyiseg"]) ){
		$adhato=User::getMaxAtadas( $USER['uid'] );
		$igeny=$p["mennyiseg"]*( ($p['egyseg']=='mb')? 1024*1024 : 1024*1024*1024 );

		if($adhato===false ||$adhato<$igeny){
			$OLDAL[]=hiba_uzi('Kérelem elutasítva, túl sokat próbálsz meg átadni');
		}
		else{
			$fogado=User::getIdByName($p['fogado_user']);
			if(!is_numeric($fogado)){
				$OLDAL[]=hiba_uzi('Nincs ilyen userünk:'.$p["fogado_user"]);
			}
			else{
			//leellenõrizve minden indulhat a móka

				//trnazakció mentese
				$sql="insert into atadas(ado,fogado,mertek,datum) values('%d','%d','%f',now() )";
				db::futat($sql,$USER['uid'],$fogado,$igeny);

				//levonas
				$sql="update users set feltolt=feltolt-(round(%f)) where uid='%d'";
				db::futat($sql,$igeny,$USER['uid']);

				//jovairas
				$sql="update users set feltolt=feltolt+(round(%f)) where uid='%d'";
				db::futat($sql,$igeny,$fogado);

				//uzi a kedvezményezetnek				
				$targy="Arányjóváírást kaptál";
				$torzs=$USER['name'] . " felhasználónk ".  bytes_to_string($igeny).' -tal növelte meg feltöltésedet.';				
				level::felad($fogado,$USER['uid'],$targy,$torzs);

				//kesz minden header
				$_SESSION['uzenet']=nyugta('Átadás sikeres');
				header("Location:atadas.php");
				exit;
			}	
		}	
	}

$smarty->assign('max',User::getMaxAtadas( $USER['uid'] ));
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('atadas.tpl');
ob_end_flush ();
?>