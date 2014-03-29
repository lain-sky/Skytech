<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


if(!empty($p['fogado_user']) && !empty($p['mennyiseg']) && is_numeric($p['mennyiseg'])) {
	$adhato = User::getMaxAtadas($USER['uid']);
	$igeny = $p['mennyiseg'] * (($p['egyseg'] == 'mb') ? 1024 * 1024 : 1024 * 1024 * 1024);

	if($adhato === false || $adhato < $igeny) {
		$OLDAL[] = hiba_uzi('Kérelem elutasítva, túl sokat próbálsz meg átadni');
	} else {
		$fogado = User::getIdByName($p['fogado_user']);
		if(!is_numeric($fogado)) {
			$OLDAL[] = hiba_uzi('Nincs ilyen userünk:' . $p['fogado_user']);
		} else {
			$sql = "INSERT INTO atadas (ado, fogado, mertek, datum) VALUES ('%d', '%d', '%f', NOW())";
			db::futat($sql, $USER['uid'], $fogado, $igeny);

			$sql = "UPDATE users SET feltolt = feltolt - (round(%f)) WHERE uid = '%d'";
			db::futat($sql, $igeny, $USER['uid']);

			$sql = "UPDATE users SET feltolt = feltolt + (round(%f)) WHERE uid = '%d'";
			db::futat($sql, $igeny, $fogado);

			$targy = 'Arányjóváírást kaptál';
			$torzs = $USER['name'] . ' felhasználónk ' . bytes_to_string($igeny) . ' -tal növelte meg feltöltésedet.';
			level::felad($fogado, $USER['uid'], $targy, $torzs);

			$_SESSION['uzenet'] = nyugta('Átadás sikeres');
			header('Location:atadas.php');
			exit;
		}
	}
}

$smarty->assign('max', User::getMaxAtadas($USER['uid']));
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('atadas.tpl');
ob_end_flush();

?>
