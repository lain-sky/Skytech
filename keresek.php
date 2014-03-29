<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();
$torrent = new Torrent();


$where = array();
$order = '';
$lapozo = new lapozo($_SERVER['REQUEST_URI'], $USER['perold'][0]);
	
if(!empty($p['keres_text'])) {
	$where[] = " (k.name LIKE '%" . $p['keres_text'] . "%') ";
	$smarty->assign('keres_text', $p['keres_text']);

	if(is_numeric($p['keres_tipus']))
		$where[] = " k.kat_id = '" . (int)$p['keres_tipus'] . "' ";
} else {
	if(!empty($g['tipus']) || !empty($g['uid']) || !empty($g['mind']) || !empty($g['id'])) {		
		if(!empty($g['tipus']))
			$where[] = "k.kat_id = '" . $g['tipus'] . "'";

		if(!empty($g['uid']))
			$where[] = "k.uid = '" . $USER['uid'] . "'";

		if(!empty($g['id']))
			$where[] = "k.kid = '" . (int)$g['id'] . "'";
		else
			$where[] = "k.status = 'aktiv'";
	}
}

switch($g['rendez']) {
	case 'tipus':
		$order = ' kat.nev ';
	break;

	case 'tipus_d':
		$order = ' kat.nev DESC ';
	break;

	case 'nev':
		$order = ' k.name ';
	break;

	case 'nev_d':
		$order = ' k.name DESC ';
	break;

	case 'kerve':
		$order = ' k.datum ';
	break;
	
	case 'kerve_d':
		$order = ' k.datum DESC ';
	break;

	case 'kertek':
		$order = ' kertek ';
	break;

	case 'kertek_d':
		$order = ' kertek DESC ';
	break;

	case 'kerte':
		$order = ' u.name ';
	break;

	case 'kerte_d':
		$order = ' u.name DESC ';
	break;

	case 'jutalom':
		$order = ' pontok ';
	break;

	case 'jutalom_d':
		$order = ' pontok DESC ';
	break;

	default:
		$order = ' k.datum DESC ';
	break;
}

$kategoriaTomb = kategoria::getForOption();
$kategoriaPlusz = array(array('value' => 'mind', 'text' => 'Összes típusban'));
$kategoriaTomb = array_merge($kategoriaPlusz, $kategoriaTomb);

if(!empty($p['keres_tipus'])) {
	foreach($kategoriaTomb as $key => $val) {
		if($p['keres_tipus'] == $val['value'])
			$kategoriaTomb[$key]['selected'] = true;
	}
}
$smarty->assign('keres_tipusok', $kategoriaTomb);

$queryString = array('uid', 'page', 'tipus');
$queryTomb = array();
foreach($queryString as $val) {
	if(!empty($g[$val]))
		$queryTomb[] = $val . "=" . $g[$val];
}
$queryUrl = $_SERVER['SCRIPT_NAME'] . '?' . implode('&', $queryTomb) . (count($queryTomb) == 0 ? '' : '&');

$keszQuery = array();
$rendezLehetoseg = array('tipus', 'nev', 'kerve', 'kertek', 'kerte', 'jutalom');
foreach($rendezLehetoseg as $val) {
	if(str_replace('_d', '', $g['rendez']) == str_replace('_d', '', $val))
		$keszQuery[] = $queryUrl . 'rendez=' . (strpos($g['rendez'], '_d') !== false ? $val : $val . '_d');
	else
		$keszQuery[] = $queryUrl . 'rendez=' . $val;
}
$smarty->assign('rendezlink', $keszQuery);

$kerek = new Kerek();
$keresek = $kerek->getList($where, $order, $lapozo->limitalo());

$smarty->assign('keresek', $keresek);
$lapozo->max = db::getOne(' SELECT FOUND_ROWS() ');
$smarty->assign('lapozo', $lapozo->szamsor());
$smarty->assign('betuvel', $lapozo->betuvel());
$smarty->assign('selectbe', $lapozo->selectbe());
if($USER['rang'] >= KERESEK_ADMIN_MIN_RANG )
	$smarty->assign('admin_panel', true);
$smarty->assign('kategoriak', kategoria::getToLista('keresek.php'));
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('keresek.tpl');
ob_end_flush();

?>
