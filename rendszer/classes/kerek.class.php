<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class Kerek extends baseModel {
	protected $table = 'kerek';
	protected $idName = 'kid';

	function pontLevon($pontDB = false) {
		$pont = new Pont();
		return $pont->addPont($GLOBALS['USER']['uid'], 40, $pontDB);
	}

	function pontCheck($pontDB = false) {
		if(!empty($pontDB))
			$min = $pontDB;
		else
			$min = abs($GLOBALS['PONT_EVENTS'][40]['value']);
			
		$pont = new Pont();
		return $pont->checkPont($GLOBALS['USER']['uid'], $min);
	}

	function addItem($kid, $pont) {
		$uid = $GLOBALS['USER']['uid'];

		$sql = "INSERT INTO kerek_item (kid, uid, pont) VALUES ('%d', '%d', '%d')";
		db::futat($sql, $kid, $uid, $pont);

		$this->pontLevon(($pont * (-1)));
	}

	function getList($where = array(), $order = '', $limit = '') {
		$sql = "SELECT SQL_CALC_FOUND_ROWS k.*, u.name as username, u.rang, kat.nev, kat.leir, kat.kep, 
		(SELECT COUNT(*) FROM kerek_item k1 WHERE k1.kid = k.kid GROUP BY k1.kid) AS kertek,	
		(SELECT SUM(pont) from kerek_item k1 WHERE k1.kid = k.kid GROUP BY k1.kid) AS pontok
		FROM kerek k LEFT JOIN users u ON u.uid = k.uid LEFT JOIN kategoria kat ON kat.kid = k.kat_id";

		if(count($where) > 0)
			$sql .= ' WHERE ' . implode(' AND ', $where);

		if(!empty($order))
			$sql .= " ORDER BY " . $order;

		if(!empty($limit))
			$sql .= " LIMIT " . $limit;

		$kesz = array();
		foreach(db::getAll($sql) as $key => $val) {	
			foreach($val as $k => $v) {
				switch($k) {
					case 'text':
						$kesz[$key]['megjegyzes'] = bb::bbdecode($v);
						$kesz[$key][$k] = $v;
					break;

					case 'kertek':
						$kesz[$key][$k] = (int)$v + 1;
					break;

					case 'pontok':
						$kesz[$key][$k] = (int)$v + abs($GLOBALS['PONT_EVENTS'][40]['value']);
					break;

					case 'datum':
						$kesz[$key]['kerve'] = current(explode(' ', $v));
						$kesz[$key][$k] = $v;
					break;

					case 'uid':
						if($GLOBALS['USER']['uid'] == $v)
							$kesz[$key]['sajat'] = true;

						$kesz[$key][$k] = $v;
					break;

					default:
						$kesz[$key][$k] = $v;
					break;
				}
			}
		}
		return $kesz;
	}

	function isModified($kid) {
		$keres = $this->getById($kid);

		if($GLOBALS['USER']['rang'] >= KERESEK_ADMIN_MIN_RANG || $GLOBALS['USER']['uid'] == $keres['uid'])
			return true;
		else
			return false;
	}

	function pontJovair($tid) {
		$kid = db::getOne("SELECT keres_id FROM torrent WHERE tid = '%d'", $tid);
		if(!empty($kid) && is_numeric($kid)) {
			if(db::getOne("SELECT status FROM kerek WHERE kid = '%d'", $kid) == 'aktiv') {
				$sumPont = db::getOne("SELECT SUM(pont) FROM kerek_item WHERE kid = '%d'", $kid) + abs($GLOBALS['PONT_EVENTS'][40]['value']);
				$pontUser = db::getOne("SELECT uid FROM torrent WHERE tid = '%d'", $tid);

				$pont = new Pont();
				$pont->addPont($pontUser, 42, $sumPont);

				db::futat("UPDATE kerek SET status = 'teljesitve' WHERE kid = '%d'", $kid);
				db::futat("UPDATE torrent SET keres_jovairva = 'yes' WHERE tid = '%d'", $tid);
			}
		}
	}
}

?>
