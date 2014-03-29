<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
require_once('rendszer/torrent.functions.php');
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

	$dict = bdec_file($torrent_file, (1024 * 1024));

	$dict['value']['announce']['value'] = $torrent->getTrackerUrl();
	$dict['value']['info']['value']['private'] = bdec('i1e');
	$dict['value']['announce']['string'] = strlen($dict['value']['announce']['value']) . ':' . $dict['value']['announce']['value'];
	$dict['value']['announce']['strlen'] = strlen($dict['value']['announce']['string']);
	unset($dict['value']['announce-list']);
	unset($dict['value']['nodes']);
	$dict = bdec(benc($dict));
	$data = benc($dict);
	list($ann, $info) = dict_check($dict, 'announce(string):info');

	header('Expires: Tue, 1 Jan 1980 00:00:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache');
	header('X-Powered-By: ' . OLDAL_VERZIO . ' (c) ' . date('Y') . ' ' . OLDAL_NEVE);
	header('Accept-Ranges: bytes');
	header('Connection: close');
	header('Content-Transfer-Encoding: binary');
	header('Content-Type: application/x-bittorrent');
	header('Content-Disposition: attachment; filename=' . $torrent_letoltesi_nev);
	print($data);
}

ob_end_flush();

?>
