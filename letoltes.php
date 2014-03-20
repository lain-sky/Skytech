<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése

$torrent=new Torrent();



if(empty($g['id']) || $torrent->checkTorrentById($g['id'])===false){
	$smarty->assign('OLDAL',hiba_uzi('A keresett torrent nem található!'));
	$smarty->display('xxx.tpl');
}
else{
ob_clean();
	$torrent_file=$torrent->getTorrentFileName($g['id']);
	$torrent_adat=$torrent->getTorrentById($g['id']);
	$torrent_letoltesi_nev='[Sky-Tech]' . fajlnev_atalakit($torrent_adat['name']. ".torrent");
	//die($torrent_letoltesi_nev);

	$dict = bdec_file($torrent_file, (1024*1024));
	unset($dict["value"]["announce-list"]);
	$dict['value']['announce']['value'] = $torrent->getTrackerUrl();
	$dict['value']['announce']['string'] = strlen($dict['value']['announce']['value']).":".$dict['value']['announce']['value'];
	$dict['value']['announce']['strlen'] = strlen($dict['value']['announce']['string']);
	$data=benc($dict);


	header ("Expires: Tue, 1 Jan 1980 00:00:00 GMT");
	header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header ("Cache-Control: no-store, no-cache, must-revalidate");
	header ("Cache-Control: post-check=0, pre-check=0", false);
	header ("Pragma: no-cache");
	header ("X-Powered-By: ".Oldal_verzio." (c) ".date("Y")." ".Oldal_neve."");
	header ("Accept-Ranges: bytes");
	header ("Connection: close");
	header ("Content-Transfer-Encoding: binary");
	header ("Content-Type: application/x-bittorrent");
	header ("Content-Disposition: attachment; filename=".$torrent_letoltesi_nev);
	print($data);	

}
ob_end_flush ();
?>