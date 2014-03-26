<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class Nfo {
	private function  __construct() {}

	function add($fajl, $name, $id) {
		$tomb = @file($fajl);
		if(count($tomb) < 1)
			return false;

		$sql = "INSERT INTO nfo (nid, name, nfo) VALUES ('%d', '%s', '%s')";
		if(db::futat($sql, $id, $name, implode('', $tomb)))
			return true;
		else
			return false;
	}

	function del($id) {
		db::futat("DELETE FROM nfo WHERE nid = '%d'", $id);
	}

	function getAll($id) {
		db::futat("SELECT nid, name, nfo FROM nfo WHERE nid = '%d'", $id);
		$t = db::elso_sor();
		return array('name' => $t['name'], 'nfo' => $t['nfo']);
	}

	function check($id) {
		if(!is_numeric($id))
			return false;
		db::futat("SELECT COUNT(*) FROM nfo WHERE nid = '%d'", $id);
		if(db::$sorok != 1)
			return false;
		return true;
	}
}

?>
