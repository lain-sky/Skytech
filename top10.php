<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


$torrentStats['Legaktívabb'] = Stats::torrent('total DESC');
$torrentStats['Leggyorsabb'] = Stats::torrent('seb DESC');
$torrentStats['Legtöbb letöltés'] = Stats::torrent('letoltve DESC');
$torrentStats['Legtöbb adat'] = Stats::torrent('adat DESC');
$torrentStats['Legtöbb Seeder'] = Stats::torrent('seed DESC');
$torrentStats['Legtöbb Leech'] = Stats::torrent('leech DESC');

$userStats['Legtöbbet feltöltõ'] = Stats::user('feltolt DESC');
$userStats['Legtöbbet letöltõ'] = Stats::user('letolt DESC');
$userStats['Legtöbbet megosztó'] = Stats::user('arany DESC');
$userStats['Leggyorsabb feltöltõ'] = Stats::user('felseb DESC');
$userStats['Leggyorsabb letöltõ'] = Stats::user('leseb DESC');

$smarty->assign('torrentek', $torrentStats);
$smarty->assign('userek', $userStats);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('top10.tpl');
ob_end_flush();

?>
