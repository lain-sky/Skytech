<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();
$torrent = new Torrent();


if(empty($g['id']) || $torrent->checkTorrentById($g['id']) === false) {
	$smarty->assign('OLDAL', hiba_uzi('A keresett torrent nem található!'));
	$smarty->display('xxx.tpl');
} else {
	ob_clean();
	$torrent_file = $torrent->getTorrentFileName($g['id']);
	$torrent_adat = $torrent->getTorrentById($g['id']);
	$torrent_letoltesi_nev = '[Sky-Tech]' . fajlnev_atalakit($torrent_adat['name'] . '.torrent');

	$dict = bdec_file($torrent_file, (1024*1024));
	unset($dict['value']['announce-list']);
	$dict['value']['announce']['value'] = $torrent->getTrackerUrl();
	$dict['value']['announce']['string'] = strlen($dict['value']['announce']['value']) . ':' . $dict['value']['announce']['value'];
	$dict['value']['announce']['strlen'] = strlen($dict['value']['announce']['string']);
	$data = benc($dict);

	echo $data;
}
ob_end_flush();

?>
