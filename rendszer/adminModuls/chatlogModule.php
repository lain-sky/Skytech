<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN != 951)
	die('Hozzáférés megtagadva');

switch($r['modul']) {
	case 'chat_log':
		$smarty->assign('modul', 'chat_log');
		$smarty->assign('modulnev', 'Chatlog');
		$smarty->assign('szobak', chat::getSzoba());
		
		if(!empty($r['id'])) {
			$data = array();
			foreach(chat::getHsz($r['id'], 1000) as $key => $val) {
				$str = '';
				$datum = (date('Ymd') == date('Ymd', $val['moddatum'])) ? date('H:i:s', $val['moddatum']) : date('Y.m.d H:i:s', $val['moddatum']);
				$str .= "<b>" . $datum . "</b>";

				if(strpos($val['text'], '##automatikus_uzi##') !== false)
					$val['text'] = str_replace('##automatikus_uzi##', '', $val['text']);
				else
					$str .= "-<span class='rank" . $val['rang'] . "'>" . $val['name'] . "</span>";

				$str .= ": " . bb::bbdecode($val['text']);
				$data[] = array('comment' => $str, 'id' => $val['cid']);
			}
			$smarty->assign('aktszoba', chat::getSzoba($r['id']));
			$smarty->assign('data', $data);
		}
	break;

	case 'chat_log_del':
		logs::sysLog('chat', 'chat hsz törlés', 'id=' . $r['id']);

		chat::delHsz($r['id']);
		$_SESSION['uzenet'] = nyugta('Sikeres törlés!');
		header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=chat_log&id=" . $r['ret']);
		exit;
	break;
	
	case 'chat_log_kiurit':
		logs::sysLog('chat', 'chat szoba kiurit', 'id=' . $r['id']);
		
		chat::szobaKiurit($r['id']);
		$_SESSION['uzenet'] = nyugta('Sikeres törlés!');
		header('Location:' . $_SERVER['SCRIPT_NAME'] . "?modul=chat_log&id=" . $r['id']);
		exit;
	break;
}

?>
