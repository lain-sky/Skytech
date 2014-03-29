<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


switch($p['modul']) {
	case 'szobalist':
		$tomb = chat::getSzobaListaAjax();
		$t = array();

		foreach($tomb as $key => $val) {
			$t[$key] = "<div class='szl_sor " . (($key % 2) == 0 ? 'div_odd' : 'div_even') . "' >";
			$t[$key] .= "<span alt='" . $val['cszid'] . "' class='szl_click kat'>" . $val['nev'] . "(" . $val['userek'] . ")</span>";
			$t[$key] .= "</div>";
		}
		db::hardClose();
		die(implode('', $t));
	break;

	case 'szobainfo':
		if(!empty($p['id']) && is_numeric($p['id'])) {
			$adatlap = chat::getSzoba($p['id']);
			$t[] = "<p><b>Név:</b>" . $adatlap['nev'] . "<br />";
			$t[] = "<b>Leírása:</b>" . $adatlap['leiras'] . "<br />";
			$t[] = "<b>Userek a szobában:</b></p><br />";
			$userek = chat::getUserInSzoba($p['id']);
			if(count($userek) < 1) {
				$t[] = "<div class='szl_sor div_odd'>A szobábban nincs user</div>";
			} else {
				foreach($userek as $key => $val) {
					$tt = "<div class='szl_sor " . (($key % 2) == 0 ? 'div_odd' : 'div_even') . "' >";
					$tt .= $val['name'];
					$tt .= "</div>";
					$t[] = $tt;
					unset($tt);
				}
			}
		} else {
			$t[] = 'A kereset szoba nem található!';
		}
		db::hardClose();
		die(implode('', $t));
	break;

	case 'gethsz':
		$t = array();
		if(!empty($p['id']) && is_numeric($p['id'])) {
			$extra = ($p['extra'] == 'yes') ? '100' : false;
			$hsz = chat::getHsz($p['id'], $extra);
			foreach($hsz as $key => $val) {
				if(date('Ymd') == date('Ymd', $val['moddatum']))
					$datum = date('H:i:s', $val['moddatum']);
				else
					$datum = date('Y.m.d H:i:s', $val['moddatum']);

				$t[$key] = "<div class='hsz_sor' >";
				$t[$key] .= "<b>" . $datum . "</b>";

				if(strpos($val['text'], '##automatikus_uzi##') !== false)
					$val['text'] = str_replace('##automatikus_uzi##', '', $val['text']);
				else
					$t[$key] .= "-<span class='rank" . $val['rang'] . "'>" . $val['name'] . "</span>";

				$t[$key] .= ": " . bb::bbdecode($val['text']);
				$t[$key] .= "</div>";
			}
		} else {
			$t[] = 'Hiba a frissitéskor!';
		}
		db::hardClose();
		die(implode('', $t));
	break;

	case 'addhsz':
		if(!empty($p['id']) && is_numeric($p['id']) && !empty($p['text'])) {
			$text = trim(iconv("UTF-8", "ISO-8859-2", $p['text']));

			if(strlen($text) < 1)
				die('ures hsz');
			if($p['szin'] != 'alap')
				$text = "[color=" . $p['szin'] . "]" . $text . "[/color]";
			chat::addHsz($p['id'],$text);
		}
		db::hardClose();
	break;

	case 'szobabelep':
		if(!empty($p['id']) && is_numeric($p['id']))
			chat::addBelepes($p['id']);
		db::hardClose();
	break;

	default:
		$t = 'Nem talámom a modult:' . $p['modul'];
		db::hardClose();
		die($t);
	break;
}

$smarty->assign('OLDAL', $OLDAL);
$smarty->display('xxx.tpl');
ob_end_flush();

?>
