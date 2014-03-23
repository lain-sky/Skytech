<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'uzenofal':
		$data = array();
		db::futat("SELECT cim, text, cid, mod_user, mod_date FROM cikk WHERE mihez = 'uzifal' ORDER BY mod_date DESC ");

		foreach(db::tomb() as $i => $row) {
			foreach($row as $key => $val) {
				$data[$i][$key] = ($key == 'text') ? bb::bbdecode($val) : $val;
			}
			$data[$i]['mod_user_name'] = User::getNameById($row['mod_user']);
		}

		$smarty->assign('modul','uzenofal');
		$smarty->assign('modulnev','Üzenõfal');
		$smarty->assign('data',$data);
	break;

	case 'uzenofal_uj':
		$smarty->assign('modul', 'uzenofal_uj');
		$smarty->assign('modulnev', 'Új bejegyzés létrehozása');
	break;

	case 'uzenofal_mod':
		$doc = new Doc();
		$modId = (int)$g['id'];

		$smarty->assign('modul','uzenofal_uj');
		$smarty->assign('modulnev','Bejegyzés szeresztése');
		$smarty->assign('data', $doc->getById($modId));
	break;

	case 'uzenofal_save':
		$doc = new Doc();
		$modId = (int)$p['id'];
		$data['cim'] = $p['cim'];
		$data['text'] = $p['text'];
		$data['mihez'] = 'uzifal';
		$data['mod_user'] = $USER['uid'];
		$data['mod_date'] = date('Y-m-d H:i:s');

		if(!empty($modId)) {
			logs::sysLog('uzenofal', 'uzenofal modositas', 'docId=' . $modId);
			$doc->update(array('cid' => $modId), $data);
		} else {
			logs::sysLog('uzenofal', 'új uzenofal', 'cim=' . $p['cim']);
			$doc->add($data);
		}

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=uzenofal");
		exit;
	break;

	case 'uzenofal_del':
		$doc = new Doc();
		$modId = (int)$g['id'];

		logs::sysLog('uzenofal', 'uzenofal törlés', 'docId=' . $modId);
		$doc->del(array('cid' => $modId));

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=uzenofal");
		exit;
	break;
}

?>
