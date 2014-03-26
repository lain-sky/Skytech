<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'temakor_lista':
		$tema = new forumTema();
		$topik = new forumTopik();
		$kesz = array();

		foreach($tema->getAll() as $i => $row) {
			$kesz[$i] = $row;
			foreach($tema->getChilden($row['fid']) as $subRow) {
				$kesz[$i]['childen'][] = $topik->getById($subRow['id']);
			}
		}

		$smarty->assign('modul', 'temakor_lista');
		$smarty->assign('modulnev', 'Fórum témakör');
		$smarty->assign('data', $kesz);
	break;

	case 'temakor_uj':
		$smarty->assign('modul', 'temakor_uj');
		$smarty->assign('modulnev', 'Új fórum témakör');
	break;
	
	case 'temakor_mod':
		$tema = new forumTema();
		$modId = (int)$g['id'];

		$smarty->assign('modul', 'temakor_uj');
		$smarty->assign('modulnev', 'Témakör szeresztése');
		$smarty->assign('data', $tema->getById($modId));
	break;

	case 'temakor_save':
		$tema = new forumTema();
		$data['cim'] = $p['cim'];
		$modId = (int)$p['id'];

		if(!empty($modId)) {
			logs::sysLog('forum', 'fórum témakör mód', 'temaId=' . $modId);
			$tema->update(array('fid' => $modId), $data);
		} else {
			logs::sysLog('forum', 'új fórum témakör', 'temaCim=' . $p['cim']);
			$tema->add($data);
		}

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=temakor_lista");
		exit;
	break;

	case 'temakor_del':
		$tema = new forumTema();
		$modId = (int)$g['id'];

		if(count($tema->getChilden($modId)) > 0) {
			$_SESSION['uzenet'] = hiba_uzi('A témacsoport nem üres!');
			header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=temakor_lista");
			exit;
		}

		logs::sysLog('forum', 'fórum témakör törlés', 'temaId=' . $modId);
		$tema->del(array('fid' => $modId));

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=temakor_lista");
		exit;
	break;

	/*** TOPIC ***/
	case 'topik_uj':
		$tema = new forumTema();

		$smarty->assign('modul', 'topik_uj');
		$smarty->assign('modulnev', 'Új topik');
		$smarty->assign('csoportok', $tema->getAll());
	break;

	case 'topik_mod':
		$topik = new forumTopik();
		$tema = new forumTema();
		$modId=(int)$g['id'];

		$smarty->assign('modul', 'topik_uj');
		$smarty->assign('modulnev', 'Topik szerkesztés');
		$smarty->assign('csoportok', $tema->getAll());
		$smarty->assign('data', $topik->getById($modId));
	break;

	case 'topik_save':
		$topik=new forumTopik();
		$modId=(int)$p['id'];

		$data['tema'] = $p['tema'];
		$data['ismerteto'] = $p['ismerteto'];
		$data['fid'] = $p['csoport'];
		$data['status'] = $p['status'];
		$data['minrang'] = $p['minrang'];

		if(!empty($modId)) {
			logs::sysLog('forum', 'fórum topik mód', 'topikId=' . $modId);
			$topik->update(array('tid' => $modId), $data);
		} else {
			logs::sysLog('forum', 'új fórum topik', 'topikCím=' . $p['tema']);
			$topik->add($data);
		}

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=temakor_lista");
		exit;
	break;

	case 'topik_del':
		$topik = new forumTopik();
		$modId=(int)$g['id'];

		logs::sysLog('forum', 'fórum topik del', 'topikId=' . $modId);
		$topik->del(array('tid' => $modId));

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=temakor_lista");
		exit;
	break;
}

?>
