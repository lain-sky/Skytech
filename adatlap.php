<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


if(!empty($p['idezet']) && is_numeric($p['idezet'])) {
	db::futat("SELECT text FROM torrent_hsz WHERE thid = '%d'", $p['idezet']);
	echo db::egy_ertek('text');
	exit;
}

if(!is_numeric($g['id']) || empty($g['id'])) {
	$OLDAL[] = hiba_uzi('A keresett torrent nem található');
} else {
	$torrent = new Torrent();
	if($torrent->checkTorrentById($g['id']) === false) {
		$OLDAL[] = hiba_uzi('A keresett torrent nem található');
	} else {
		$oldal_cime = $_SERVER['SCRIPT_NAME'] . '?id=' . $g['id'];
		$smarty->assign('oldal_cime', $oldal_cime);

		if(!empty($_SESSION['jelentes'])) {
			$OLDAL[] = $_SESSION['jelentes'];
			unset($_SESSION['jelentes']);
		}

		$ttomb = $torrent->fullLoad(array('t.tid = ' . $g['id']));
		$sql = "SELECT uploaded AS fel, downloaded AS le, UNIX_TIMESTAMP(last_action) AS time_end, UNIX_TIMESTAMP(started) AS time_start FROM peers WHERE tid = '%d'";
		db::futat($sql, $g['id']);
		$peer = db::elso_sor();
		$tk = $peer['time_end'] - $peer['time_start'];
		$ttomb[0]['seb'] = @round(($p['fel'] + $p['le']) / $tk);
		$smarty->assign('t', $ttomb[0]);
		$smarty->assign('koszi', $torrent->torrentKosziLista($g['id']));

		$uj_hsz = ($ttomb[0]['hsz_lezarva'] == 'no') ? true : false;
		db::futat("SELECT uid AS id FROM torrent_hsz WHERE tid = '%d' ORDER BY thid DESC", $g['id']);
		if($USER['uid'] == db::sor())
			$uj_hsz = false;
		if($USER['rang'] < JOG_TORRENT_HOZZASZOLAS)
			$uj_hsz = false;
		$smarty->assign('uj_hsz', $uj_hsz);

		$sql = "SELECT t.* FROM torrent_hsz t WHERE t.tid = '%d' ORDER BY t.thid";
		db::futat($sql, $g['id']);

		$hsz = array();
		foreach(db::tomb() as $k => $v) {
			$uinfo = User::load($v['uid']);
			$hsz[$k] = $uinfo;
			$hsz[$k]['datum'] = $v['datum'];
			$hsz[$k]['text'] = bb::bbdecode($v['text']);
			$hsz[$k]['hid'] = $v['thid'];

			if($v['uid'] == $USER['uid']) {
				$hsz[$k]['sajathsz'] = true;
			}
		}

		$smarty->assign('hsz', $hsz);
		
		if($USER['rang'] >= TORRENET_ADMIN_HSZ_MIN_RANG) {
			$smarty->assign('admin_link', 'true');
		}

		if($g['mod'] == 'mod' && is_numeric($g['mid'])) {
			db::futat("SELECT text AS id FROM torrent_hsz WHERE thid = '%d'", $g['mid']);
			$smarty->assign('modositas', true);
			$smarty->assign('text', db::sor());
			$smarty->assign('thid', $g['mid']);
		}

		if(!empty($p['modtext']) && !empty($p['thid'])) {
			$sql = "UPDATE torrent_hsz SET text = '%s' WHERE thid = '%d'";
			$modText = "\n\n\n[admin]Módosította: " . $USER['name'] . "\nekkor:" . date("Y.m.d H:i:s") . "[/admin]";
			if(db::futat($sql, $p['modtext'] . $modText, $p['thid']))
				$_SESSION['jelentes'] = nyugta('Módosítás sikeres volt!');
			else
				$_SESSION['jelentes'] = hiba_uzi('Módosítás sikertelen');

			header("Location:" . $oldal_cime);
		}

		if(!empty($p['text'])) {
			$sql = "INSERT INTO torrent_hsz (uid, tid, text, datum) VALUES ('%d', '%d', '%s', NOW())";
			if(db::futat($sql, $USER['uid'], $g['id'], $p['text']))
				$_SESSION['jelentes'] = nyugta('Rögzítés sikeres volt!');
			else
				$_SESSION['jelentes'] = hiba_uzi('Rögzítés sikertelen');

			header("Location:" . $oldal_cime);
		}

		if($g['mod'] == 'del' && $USER['rang'] >= TORRENET_ADMIN_HSZ_MIN_RANG && is_numeric($g['mid'])) {
			if(db::futat("DELETE FROM torrent_hsz WHERE thid = '%d'", $g['mid']))
				$_SESSION['jelentes'] = nyugta('Törlés sikeres volt!');
			else
				$_SESSION['jelentes'] = hiba_uzi('Törlés sikertelen');

			header("Location:" . $oldal_cime);
		}
	}
}

$smarty->assign('OLDAL', $OLDAL);
$smarty->display('adatlap.tpl');
ob_end_flush();

?>
