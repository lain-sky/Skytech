<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


db::futat("SELECT uid FROM users WHERE uid = '%d'", $g['uid']);
if(db::$sorok != 1) {
	$OLDAL[]=hiba_uzi('Nincs ilyen felhasználónk!');
} else {
	if($USER['rang'] >= USER_ADMIN_IN_USERINFO) {
		$smarty->assign('adminpanel', true);
		$smarty->assign('oldal_cime', $_SERVER['SCRIPT_NAME'] . '?uid=' . $g['uid']);

		$warn = Warn::get($g['uid']);
		if($warn !== true) {
			$smarty->assign('warn', $warn);
			$smarty->assign('warnid', Warn::getId($g['uid'], 'warn'));
		}

		$ban = Warn::get($g['uid'], 'ban');
		if($ban !== true) {
			$smarty->assign('ban', $ban);
			$smarty->assign('banid', Warn::getId($g['uid'], 'ban'));
		}

		if(!empty($p['text']) && !empty($p['lejar'])) {
			if($g['uid'] == 1 || $g['uid'] == 2) {
				header('location:' . $_SERVER['SCRIPT_NAME'] . '?uid=' . $g['uid']);
				exit;
			}
			switch($p['lejar']) {
				case '1':
				case '2':
				case '3':
				case '4':
					$lejar_mod = time() + (604800 * $p['lejar']);
				break;

				case '5';
					$lejar_mod = time() + (604800 * 150);
				break;
			}

			Warn::add($g['uid'], $p['text'], date('Y-m-d H:i:s', $lejar_mod), $p['type']);
			$_SESSION['uzenet'] = nyugta('A hozzáadása megtörtént');
			header('location:' . $_SERVER['SCRIPT_NAME'] . '?uid=' . $g['uid']);
			exit;
		}

		if(!empty($p['del']) && is_numeric($p['del'])) {
			Warn::del($p['del']);
			$_SESSION['uzenet'] = nyugta('A törlése megtörtént');
			header('location:' . $_SERVER['SCRIPT_NAME'] . '?uid=' . $g['uid']);
			exit;
		}
	}

	$userinfo = User::load($g['uid']);

	if(($USER['rang'] >= $userinfo['rang'] && $USER['rang'] >= USER_EMAIL_NO_HIDDEN_MIN_RANG) || ($USER['uid'] == $userinfo['uid']))
		$smarty->assign('mailNoHidden', true);
	else
		$smarty->assign('mailNoHidden', false);

	$userinfo['barat'] = isBarat($g['uid']);
	$userinfo['reg_date'] = str_replace('.', '-', $userinfo['reg_date']);
	$userinfo['vizit'] = str_replace('.', '-', $userinfo['vizit']);
	$smarty->assign('uinfo', $userinfo);
	$smarty->assign('user_neve', $userinfo['name'] . ' profilja');
	$smarty->assign('ladad', User::getLadad($g['uid'], true));

	$sajatTorrent = Torrent::fullLoad(array("t.uid='" . $g['uid'] . "'"));
	$smarty->assign('sajattorrent', $sajatTorrent);
	
	$where[] = "t.tid IN(SELECT p.tid FROM peers p WHERE p.uid = '" . $g['uid'] . "')";
	$aktivTorrent = Torrent::fullLoad($where);
	$smarty->assign('aktivtorrent', $aktivTorrent);
}

$smarty->assign('OLDAL', $OLDAL);
$smarty->display('userinfo.tpl');
ob_end_flush ();

?>
