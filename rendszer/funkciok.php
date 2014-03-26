<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

function d($v, $e = 0) {
	echo '<PRE>';
	var_dump($v);
	echo '</PRE>';

	if($e != 0)
		exit;
}

function section_open($cim = 'nincs') {
		$t = explode('|', $cim);

		if(in_array(md5($t[0]), $GLOBALS['SECTION_COOKIES'])) {
			$display = 'none';
			$class = 'section_collapsed';
		} else {
			$display = 'block';
			$class = 'section_expanded';
		}

		$tt = "\n\n<div class='section'>\n";
		$tt .= "\t<div class='section_header'>\n";
		$tt .= "\t\t<span class='" . $class . "' id='" . md5($t[0]) . "_span'><a href='#" . md5($t[0]) . "' class='section_link'>" . $t[0] . "</a></span>\n";
		$tt .= "\t</div>\n";
		$tt .= "\t<div class='section_content' id='" . md5($t[0]) . "' style='text-align: left; display:" . $display . ";'>\n";
		return $tt;	
}

function section_end() {
	$tt = "\t</div>\n";
	$tt .= "</div><br /><br />\n\n";
	return $tt;
}

function section_end_kek() {
	$tt = "\t</div>\n";
	$tt .= "</div><div class='section_footer'></div><br /><br />\n\n";
	return $tt;
}

function user_arany($fel, $le) {
	$tomb['le'] = '<span class="highlight">' . bytes_to_string($le) . '</span>';
	$tomb['fel'] = '<span class="highlight">' . bytes_to_string($fel) . '</span>';
	$arany = ($fel > 0 && $le > 0) ? round(($fel / $le), 3) : 0;
	$tomb['arany'] = '<span class="' . aranyszin($arany) . '" >' . $arany . '</span>';
	return $tomb;
}

function uzi($title = 'Üzenet', $text = 'Hello torrentbarát!', $gomb = 'ok|index.php', $level = 1, $width = 450) {
	$tt = '';
	$prefix = '';
	$g = explode('|', $gomb);

	for($i = 0; $i < $level; $i++) {
		$prefix .= "\t";
	}
	$tt .= $prefix . "<div class=\"dialog\" style=\"width: " . $width . (is_int($width) ? 'px' : '') . ";\">\n";
	$tt .= $prefix . "\t<div class=\"dialog_header\"><span class=\"dialog_title\">" . $title . "</span></div>\n";
	$tt .= $prefix . "\t<div class=\"dialog_content\">\n";
	$tt .= $prefix . "\t\t" . $text . "\n<br /><br />";
	$tt .= $prefix . "\t\t\t<a class=\"pic\" href=\"" . $g[1] . "\"><img border=\"0\" src=\"kinezet/alap/btn_" . $g[0] . ".png\" alt=\"" . $g[0] . "\"/></a>&nbsp;\n";
	$tt .= $prefix . "\t</div>\n";
	$tt .= $prefix . "</div>\n";
	return $tt;
}

function hiba_uzi($text) {
	$t = explode('|', $text);
	$tt = "<div id='eltuno_dialog'>";
	$tt .= "\n\n<div id='eltuno_dialog' class='dialog' style='width: 450px;'>\n";
	$tt .= "\t<div class='dialog_header'><span class='dialog_title'>";
	$tt .= (!empty($t[1])) ? $t[1] : 'Hiba';
	$tt .= "</span></div>\n";
	$tt .= "\t<div class='dialog_content'>\n";
	$tt .= "\t\t<span class='red'>" . $t[0] . "</span>\n";
	$tt .= "\t</div>\n";
	$tt .= "</div>\n\n<br /><br />";
	$tt .= "</div>";
	return $tt;
}

function nyugta($text) {
	$t = explode('|', $text);
	$tt = "<div id='eltuno_dialog'>";
	$tt .= "\n\n<div class='dialog' style='width: 450px;'>\n";
	$tt .= "\t<div class='dialog_header'><span class='dialog_title'>";
	$tt .= (!empty($t[1])) ? $t[1]:'Nyugtázó';
	$tt .= "</span></div>\n";
	$tt .= "\t<div class='dialog_content'>\n";
	$tt .= "\t\t" . $t[0] . "\n";
	$tt .= "\t</div>\n";
	$tt .= "</div>\n\n<br /><br />";
	$tt .= "</div>";
	return $tt;
}

function bytes_to_string($bytes) {
	$bytes = abs($bytes);
	$unit = 'B';
	$sizes = array('', 'k', 'M', 'G', 'T', 'P', 'E');
	$extension = $unit;
	for($i = 1; (($i < count($sizes)) && ($bytes >= 1024)); $i++) {
		$bytes /= 1024;
		$extension = $sizes[$i] . $unit;
	}
	return round($bytes, 2) . ' ' . $extension;
}

function time_to_string($mikor) {
	$stamp = time() - $mikor;
	if($stamp >= 604800)
		return (int)($stamp / 604800) . ' hete';
	elseif($stamp >= 86400)
		return (int)($stamp / 86400) . ' napja';
	elseif($stamp >= 3600)
		return (int)($stamp / 3600) . ' órája';
	elseif($stamp >= 60)
		return (int)($stamp / 60) . ' perce';
	else
		return 'most';
}

function date_to_string($mikor) {
	$stamp = time() - strtotime($mikor);
	if($stamp >= 3600)
		return (int)($stamp / 3600) . ' órája';
	elseif($stamp >= 60)
		return (int)($stamp / 60) . ' perce';
	else
		return '1 perce';
}

function ido($str) {
	if($str < 0)
		$str = 0;

	$t = array();
	foreach(array('60:mp', '60:p', '24:o', '0:n') as $x) {
		$y = explode(':', $x);
		if($y[0] > 1) {
			$v = $str % $y[0];
			$str = floor($str / $y[0]);
		} else {
			$v = $str;
		}
		$t[$y[1]] = $v;
	}

	if($t['n'])
		return sprintf('%d ó %d p', (($t['n']*24)+$t['o']), $t['p']);
	elseif($t['o'])
		return sprintf('%d ó %d p', $t['o'], $t['p']);
	elseif($t['p'])
		return sprintf('%d p', $t['p']);
	else
		return '-';
}

function aranyszin($arany) {
	if($arany < 0.5)
		return 'ratio1';
	if($arany < 0.8)
		return 'ratio2';
	if($arany < 1.2)
		return 'ratio3';
	if($arany < 2)
		return 'ratio4';
	return 'ratio5';
}

function getfiletype($ext) {
	global $filetypes;
	$ext = strtolower($ext);
	if($filetypes[$ext])
		return $filetypes[$ext];
	else
		return 'Ismeretlen';
}

function ervenyes_nev($username) {
	if(empty($username))
		return false;
	return preg_match('/^[a-z0-9]*$/is', $username);
}

function ervenyes_email($email) {
	if(empty($email))
		return false;
	return preg_match('/^[\w.-]+@([\w.-]+\.)+[a-z]{2,6}$/is', $email);
}

function veletlen_adat($nev) {
	$ret = array('passkey' => veletlen_torrent_pass());
	$pw = explode('|', veletlen_jelszo($nev));
	$ret['password'] = $pw[1];
	$ret['passhash'] = $pw[0];
	return($ret);
}

function fajlnev_atalakit($nev) {
	$mit = array('ö','ü','ó','õ','ú','é','á','û','í',' ',"'",'"','+','!','%','/','=','(',')','@','&','#','>','<','*','\\','|','$');
	$mire = array('o','u','o','o','u','e','a','u','i','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_');
	$kesz = str_replace($mit, $mire, $nev);
	return $kesz;
}

function veletlen_jelszo($nev) {
	do {
		for($i = 0; $i <= 4; $i++) {
			switch(mt_rand(1, 3)) {
				case 1:
					$string = $string . chr(mt_rand(48, 57));
					break;

				case 2:
					$string = $string . chr(mt_rand(65, 90));
					break;

					case 3:
					$string = $string . chr(mt_rand(97, 122));
					break;
			}
		}
		$md5 = md5($nev . $string);
		db::futat("SELECT uid FROM users WHERE pass = '%s' LIMIT 1", $md5);
	} while(db::$sorok !== 0);
	return $md5 . '|' . $string;
}

function veletlen_torrent_pass() {
	do {
		for($i = 0; $i <= 50; $i++) {
			$string = $string . chr(mt_rand(32, 126));
		}
		$pkey = md5($string);
		db::futat("SELECT uid FROM users WHERE tor_pass = '%s' LIMIT 1", $pkey);
	} while(db::$sorok !== 0);
	return $pkey;
}

function veletlen_ellenor() {
	do {
		for($i = 0; $i <= 50; $i++) {
			$string = $string . chr(mt_rand(32, 126));
		}
		$hash = md5($string);
		db::futat("SELECT rid FROM regisztral WHERE ellenor = '%s' LIMIT 1", $hash);
	} while(db::$sorok !== 0);
	return $hash;
}

function as_md5($var) {
	return((preg_match("/^[A-Fa-f0-9]{32}$/", $var) == 1) ? $var : NULL);
}

function reg_mail($tomb) {
	$tt = '<html><head></head>
	<body>
	<h2>Kedves ' . $tomb['name'] . '!</h2>
	<hr>
	<p>Üdvözlünk az ' . OLDAL_NEVE . ' felhasználói között!<br/><br/>
	Te, vagy valaki más regisztrálta ezt az e-mail címet. Ha valóban te voltál az,<br/>
	az alábbi linkre kattintva megerõsítheted a registrációdat.<br/><br/>
	'.OLDAL_CIME.'/regisztracio.php?mod=' . $tomb['ellenor'] . '<br/><br />
	(Ha nem tudsz a hivatkozásra kattintani, másold be a böngészõd címsorába!)<br/><br/>
	<b>Figyelem!</b> A fenti hivatkozás csak három napig érvényes!<br/><br/>
	Egészen addig nem tudsz bejelentkezni, amíg meg nem erõsíted a regisztrációd.<br/><br/>
	Emlékeztetõül:<br/>
	Neved: <b>' . $tomb['name'] . '</b><br/>
	Jelszavad: <b>' . $tomb['pass'] . '</b><br/><br/>
	Amennyiben mégsem te regisztráltál oldalunkra, nyugodtan töröld ezt az üzenetet.<br/><br/>
	Köszönjük,<br/><br/>
	' . date('Y-m-d') . ' - ' . OLDAL_CSAPATA . '<br/>
	<i>' . OLDAL_CIME . '</i><br/></p>
	</body>
	</html>';
	return $tt;
}

function uj_jelszo_mail($tomb) {
	$tt = '<html><head></head>
	<body>
	<h2>Kedves ' . $tomb['name'] . '!</h2>
	<hr>
	<p>Kérted, hogy jelszavad változtassuk meg a következõre:<br/><br/>
	<b>' . $tomb['pass'] . '</b><br/><br/>
	Ha valóban meg kívánod változtatni a jelszavad, kattints az alábbi hivatkozásra:<br/><br/>
	' . OLDAL_CIME . '/regisztracio.php?mod=' . $tomb['ellenor'] . '<br /><br/>
	(Ha nem tudsz a hivatkozásra kattintani, másold be a böngészõd címsorába!)<br/><br/>
	<b>Figyelem!</b> A fenti hivatkozás csak három napig érvényes!<br/><br/>
	Jelszavad egészen addig a régi marad, míg meg nem erõsíted a fenti hivatkozás meghívásával.<br/>
	Ha mégsem szeretnéd megváltoztatni a jelszavad, nyugodtan töröld ezt az üzenetet.<br/><br/>
	Köszönjük,<br/><br/>
	' . date('Y-m-d') . ' - ' . OLDAL_CSAPATA . '<br/>
	<i>' . OLDAL_CIME . '</i><br/></p>
	</body>
	</html>';
	return $tt;
}

function elfelejtet_jelszo_mail($tomb) {
	$tt = '<html><head></head>
	<body>
	<h2>Kedves ' . $tomb['name'] . '!</h2>
	<hr>
	<p>Jelezted, hogy elfelejtetted a jelszavad. Ha valóban így van, az alábbi hivatkozásra<br/>kattintva érvényesítheted a véletlenszerûen generált új jelszavadat:<br/>
	<br />';
	$tt .= $tomb['jelszo'];
	$tt .= '
	<br />
	<br/>
	' . OLDAL_CIME . '/regisztracio.php?mod=' . $tomb['ellenor'] . '<br /><br/>
	(Ha nem tudsz a hivatkozásra kattintani, másold be a böngészõd címsorába!)<br/><br/>
	<b>Figyelem!</b> A fenti hivatkozás csak három napig érvényes!<br/><br/>
	Ha mégsem felejtetted el a jelszavad, nyugodtan töröld ezt az üzenetet.<br/><br/>
	Köszönjük,<br/><br/>
	' . date('Y-m-d') . ' - ' . OLDAL_CSAPATA . '<br/>
	<i>' . OLDAL_CIME . '</i><br/></p>
	</body>
	</html>';
	return $tt;
}

function meghivo_mail($tomb) {
	$tt='<html><head></head>
	<body>
	<h2>Kedves ' . $tomb['mail'] . '!</h2>
	<hr>
	<p>Üdvözlünk az ' . OLDAL_NEVE . ' felhasználói között!<br/><br/>
	' . $tomb['nev'] . ' nevû taguk meghívott az oldalra, az alábbi linkre kattintva regisztrálhatod magad.<br/><br/>
	' . OLDAL_CIME . '/regisztracio.php?mod=' . $tomb['ellenor'] . '<br /><br/>
	(Ha nem tudsz a hivatkozásra kattintani, másold be a böngészõd címsorába!)<br/><br/>
	<b>Figyelem!</b> A fenti hivatkozás csak három napig érvényes!<br/><br/>
	Amennyiben nem szeretnél regisztrálni az oldalunkra, nyugodtan töröld ezt az üzenetet.<br/><br/>
	Köszönjük,<br/><br/>
	' . date('Y-m-d') . ' - ' . OLDAL_CSAPATA . '<br/>
	<i>' . OLDAL_CIME . '</i><br/></p>
	</body>
	</html>';
	return $tt;
}

function isBarat($uid) {
	$sql = "SELECT COUNT(*) AS id FROM barat WHERE tulaj_uid = '%d' AND barat_uid = '%d'";
	db::futat($sql, $GLOBALS['USER']['uid'], $uid);
	if(db::sor() == 0)
		return false;
	return true;
}

function upTimeProcess() {
	exec('uptime', $output); 
	$output = explode(',', $output[0]);
	$upData[] = trim(str_replace('load average:', '', $output[2]));
	$upData[] = trim($output[3]);
	$upData[] = trim($output[4]);
	$upAtlag = round((array_sum($upData) / 3), 4) / 4;
	$kerek = ($upAtlag > 1) ? 1 : $upAtlag;
	return $kerek; 
}

?>
