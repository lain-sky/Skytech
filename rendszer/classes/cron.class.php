<?php
class cron {
	private $dat = array();
	private $sqls = array();

	function __construct($milyen = false) {
		if($milyen) {
			$this->dat[] = array('type' => 1, 'gyak' => 1, 'func' => 'rangUpdate');
			$this->dat[] = array('type' => 2, 'gyak' => 1, 'func' => 'peersClear');
			$this->dat[] = array('type' => 3, 'gyak' => 1, 'func' => 'chatClear');
			$this->dat[] = array('type' => 4, 'gyak' => 1, 'func' => 'logsClear');
			$this->dat[] = array('type' => 5, 'gyak' => 1, 'func' => 'regClear');
			$this->dat[] = array('type' => 6, 'gyak' => 1, 'func' => 'warnClear');
			$this->dat[] = array('type' => 7, 'gyak' => 1, 'func' => 'pontFeltoltes');
		} else {
			$this->dat[] = array('type' => 1, 'gyak' => CRON_RANG, 'func' => 'rangUpdate');
			$this->dat[] = array('type' => 2, 'gyak' => PEERS_TAKARIT, 'func' => 'peersClear');
			$this->dat[] = array('type' => 3, 'gyak' => CHAT_TAKARIT, 'func' => 'chatClear');
			$this->dat[] = array('type' => 4, 'gyak' => LOGS_TAKARIT, 'func' => 'logsClear');
			$this->dat[] = array('type' => 5, 'gyak' => REG_TAKARIT, 'func' => 'regClear');
			$this->dat[] = array('type' => 6, 'gyak' => WARN_TAKARIT, 'func' => 'warnClear');
			$this->dat[] = array('type' => 7, 'gyak' => PONT_FELTOLTES_JOVAIR, 'func' => 'pontFeltoltes');
		}

		foreach($this->dat as $val) {
			$utolso = $this->lastAction($val['type']);
			if(time() > ($utolso + $val['gyak'])) {
				call_user_func(array($this, $val['func']), $val['type']);
			}
		}
		return true;
	}

	private function lastAction($type) {
		$sql = "SELECT UNIX_TIMESTAMP(datum) AS num FROM logs_cron WHERE type = '%d' ORDER BY lid DESC LIMIT 1";
		db::futat($sql, $type);
		$ert = db::egy_ertek('num');
		if(!empty($ert) && is_numeric($ert))
			return $ert;
		else
			return 0;
	}

	private function logs($type, $sor = 0) {
		$sql = "INSERT INTO logs_cron (type, datum, sor) VALUES('%d', '%s', '%d')";
		db::futat($sql, $type, date('Y-m-d H:i:s'), $sor);
	}

	private function rangUpdate($type) {
		$n = 0;
		$sql = "SELECT uid, letolt, feltolt, rang FROM users WHERE statusz = 'aktiv' AND rang < 5 AND reg_date < '%d'";
		db::futat($sql, (time() - RANG_IDO_LIMIT));
		$tomb = db::tomb();
		foreach($tomb as $u) {
			$arany = round(($u['feltolt'] / ($u['letolt'] + 1)), 3);

			switch(true) {
				case $arany > RANG_TAG_MIN:
					if($u['rang'] != 4) {
						User::update($u['uid'], array('rang' => 4));
						$n++;
					}
				break;

				case $arany > RANG_FELHSZ_MIN: 
					if($u['rang'] != 3) {
						User::update($u['uid'], array('rang' => 3));
						$n++;
					}
				break;

				case $arany > RANG_LEECH_MIN:
					if($u['rang'] != 2) {
						User::update($u['uid'], array('rang' => 2));
						$n++;
					}
				break;

				default:
				break;
			}
		}

		$this->logs($type, $n);
	}

	private function peersClear($type) {
		$lim = (TRACKER_AUTO_REFRESH * 1.5);
		$sql = "DELETE FROM peers WHERE (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(last_action)) > %d";
		db::futat($sql, $lim);
		$sor = db::$sorok2;

		$this->sqls[] = db::$parancs;
		$this->logs($type, $sor);
	}

	private function chatClear($type) {
		$lim = CHAT_ADATMEGORZES;
		$sql = "DELETE FROM chat WHERE (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(datum)) > %d";
		db::futat($sql, $lim);
		$sor = db::$sorok2;

		$this->sqls[] = db::$parancs;
		$this->logs($type, $sor);
	}

	private function logsClear($type) {
		$lim = LOGS_ADATMEGORZES;
		$sor = 0;
		$tablak = array('logs_user', 'logs_torrent', 'logs_cron', 'logs_falidlogin');
		foreach($tablak as $tabla) {
			$sql = "DELETE FROM %s WHERE (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(datum)) > %d";
			db::futat($sql, $tabla, $lim);
			$sor += db::$sorok2;
			$this->sqls[] = db::$parancs;
		}
		$this->logs($type, $sor);
	}

	private function regClear($type) {
		$lim = 60*60*24*7;

		$sql = "DELETE FROM meghivo WHERE meghivott IS NULL AND (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(datum)) > %d";
		db::futat($sql, $lim);
		$this->sqls[] = db::$parancs;

		$sql = "DELETE FROM regisztral WHERE (UNIX_TIMESTAMP(NOW()) - date) > %d";
		db::futat($sql, $lim);
		$sor = db::$sorok2;

		$this->sqls[] = db::$parancs;
		$this->logs($type, $sor);
	}

	private function warnClear($type) {
		$sql = "DELETE FROM warn WHERE UNIX_TIMESTAMP(NOW()) > UNIX_TIMESTAMP(lejar)";
		db::futat($sql);
		$sor = db::$sorok2;

		$this->sqls[] = db::$parancs;
		$this->logs($type, $sor);
	}

	 function pontFeltoltes($type) {
		$tegnap = date('Y-m-d', time() - (60 * 60 * 24));
		$sql = "SELECT uid, SUM(fel) AS meret FROM logs_torrent WHERE datum BETWEEN '%s 00:00:00' AND '%s 23:59:59' GROUP BY uid";
		$tomb = db::getAll($sql, $tegnap, $tegnap);
		$pont = new Pont();
		$i = 0;
		foreach($tomb as $row) {
			if($row['meret'] > 0) {
				$pont->addTrackerFeltolt($row['meret'], $row['uid']);
				$i++;
			}
		}
		$this->logs($type, $i);
	}
}

?>
