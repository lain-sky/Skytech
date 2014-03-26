<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class Stats {
	function torrent($order, $limit = 10) {
		$sql = "SELECT t.tid, t.name, t.letoltve,
		(SELECT SUM(letolt + feltolt) FROM peerszum psz WHERE psz.tid = t.tid) AS adat,
		(SELECT COUNT(*) FROM peers ps WHERE ps.seeder = 'yes' AND ps.tid = t.tid) AS seed,
		(SELECT COUNT(*) FROM peers pl WHERE pl.seeder = 'no' AND pl.tid = t.tid) AS leech,
		(SELECT COUNT(*) FROM peers psl WHERE psl.tid = t.tid) AS total,
		(SELECT SUM(pts.downloaded / (UNIX_TIMESTAMP(pts.last_action) - UNIX_TIMESTAMP(pts.started))) FROM peers pts WHERE pts.tid = tid) AS seb
		FROM torrent t";
		$sql .= " ORDER BY " . $order;
		$sql .= " LIMIT " . $limit;
		db::futat($sql);

		$tomb = db::tomb();
		$kesz = array();
		foreach($tomb as $key => $val) {
			$kesz[$key]['name'] = "<a href='adatlap.php?id=" . $val['tid'] . "'>" . $val['name'] . "</a>";
			$kesz[$key]['letoltve'] = number_format($val['letoltve']);
			$kesz[$key]['adat'] = bytes_to_string($val['adat']);
			$kesz[$key]['seed'] = number_format($val['seed']);
			$kesz[$key]['leech'] = number_format($val['leech']);
			$kesz[$key]['total'] = number_format($val['total']);
			$kesz[$key]['ratio'] = (!empty($val['seed']) && !empty($val['leech'])) ? round($val['seed'] / $val['leech'], 3) : 0;
			$kesz[$key]['seb'] = bytes_to_string($val['seb']) . '/s';
		}
		return Stats::rowMake($kesz);
	}

	function user($order, $limit = 10) {
		$sql = "SELECT u.uid, u.name, u.feltolt, u.letolt, u.reg_date, round((u.feltolt / u.letolt), 3) AS arany,
			(SELECT SUM(pts.downloaded / (UNIX_TIMESTAMP(pts.last_action) - UNIX_TIMESTAMP(pts.started))) FROM peers pts WHERE pts.uid = u.uid) AS leseb,
			(SELECT SUM(pt.uploaded / (UNIX_TIMESTAMP(pt.last_action) - UNIX_TIMESTAMP(pt.started))) FROM peers pt WHERE pt.uid = u.uid) AS felseb
			FROM users u";
		$sql .= " ORDER BY " . $order;
		$sql .= " LIMIT " . $limit;
		db::futat($sql);

		$tomb = db::tomb();
		$kesz = array();
		foreach($tomb as $key => $val) {
			$kesz[$key]['name'] = "<a href='userinfo.php?uid=" . $val['uid'] . "'>" . $val['name'] . "</a>";
			$kesz[$key]['feltolt'] = bytes_to_string($val['feltolt']);
			$kesz[$key]['feltoltseb'] = bytes_to_string($val['felseb']) . "/s";
			$kesz[$key]['letolt'] = bytes_to_string($val['letolt']);
			$kesz[$key]['leseb'] = bytes_to_string($val['leseb']) . "/s";
			$kesz[$key]['arany'] = $val['arany'];
			$kesz[$key]['csat'] = date('Y-m-d H:i:s', $val['reg_date']) . "&nbsp;(" . time_to_string($val['reg_date']) . ")";
		}
		return Stats::rowMake($kesz);
	}

	function rowMake($tomb) {
		$kesz = array();
		foreach($tomb as $key => $val) {
			$kesz[] = "<td>&nbsp;&nbsp;" . implode('</td><td>&nbsp;&nbsp;', $val) . "</td>";
		}
		return $kesz;
	}

	function makeWhere($ig = null, $tol = null) {
		if(!empty($ig) && !empty($tol))
			$where[] = "datum BETWEEN '" . $tol . "' AND '" . $ig . "'";
		elseif(!empty($ig))
			$where[] = "datum < '" . $ig . "'";
		elseif(!empty($tol))
			$where[] = "datum > '" . $tol . "'";
		else
			return '';

		if(count($where) != 1)
			return;
		$kesz = ' WHERE ' . implode(' AND ', $where);
		return $kesz;
	}

	static function indexStats() {
		// összes felhasználó
		db::futat("SELECT COUNT(*) AS db FROM users WHERE statusz IN('aktiv', 'passziv')");
		$tomb = db::tomb();
		$stat['user_db'] = $tomb[0]['db'];

		// tag szám
		db::futat("SELECT COUNT(*) AS db FROM users WHERE rang = '4'");
		$tomb1 = db::tomb();
		$stat['user_tag'] = $tomb1[0]['db'];

		//osszes letöltés
		db::futat("SELECT SUM(letolt) AS ossz FROM peerszum");
		$tomb2 = db::tomb();
		$stat['ossz'] = $tomb2[0]['ossz'];

		db::futat("SELECT SUM(letolt) AS ossz FROM users");
		$tomb3 = db::tomb();
		$stat['no_ingyen'] = $tomb3[0]['ossz'];
		$stat['ingyen'] = $stat['ossz'] - $stat['no_ingyen'];

		//torrent
		db::futat("SELECT COUNT(*) AS ez FROM torrent");
		$stat['torrent'] = db::egy_ertek();

		//peerek
		db::futat("SELECT COUNT(*) AS ez FROM peers");
		$stat['peers'] = db::egy_ertek();

		//seeder
		db::futat("SELECT COUNT(*) AS ez FROM peers WHERE seeder = 'yes'");
		$stat['seeder'] = db::egy_ertek();

		//Leecher
		$stat['leecher'] = $stat['peers'] - $stat['seeder'];

		//Seed/Leech
		$stat['arany'] = @round((($stat['seeder'] / $stat['leecher']) * 100), 2);

		//letolt seb
		db::futat("SELECT round(SUM(downloaded / (UNIX_TIMESTAMP(last_action) - UNIX_TIMESTAMP(started)))) AS ez FROM peers WHERE seeder = 'no'");
		$stat['sebesseg'] = db::egy_ertek() * 10;
		
		return $stat;
	}

	static function aktivUsers(){
		db::futat("SELECT uid, name, rang FROM users WHERE (vizit + 1200) > '%d' AND uid NOT IN(1) ORDER BY name", time());
		return db::tomb();
	}
}

?>
