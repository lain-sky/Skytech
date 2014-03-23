<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'syslog':
		$where = array();

		if(!empty($p['user_id']) && is_numeric($p['user_id']))
			$searchUserId = (int)$p['user_id'];

		if(!empty($p['user_name']))
			$searchUserId = (int)User::getIdByName($p['user_name']);
		
		if(!empty($searchUserId)) {
			$where[] = " l.uid = '" . $searchUserId . "'";
			$searchUser = User::load($searchUserId);
			$data['user_id'] = $searchUser['uid'];
			$data['user_name'] = $searchUser['name'];
		}

		if(!empty($p['datum_tol']) && !empty($p['datum_ig']))
			$where[] = " (l.datum BETWEEN '" . $p['datum_tol'] . "' AND '" . $p['datum_ig'] . "') ";
		elseif(!empty($p['datum_tol']))
			$where[] = " (l.datum >= '" . $p['datum_tol'] . "')";
		
		if(!empty($p['log_type']))
			$where[] = " (type = '" . $p['log_type'] . "')";

		$data['datum_tol'] = $p['datum_tol'];
		$data['datum_ig'] = $p['datum_ig'];
		$data['log_type'] = $p['log_type'];

		$sql = "SELECT l.* ,
			(SELECT u.name FROM users u WHERE u.uid = l.uid) user_name
			FROM logs_system l WHERE ";

		$sql .= implode(' AND ', $where);
		$sql .= " ORDER BY lid DESC";

		if(count($where) > 0)
			$smarty->assign('log', db::getAll( $sql) );
		
		$smarty->assign('modul', 'syslog');	
		$smarty->assign('modulnev', 'System Log');
		$smarty->assign('logType', logs::getAllSysLogType());
		$smarty->assign('data', $data);
	break;

	case 'pontlog':
		$where = array();

		if(!empty($p['user_id']) && is_numeric($p['user_id']))
			$searchUserId = (int)$p['user_id'];

		if(!empty($p['user_name']))
			$searchUserId = (int)User::getIdByName($p['user_name']);
		
		if(!empty($searchUserId)) {
			$where[] = " l.uid = '" . $searchUserId . "'";
			$searchUser = User::load($searchUserId);
			$data['user_id'] = $searchUser['uid'];
			$data['user_name'] = $searchUser['name'];
		}

		if(!empty($p['datum_tol']) && !empty($p['datum_ig']))
			$where[] = " (l.date BETWEEN '" . $p['datum_tol'] . "' AND '" . $p['datum_ig'] . "')";
		elseif(!empty($p['datum_tol']))
			$where[] = " (l.date >= '" . $p['datum_tol'] . "')";

		$data['datum_tol'] = $p['datum_tol'];
		$data['datum_ig'] = $p['datum_ig'];

		$sql = "SELECT l.*,
			(SELECT u.name FROM users u WHERE u.uid = l.uid) user_name
			FROM pontok l";

		if(count($where) > 0)
			$sql .= " WHERE " . implode(' AND ', $where);

		$sql .= " ORDER BY pid DESC LIMIT 500";
		
		$pontLog = db::getAll($sql);
		foreach($pontLog as $i => $row) {
			$pontLog[$i]['eventText'] = $PONT_EVENTS[$row['event']]['name'];
		}

		$smarty->assign('modul', 'pontlog');
		$smarty->assign('modulnev', 'Pont Log');
		$smarty->assign('data', $data);
		$smarty->assign('pontLog', $pontLog);
	break;

	case 'falidLoginLog':
		switch($_GET['group']) {
			case 'ip':
				$group = 'ip';
			break;
			
			default :
				$group = 'username';
			break;
		}

		$datum = date('Y-m-d');
		$sql = "SELECT username, ip, COUNT(*) AS db FROM logs_falidlogin WHERE datum = '%s' GROUP BY " . $group . " ORDER BY db DESC LIMIT 100";
		$data = db::getAll($sql, $datum);

		$smarty->assign('modul', 'falid_login');
		$smarty->assign('modulnev', 'falid Login');
		$smarty->assign('data', $data);
		$smarty->assign('datum', $datum);
		$smarty->assign('group', $group);
	break;

	case 'falidLoginLogClear':
		$ip = $_GET['ip'];
		$name = $_GET['name'];
		$group = $_GET['group'];

		if(!empty($ip) && $group == 'ip') {
			$sql = "DELETE FROM logs_falidlogin WHERE ip = '%s'";
			db::futat($sql, $ip);

			$_SESSION['uzenet'] = nyugta('Sikeres törlés!');
		} elseif(!empty($name) && $group == 'username') {
			$sql = "DELETE FROM logs_falidlogin WHERE username = '%s'";
			db::futat($sql, $name);

			$_SESSION['uzenet'] = nyugta('Sikeres törlés!');
		} else {
			$_SESSION['uzenet'] = hiba_uzi('Hiányzó adatok!');	
		}

		header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=falidLoginLog");
		exit;
	break;
}

?>
