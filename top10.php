<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése



$torrentStats['Legaktívabb']=Stats::torrent('total desc');
$torrentStats['Leggyorsabb']=Stats::torrent('seb desc');
$torrentStats['Legtöbb letöltés']=Stats::torrent('letoltve desc');
$torrentStats['Legtöbb adat']=Stats::torrent('adat desc');
$torrentStats['Legtöbb Seeder']=Stats::torrent('seed desc');
$torrentStats['Legtöbb Leech']=Stats::torrent('leech desc');

$smarty->assign('torrentek',$torrentStats);



$userStats['Legtöbbet feltöltõ']=Stats::user('feltolt desc');
$userStats['Legtöbbet letöltõ']=Stats::user('letolt desc');
$userStats['Legtöbbet megosztó']=Stats::user('arany desc');
$userStats['Leggyorsabb feltöltõ']=Stats::user('felseb desc');
$userStats['Leggyorsabb letöltõ']=Stats::user('leseb desc');

$smarty->assign('userek',$userStats);



$smarty->assign('OLDAL',$OLDAL);
$smarty->display('top10.tpl');
ob_end_flush ();
?>