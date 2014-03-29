<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


if(SYSTEM_OFF === true) {
	echo OLDAL_HIBA;
	exit;
}

db::futat("SELECT hid AS id, cim, text, datum, disp FROM hirek ORDER BY datum DESC");
$hirek = db::tomb();

if($USER['rang'] > 10) {
	$smarty->assign('uj_link', '<a href="hirek.php?mit=uj&vissza=index.php" >Új hír hozzáadása</a>');
}

foreach($hirek as $key => $val) {
	$hirek[$key]['text'] = bb::bbdecode($val['text']);
}
$smarty->assign('hirek', Cache::get(CACHE_HIREK));

//általámos statisztika
//szerver fut
db::futat("SHOW GLOBAL VARIABLES");
db::futat("SHOW GLOBAL STATUS");
$tomb = db::tomb();
$idotomb = explode(':', date('j:H:i:s', $tomb[251]["Value"]));
$stat['futasido'] = $idotomb[0] . ' nap ' . $idotomb[1] . ' óra ' . $idotomb[2] . ' perc ' . $idotomb[3] . ' sec';

$cr = upTimeProcess();
$smarty->assign('cpu_width', round((LOAD_WIDTH * $cr)));
$smarty->assign('cpu_arany', round(($cr * 100), 2));

$rr = round(($cr / rand(3, 9)), 2); 
$smarty->assign('ram_width', round((LOAD_WIDTH * $rr)));
$smarty->assign('ram_arany', round(($rr * 100), 2));

$smarty->assign('stat', Cache::get(CACHE_INDEX_STATS));

$smarty->assign('OLDAL', $OLDAL);
$smarty->display('index.tpl');
ob_end_flush();

?>
