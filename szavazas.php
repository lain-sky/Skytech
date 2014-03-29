<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


if(!empty($p) && $USER['rang'] >= SZAVAZAS_ADMIN_MIN_RANG) {
	if($p['modmezo'] == 'uj') {
		if(db::futat("INSERT INTO szavazas (cim, datum) VALUES ('%s', NOW())", $p['kerdes']) === true) {
			$szavaz_id = db::$id;
			foreach($p['valasz'] as $v) {
				if(!empty($v)) {
					db::futat("INSERT INTO szavazas_elem (szid, text) VALUES('%d', '%s')", $szavaz_id, $v);
				}
			}
			$_SESSION['uzenet'] = nyugta('Az új szavazás rögzítés sikerült');
			header('Location: ' . $p['vissza']);
			exit;
		} else {
			$OLDAL[] = hiba_uzi('A rögzítés sikertelen');
		}
	} elseif($p['modmezo'] == 'mod' && is_numeric($p['modid'])) {
		if(!empty($p['kerdes'])) {
			if(db::futat("UPDATE szavazas SET cim = '%s' WHERE szid = '%d'", $p['kerdes'], $p['modid']) === true) {
				foreach($p['regi'] as $key => $val) {
					if(!empty($val)) {
						db::futat("UPDATE szavazas_elem SET text = '%s' WHERE sze_id = '%d'", $val, $key);
					} else {
						db::futat("DELETE FROM szavazas_elem WHERE sze_id = '%d'", $key);
						db::futat("DELETE FROM szavazatok WHERE sze_id = '%d'", $key);
					}
				}

				foreach($p['valasz'] as $v) {
					if(!empty($v))
						db::futat("INSERT INTO szavazas_elem (szid, text) VALUES ('%d', '%s')", $p['modid'], $v);
				}
				$_SESSION['uzenet'] = nyugta('A módosítás sikerült');
				header('Location: ' . $p['vissza']);
				exit;
			} else {
				$OLDAL[] = hiba_uzi('A módosítás sikertelen');	
			}
		} else {
			$OLDAL[] = hiba_uzi('A kérdés címe nem volt kitöltve ezért nem végeztem mûveletet');
		}
	} elseif($p['modmezo'] == 'del' && is_numeric($p['modid'])) {
		if(db::futat("DELETE FROM szavazas WHERE szid = '%d'", $p['modid']) === true) {
			db::futat("DELETE FROM szavazas_elem WHERE szid = '%d'", $p['modid']);
			db::futat("DELETE FROM szavazatok WHERE szid = '%d'", $p['modid']);
			die('ok');
		} else {
			$OLDAL[]=hiba_uzi('A törlés sikertelen');
		}
	}
}

if(!empty($g) && $USER['rang'] >= SZAVAZAS_ADMIN_MIN_RANG) {
	$smarty->assign('feldolgozo', $_SERVER['SCRIPT_NAME']);
	$smarty->assign('vissza', $g['vissza']);

	if($g['mit'] == 'uj') {
		$form[] = array('olv' => 'Kérdés', 'id' => 'kerdes');
		for($i = 1; $i < 11; $i++) {
			$form[] = array('olv' => 'Válasz ' . $i, 'id' => 'valasz[' . $i . ']');
		}	
		$smarty->assign('form', $form);
		$smarty->assign('modmezo', '<input type="hidden" name="modmezo" value="uj" />');
		$smarty->assign('fejlec', 'Új szvazás');
	} elseif($g['mit'] == 'mod' && is_numeric($g['id'])) {
		db::futat("SELECT cim FROM szavazas WHERE szid = '%d'", $g['id']);
		$cim = db::tomb();
		$form[] = array('olv' => 'Kérdés', 'id' => 'kerdes', 'val' => $cim[0]['cim']);

		db::futat("SELECT sze_id, text FROM szavazas_elem WHERE szid = '%d' ORDER BY szid", $g['id']);
		$tomb = db::tomb();

		foreach($tomb as $i => $elem) {
			$form[] = array('olv' => 'Válasz ' . ($i + 1), 'id' => 'regi[' . $elem['sze_id'] . ']', 'val' => $elem['text']);
		}

		for($i = count($tomb); $i < 11; $i++) {
			$form[] = array('olv' => 'Válasz ' . $i, 'id' => 'valasz[' . $i . ']');
		}	

		$smarty->assign('form', $form);
		$smarty->assign('modmezo', '<input type="hidden" name="modmezo" value="mod" /><input type="hidden" name="modid" value="' . $g['id'] . '" />');
		$smarty->assign('fejlec', 'Szavazás módosítása');
	} elseif($g['mit'] == 'del' && is_numeric($g['id'])) {
		$smarty->assign('modmezo', '<input type="hidden" name="modmezo" value="del" /><input type="hidden" name="modid" value="' . $g['id'] . '" />');
		$smarty->assign('fejlec', 'Szavazás törlése');
	} else {
		$OLDAL[] = hiba_uzi('Vak vágány');
	}
} else {
	db::futat("SELECT szid, cim, datum FROM szavazas ORDER BY szid DESC LIMIT 0, 15");
	$tomb=db::tomb();
	$szavazasok = array();
	foreach($tomb as $i => $elem) {
		$szavazasok[$i]['cim'] = $elem['cim'];
		$szavazasok[$i]['datum'] = $elem['datum'];
		$szavazasok[$i]['text'] = $old->szavazas_eredmeny($elem['szid']);
		if($USER['rang'] >= SZAVAZAS_ADMIN_MIN_RANG) {
			$szavazasok[$i]['link'] = '<a href="szavazas.php?mit=mod&id=' . $elem['szid'] . '">Szavazás szerkesztése</a> &bull; ';
			$szavazasok[$i]['link'] .= '<a href="szavazas.php?mit=del&id=' . $elem['szid'] . '"class="szavaztorol" alt="' . $elem['szid'] . '">Szavazás törlése</a> &bull; ';
			$szavazasok[$i]['link'] .= '<a href="szavazas.php?mit=uj">Új szavazás</a>';
		}
	}
	$smarty->assign('szavazasok', $szavazasok);
}

$smarty->assign('OLDAL', $OLDAL);
$smarty->display('szavazas.tpl');
ob_end_flush();

?>
