<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság
/**
* Ez az osztály felel a belsõ levelezéért
* Pélpányosítani nem lehet
* 
* 
* A level tipusai:
* n -> normal level
* b -> barattol szarmazo
* k -> korlevel
* r -> rendszeruzi
* 
* A level status:
* n -> normal level
* u -> uj level
* e -> elkuldott level 
* s -> szemetesben
*/

class level {
	private function __construct() {}

	function felad($tulaj, $partner, $targy, $torzs, $tipus = 'n', $status = 'u', $parent = '0') {
		$datum = time();
		$pari = "INSERT INTO levelek (tulaj, partner, targy, torzs, datum, tipus, status, parent) VALUES ('%d', '%d', '%s', '%s', '%d', '%s', '%s', '%d')";
		$ok = db::futat($pari, $tulaj, $partner, $targy, $torzs, $datum, $tipus, $status, $parent);
		return $ok;
	}

	function korlevel($targy, $torzs, $where = '') {
		$pari =	"INSERT INTO levelek (tulaj, partner, datum, targy, torzs, tipus) ".
				"SELECT uid, '%d', '%d', '%s', '%s', 'k' FROM users u ".
				"WHERE u.statusz = 'aktiv' " . $where;
		$ok = db::futat($pari, OLDAL_MAIL_USER_ID, time(), $targy, $torzs);
		return $ok;
	}

	function staffLevel($torzs) {
		$pari = "INSERT INTO levelek (tulaj, partner, datum, targy, torzs, tipus) ".
				"SELECT uid, '%d', '%d', '%s', '%s', 'r' FROM users u ".
				"WHERE u.rang IN(10,9)";
		$ok = db::futat($pari, OLDAL_MAIL_USER_ID, time(), 'STAFF', $torzs);
		return $ok;
	}

	function levelTorol($mit) {
		$user = $GLOBALS['USER']['uid'];
		$pari = "DELETE FRON levelek WHERE tulaj = '%d' AND lid = '%d'";
		$ok = db::futat($pari, $user, $mit);
		return $ok;
	}

	function setLevelStatus($mit, $status) {
		$user = $GLOBALS['USER']['uid'];
		$pari = "UPDATE levelek SET status = '%s' WHERE tulaj = '%d' AND lid = '%d'";
		$ok = db::futat($pari, $status, $user, $mit);
		return $ok;
	}

	function getBejovo() {
		return self::getLevelLista(1);	
	}

	function getSzemetes() {
		return self::getLevelLista(2);
	}

	function getKuldott() {
		return self::getLevelLista(3);
	}

	function getLevelLista($tipus) {
		$user = $GLOBALS['USER']['uid'];
		switch($tipus) {
			case 1:
				$pari = "SELECT lid, datum, targy, torzs, name, partner, jelolt_e, tipus FROM levelek l ".
						"LEFT JOIN users u ON l.partner = u.uid WHERE (l.status = 'n' OR l.status = 'u') AND ".
						"tulaj = '%d' ORDER BY datum DESC";
			break;

			case 2:
				$pari = "SELECT lid, datum, targy, torzs, name, partner, jelolt_e, tipus FROM levelek l ".
						"LEFT JOIN users u ON l.partner = u.uid WHERE l.status = 's' AND ".
						"tulaj = '%d' ORDER BY datum DESC";
			break;

			case 3:
				$pari = "SELECT lid, datum, targy, torzs, name, partner, jelolt_e, tipus FROM levelek l ".
						"LEFT JOIN users u ON l.partner = u.uid WHERE l.status = 'e' AND ".
						"tulaj = '%d' ORDER BY datum DESC";
			break;
		}

		db::futat($pari, $user);	

		$tomb = db::tomb();
		$kesz = array();
		foreach($tomb as $val) {
			$kesz[] = level::convertLevel($val);
		}
		return $kesz;	
	}

	function getLevel($lid, $convert = 0) {
		$user = $GLOBALS['USER']['uid'];
		$pari = "SELECT lid, datum, targy, torzs, name, partner, jelolt_e, tipus FROM levelek l ".
				"LEFT JOIN users u ON l.partner = u.uid WHERE l.lid = '%d' AND ".
				"tulaj = '%d'";
		db::futat($pari, $lid, $user);

		$tomb = db::tomb();
		if($convert === 1)
			return level::convertLevel($tomb[0]);
		else
			return $tomb[0];
	}

	function convertLevel($val) {
		$kesz = array();
		$kesz['id'] = $val['lid'];
		$kesz['erkezet'] = date('Y.m.d H:i:s',$val['datum']);
		$kesz['targy'] = $val['targy'];
		$kesz['partner'] = $val['name'];
		$kesz['torzs'] = bb::bbdecode($val['torzs']);
		$kesz['jelolt_e'] = $val['jelolt_e'];
		$kesz['tipus'] = $val['tipus'];
		$kesz['avatar'] = user::getAvatarById($val['partner']);

		return $kesz;
	}

	function setJeloltE($tomb, $flag) {
		if(count($tomb) < 1)
			return true;
		$user = $GLOBALS['USER']['uid'];
		$i = ($flag) ? 1 : 0;
		$idList = implode(',', $tomb);
		$pari = "UPDATE levelek SET jelolt_e = '%s' WHERE tulaj = '%d' AND lid IN(%s)";
		db::futat($pari, $i, $user, $idList);
	}
}

?>
