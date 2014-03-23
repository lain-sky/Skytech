<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'oldal_stats':
		$where = Stats::makeWhere($p['ig'], $p['tol']);

		switch($p['bontas']) {
			case 'havi':
				$ido = '(hónap)';
				$bontas = " substr(datum, 6, 2)";
			break;

			case 'napi':
				$ido = '(nap)';
				$bontas = " substr(datum, 3, 8)";
			break;

			default :
				$ido = '(hét)';
				$bontas = " week(datum)";
			break;
		}

		//osszes oldal kukucs
		$sql = "SELECT COUNT(*) AS num, " . $bontas . " AS ido FROM logs_user " . $where . " GROUP BY ido ORDER BY ido DESC";
		db::futat($sql);
		$smarty->assign("osszes_oldal", db::tomb());

		//osszes latogato
		$sql = "SELECT COUNT(DISTINCT(uid)) AS num, " . $bontas . " AS ido FROM logs_user " . $where . " GROUP BY ido ORDER BY ido DESC";
		db::futat($sql);
		$smarty->assign("osszes_latogato", db::tomb());

		//oldal látogatások
		$sql = "SELECT COUNT(fajl) AS num, fajl FROM logs_user " . $where . " GROUP BY fajl ORDER BY num DESC";
		db::futat($sql);
		$smarty->assign("osszes_fajl", db::tomb());

		//bongészõk
		$sql="SELECT COUNT(bongeszo) AS num, CONCAT_WS(' ', bongeszo, bongeszo_ver) AS bong, bongeszo, bongeszo_ver FROM logs_user " . $where . " GROUP BY bong ORDER BY num DESC";
		db::futat($sql);

		foreach(db::tomb() as $key => $val) {
			$osszes_bongeszok[] = array("nev" => $BONGESZO_TIPUSOK[$val['bongeszo']] . " " . $val['bongeszo_ver'], "ert" => $val['num']);
		}

		//os
		$sql = "SELECT COUNT(os) AS num, os FROM logs_user " . $WHERE . " GROUP BY os ORDER BY num DESC";
		db::futat($sql);

		foreach(db::tomb() as $key => $val) {
			$osszes_os[] = array("nev" => $OS_TIPUSOK[$val['os']], "ert" => $val['num']);
		}

		$smarty->assign('modulnev', 'Oldal statisztika');
		$smarty->assign('modul', 'oldal_stats');
		$smarty->assign('ido', $ido);
		$smarty->assign('tol', $p['tol']);
		$smarty->assign('ig', $p['ig']);
		$smarty->assign("osszes_bongeszok", $osszes_bongeszok);
		$smarty->assign("osszes_os", $osszes_os);
	break;

	case 'user_stats':
		$where = Stats::makeWhere($p['ig'], $p['tol']);

		switch($p['bontas']) {
			case 'havi':
				$ido = '(hónap)';
				$bontas = "substr(datum, 6, 2)";
				$bontas2 = "substr(from_unixtime(reg_date), 6, 2)";
			break;

			case 'napi':
				$ido = '(nap)';
				$bontas = "substr(datum, 3, 8)";
				$bontas2 = "substr(from_unixtime(reg_date), 3, 8)";
			break;

			default :
				$ido = '(hét)';
				$bontas = "week(datum)";
				$bontas2 = "week(from_unixtime(reg_date))";
			break;
		}

		//regisztrált tagok száma
		$sql = "SELECT COUNT(*) AS num, " . $bontas2 . " AS ido FROM users " . $where . " GROUP BY ido";
		db::futat($sql);
		$smarty->assign("regek", db::tomb());

		//meghívások szama
		$sql = "SELECT COUNT(*) AS num, " . $bontas . " AS ido FROM meghivo " . $where . " GROUP BY ido";
		db::futat($sql);
		$smarty->assign("meghivok", db::tomb());

		//meghivokból való reg
		$sql = "SELECT COUNT(*) AS num, " . $bontas . " AS ido FROM meghivo " . (!empty($where) ? " meghivott IS NOT NULL " : " WHERE meghivott IS NOT NULL ") . " GROUP BY ido";
		db::futat($sql);
		$smarty->assign("meghivo_reg", db::tomb());

		//rangok eloszlasa
		$sql = "SELECT COUNT(rang) AS num, rang FROM users " . $where . " GROUP BY rang ORDER BY num DESC";
		db::futat($sql);
		foreach(db::tomb() as $key => $val) {
			$tomb[] = array("nev" => $RANGOK[$val['rang']], "ert" => $val['num']);
		}

		$smarty->assign('modulnev', 'User statisztika');
		$smarty->assign('modul', 'user_stats');
		$smarty->assign('ido', $ido);
		$smarty->assign('tol', $p['tol']);
		$smarty->assign('ig', $p['ig']);
		$smarty->assign("rangok", $tomb);
	break;

	case 'tracker_stats':
		$where = Stats::makeWhere($p['ig'], $p['tol']);

		switch($p['bontas']) {
			case 'havi':
				$ido = '(hónap)';
				$bontas = "substr(datum, 6, 2)";
			break;

			case 'napi':
				$ido = '(nap)';
				$bontas = "substr(datum, 3, 8)";
			break;

			default :
				$ido = '(hét)';
				$bontas = "week(datum)";
			break;
		}

		//feltoltesek
		$sql = "SELECT SUM(fel) AS num, " . $bontas . " AS ido FROM logs_torrent " . $where . " GROUP BY ido";
		db::futat($sql);
		$smarty->assign("feltoltes", db::tomb());

		//letoltes
		$sql = "SELECT SUM(le) AS num, " . $bontas . " AS ido FROM logs_torrent " . $where . " GROUP BY ido";
		db::futat($sql);
		$smarty->assign("letoltes", db::tomb());

		//eltérés
		$sql = "SELECT ABS(SUM(le)-SUM(fel)) AS num, " . $bontas . " AS ido FROM logs_torrent " . $where . " GROUP BY ido";
		db::futat($sql);
		$smarty->assign("elteres", db::tomb());

		//feltotés-kategoria
		$sql = "SELECT SUM(l.fel) AS num, (SELECT k.nev FROM kategoria k WHERE k.kid = (SELECT t.kid FROM torrent t WHERE t.tid = l.tid)) AS ido FROM logs_torrent l " . $where . " GROUP BY ido ORDER BY num DESC";
		db::futat($sql);
		$smarty->assign("feltoltes_kat", db::tomb());

		//letoltes-kategoria
		$sql = "SELECT SUM(l.le) AS num, (SELECT k.nev FROM kategoria k WHERE k.kid = (SELECT t.kid FROM torrent t WHERE t.tid = l.tid)) AS ido FROM logs_torrent l " . $where . " GROUP BY ido ORDER BY num DESC";
		db::futat($sql);
		$smarty->assign("letoltes_kat", db::tomb());

		//eltérés-kategoria
		$sql = "SELECT ABS(SUM(l.fel)-SUM(l.le)) AS num, (SELECT k.nev FROM kategoria k WHERE k.kid = (SELECT t.kid FROM torrent t WHERE t.tid = l.tid)) AS ido FROM logs_torrent l " . $where . " GROUP BY ido ORDER BY num DESC";
		db::futat($sql);
		$smarty->assign("elteres_kat", db::tomb());

		$smarty->assign('modulnev', 'Tracker statisztika');
		$smarty->assign('modul', 'tracker_stats');
		$smarty->assign('ido', $ido);
		$smarty->assign('tol', $p['tol']);
		$smarty->assign('ig', $p['ig']);
	break;

	case 'cron_stats':
		$where = Stats::makeWhere($p['ig'], $p['tol']);
		
		switch($p['bontas']) {
			case 'havi':
				$ido = '(hónap)';
				$bontas = "substr(datum, 6, 2)";
			break;

			case 'napi':
				$ido = '(nap)';
				$bontas = "substr(datum, 3, 8)";
			break;

			default :
				$ido = '(hét)';
				$bontas = "week(datum)";
			break;
		}

		$cr = array(
			array('nev' => 'rang', 'id' => 1),
			array('nev' => 'peers', 'id' => 2),
			array('nev' => 'chat', 'id' => 3),
			array('nev' => 'logs', 'id' => 4),
			array('nev' => 'reg', 'id' => 5),
			array('nev' => 'warn', 'id' => 6),
		);

		foreach($cr as $val) {
			$sql = "SELECT SUM(sor) AS num, COUNT(*) AS db, " . $bontas . " AS ido FROM logs_cron WHERE type = '%d' GROUP BY ido";
			db::futat($sql, $val['id']);
			$smarty->assign($val['nev'], db::tomb());
		}

		$smarty->assign('modulnev', 'Cron statisztika');
		$smarty->assign('modul', 'cron_stats');
		$smarty->assign('ido', $ido);
		$smarty->assign('tol', $p['tol']);
		$smarty->assign('ig', $p['ig']);
	break;

	case 'cheat_stats':
		$where = " WHERE torrent IS NOT NULL";

		if(empty($_POST['datumtol']))
			$_POST['datumtol'] = date('Y-m-d');

		if(!empty($_POST['datumtol']) && !empty($_POST['datumig']))
			$where .= " AND date BETWEEN '" . $_POST['datumtol'] . "' AND '" . $_POST['datumig'] . "'";
		elseif(!empty($_POST['datumtol']))
			$where .= " AND date >= '" . $_POST['datumtol'] . "'";

		$sql = "SELECT * FROM cheat_files " . $where . " ORDER BY kulonbseg DESC LIMIT 100";
		db::futat($sql);
		$cheatFiles = db::tomb();
		$cheatFilesIds = array();

		foreach($cheatFiles as $item)
			$cheatFilesIds[] = $item['tid'];

		if(count($cheatFilesIds)>=1){
			$sql = "SELECT l.uid, (SELECT name FROM users u WHERE u.uid = l.uid) AS username,
				SUM(feltolt) AS felt, SUM(letolt) AS let, COUNT(*) AS db 
				FROM peerszum l WHERE l.tid IN(" . implode(',', $cheatFilesIds) .") 
				GROUP BY l.uid ORDER BY db DESC LIMIT 100
			";
			db::futat($sql);
			$cheatUsers = db::tomb();
			$smarty->assign('cheatUsers',$cheatUsers);
		}

		$smarty->assign('modul', 'cheat_stats');
		$smarty->assign('modulnev', 'Cheat');
		$smarty->assign('datumtol', $_POST['datumtol']);
		$smarty->assign('datumig', $_POST['datumig']);
		$smarty->assign('cheatFiles', $cheatFiles );
	break;

	case 'cheat_stats_reszletes':
		$torrentId = $_POST['tid'];
		$where = "tid='" . $torrentId . "'";
		//$datumTol = $_POST['datumtol'];
		//$datumIg = $_POST['datumig'];

		if(!empty($datumTol) && !empty($datumIg))
			$where .= " date BETWEEN '" . $datumTol . "' AND '" . $datumIg . "'";
		elseif(!empty($datumTol))
			$where .= " date >= '" . $datumTol . "'";

		$sql = "SELECT 
			(SELECT name FROM users u WHERE u.uid = l.uid) AS username,
			SUM(fel) AS feltolt, SUM(le) AS letolt, l.ip AS kliens_ip,
			(SELECT u2.ip FROM users u2 WHERE u2.uid = l.uid) AS user_ip,
			l.uid FROM logs_torrent l WHERE " . $where . " GROUP BY l.uid, l.ip";

		db::futat($sql);

		$smarty->assign('modul', 'cheat_stats_reszletes');
		$smarty->assign('torrentId', $torrentId);
		$smarty->assign('data', db::tomb());
		echo $smarty->fetch('skytech.tpl');
		die();
	break;

	case 'cheat_user':
		$torrentId = $_REQUEST['tid'];
		$userId = $_REQUEST['uid'];
		$datumTol = $_REQUEST['datumtol'];
		$datumIg = $_REQUEST['datumig'];

		if(!empty($torrentId) && !empty($userId)) {
			$smarty->assign('userName', User::getNameById($userId));
			$smarty->assign('torrentName', Torrent::getNameById($torrentId));

			$where = " tid = '" . $torrentId . "' AND uid = '" . $userId . "'";

			if(!empty($datumTol) && !empty($datumIg))
				$where .= " AND date BETWEEN '" . $datumTol . "' AND '" . $datumIg . "'";
			elseif(!empty($datumTol))
				$where .= " AND  date >= '" . $datumTol . "'";

			$sql = "SELECT * FROM cheat_users WHERE " . $where;
			db::futat($sql);

			$smarty->assign('data', db::tomb());
		}

		$smarty->assign('modul', 'cheat_user');
		$smarty->assign('modulnev', 'Cheat Users');
		$smarty->assign('datumtol', $datumTol);
		$smarty->assign('datumig', $datumIg);
		$smarty->assign('uid', $userId);
		$smarty->assign('tid', $torrentId);
	break;

	case 'user_kovetes':
		$userId = $_POST['uid'];
		$datumTol = $_POST['datumtol'];
		$datumIg = $_POST['datumig'];

		if(!empty($userId) && $userId != 1) {
			$smarty->assign('userName', User::getNameById($userId));

			$where = " uid = '" . $userId . "'";

			if(!empty($datumTol) && !empty($datumIg))
				$where .= " AND datum BETWEEN '" . $datumTol . "' AND '" . $datumIg . "'";
			elseif(!empty($datumTol))
				$where .= " AND datum >= '" . $datumTol . "'";
			
			$sql = "SELECT * FROM logs_user WHERE " . $where . " ORDER BY lid";
			db::futat($sql);

			$kesz = array();
			
			foreach(db::tomb() as $i => $row) {
				foreach($row as $key => $val) {
					switch($key) {
						case 'os':
							$kesz[$i][$key] = $OS_TIPUSOK[$val];
						break;

						case 'bongeszo':
							$kesz[$i][$key] = $BONGESZO_TIPUSOK[$val];
						break;

						default:
							$kesz[$i][$key] = $val;
						break;
					}
				}
			}

			$smarty->assign('data', $kesz);
		}

		$smarty->assign('modul', 'user_kovetes');
		$smarty->assign('modulnev', 'User Követés');
		$smarty->assign('datumtol', $datumTol);
		$smarty->assign('datumig', $datumIg);
		$smarty->assign('uid', $userId);
	break;

	case 'uzenofal':
		$data = array();
		db::futat("SELECT cim, text, cid FROM cikk WHERE mihez = 'uzifal'");
		foreach(db::tomb() as $i => $row) {
			foreach($row as $key => $val) {
				$data[$i][$key] = ($key == 'text') ? bb::bbdecode($val) : $val;
			}
		}

		$smarty->assign('modul', 'uzenofal');
		$smarty->assign('modulnev', 'Üzenõfal');
		$smarty->assign('data', $data);
	break;
}

?>
