<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class hitnrun {
	function __construct(){
		$this->uid = $GLOBALS['USER']['uid'];
	}

	function getall($ord = 't.name') {
		$pari = "SELECT h.hid, h.tid, h.kezdes, h.frissitve, h.status, h.feltoltve, h.letoltve, (h.feltoltve/h.letoltve) AS arany, h.hatravan, t.name FROM hitnrun h LEFT JOIN torrent t ON h.tid = t.tid WHERE h.uid = '%d' ORDER BY %s";
		if(db::futat($pari, $this->uid, $ord))
			return db::tomb();
		else
			return false;
	}

	function getReq($ord = 't.name') {
		$pari = "SELECT h.hid, h.tid, h.kezdes, h.frissitve, h.status, h.feltoltve, h.letoltve, (h.feltoltve/h.letoltve) AS arany, h.hatravan, t.name FROM hitnrun h LEFT JOIN torrent t ON h.tid = t.tid WHERE h.uid = '%d' AND h.hatravan > 0 ORDER BY %s";
		if(db::futat($pari, $this->uid, $ord))
			return db::tomb();
		else
			return false;
	}

	function getossz() {
		$pari = "SELECT COUNT(hid) AS ossz FROM hitnrun WHERE uid = '%d'";
		db::futat($pari, $this->uid);
		return db::elso_sor();
	}

	function gethr() {
		$pari = "SELECT COUNT(hid) AS hr FROM hitnrun WHERE uid = '%d' AND hatravan > 0";
		db::futat($pari, $this->uid);
		return db::elso_sor();
	}
}

?>
