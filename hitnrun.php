<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();
$hnr = new hitnrun();

switch($g['rendez']) {
	case 'nev':
		$order = ' t.name';
	break;

	case 'nev_d':
		$order = ' t.name DESC';
	break;

	case 'start':
		$order = ' h.kezdes';
	break;

	case 'start_d':
		$order = ' h.kezdes DESC';
	break;

	case 'frissitve':
		$order = ' h.frissitve';
	break;

	case 'frissitve_d':
		$order = ' h.frissitve DESC';
	break;

	case 'status':
		$order = ' h.status';
	break;

	case 'status_d':
		$order = ' h.status DESC';
	break;

	case 'fel':
		$order = ' h.feltoltve';
	break;

	case 'fel_d':
		$order = ' h.feltoltve DESC';
	break;

	case 'le':
		$order = ' h.letoltve';
	break;

	case 'le_d':
		$order = ' h.letoltve DESC';
	break;
	
	case 'hatravan':
		$order = ' h.hatravan';
	break;

	case 'hatravan_d':
		$order = ' h.hatravan DESC';
	break;

	case 'arany':
		$order = ' arany';
	break;

	case 'arany_d':
		$order = ' arany DESC';
	break;
	
	default:
		$order = ' t.name';
	break;
}

if($g['showall'] == 'true') {
	$seed = $hnr->getall($order);//megjelenik
	$seed2 = $hnr->gethr();
	$smarty->assign('osszdb', count($seed));
	$smarty->assign('hrdb', $seed2['hr']);
	$smarty->assign('db', count($seed));
} else {
	$seed = $hnr->getReq($order); //megjelenik
	$seed2 = $hnr->getossz();
	$smarty->assign('osszdb', $seed2['ossz']);
	$smarty->assign('hrdb', count($seed));
	$smarty->assign('db', count($seed));
}

$queryString = array('showall');
$queryTomb = array();
foreach($queryString as $val) {
	if(!empty($g[$val]))
		$queryTomb[] = $val . '=' . $g[$val];
}
$queryUrl = $_SERVER['SCRIPT_NAME'] . '?' . implode('&', $queryTomb) . (count($queryTomb) == 0 ? '' : '&');

$keszQuery = array();
$rendezLehetoseg = array('nev', 'start', 'frissitve', 'status', 'fel', 'le', 'hatravan', 'arany');
foreach($rendezLehetoseg as $val) {
	if(str_replace('_d', '', $g['rendez']) == str_replace('_d', '', $val))
		$keszQuery[] = $queryUrl . 'rendez=' . (strpos($g['rendez'], '_d') !== false ? $val : $val . '_d');
	else
		$keszQuery[] = $queryUrl . 'rendez=' . $val;
}
$smarty->assign('rendezlink', $keszQuery);
$smarty->assign('seed', $seed);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('hitnrun.tpl');
ob_end_flush();

?>
