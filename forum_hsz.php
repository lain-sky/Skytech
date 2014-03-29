<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


$aktualis_oldal = $_SERVER['SCRIPT_NAME'] . '?id=' . $g['id'] . '&amp;page=' . $g['page'];
$smarty->assign('oldal_cime', $aktualis_oldal);
$smarty->assign('oldal_id', 'forum.php?id=' . $g['id']);
$smarty->assign('vissza', 'vissza=' . $_SERVER['SCRIPT_NAME'] . '?id=' . $g['id']);

if(!empty($p['idezet']) && is_numeric($p['idezet'])) {
	db::futat("SELECT text FROM forum_hsz WHERE hid = '%d'", $p['idezet']);
	echo db::egy_ertek('text');
	exit;
}

if(!empty($g['letolt'])) {
	header('Content-Disposition: attachment; filename="levelek.txt"');
	header('Content-Type: plain/text');
	$sql = "SELECT h.*,
		(SELECT t.tema FROM forum_topik t WHERE t.tid = h.tid) AS topik 
		FROM forum_hsz h WHERE hid = '%d'";

	db::futat($sql, $g['letolt']);
	$t = db::elso_sor();
	$u = User::load($t['uid']);

	echo OLDAL_FEJLEC . "\r\n" . OLDAL_CIME . "\r\nFórum hozzászólás\r\n\r\n";
	echo 'Hozzászolás topikja: ' . $t['topik'] . "\r\n";
	echo 'Hozzászólás szerzõje: ' . $u['name'] . "\r\n";
	echo 'Hozzászólás ideje: ' . date('Y-m-d H:i:s', $t['datum']) . "\r\n";
	echo 'Hozzászólás: ' . "\r\n";
	echo $t['text'] . "\r\n";

	exit;
}

if(!is_numeric($g['id'])) {
	$OLDAL[] = hiba_uzi('A kért topik nem létezik');
} else {
	if(db::futat("SELECT tema, ismerteto, tid, status, minrang FROM forum_topik WHERE tid = '%d'", $g['id']) === false) {
		$OLDAL[] = hiba_uzi('A kért topik nem létezik');
	} else {
		$topik = db::tomb();
		$smarty->assign('topik', array('tema' => $topik[0]['tema'], 'ismerteto' => $topik[0]['ismerteto'], 'tid' => $topik[0]['tid'], 'status' => $topik[0]['status']));
		$topik_status = $topik[0]['status'];
		if($USER['rang'] < $topik[0]['minrang']) {
			$ujhsz = false;
		} else {
			$ujhsz = true;
		}

		if($USER['rang'] < JOG_FORUM_HOZZASZOLAS)
			$ujhsz = false;

		$smarty->assign('ujhsz', $ujhsz);

		if($topik[0]['status'] == 'n' || $USER['rang'] >= $topik[0]['minrang']) {
			if(!empty($p['text']) && empty($p['modmezo'])) {
				$rogzit = "INSERT INTO forum_hsz (tid, uid, text, datum) VALUES ('%d', '%d', '%s', '%d')";
				if(db::futat($rogzit, $g['id'], $USER['uid'], $p['text'], time()) === true) {
					$_SESSION['uzenet'] = nyugta('Hozzászólásodat rögzítettük');
					header('Location:' . $aktualis_oldal);
					exit;
				} else {
					$OLDAL[] = hiba_uzi('Rögzítési hiba! Próbáld meg késõbb!');
				}
			} elseif($p['modmezo'] == 'mod' && is_numeric($p['modid'])) {
				$pari = "UPDATE forum_hsz SET text = '%s' WHERE hid = '%d'";
				$modText = "\n\n\n[admin]Módosította:" . $USER['name'] . "\nekkor:" . date("Y.m.d H:i:s") . "[/admin]";
				if(db::futat($pari, $p['text'] . $modText, $p['modid']) === true) {
					$_SESSION['uzenet'] = nyugta('A módosításokat rögzítettük');
					header("Location:" . $aktualis_oldal);
					exit;
				} else {
					$OLDAL[] = hiba_uzi('Rögzítési hiba! Próbáld meg késõbb!');
				}
			} elseif($p['modmezo'] == 'del' && is_numeric($p['modid']) && $USER['rang'] >= FORUM_ADMIN_MIN_RANG) {
				$pari = "DELETE FROM forum_hsz WHERE hid = '%d'";
				if(db::futat($pari, $p['modid']) === true) {
					$_SESSION['uzenet'] = nyugta('A törlés megtörtént');
					header('Location:' . $aktualis_oldal);
					exit;
				} else {
					$OLDAL[] = hiba_uzi('Sikertelen törlés! Próbáld meg késõbb!');
				}
			}
		}

		if($g['mod'] == 'mod' && is_numeric($g['mid'])) {
				db::futat("SELECT text FROM forum_hsz WHERE hid = '%d'", $g['mid']);
				$tomb = db::tomb();
				$smarty->assign('dat', $tomb[0]);
				$smarty->assign('modmezo', '<input type="hidden" name="modmezo" value="mod" /><input type="hidden" name="modid" value="' . $g['mid'] . '" />');
				$smarty->assign('fejlec', 'Fórum hozzászólás módosítása');
				$smarty->assign('vezerlo', 'mod');
		} elseif($g['mod'] == 'del' && is_numeric($g['mid']) && $USER['rang'] >= FORUM_ADMIN_MIN_RANG) {
				$smarty->assign('modmezo', '<input type="hidden" name="modmezo" value="del" /><input type="hidden" name="modid" value="' . $g['mid'] . '" />');
				$smarty->assign('fejlec', 'Hozzászólás törlése');
				$smarty->assign('vezerlo', 'torol');
		}

		$lapozo = new lapozo($_SERVER['REQUEST_URI'], $USER['perold'][1]);
		if(empty($g['keres'])) {
			$pari = "SELECT SQL_CALC_FOUND_ROWS h.* FROM forum_hsz h 
				WHERE h.tid = '" . $topik[0]['tid'] . "' ORDER BY h.hid DESC LIMIT " . $lapozo->limitalo();
		} else {
			$pari = "SELECT SQL_CALC_FOUND_ROWS h.* FROM forum_hsz h 
				WHERE h.tid = '" . $topik[0]['tid'] . "' AND h.text LIKE '%" . $g['keres'] . "%' ORDER BY h.hid DESC LIMIT " . $lapozo->limitalo();
				$smarty->assign('keres_text', $g['keres']);
				$smarty->assign('keres_reset', $_SERVER['REQUEST_URI']);
		}

		db::futat($pari);
		$tomb = db::tomb();
		$hsz = array();
		foreach($tomb as $k => $v) {
			$uinfo = User::load($v['uid']);
			$hsz[$k] = $uinfo;
			$hsz[$k]['datum'] = date('Y.m.d H:i:s', $v['datum']);
			$hsz[$k]['text'] = bb::bbdecode($v['text']);
			$hsz[$k]['hid'] = $v['hid'];

			if($v['uid'] == $USER['uid'] && $topik_status == 'n') {
				$hsz[$k]['sajathsz'] = true;
			}
		}
		$smarty->assign('hsz', $hsz);

		db::futat("SELECT FOUND_ROWS() AS id");
		$lapozo->max = db::sor();
		$smarty->assign('lapozo', $lapozo->szamsor());
		$smarty->assign('betuvel', $lapozo->betuvel());
		$smarty->assign('selectbe', $lapozo->selectbe());

		if($USER['rang'] >= FORUM_ADMIN_MIN_RANG) {
			$smarty->assign('admin_link', 'true');
		}
	}
}

$smarty->assign('OLDAL', $OLDAL);
$smarty->display('forum_hsz.tpl');
ob_end_flush();

?>
