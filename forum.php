<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


if(empty($g['keres'])) {
	$pari = "SELECT f.cim AS focim, f.fid, t.status AS tipus, t.tid, t.tema, t.minrang, t.ismerteto,
			(SELECT datum FROM forum_hsz WHERE tid = t.tid ORDER BY hid DESC LIMIT 1) AS hsz_date,
			(SELECT uid FROM forum_hsz WHERE tid = t.tid ORDER BY hid DESC LIMIT 1) AS uid,
			(SELECT name FROM forum_hsz fh LEFT JOIN users u ON fh.uid = u.uid WHERE tid = t.tid ORDER BY hid DESC LIMIT 1) AS name,
			(SELECT rang FROM forum_hsz fh LEFT JOIN users u ON fh.uid = u.uid WHERE tid = t.tid ORDER BY hid DESC LIMIT 1) AS rang
			FROM forum_csoport f LEFT JOIN forum_topik t ON f.fid = t.fid";
} else {
	$pari = "SELECT f.cim AS focim, f.fid, t.status AS tipus, t.tid, t.tema, t.minrang, t.ismerteto, MAX(h.datum) AS hsz_date, u.uid, u.name, u.rang FROM forum_csoport f
			LEFT JOIN forum_topik t ON f.fid = t.fid
			LEFT JOIN forum_hsz h ON t.tid = h.tid
			LEFT JOIN users u ON h.uid = u.uid
			WHERE t.ismerteto LIKE '%" . $g['keres'] . "%' OR t.tema LIKE '%" . $g['keres'] . "%' GROUP BY t.tid";

	$smarty->assign('keres_text',$g['keres']);
	$smarty->assign('keres_reset',$_SERVER['REQUEST_URI']);
}

db::futat($pari);
$tomb = db::tomb();

$topikok = array();
$focim = array();
foreach($tomb as $k => $v) {
	$topikok[$v['fid']][] = array('tipus' => $v['tipus'], 'tid' => $v['tid'], 'tema' => $v['tema'], 'ismerteto' => $v['ismerteto'], 'hsz_datum' => @date('Y.m.d H:i:s', $v['hsz_date']), 'uid' => $v['uid'], 'name' => $v['name'], 'rang' => $v['rang'], 'minrang' => $v['minrang']);
	$focim[$v['fid']] = $v['focim'] ;
}

foreach($focim as $key => $val) {
	$sql = "SELECT SUM(".
			"(SELECT COUNT(*) FROM forum_hsz h WHERE t.tid = h.tid)".
			") AS num FROM forum_topik t WHERE t.fid = '%d'";
	db::futat($sql, $key);
	$focim[$key] = $val . " &nbsp;&bull;&nbsp; Hozzászólások összesen " . db::egy_ertek('num') . ' db';
}

$smarty->assign('topikok', $topikok);
$smarty->assign('focim', $focim);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('forum.tpl');
ob_end_flush();

?>
