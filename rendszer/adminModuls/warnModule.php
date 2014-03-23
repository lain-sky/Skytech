<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'warn_lista':
		$smarty->assign('modul', 'warn_lista');
		$smarty->assign('modulnev', 'WARN');
		$smarty->assign('data', Warn::getAllByType('warn'));
	break;

	case 'warn_uj':
		if(!empty($p['user_id']) && is_numeric($p['user_id']))
			$searchUserId = (int)$p['user_id'];

		if(!empty($p['user_name']))
			$searchUserId = (int)User::getIdByName($p['user_name']);

		if(!empty($searchUserId))
			$smarty->assign('data', User::load($searchUserId));

		$smarty->assign('modul', 'warn_uj');
		$smarty->assign('modulnev', 'Új WARN létrehozása');
	break;

	case 'warn_save':
		$data['uid'] = (int)$p['warnuid'];
		$data['aid'] = $USER['uid'];
		$data['text'] = $p['text'];
		$data['lejar'] = $p['lejar'];
		$data['type'] = 'warn';

		logs::sysLog('warn', 'új warn', 'uid=' . $data['uid']);
		Warn::add($data['uid'], $data['aid'], $data['text'], $data['lejar'], $data['type']);

		$pont = new Pont();
		$pont->addWarn($data['uid']);

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=warn_lista");
		exit;
	break;

	case 'warn_del':
		logs::sysLog('warn', 'warn törlés', 'warnid=' . $g['id']);
		Warn::del((int)$g['id']);

		$_SESSION['uzenet'] = nyugta('A müvelet sikeres');
		header("Location:" . $_SERVER['SCRIPT_NAME'] . "?modul=warn_lista");
		exit;
	break;
}

?>
