<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();
$kerek = new Kerek();


if(!empty($g['modul']) && !empty($g['kid']) && is_numeric($g['kid'])) {
	switch($g['modul']) {
		case 'keres_del':
			if($kerek->isModified((int)$g['kid']) == true)
				$kerek->del("kid = '" . $g['kid'] . "'");
		break;

		case 'keres_csat':
			$pont = (int)$g['pont'];
			if($pont < 1)
				die('Egy Sky-Pontnál kevesebbel nem lehet csatlakozni egy kéréshez!');
			if($kerek->pontCheck($pont) != true)
				die('Nincs elegendõ Sky-Pontod!');
			$kerek->addItem($g['kid'], $pont);
			die('Csatlakoztál a kéréshez ' . $pont . ' Sky-Ponttal');
		break;

		default:
			die('Modulhiba');
		break;
	}
}

if(!empty($p['name']) && !empty($p['kat']) && is_numeric($p['kat'])) {
	$insert['uid'] = (int)$USER['uid'];
	$insert['kat_id'] = (int)$p['kat'];
	$insert['name'] = $p['name'];
	$insert['text'] = $p['text'];
	$insert['datum'] = date('Y-m-d H:i:s');

	if(!empty($p['modId']) && is_numeric($p['modId'])) {
		if($kerek->isModified((int)$p['modId'])) {
			unset($insert['uid'], $insert['datum']);
			$insert['mod_datum'] = date('Y-m-d H:i:s');
			$insert['mod_uid'] = (int)$USER['uid'];
			$kerek->update('kid = ' . (int)$p['modId'], $insert);
			$_SESSION['uzenet'] = nyugta('Sikeres módosítás');
		} else {
			$_SESSION['uzenet'] = hiba_uzi('Más kérését nem szerkeztheted!');
		}
	} else {
		if($kerek->pontCheck() == true && $kerek->pontLevon() == true) {
			$kerek->add($insert);
			$_SESSION['uzenet'] = nyugta('Sikeres beküldés');
		}  else {
			$_SESSION['uzenet'] = hiba_uzi('Nincs elegendo Sky-Pontod!');
		}
	}

	header('Location:' . $_SERVER['SCRIPT_NAME']);
	exit;
} elseif(!empty($g['modosit']) && is_numeric($g['modosit'])) {
	$data = $kerek->getById((int)$g['modosit']);
	$smarty->assign('data', $data);
	$smarty->assign('cim', 'Kérés szerkesztése');
} else {
	$smarty->assign('cim', 'Új kérés');
}

$smarty->assign('kats', kategoria::getAll('kid, nev'));
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('kerek.tpl');
ob_end_flush();

?>
