<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'hir_lista':
		$hir = new Hir();
		$hirek = $hir->getAll();

		foreach($hirek as $key => $val) {
			$hirek[$key]['text'] = bb::bbdecode($val['text']);
		}

		$smarty->assign('modul', 'hir_lista');
		$smarty->assign('modulnev', 'Hírek');
		$smarty->assign('data', $hirek);
	break;

	case 'hir_uj':
		$smarty->assign('modul', 'hir_uj');
		$smarty->assign('modulnev', 'Új hír létrehozása');
		$smarty->assign('data', array('datum' => date('Y-m-d H:i:s')));
	break;

	case 'hir_mod':
		$hir = new Hir();
		$modId = (int)$g['id'];

		$smarty->assign('modul', 'hir_uj');
		$smarty->assign('modulnev', 'Hír szeresztése');
		$smarty->assign('data', $hir->getById($modId));
	break;

	case 'hir_save':
		$hir = new Hir();
		$modId = (int)$p['id'];

		$data['cim'] = $p['cim'];
		$data['text'] = $p['text'];
		$data['datum'] = $p['datum'];
		$data['disp'] = $p['disp'];

		if(!empty($modId)) {
			logs::sysLog('hir', 'hir mód', 'hirId=' . $modId);
			$hir->update(array('hid' => $modId), $data);
		} else {
			logs::sysLog('hir', 'hir új', 'hirCím=' . $p['cim']);
			$hir->add($data);
		}

		Cache::set(CACHE_HIREK);

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=hir_lista");
		exit;
	break;

	case 'hir_del':
		$hir = new Hir();
		$modId = (int)$g['id'];

		logs::sysLog('hir', 'hir töröl', 'hirId=' . $modId);
		$hir->del(array('hid' => $modId));

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=hir_lista");
		exit;
	break;
}

?>
