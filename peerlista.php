<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


$sql = "SELECT 
		(SELECT name FROM users WHERE uid = p.uid) AS username,
		(SELECT rang FROM users WHERE uid = p.uid) AS rang,
		(SELECT meret FROM torrent WHERE tid = p.tid) AS szum,
		p.connectable AS modozat, p.uploaded AS fel, p.downloaded AS le, ps.feltolt AS szum_fel, ps.letolt AS szum_le, UNIX_TIMESTAMP(p.last_action) AS time_end,
		UNIX_TIMESTAMP(p.started) AS time_start, p.agent AS kliens, p.seeder, p.uid
		FROM peerszum ps JOIN peers p ON ps.uid = p.uid AND ps.tid = p.tid WHERE p.tid = '%d'";

db::futat($sql, $g['id']);
$tomb = db::tomb();
$kesz = array();

foreach($tomb as $p) {
	$tk = $p['time_end'] - $p['time_start'];

	$kesz[$p['seeder']][] = array(
		'uid' => $p['uid'],
		'rang' => $p['rang'],
		'name' => $p['username'],
		'mod' => $p['modozat'],
		'feltolt' => $p['szum_fel'],
		'feltolt_seb' => @round($p['fel'] / $tk),
		'letolt' => $p['szum_le'],
		'letolt_seb' => @round($p['le'] / $tk),
		'arany' => @round(($p['szum_fel'] / ($p['szum_le'] + 1)), 3),
		'allapot' => @round((($p['szum_le'] / $p['szum']) * 100), 2),
		'kliens' => $p['kliens'],
		'csat' => $p['time_start'],
		'fris' => $p['time_end']	
	);
}

$torrent = torrent::fullLoad(array('tid = ' . $g['id']));
$smarty->assign('torrent', $torrent[0] );
$smarty->assign('seed', $kesz['yes']);
$smarty->assign('leech', $kesz['no']);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('peerlista.tpl');
ob_end_flush();

?>
