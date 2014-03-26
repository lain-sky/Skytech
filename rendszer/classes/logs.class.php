<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class logs {
	protected static $userLogId = 0;

	function user() {
		$uid = $_SESSION['uid'];
		$rang = $_SESSION['rang'];
		$os = Browser_Detection::get_os($_SERVER['HTTP_USER_AGENT']);
		$bongeszoTomb = Browser_Detection::get_browser($_SERVER['HTTP_USER_AGENT']);
		$bongeszo = $bongeszoTomb['tip'];
		$bongeszo_ver = $bongeszoTomb['ver'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$qstring = $_SERVER['QUERY_STRING'];

		$fajlTomb = explode('/', $_SERVER['SCRIPT_NAME']);
		$fajl = array_pop($fajlTomb);
		$sPost=var_export($_POST, true);

		if(in_array($fajl, $GLOBALS['NO_LOGS_FILE']))
			return true;

		$sql = "INSERT INTO logs_user (uid, fajl, os, bongeszo, bongeszo_ver, ip, datum, qstring, post, rang) VALUES('%d', '%s', '%d', '%d', '%s', '%s', now(), '%s', '%s', '%d')";
		db::futat($sql, $uid, $fajl, $os, $bongeszo, $bongeszo_ver, $ip, $qstring, $sPost, $rang);
		self::$userLogId = db::$id;
	}

	function torrent($tid ,$uid, $oszfel, $oszle, $fel = 0, $le = 0, $get = 'alma') {
		$ip = $_SERVER['REMOTE_ADDR'];
		if($fel > 0 || $le > 0) {
			$sql = "INSERT INTO logs_torrent (tid, uid, oszfel, oszle, fel, le, datum, ip, get) VALUES('%d', '%d', '%f', '%f', '%f', '%f', now(), '%s', '%s')";
			db::futat($sql, $tid, $uid, $oszfel, $oszle, $fel, $le, $ip, $get);
		}
	}

	function addFaildLogin($user , $pass) {
		$ip = belep::getIp();

		$sql = "INSERT INTO logs_falidlogin (username, password, ip, datum, time) VALUES('%s', '%s', '%s', '%s', '%s')";
		db::futat($sql, $user, $pass, $ip, date('Y-m-d'), date('H:i:s'));
	}

	function getCountFalidLogin() {
		$ip = belep::getIp();
		$datum = date('Y-m-d');

		$sql = "SELECT COUNT(*) AS db FROM logs_falidlogin WHERE datum = '%s' AND ip = '%s'";
		db::futat($sql, $datum, $ip);
		return db::egy_ertek('db');
	}

	function sysLog($type, $text, $other = '') {
		$uid = $GLOBALS['USER']['uid'];
		$sql = "INSERT INTO logs_system(uid, luid, type, text, other, datum) VALUES('%d', '%d', '%s', '%s', '%s', now())";
		db::futat($sql, $uid, self::$userLogId, $type, $text, $other);
	}

	function getAllSysLogType() {
		$sql = "SELECT type FROM logs_system GROUP BY type ORDER BY type";
		$kesz = array();
		foreach(db::getAll($sql) as $row) {
			$kesz[] = $row['type'];
		}
		return $kesz;
	}
}

?>
