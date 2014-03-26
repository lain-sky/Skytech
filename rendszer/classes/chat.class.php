<?php
if(!defined('SZINT1') || SZINT1 !== 666 )
	die('Hozzáférés megtagadva');

define('CHAT_AKTIV_LIMIT',300);

class chat {
	function addSzoba($nev, $leiras) {
		if(!empty($nev)) {
			$sql = "INSERT INTO chat_szoba (nev, leiras) VALUES ('%s', '%s')";
			db::futat($sql, $nev, $leiras);
		}
	}

	function delSzoba($id) {
		if(!empty($id) && is_numeric($id)) {
			$sql = "DELETE FROM chat_szoba WHERE cszid = '%d'";
			db::futat($sql, $id);

			$sql = "DELETE FROM chat WHERE cszid = '%d'";
			db::futat($sql, $id);
		}
	}

	function getSzoba($id = null) {
		if($id === null) {
			$sql = "SELECT * FROM chat_szoba ORDER BY nev";
			db::futat($sql);
			return db::tomb();
		} else {
			$sql = "SELECT * FROM chat_szoba WHERE cszid = '%d' ORDER BY nev";
			db::futat($sql, $id);
			return db::elso_sor();
		}
	}

	function updateSzoba($id, $nev, $leiras) {
		if(!empty($id) && is_numeric($id) && !empty($nev)) {
			$sql = "UPDATE chat_szoba SET nev = '%s', leiras = '%s' WHERE cszid = '%d'";
			db::futat($sql, $nev, $leiras, $id);
		}
	}

	function getSzobaListaAjax() {
		$sql = "SELECT *, (CELECT COUNT(DISTINCT(c.uid)) FROM chat c WHERE c.cszid = sz.cszid AND UNIX_TIMESTAMP(c.datum) > (UNIX_TIMESTAMP(NOW()) -  600)) AS userek FROM chat_szoba sz WHERE cszid != 14 ORDER BY sz.nev";		
		db::futat($sql);

		return db::tomb();
	}

	function getUserInSzoba($id) {
		$sql = "SELECT (SELECT name FROM users u WHERE u.uid = c.uid) AS name FROM chat c WHERE cszid = '%d' AND UNIX_TIMESTAMP(datum) > '%d' GROUP BY c.uid";
		db::futat($sql, $id, (time() - CHAT_AKTIV_LIMIT));
		return db::tomb();
	}

	function getHsz($id, $limit = false) {
		$tol = &$_SESSION['chat'][$id];
		$sql = "SELECT *, UNIX_TIMESTAMP(datum) AS moddatum,
		(SELECT name FROM users u WHERE u.uid = c.uid) AS name,
		(SELECT rang FROM users u WHERE u.uid = c.uid) AS rang 
		FROM chat c WHERE cszid = '%d'";

		if($limit !== false) {
			$sql .= " ORDER BY cid DESC";
			$sql .= " LIMIT " . $limit;
		} elseif(is_numeric($tol)) {
			$sql .= " AND cid > " . $tol;
			$sql .= " ORDER BY cid DESC";
		} else {
			$sql .= " ORDER BY cid DESC";
			$sql .= " LIMIT 1";
		}

		db::futat($sql, $id);
		$tomb = db::tomb();

		if(count($tomb) > 0)
			$tol = $tomb[0]['cid'];

		return $tomb;		
	}

	function addHsz($id, $text) {
		$sql = "INSERT INTO chat (cszid, uid, text, datum) VALUES ('%d', '%d', '%s', '%s')";
		db::futat($sql, $id, $GLOBALS['USER']['uid'], $text, date('Y.m.d H:i:s'));
	}

	function addBelepes($id) {
		$ki = $GLOBALS['USER']['name'];
		$text = '##automatikus_uzi##[color=green][b]' . $ki . ' belépett a szobába :!: [/b][/color]';
		chat::addHsz($id, $text);	
	}

	function delHsz($id) {
		$sql = "DELETE FROM chat WHERE cid = '%d'";
		db::futat($sql, $id);
	}

	function szobaKiurit($id) {
		$sql = "DELETE FROM chat WHERE cszid = '%d'";
		db::futat($sql, $id);
	}
}

?>
