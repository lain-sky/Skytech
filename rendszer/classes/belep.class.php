<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class belep {
	function __construct() {
		return call_user_func(array($this, 'chek'));
	}

	function chek() {
		global $USER;
		if(!empty($USER['uid'])) {
			$temp_suti = ($USER['ip_ceck'] === true) ? SUTI_ELET : SUTI_ELET_BIZT;

			if($temp_suti > 0 && !empty($USER['timestamp'])) {
				if(($USER['timestamp'] + $temp_suti) < time()) {
					$this->logout(HIBA_TIMEOUT);
					exit;
				} else {
					$USER['timestamp'] = time();
				}

				if($USER['ip_ceck'] === false)
					$hash = belep::getHash();
				else
					$hash = belep::getHash(belep::getIp());

				db::futat("SELECT uid FROM users WHERE uid = '%d' AND sess_hash = '%s'", $USER['uid'], $hash);
				if(db::$sorok !== 1) {
					belep::logout(HIBA_UJRA);
					exit;
				} else {
					db::futat("UPDATE users SET vizit = '%d', ip = '%s' WHERE uid = '%d'", time(), $_SERVER['REMOTE_ADDR'], $USER['uid']);

					$userAdat = User::load($USER['uid']);
					foreach($userAdat as $key => $val) {
						$USER[$key] = $val;
					}

					logs::user();
					return $this->jogosultsag();
				}
			} else {
				belep::logout('Végzetes hiba történt!');
				exit;
			}
		} else {
			$this->logout(HIBA_NO_ID);
		}
	}

	function getHash($ip = '') {
		$sId = session_id();
		$bongeszo = $_SERVER['HTTP_USER_AGENT'];
		return md5($sId . 'a' . $ip . 'a' . $bongeszo);
	}

	function getIp(){
		$ip = $_SERVER['REMOTE_ADDR'];
		$ip .= (!empty($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_VIA'] : '');
		$ip .= (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '');
		return $ip;
	}

	function logout($cim = '') {
		db::futat("UPDATE users SET sess_hash = 'kileptetve' WHERE uid = '%d'", $GLOABLS['USER']['uid']);

		setcookie(session_name(), '', 0, '/');
		unset($_COOKIE[session_name()]);
		unset($_COOKIE);

		$_SESSION = array();
		session_destroy();
		unset($_SESSION);

		$GLOBALS['USER'] = array();
		unset($GLOBALS['USER']);

		if(!empty($cim)) {
			header('Location: belep.php?mod=' . urlencode(base64_encode($cim)));
			exit;
		} else {
			header('Location: belep.php');
		}
		exit;
	}

	function login($name, $pass, $ip = true) {
		db::futat("SELECT uid FROM users WHERE name = '%s'", $name);
		if(db::$sorok !== 1) {
			logs::addFaildLogin($name, $pass);
			belep::logout(HIBAS_NEV);
			exit;
		}

		db::futat("SELECT uid, statusz FROM users WHERE name = '%s' AND pass = '%s'", $name, md5($name . $pass));
		$vUserData = db::tomb();
		$vUserData = $vUserData[0];

		if(db::$sorok !== 1) {
			logs::addFaildLogin($name, $pass);
			belep::logout(HIBAS_JELSZO);
			exit;
		}

		switch($vUserData['statusz']) {
			case 'aktiv':
			break;

			case 'uj':
				logs::addFaildLogin($name, $pass);
				belep::logout(HIBA_MEGEROSITETLEN);
				exit;
			break;

			case 'torolt':
				logs::addFaildLogin($name, $pass);
				belep::logout(HIBA_TOROLT_USER);
				exit;
			break;

			default:
				logs::addFaildLogin($name, $pass);
				belep::logout(HIBA_NINCS_STATUS);
				exit;
			break;
		}

		$banText = Warn::getByUid($vUserData['uid'], 'ban');
		if($banText !== true) {
			logs::addFaildLogin($name, $pass);
			belep::logout("BAN:" . $banText);
			exit;
		}

		$userId = $vUserData['uid'];
		$_SESSION['uid'] = $userId;

		if($ip === false) {
			$hash = belep::getHash();
			$_SESSION['ip_ceck'] = false;
		} else {
			$hash = belep::getHash(belep::getIp());
			$_SESSION['ip_ceck'] = true;
		}

		$_SESSION['timestamp'] = time();

		$sql = "UPDATE users SET sess_hash = '%s' WHERE uid = '%d'";
		db::futat($sql, $hash, $userId);

		$userAdat = User::load($_SESSION['uid']);
		foreach($userAdat as $key => $val) {
			$_SESSION[$key] = $val;
		}

		$pont = new Pont();
		$pont->addBelep();
		
		$tovabb = 'index.php';
		header("Location:" . $tovabb);
		exit;
	}

	function jogosultsag() {
		$rang = (int)$GLOBALS['USER']['rang'];
		$oldal = strtoupper(str_replace(array('/', 'skytech', '.php'), '', $_SERVER["REQUEST_URI"]));
		$konst = @constant('JOG_' . $oldal);

		if($konst != NULL) {
			if((int)$konst > $rang) {
				$cim = '404.php?ok=' . urlencode('Az oldal megtekintéséhez a legkisebb jog: ' . $GLOBALS['RANGOK'][(int)$konst]);
				header('location: ' . $cim);
				exit;
			}
		}
		return;
	}
}

?>
