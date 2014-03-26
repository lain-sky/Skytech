<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class Staff {
	function addLevel($torzs, $targy) {
		$tulaj = OLDAL_MAIL_USER_ID;
		$partner = $GLOBALS['USER']['uid'];
		level::felad($tulaj, $partner, $targy, $torzs);
	}

	function addValasz($torzs, $targy, $parent) {
		$sql = "SELECT partner FROM levelek WHERE lid = '%d'";
		db::futat($sql, $parent);
		$partner = db::egy_ertek('partner');

		$sql = "INSERT INTO levelek (tulaj, partner, parent, datum, targy, torzs, status) VALUES('%d', '%d', '%d', '%d', '%s', '%s', '%s')";
		db::futat($sql, $partner, OLDAL_MAIL_USER_ID, $parent, time(), $targy, $torzs, 'u');
		db::futat($sql, OLDAL_MAIL_USER_ID, $partner, 0, time(), $targy, $torzs, 'n');
	}

	function getLevelek() {
		$sql = "SELECT l.*,
				(SELECT COUNT(*) FROM levelek l2 WHERE l.lid = l2.parent) AS valaszok,
				(SELECT u.name FROM users u WHERE l.partner = u.uid) AS partner_nev
			FROM levelek l WHERE l.tulaj = '%d' AND l.status = 'u' ORDER BY datum DESC LIMIT 50";
		db::futat($sql, OLDAL_MAIL_USER_ID);

		return self::processLevel(db::tomb());
	}

	function getChilden($levelId) {
		$sql = "SELECT lid FROM levelek WHERE parent = '%d'";
		db::futat($sql, $levelId);
		foreach(db::tomb() as $row) {
			$ids[] = $row['lid'];
		}

		return self::loadLevel($ids, 'ORDER BY datum');
	}

	function loadLevel($lid, $desc = 'ORDER BY l.lid') {
		if(is_numeric($lid))
			$modLid = $lid;
		elseif(is_array($lid))
			$modLid = implode(',', $lid);
		else
			return false;

		$sql = "SELECT l.*,
				(SELECT COUNT(*) FROM levelek l2 WHERE l2.lid = l.parent) AS valaszok,
				(SELECT u.name FROM users u WHERE l.partner = u.uid) AS partner_nev,
				(SELECT u2.name FROM users u2 WHERE l.tulaj = u2.uid) AS tulaj_nev
			FROM levelek l WHERE (l.tulaj = '%d' OR l.partner = '%d') AND l.lid IN(%s) " . $desc;
		db::futat($sql, OLDAL_MAIL_USER_ID, OLDAL_MAIL_USER_ID, $modLid);
		return self::processLevel(db::tomb());
	}

	private function processLevel($tomb) {
		$kesz = array();
		foreach($tomb as $i => $row) {
			foreach($row as $key => $val) {
				switch($key) {
					case 'datum':
						$kesz[$i][$key] = date('Y-m-d H:i:s', $val);
					break;

					case 'torzs':
						$kesz[$i]['torzsKonvert'] = bb::bbdecode($val);
						$kesz[$i]['lead'] = htmlspecialchars(str_replace('<br/>', ' ', substr($val, 0, 75))) . '...';
						$kesz[$i][$key] = $val;
					break;

					case 'tulaj':
					case 'partner':
						if($val != OLDAL_MAIL_USER_ID) {
							$kesz[$i]['luser'] = $val;
							$kesz[$i]['luser_avatar'] = user::getAvatarById($val);
						}
						else{
							$kesz[$i]['rendszer'] = $val;
							$kesz[$i]['rendszer_avatar'] = user::getAvatarById($val);
						}
						$kesz[$i][$key] = $val;
					break;
					
					default:
						$kesz[$i][$key] = $val;
					break;
				}
			}
		}

		return $kesz;
	}

	function levelTorol($levelId) {
		$pari = "UPDATE levelek SET status = 'n' WHERE tulaj = '%d' AND lid = '%d'";
		db::futat($pari, OLDAL_MAIL_USER_ID, $levelId);
	}
}

?>
