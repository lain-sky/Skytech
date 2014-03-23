<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'regfalid_lista':
		if(!empty($p['user_id']) && is_numeric($p['user_id']))
			$searchUserId = (int)$p['user_id'];

		if(!empty($p['user_name']))
			$searchUserId = (int)User::getIdByName($p['user_name']);

		if(!empty($searchUserId)) {
			$loadUser = User::load($searchUserId);

			$viewData['user_id'] = $loadUser['uid'];
			$viewData['user_name'] = $loadUser['name'];

			$where[] = "uid='" . $searchUserId . "'";
		}

		if(!empty($p['datum_tol']) && !empty($p['datum_ig']))
			$where[] = " (reg_date BETWEEN '" . strtotime($p['datum_tol']) . "' AND '" . strtotime($p['datum_ig']) . "') ";
		elseif(!empty($p['datum_tol']))
			$where[] = " (reg_date >= '" . strtotime($p['datum_tol']) . "')";
		else {
			$p['datum_tol'] = date('Y-m-d', (time()-(60*60*24*3)));
			$where[] = " (reg_date >= '" . strtotime($p['datum_tol']) . "')";
		}

		$viewData['datum_tol'] = $p['datum_tol'];
		$viewData['datum_ig'] = $p['datum_ig'];

		$sql = "SELECT * FROM users WHERE statusz = 'uj' ";

		if(!empty($where) && count($where) >0)
			$sql .= " and " . implode(' AND ', $where);

		$sql .= " ORDER BY uid ";

		$array=db::getAll($sql);

		foreach($array as $i => $row) {
			$array[$i]['reg_date'] = date('Y-m-d H:i:s', $row['reg_date']);
		}

		$smarty->assign('modul', 'regfalid_lista');
		$smarty->assign('modulnev', 'Hibás regisztrációk');
		$smarty->assign('data', $viewData);
		$smarty->assign('errorList',$array);
	break;

	case 'regfalid_resend':
		if(!empty($r['id'])) {
			$loadUser = User::load($r['id']);
			$userId = $loadUser['uid'];
			$userName = $loadUser['name'];
			$userMail = $loadUser['email'];
			$vadat = veletlen_adat($userName);

			$sql = "UPDATE users SET pass = '%s' WHERE uid = '%d' ";
			db::futat($sql, $vadat['passhash'], $userId);

			$ellenor=veletlen_ellenor();

			//az ellenõrzõ adatok rogzítése
			db::futat("INSERT INTO regisztral(uid, date, type, tema, ellenor) VALUES('%d', '%d', 'reg', '', '%s')", $userId, time(), md5($ellenor));

			//email kiküldése
			require_once( CLASS_DIR . 'mailer.class.php');

			if(sendEmail($userMail, $userMail, OLDAL_NEVE." - regisztráció megerõsítése", reg_mail(array('name' => $userName, 'pass' => $vadat['password'], 'ellenor' => $ellenor)))) {
				$_SESSION['uzenet'] = nyugta('A levelet kiküldtük!');
				logs::sysLog('user_admin', 'reg_ujrakuld', 'uid=' . $r['id']);
			} else {
				$_SESSION['uzenet'] = hiba_uzi('Kiküldési hiba! Kérlek jelezd a staffnak!');
			}
		} else {
			$_SESSION['uzenet'] = hiba_uzi('Error');
		}

		$smarty->assign('modul', 'ban_uj');
		$smarty->assign('modulnev', 'Új ban létrehozása');
		header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=regfalid_lista");
		exit;
	break;

	case 'regfalid_confirm':
		if(!empty($g['id']) && is_numeric($g['id'])) {
			$sql = "UPDATE users SET statusz = 'aktiv' WHERE uid = '%d' ";

			db::futat($sql, $g['id']);
			logs::sysLog( 'user_admin' , 'reg_megerosit', 'uid='. $g['id']  );

			$_SESSION['uzenet'] = nyugta('Az usert aktiváltuk adj meg neki új jelszót, ill emailt, ha szükséges');
			header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=user_mod&id=" . $g['id']);
			exit;
		}

		$_SESSION['uzenet'] = hiba_uzi('Error');
		header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=regfalid_lista");
		exit;
	break;

	case 'csoportos_meghivas':
		if(!empty( $_FILES["lista"]["tmp_name"])) {
			$tomb = array();
			foreach(file($_FILES["lista"]["tmp_name"]) as $row) {
				if(count($tomb) > 50)
					continue;

				$row = trim($row);
				if(!empty($row))
					$tomb[]= $row;
			}

			$smarty->assign('cimek', $tomb);
		}

		$smarty->assign('modul', 'csoportos_meghivas');
		$smarty->assign('modulnev', 'Csoportos meghívás');
	break;

	case 'csoportos_send':
		$cimek = $_POST['cimek'];

		foreach($cimek as $cim) {
			$sql = "INSERT INTO meghivo (uid, feltolt, email, datum) VALUES (%d, %f, '%s', now())";
			db::futat($sql, $USER['uid'], $USER['feltolt'], $cim);

			$ellenor=veletlen_ellenor();
			$sql = "INSERT INTO regisztral (uid, date, type, tema, ellenor) VALUES ('%d', '%d', 'meghivo', '%d', '%s')";
			db::futat($sql, $USER['uid'], time(), db::$id, md5($ellenor));

			require_once( CLASS_DIR . 'mailer.class.php');
			sendEmail($cim, $cim, OLDAL_NEVE." - meghívó", meghivo_mail(array('mail' => $cim, 'nev' => $USER['name'], 'ellenor' => $ellenor)));
		}

		$_SESSION['uzenet'] = nyugta('Leveleket kiküldtük');
		header('Location:' . $_SERVER['SCRIPT_NAME']);
		exit;
	break;
}

?>
