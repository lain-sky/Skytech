<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class User {
	private function __construct() {}

	function getIdByName($nev) {
		db::futat("SELECT uid FROM users WHERE name = '%s'", $nev);
		$id = db::egy_ertek('uid');
		if(is_numeric($id))
			return $id;
		else
			return false;
	}

	function getNameById($id) {
		db::futat("SELECT name FROM users WHERE uid = '%d'", $id);
		$name = db::egy_ertek('name');
		if(!empty($name))
			return $name;
		else
			return false;
	}

	function getAvatarById($uid) {
		$pari = "SELECT avatar FROM user_data WHERE uid = '%d'";
		db::futat($pari, $uid);
		$avatar = db::egy_ertek('avatar');
		if(!empty($avatar) && $avatar != 'avatar.png') {
			return $avatar;
		} else {
			$text = 'kinezet/' . $GLOBALS['USER']['smink'] . '/avatar.png';
			return $text;
		}
	}

	function load($uid) {
		$sql = "SELECT u.uid, u.name, u.email, u.rang, u.vizit, u.letolt, u.feltolt, u.reg_date, u.tor_pass, u.egyedi_rang, u.statusz, ".
			"(SELECT COUNT(*) FROM forum_hsz f WHERE f.uid = u.uid) AS hozzaszolas, ".
			"(SELECT COUNT(*) FROM torrent_hsz tf WHERE tf.uid = u.uid) AS torrent_hozzaszolas, ".
			"(SELECT smink FROM user_data d WHERE d.uid = u.uid) AS smink, ".
			"(SELECT orszag FROM user_data a WHERE a.uid = u.uid) AS orszag, " .
			"(SELECT varos FROM user_data t WHERE t.uid = u.uid) AS varos, ".
			"(SELECT avatar FROM user_data ta WHERE ta.uid = u.uid) AS avatar, ".
			"(SELECT megjelen FROM user_data ta WHERE ta.uid = u.uid) AS megjelen, ".
			"(SELECT perold FROM user_data ta WHERE ta.uid = u.uid) AS perold, ".
			"(SELECT kategoriak FROM user_data tk WHERE tk.uid = u.uid) AS kategoriak, ".
			"(SELECT uj_torrent FROM user_data tt WHERE tt.uid = u.uid) AS uj_torrent, ".
			"(SELECT nem FROM user_data tn WHERE tn.uid = u.uid) AS neme, ".
			"(SELECT SUM(po.pont) FROM pontok po WHERE po.uid = u.uid) AS pontok ".
			"(SELECT SUM(to.tid) FROM torrent to WHERE to.uid = u.uid) AS torrentek ".
			"(SELECT SUM(b.barat_uid) FROM barat b WHERE b.tulaj_uid = u.uid) AS baratok ".
			"FROM users u WHERE u.uid = '%d'";
		db::futat($sql, $uid);
		$tomb = db::tomb();
		$t = $tomb[0];

		$kesz = array();
		$kesz['uid'] = $t['uid']; 
		$kesz['name'] = $t['name'];
		$kesz['email'] = $t['email'];
		$kesz['feltolt'] = $t['feltolt'];
		$kesz['letolt'] = $t['letolt'];
		$kesz['arany'] = ($kesz['feltolt'] > 0 && $kesz['letolt'] > 0) ? round(($t['feltolt'] / $t['letolt']), 3) : 0;
		$kesz['arany_text'] = ($kesz['arany'] == 0) ? 'nincs' : number_format($kesz['arany'], 3);
		$kesz['rang'] = $t['rang'];
		$kesz['statusz'] = $t['statusz'];
		$kesz['egyedi_rang'] = $t['egyedi_rang'];
		$kesz['rang_text'] = (!empty($t['egyedi_rang'])) ? $t['egyedi_rang'] : $GLOBALS['RANGOK'][$t['rang']];
		$kesz['reg_date'] = date('Y.m.d H:i:s', $t['reg_date']);
		$kesz['vizit'] = date('Y.m.d H:i:s', $t['vizit']);
		$kesz['tor_pass'] = $t['tor_pass'];
		$kesz['varos'] = $t['varos'];
		$kesz['orszag'] = $GLOBALS['ORSZAGTOMB'][$t['orszag']];
		$kesz['smink'] = $t['smink'];
		$kesz['avatar'] = (strpos($t['avatar'], 'http://') === false) ? 'kinezet/' . (!empty($GLOBALS['USER']['smink']) ? $GLOBALS['USER']['smink'] : 'alap') . '/avatar.png' : $t['avatar'];
		$kesz['hszszam'] = $t['hozzaszolas'];
		$kesz['tor_hszszam'] = $t['torrent_hozzaszolas'];
		$kesz['uj_torrent'] = $t['uj_torrent'];
		$kesz['neme'] = $t['neme'];
		$kesz['kategoriak_text'] = $t['kategoriak'];
		$kesz['kategoriak_tomb'] = explode(',', $t['kategoriak']);
		$kesz['megjelen'] = explode('|', $t['megjelen']);
		$kesz['perold'] = explode('|', $t['perold']);
		$kesz['pontok'] = $t['pontok'];
		$kesz['torrentek'] = $t['torrentek'];
		$kesz['baratok'] = $t['baratok'];
		$kesz['gui'] = $kesz['megjelen'][3];

		return $kesz;
	}

	function getMaxAtadas($uid) {
		db::futat("SELECT feltolt, letolt FROM users WHERE uid = '%d'", $uid);
		$tomb = db::tomb();
		$le = $tomb[0]['letolt'];
		$fel = $tomb[0]['feltolt'];
		$atadhato = $fel - ($le * MIN_ATAD_RATIO);

		if($atadhato > 0)
			return $atadhato;
		else
			return false;
	}

	function feltoltKulonbseg($uid, $mihez = 0) {
		$ki = User::load($uid);
		return $ki['feltolt'] - $mihez;
	}

	function getLadad($uid, $konvert = true) {
		db::futat("SELECT ladad, ladad_text FROM user_data WHERE uid = '%d'", $uid);
		$tomb = db::elso_sor();
		$kesz['ladad'] = $tomb['ladad'];
		$kesz['ladad_text'] = ($konvert) ? bb::bbdecode($tomb['ladad_text']) : $tomb['ladad_text'];
		return $kesz;
	}

	function checkUserName($name) {
		if(array_search($name, $GLOBALS['tiltott_nev']) !== false)
			return 'A kiválsztott név titló listán van';

		if(!ervenyes_nev($name))
			return 'A kiválasztott név érvénytelen karaktereket tartalmaz! A neved csak az angol abc betûit, és számokat tartalmazhat!';

		db::futat("SELECT uid FROM users WHERE name = '%s'", $name);
		if(db::$sorok !== 0)
			return 'Sajnálom, de már valaki használja az általad választott nevet!';

		return true;
	}

	function checkEmail($email) {
		if(array_search($email, $GLOBALS['tiltott_email']) !== false)
			return 'A kiválsztott email cím titló listán van';

		if(!ervenyes_email($email))
			return 'A megadott e-mail cím érvénytelen. Csak úgy tudsz regisztrálni, ha egy érvényes, mûködõ e-mail címet adsz meg!';

		db::futat("SELECT uid FROM users WHERE email = '%s'", $email);
		if(db::$sorok !== 0)
			return 'Sajnálom, de már valaki használja az általad választott email címet!';

		return true;
	}

	function update($id, $tomb, $tabla = 'users') {
		$up = array();
		foreach($tomb as $key => $val) {
			$up[] = $key . "='" . $val . "'";
		}

		if(count($up) < 1)
			return;

		$sql = "UPDATE " . $tabla . " SET " . implode(',', $up) . " WHERE uid = '" . $id . "'";
		return db::futat($sql);
	}
}

?>
