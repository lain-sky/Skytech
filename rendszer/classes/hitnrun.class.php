<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class hitnrun {
	function __construct(){
		$this->uid = $GLOBALS['USER']['uid'];
		$this->datum = date('Y-m-d H:i:s');
	}

	function add($tid, $down) {
		$pari = "INSERT INTO hitnrun(uid, tid, kezdes, frissitve, status, letoltve) VALUES('%d', '%d', '%s', '%s', '%d', '%f')";
		db::futat($pari, $this->uid, $tid, $this->datum, $this->datum, 1, $down);
	}

	function update($id, $stat, $up, $down, $req) {
		$pari = "UPDATE hitnrun SET frissitve = '%s', status = '%d', feltoltve = '%f', letoltve = '%f', hatravan = '%d' WHERE hid = '%d'";
		return db::futat($pari, $this->datum, $stat, $up, $down, $req, $id);
	}

	function getegy($uid, $tid) {
		$pari = "SELECT hid, status, feltoltve, letoltve, hatravan FROM hitnrun WHERE uid = '%d' AND tid = '%d'";
		db::futat($pari, $uid, $tid);
		if(db::$sorok == 0)
			return false;
		else
			return db::tomb();
	}

	function getall() {
		$pari = "SELECT h.hid, h.tid, h.kezdes, h.frissitve, h.status, h.feltoltve, h.letoltve, h.hatravan, t.name FROM hitnrun h LEFT JOIN torrent t ON h.tid = t.tid WHERE h.uid = '%d'";
		db::futat($pari, $this->uid);
		return db::tomb();
	}

	function getReq() {
		$pari = "SELECT COUNT(h.hid) AS hr, h.hid, h.tid, h.kezdes, h.frissitve, h.status, h.feltoltve, h.letoltve, h.hatravan, t.name FROM hitnrun h LEFT JOIN torrent t ON h.tid = t.tid WHERE h.uid = '%d' AND h.hatravan > 0";
		db::futat($pari, $this->uid);
		return db::tomb();
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
