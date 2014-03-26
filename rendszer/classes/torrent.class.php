<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class Torrent {
	public $name;
	public $kid;
	public $eredeti = 'n';
	public $honlap;
	public $megjelen;
	public $megjegyzes;
	public $kep1;
	public $kep2;
	public $kep3;
	public $uid;
	public $datum;
	public $search_text;
	public $meret;
	public $fajl_db;
	public $fajlok;
	public $tempname;
	public $info_hash;
	public $nfo;
	public $nfo_temp;
	public $anonymous = 'no';
	public $keresId;

	function __construct() {
		$this->uid = $GLOBALS['USER']['uid'];
		$this->datum = date('Y-m-d H:i:s');
		$this->urang = $GLOBALS['USER']['rang'];
		$this->nfo = 'no';
	}

	function add() {
		$pari = "INSERT INTO torrent (kid, uid, name, search_text, datum, fajl_db, meret, kep1, kep2, kep3, megjelen, megjegyzes, eredeti, info_hash, nfo_name, honlap, anonymous, keres_id) VALUES ".
								 "('%d', '%d', '%s', '%s', '%s', '%d', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d')";
		$ok = db::futat($pari
					,$this->kid
					,$this->uid
					,$this->name
					,$this->search_text
					,$this->datum
					,$this->fajl_db
					,$this->meret
					,$this->kep1
					,$this->kep2
					,$this->kep3
					,$this->megjelen
					,$this->megjegyzes
					,$this->eredeti
					,md5($this->info_hash)
					,$this->nfo
					,$this->honlap
					,$this->anonymous
					,$this->keresId
					);
		if($ok)
			return $this->fajlRogzit(db::$id);
		else
			return false;
	}

	function update($id, $tomb, $admin_jog = true) {
		if($admin_jog)
			if($GLOBALS['USER']['rang'] < TORRENET_ADMIN_MIN_RANG)
				return false;

		$mod = array();
		foreach($tomb as $key => $val) {
			$mod[] = $key . "='" . addslashes($val) . "'";
		}

		if(count($mod) > 0) {
			$pari = "UPDATE torrent SET " . implode(',', $mod) . " WHERE tid = '%d'";
			$ok = db::futat($pari, $id);
			return $ok;
		}
		return false;
	}

	function fajlRogzit($tid) {
		foreach($this->fajlok as $tomb) {
			$pari = "INSERT INTO torrent_files (tid, name, size) VALUES ('%d', '%s', '%f')";
			db::futat($pari, $tid, $tomb[0], $tomb[1]);
		}
		return $this->fajlMasol($tid);
	}

	function fajlMasol($tid) {
		$fajl = $this->getTorrentFileName($tid);
		if(move_uploaded_file($this->tempname, $fajl))
			return $tid;
		else
			return false;
	}

	function nfoMasol($tid) {
		$fajl = $this->getNfoFileName($tid);
		if(move_uploaded_file($this->nfo_temp, $fajl))
			return true;
		else
			return false;
	}

	function getTrackerUrl() {
		$url = TORRENT_TRACKER . "?passkey=" . $GLOBALS['USER']['tor_pass'];
		return $url;
	}

	function getTorrentById($id) {
		db::futat("SELECT * FROM torrent WHERE tid = '%d'", $id);
		if(db::$sorok < 1)
			return false;
		$tomb = db::tomb();
		return $tomb[0];
	}

	function checkTorrentById($id) {
		db::futat("SELECT COUNT(*) AS db FROM torrent WHERE tid = '%d'", $id);
		if(db::egy_ertek('db') != 1)
			return false;

		$fajl = $this->getTorrentFileName($id);
		if(@!is_file($fajl))
			return false;
		if(@!is_readable($fajl))
			return false;
		return true;
	}

	function checkTorrentByInfoHash($hash) {
		db::futat("SELECT COUNT(*) AS db FROM torrent WHERE tid = '%d'", $id);
		if(db::egy_ertek('db') != 1)
			return false;
	}

	function getTorrentFileName($id) {
		$fajl = TORRENT_PATH . $id . ".torrent";
		return $fajl;
	}

	function getNfoFileName($id) {
		$fajl = NFO_PATH . $id . ".nfo";
		return $fajl;
	}

	function getNfoTartalom($id){
		$fajl = $this->getNfoFileName($id);
		if(@!is_file($fajl))
			return 'A NFO már nincs meg a szerveren!';
		$tomb = @file($fajl);
		$str = implode('<br />', $tomb);
		return 	$str;
	}

	function getFileList($id) {
		$sql = "SELECT name, size FROM torrent_files WHERE tid = '%d'";
		db::futat($sql, $id);
		$tt = "<table style='width:916px;' class='skinned'><tr class='head'><td>Név</td><td>Kiterjesztés</td><td>Típus</td><td>Méret</td></tr>";
		foreach(db::tomb() as $key => $val) {
			$tt .= "<tr class='flash'>\n<td class='left'style='width: 550px;'>" . $val['name'] . "</td>";
			$kit = explode('.', $val['name']);
			$tt .= "<td>" . $kit[count($kit)-1] . "</td>";
			$tt .= "<td>" . getfiletype($kit[count($kit)-1]) . "</td>";
			$tt .= "<td>" . bytes_to_string($val['size']) . "</td>\n</tr>\n";
		}
		return $tt;
	}

	function setTorrentMegnez($id) {
		db::futat("UPDATE torrent SET megnezve = megnezve + 1 WHERE tid = '%d'", $id);
	}

	function delTorrent($id) {
		if($GLOBALS['USER']['rang'] < TORRENET_ADMIN_MIN_RANG)
			return false;
		db::futat("DELETE FROM torrent WHERE tid = '%d'", $id);
		db::futat("DELETE FROM torrent_files WHERE tid = '%d'", $id);
		Nfo::del($id);
		@unlink($this->getTorrentFileName($id));
	}

	function fullLoad($where = array(), $order = '', $limit = '', $dekod = 1) {
		$sql = "SELECT SQL_CALC_FOUND_ROWS 
				t.tid, t.uid, t.name, t.nfo_name, t.datum, UNIX_TIMESTAMP(t.datum) AS tdatum, t.meret, t.letoltve, t.seeders, t.leechers, t.megnezve, t.kid,
				t.kep1, t.kep2, t.kep3, t.megjelen, t.honlap, t.megjegyzes, t.eredeti, t.admin_megj, t.admin_datum, t.admin_id, t.hsz_lezarva, t.ingyen, t.hidden, t.anonymous, t.keres_id, t.keres_jovairva,
				(SELECT COUNT(*) FROM torrent_files WHERE tid = t.tid) AS fajldb,
				(SELECT name FROM users u WHERE u.uid = t.uid) AS username,
				(SELECT rang FROM users u WHERE u.uid = t.uid) AS rang,
				(SELECT nev FROM kategoria k WHERE k.kid = t.kid) AS nev,
				(SELECT leir FROM kategoria k WHERE k.kid = t.kid) AS leir,
				(SELECT kep FROM kategoria k WHERE k.kid = t.kid) AS kep,
				(SELECT name FROM users u WHERE u.uid = t.admin_id) AS adminname,
				(SELECT COUNT(*) FROM peers p WHERE p.tid = t.tid AND seeder='yes') AS seed,
				(SELECT COUNT(*) FROM peers p WHERE p.tid = t.tid AND seeder='no') AS leech,
				(SELECT COUNT(*) FROM torrent_hsz p WHERE p.tid = t.tid) AS comment,
				(SELECT COUNT(*) FROM torrent_konyv p WHERE p.tid = t.tid AND p.uid = '" . $GLOBALS['USER']['uid'] . "') AS konyv
				FROM torrent t";

		$tomb = array();
		if($GLOBALS['USER']['rang'] >= TORRENET_ADMIN_MIN_RANG) {
		} else {
			$tomb[] = " t.hidden = 'no' ";
		}

		foreach($where as $val) {
			$tomb[] = $val;
		}

		if(count($tomb) > 0)
			$sql .= " WHERE " . implode(' AND ', $tomb);

		if(!empty($order))
			$sql .= " ORDER BY " . $order;

		if(!empty($limit))
			$sql .= " LIMIT " . $limit;

		db::futat($sql);
		$nagytomb = db::tomb();
		if($dekod != 1)
			return $nagytomb;

		$kesz = array();
		foreach($nagytomb as $key => $val) {
			foreach($val as $k => $v) {
				if($k == 'megjegyzes' || $k == 'admin_megj')
					$kesz[$key][$k] = bb::bbdecode($v);
				else
					$kesz[$key][$k] = $v;		
			}

			if($GLOBALS['USER']['uj_torrent'] < $val['tdatum'])
				$kesz[$key]['uj_torrent'] = true;
			else
				$kesz[$key]['uj_torrent'] = false;

			if($GLOBALS['USER']['uid'] == $val['uid'])
				$kesz[$key]['sajat_torrent'] = true;
			else
				$kesz[$key]['sajat_torrent'] = false;

			if($val['anonymous'] == 'yes' && $GLOBALS['USER']['rang'] < TORRENET_ADMIN_MIN_RANG) {
				$kesz[$key]['uid'] = 4;
				$kesz[$key]['rang'] = 1;
				$kesz[$key]['username'] = 'Anonymous';
			}
		}
		return $kesz;
	}

	function torrentKoszi($tid) {
		$sql = "INSERT INTO torrent_koszi (tid, uid) VALUES ('%d', '%d')";
		db::futat($sql, $tid, $this->uid);
		return $this->torrentKosziLista($tid);
	}

	function torrentKosziLista($tid) {
		$sql = "SELECT u.rang, u.uid, u.name FROM torrent_koszi t LEFT JOIN users u ON t.uid = u.uid WHERE t.tid = '%d'";
		db::futat($sql, $tid);
		$tomb = db::tomb();

		$kesz = array();
		foreach($tomb as $val) {
			$kesz[] = "<a href='userinfo.php?uid=" . $val['uid'] . "'><span class='rank" . $val['rang'] . "' >" . $val['name'] . "</span></a>";
		}
		return implode(',', $kesz) . $this->torrentKosziCheck($tid);
	}

	function torrentKosziCheck($tid) {
		$uid = $GLOBALS['USER']['uid'];
		$sql = "SELECT * FROM torrent_koszi WHERE uid = '%d' AND tid = '%d'";
		db::futat($sql, $uid, $tid);

		if(db::$sorok < 1)
			return '<a href="' . $tid . '" class="torrent_koszi">&nbsp;&nbsp;Köszönöm!</a>';
		else
			return;
	}

	 function getTulaj($tid) {
		db::futat("SELECT uid FROM torrent WHERE tid = '%d'", $tid);
		return db::egy_ertek('uid');
	 }

	 function isUnique($infoHash) {
		$sql = "SELECT COUNT(*) AS db FROM torrent WHERE info_hash = '%s'";
		db::futat($sql, $infoHash);

		if(db::egy_ertek('db') == 0)
			return true;
		else
			return false;
	 }

	function getNameById($id) {
		db::futat("SELECT name FROM torrent WHERE tid = '%d'", $id);
		$name = db::egy_ertek('name');
		if(!empty($name))
			return $name;
		else
			return false;
	}
}

?>
