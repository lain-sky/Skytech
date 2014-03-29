<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
require_once('rendszer/torrent.functions.php');
$belep = new belep();
$old = new old();
$f = $_FILES;
$torrent = new Torrent();


if(!empty($p) && !empty($f)) {
	if(!empty($p['tname']))
		$torrent->name = trim($p['tname']);
	else
		$hiba[] = 'Nem adtad meg a torrent nevét';	

	if(!empty($p['tcategory']) && is_numeric($p['tcategory']))
		$torrent->kid = $p['tcategory'];
	else
		$hiba[] = 'Nem választottál kategóriát';

	if(!empty($p['tnotes']))
		$torrent->megjegyzes = $p['tnotes'];

	if(!empty($p['anonymous']) && $p['anonymous'] = 'igen')
		$torrent->anonymous = 'yes';

	if($p['tcene'] == 'yes') {
		$torrent->eredeti = 'y';

		if(!empty($p['homepage']))
			$torrent->honlap = $p['homepage'];

		if(!empty($p['year']))
			$torrent->megjelen = $p['year'];
	} else {
		if(!empty($p['homepage']))
			$torrent->honlap = $p['homepage'];
		else
			$hiba[] = 'Nem adtál meg honlapot';

		if(!empty($p['year']))
			$torrent->megjelen = $p['year'];
		else
			$hiba[] = 'Nem adtál meg megjelenést';
	}

	if(!empty($p['pic1']))
		$torrent->kep1 = $p['pic1'];

	if(!empty($p['pic2']))
		$torrent->kep2 = $p['pic2'];

	if(!empty($p['pic3']))
		$torrent->kep3 = $p['pic3'];

	if(!empty($f['tfile'])) {
		$fName = $f['tfile']['name'];
		$fTemp = $f['tfile']['tmp_name'];

		$jo_file_type = array('application/x-bittorrent', 'application/octet-stream', 'application/force-download');

		if(in_array($f['tfile']['type'], $jo_file_type) !== true)
			$hiba[] = 'A torrentfájl formátuma nem megfelelõ!';

		if(!preg_match('/^(.+)\.torrent$/si', $fName, $matches))
			$hiba[] = 'A torretn fájl kiterjesztése nem mgefelelõ!';

		$shortfname = $torrent_m = $matches[1];
	} else {
		$hiba[] = 'Nincs torrent fájl!';
	}

	if(!empty($f['tnfo']) && !empty($f['tnfo']['name']) && !empty($f['tnfo']['tmp_name'])) {
		$nfoName = $f['tnfo']['name'];
		$nfoTemp = $f['tnfo']['tmp_name'];

		$joNfoFileType = array('application/octet-stream', 'application/x-nfo', 'text/nfo', 'text/plain');

		if(in_array($f['tnfo']['type'], $joNfoFileType) !== true)
			$hiba[] = 'Az nfo formátuma nem megfelelõ!';

		if(!preg_match('/^(.+)\.nfo$/si', $nfoName, $nfomatches))
			$hiba[]='Az nfo fájl kiterjesztése nem mgefelelõ!';

		if(count($hiba) < 1)
			$nfoellen = true;
	}

	if($p['tcene'] == 'yes') {
		if($nfoellen !== true)
			$hiba[] = 'Nem csatoltál nfo fájlt, pedig kellett volna!';
	}

	if(count($hiba) < 1) {
		privHack($fTemp, MAX_TORRENT_SIZE);

		$dict = bdec_file($fTemp, MAX_TORRENT_SIZE);
		if(!isset($dict))
			$hiba[]='Hiba a torrent fájl olvasása közben!';

		list($ann, $info) = dict_check($dict, 'announce(string):info');
		list($dname, $plen, $pieces) = dict_check($info, 'name(string):piece length(integer):pieces(string)');

		if(strlen($pieces) % 20 != 0)
			$hiba[] = 'invalid pieces';

		$filelist = array();
		$totallen = dict_get($info, 'length', 'integer');
		if(isset($totallen)) {
			$filelist[] = array($dname, $totallen);
			$type = 'single';
		} else {
			$flist = dict_get($info, 'files', 'list');
			if(!isset($flist))
				die('missing both length and files');
			if(!count($flist))
				die('no files');
			$totallen = array();
			foreach($flist as $fn) {
				list($ll, $ff) = dict_check($fn, 'length(integer):path(list)');
				$totallen[] = $ll;
				$ffa = array();
				foreach($ff as $ffe) {
					if ($ffe['type'] != 'string')
						die('filename error');
					$ffa[] = $ffe['value'];
				}
				if(!count($ffa))
					die('filename error2');

				$ffe = implode('/', $ffa);
				$filelist[] = array($ffe, $ll);
			}
			$type = 'multi';
		}

		$tempInfoHash = md5(pack('H*', sha1($info['string'])));
		if(Torrent::isUnique($tempInfoHash) != true)
			$hiba[] = 'A torrent már az adatbázisunkban van!!';
	}

	if(count($hiba) < 1) {
		$torrent->search_text = searchfield($shortfname . $dname . $torrent_m);
		$torrent->meret = (is_array($totallen)) ? array_sum($totallen) : $totallen;
		$torrent->fajl_db = count($filelist);
		$torrent->fajlok = $filelist;
		$torrent->tempname = $fTemp;
		$torrent->info_hash = pack('H*', sha1($info['string']));
		$rogzitett = $torrent->add();
		if($rogzitett !== false) {			
			if($nfoellen === true) {
				$torrent->nfo_temp = $nfoTemp;
				if(Nfo::add($nfoTemp, $nfoName, $rogzitett))
					$torrent->update($rogzitett, array('nfo_name' => 'yes'), false);
				else
					$OLDAL[] = hiba_uzi('Figyelmeztetés! Hiba az NFO fájl csatolása közben');
			}
			logs::sysLog('torrent', 'torrent feltöltés', 'tid = ' . $rogzitett);
			
			$pontok = new Pont();
			$pontok->addTorrentFeltolt($torrent->meret);

			$OLDAL[] = nyugta('Feltöltés sikeres!');
		} else {
			$OLDAL[] = hiba_uzi('Feltöltés sikertelen');
		}
	} else {
		$OLDAL[] = hiba_uzi(implode('<br />', $hiba));
	}
}

db::futat("SELECT text, cid FROM cikk WHERE mihez = 'felt'");
$segedlet = array();
foreach(db::elso_sor() as $key => $val) {
	$segedlet[$key] = ($key == 'text') ? str_replace('##tracker_url##', $torrent->getTrackerUrl(), bb::bbdecode($val)) : $val;
}

$smarty->assign('segedlet', $segedlet);
if($USER['rang'] > 8 )
	$smarty->assign('admin_link', 'true');

$smarty->assign('tipusok', kategoria::getAll('kid,nev'));
$smarty->assign('passkey', $torrent->getTrackerUrl());
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('feltolt.tpl');
ob_end_flush();

?>
