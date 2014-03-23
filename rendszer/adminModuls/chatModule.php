<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'chat_szoba':
		$smarty->assign('modul', 'chat_szoba');

		if(!empty($r['modid'])) {
			$smarty->assign('modid', $r['modid']);
			$smarty->assign('mod', chat::getSzoba($r['modid']));
			$smarty->assign('modulnev', 'Szoba módosítás');
			$smarty->assign('feldolgozo_modul', 'chat_mod_szoba');
			$smarty->assign('modid', $r['modid']);
		} else {
			$smarty->assign('modulnev', 'Új szoba');
			$smarty->assign('modulnev2', 'Chat szobak');
			$smarty->assign('szobak', chat::getSzoba());
			$smarty->assign('feldolgozo_modul', 'chat_add_szoba');
		}
	break;

	case 'chat_del_szoba':
		logs::sysLog('chat', 'chat szoba törlés', 'id=' . $r['modid']);

		chat::delSzoba($r['modid']);
		$_SESSION['uzenet'] = nyugta('Sikeres törlés!');
		header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=chat_szoba");
		exit;
	break;
	
	case 'chat_add_szoba':
		logs::sysLog('chat', 'chat szoba létrehozás', 'name=' . $r['nev']);

		chat::addSzoba($r['nev'], $r['leiras']);
		$_SESSION['uzenet'] = nyugta('Sikeres rögzítés!');
		header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=chat_szoba");
		exit;
	break;

	case 'chat_mod_szoba':
		logs::sysLog('chat', 'chat szoba módosítás', 'id=' . $r['modid']);

		chat::updateSzoba($r['modid'], $r['nev'], $r['leiras']);
		$_SESSION['uzenet'] = nyugta('Sikeres modositas');
		header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=chat_szoba");
		exit;
	break;
}

?>
