<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class hitnrun {
	function __construct(){
		$this->uid = $GLOBALS['USER']['uid'];
	}

	function getall() {
		$pari = "SELECT h.hid, h.tid, h.kezdes, h.frissitve, h.status, h.feltoltve, h.letoltve, h.hatravan, t.name FROM hitnrun h LEFT JOIN torrent t ON h.tid = t.tid WHERE h.uid = '%d'";
		if(db::futat($pari, $this->uid))
			return db::tomb();
		else
			return false;
	}

	function getReq() {
		$pari = "SELECT h.hid, h.tid, h.kezdes, h.frissitve, h.status, h.feltoltve, h.letoltve, h.hatravan, t.name FROM hitnrun h LEFT JOIN torrent t ON h.tid = t.tid WHERE h.uid = '%d' AND h.hatravan > 0";
		if(db::futat($pari, $this->uid))
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
