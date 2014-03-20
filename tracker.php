<?php
define('SZINT1',666);
define('MAIL_DEBUG',false);

require_once('../rendszer/config.php');
require_once('../rendszer/db_class.php');
require_once('../rendszer/torrent.class.php');
require_once('../rendszer/torrent.functions.php');
require_once('../rendszer/logs.class.php');
require_once('../rendszer/debug.class.php');



//$getCopy=$_GET;
//unset($getCopy['peer_id'],$getCopy['info_hash']);
$torrentLogHozAGet=var_export($_GET, true);
//$torrentLogHozAGet=iconv("UTF-8", "ISO-8859-2//IGNORE",  $torrentLogHozAGet );
//$torrentLogHozAGet='alma';

if(TRACKER=='no'){
	err(TRACKER_KIKAPCSOL_TEXT);
}


/*beallitasok */
$announce_interval= (int)TRACKER_AUTO_REFRESH; //az idõ amilyen sûrûn visszanéz a kliens
$rsize = (int)MAX_PEERS;// ez egy torrenthez kapcsoloódo max user
$announce_wait = (int)MIN_BEJELENTKEZES;//min várakoztatás
$MEMBERSONLY="yes"; //valami az userekkel kapcsolatos
$waitsystem=(ADAT_KORLATOZAS == "yes")? "yes":"no" ;
$maxdlsystem =(SLOT_KORLATOZAS =="yes")? "yes":"no" ;
$ip = getip();
$dt=date("Y-m-d H:i:s",(time()-180));
$updateset = array();

$uagent = $_SERVER['HTTP_USER_AGENT'];
$agent = $_SERVER["HTTP_USER_AGENT"];
if(function_exists('getallheaders')){
	$headers = getallheaders();
}



/*************/
/* takaritas */
/*************/
//db::futat("delete from peers where (UNIX_TIMESTAMP(now())- UNIX_TIMESTAMP(last_action))>%d",($announce_interval+100));


/****************/
/* adat konvert */
/****************/
foreach (array("passkey","info_hash","peer_id","event","ip", "localip") as $x){
	if(isset($_GET[$x])) $GLOBALS[$x] = "" . $_GET[$x];
}
foreach (array("port","downloaded","uploaded","left") as $x){
	$GLOBALS[$x] = 0 + $_GET[$x];
}
if (strpos($passkey, "?")){	
	$tmp = substr($passkey, strpos($passkey, "?"));	
	$passkey = substr($passkey, 0, strpos($passkey, "?"));	
	$tmpname = substr($tmp, 1, strpos($tmp, "=")-1);	
	$tmpvalue = substr($tmp, strpos($tmp, "=")+1);	
	$GLOBALS[$tmpname] = $tmpvalue;
}

foreach (array("passkey","info_hash","peer_id","port","downloaded","uploaded","left") as $x)
	if (!isset($x)) err("Missing key: $x");
		foreach (array("info_hash","peer_id") as $x)
			if (strlen(stripslashes($GLOBALS[$x])) != 20) err("Invalid $x (" . strlen($GLOBALS[$x]) . " - " . urlencode($GLOBALS[$x]) . ")");
				if (strlen($passkey) != 32) err("Invalid passkey (" . strlen($passkey) . " - $passkey)");

				
foreach(array("num want", "numwant", "num_want") as $k){
	if (isset($_GET[$k])){
		$rsize = 0 + $_GET[$k];
		break;
	}
}
if (!isset($event))	$event = "";
$seeder = ($left == 0) ? "yes" : "no";

/**********/
/* Chechk */
/**********/

//anti cheat
if (isset($headers["Cookie"]) || isset($headers["Accept-Language"]) || isset($headers["Accept-Charset"])){
	err("Anti-Cheater= Ez nem szep dolog!");
}


//bongeszobol valo futathatosagi tiltas
if (ereg("^Mozilla\\/", $agent) || ereg("^Opera\\/", $agent) || ereg("^Links ", $agent) || ereg("^Lynx\\/", $agent))
	err("A torrent nem toltheto bongeszobol!");

//tiltot kliensek

db::futat("select kliens from tiltot_kliens");
foreach(db::elso_sor() as $nea){
	$n = $nea['kliens'];
	$nr = preg_replace("/\//", "\/", $n);
	$neadle = "/\b$nr\b/i";
	if (preg_match($neadle, $uagent))
	        err("A kliensed tito listan van,az oldalon megtalalod a tamogatott klienseket:".Oldal_cime);
}
if(ereg("^BitTorrent\\/S-", $agent)) err("Shadow's Experimental Client is Banned. Please use uTorrent.");
if(ereg("^ABC\\/ABC", $agent)) err ("ABC is Banned. Please use uTorrent.");
if(ereg("^Python-urllib\\/2.4", $agent)) err ("Banned Client. Please use uTorrent.");

//megint kliens chek
getoutofmysite($peer_id);

//port check
if (!$port || $port > 0xffff) err("invalid port");
if (portblacklisted($port)){
	err("Port $port is blacklisted.");
}

//van-e passkey
db::futat("select count(*)as db from users where tor_pass='%s'",$passkey);
$valid=db::tomb();
if ($valid[0]['db'] != 1) err("Hibas passkey!Probald ujra letolteni a torrent fajt:".Oldal_cime);


/***************/
/* innen indul */
/***************/

// torrent létezik e?
db::futat("select tid,kid,name,seeders+leechers as numpeers,UNIX_TIMESTAMP(datum) AS letrehozva,ingyen from torrent where (info_hash='%s' or info_hash='%s'  or info_hash='%s')",md5(stripslashes($info_hash)),md5(my_hash(stripslashes($info_hash))),md5($info_hash));

if (db::$sorok<1){
	d::addText('sql',db::$parancs);
	d::addText('hash',$info_hash);
	d::send(false); 
	err("A torrent nincs regisztralva a tracker-en!!");
}

//torrentadatainak betoltese
	$torrent=db::tomb();
	$torrentid = $torrent[0]["tid"];
	$ingyen_torrent=$torrent[0]["ingyen"];
	$torrentname = $torrent[0]["name"];
	$torrentcategory = $torrent[0]["kid"];
	$numpeers = $torrent[0]["numpeers"];
	$torrentLetrehozva=$torrent[0]['letrehozva'];
	$limit = "";
	$fields = "seeder, peer_id, ip, port, uploaded, downloaded, uid, last_action,  UNIX_TIMESTAMP(NOW()) AS nowts, UNIX_TIMESTAMP(prev_action) AS prevts ";

//ha tobben csatlakoznak mint a megadott limit
if ($numpeers > $rsize)	$limit = "ORDER BY RAND() LIMIT $rsize";

//peers adatok lekérése
//$pari="select ".$fields." from peers where tid='%d' and connectable = 'yes' ".$limit;
$pari="select ".$fields." from peers where tid='%d'  ".$limit;
db::futat($pari,$torrentid);
$peerlistahoz=db::tomb();

//peerlista oszeálítasa
$resp = "d" . benc_str("interval") . "i" . $announce_interval . "e" . benc_str("peers") . "l";
unset($self);
foreach($peerlistahoz as $row){
	$row["peer_id"]=numericEncode($row["peer_id"]);
	$row["peer_id"] = hash_pad($row["peer_id"]);

	//user azon=> a connecttable miatt seeeder lehet csak
	if ($row["peer_id"] === $peer_id){
		$userid = $row["uid"];
		$self = $row;
		continue;
	}
	$resp .= "d" .
		benc_str("ip") . benc_str($row["ip"]) .
		benc_str("peer id") . benc_str($row["peer_id"]) .
		benc_str("port") . "i" . $row["port"] . "e" .
		"e";
}

$resp .= "ee";
$selfwhere = "tid = '".$torrentid."' AND peer_id='". numericDecode($peer_id)."'";

//ha nincs benne az user a nincs benne akkor talán most ha csak a lecthereket nézzük
if (!isset($self)){
	db::futat("SELECT ".$fields." FROM peers WHERE ".$selfwhere);
	$peerlist2=db::tomb();
	$row=$peerlist2[0];
	if(!empty($row)){
		$userid = $row["uid"];
		$self = $row;
	}
}

//minimum vároakoztatás
if( isset($self) && ($self['prevts'] > ($self['nowts'] - $announce_wait )) )
	err('Minimum bejelentkezesi ido: ' . $announce_wait . ' seconds');

//nincs meg bent az user a peer listaban azaz friss letöltõ
if (!isset($self)){	
	db::futat("SELECT COUNT(*) as db FROM peers WHERE tid='%d' and passkey='%s'",$torrentid,$passkey);
	$valid=db::tomb();	
	
	if ($valid[0]['db'] >= 1 && $seeder == 'no') err("Connection limit exceeded! You may only leech from one location at a time.");	
	if ($valid[0]['db'] >= 3 && $seeder == 'yes') err("Connection limit exceeded!");

	db::futat("select uid,feltolt,letolt,rang from users where tor_pass='%s' and statusz='aktiv' limit 1",$passkey);	
	if ($MEMBERSONLY == "yes" && db::$sorok == 0){
		err("A passkey hiba keresd fel az oldalt:".Oldal_cime);

}

	$az = db::elso_sor();
	$userid = 0 + $az["uid"];

	//ujonc korlátozás	
	if ($az["rang"] < (int)KORLATOZAS_RANG){
		$gigs = $az["feltolt"];
		$elapsed = (time() - $torrentLetrehozva) ;
		$ratio = (($az["letolt"] > 0) ? ($az["feltolt"] / $az["letolt"]) : 1);

		if ($waitsystem == "yes") {			
			if (	$ratio < ADAT_KORLATOZ_1_RATIO || $gigs < ADAT_KORLATOZ_1_DATA ) $wait = ADAT_KORLATOZ_1_WAIT;
			elseif ($ratio < ADAT_KORLATOZ_2_RATIO || $gigs < ADAT_KORLATOZ_2_DATA ) $wait = ADAT_KORLATOZ_2_WAIT;
			elseif ($ratio < ADAT_KORLATOZ_3_RATIO || $gigs < ADAT_KORLATOZ_3_DATA ) $wait = ADAT_KORLATOZ_3_WAIT;
			elseif ($ratio < ADAT_KORLATOZ_4_RATIO || $gigs < ADAT_KORLATOZ_4_DATA ) $wait = ADAT_KORLATOZ_4_WAIT;
			else $wait = 0;
			if ($elapsed < $wait)
				err("Idokorlatozas! letelik: " . date('d H:i:s',($wait - $elapsed) ) . " mulva");
		}

		if ($maxdlsystem == "yes") {
			if (	$ratio < SLOT_KORLATOZ_1_RATIO || $gigs < SLOT_KORLATOZ_1_DATA) $max = SLOT_KORLATOZ_1_MAX;
			elseif ($ratio < SLOT_KORLATOZ_2_RATIO || $gigs < SLOT_KORLATOZ_2_DATA) $max = SLOT_KORLATOZ_2_MAX;
			elseif ($ratio < SLOT_KORLATOZ_3_RATIO || $gigs < SLOT_KORLATOZ_3_DATA) $max = SLOT_KORLATOZ_3_MAX;
			elseif ($ratio < SLOT_KORLATOZ_4_RATIO || $gigs < SLOT_KORLATOZ_4_DATA) $max = SLOT_KORLATOZ_4_MAX;
			else $max = 0;
			if ($max > 0) {
				db::futat("select count(*) as num from peers where uid='%d' and seeder='no'");				
				if (db::egy_ertek('num') > $max) err("Slot korlatozas, maximum". $max ." slot-ot hasznalhatsz");
			}
		}
	}
}

else{
//az user ben tvan a peer tablaban
	$upthis = max(0, $uploaded - $self["uploaded"]);
	$downthis = max(0, $downloaded - $self["downloaded"]);

	// feltoltesi adatok jovairasa
	if ($upthis > 0 || $downthis > 0){
		$pari="UPDATE users SET feltolt = feltolt + %f , letolt = letolt + %f WHERE uid='%d'";		
		$modLetot=($ingyen_torrent=='yes')? 0:$downthis;		
		db::futat($pari,$upthis,$modLetot,$userid );

	}
}



	$downloaded2=$downloaded - $self["downloaded"];
	$uploaded2=$uploaded - $self["uploaded"];
	$prev_action = $self['last_action'];

	//mentes a peer listahoz
	db::futat("select count(*) as num from peerszum where uid='%d' and tid='%d'",$userid,$torrentid);
	if(db::egy_ertek('num')<1){
		//peer szumba rogzit
		$pari="insert into peerszum(uid,tid,feltolt,letolt) values('%d','%d','%d','%d')";
		db::futat($pari,$userid,$torrentid,$uploaded,$downloaded);
	}
	else{
		//peer szum update
		$pari="update peerszum set feltolt=feltolt+ %f , letolt=letolt+ %f where uid='%d' and tid='%d'";
		db::futat($pari,$uploaded2,$downloaded2,$userid,$torrentid);
	}

//a toltogetes megallitasa
if ($event == "stopped"){	
	db::futat("DELETE FROM peers WHERE " . $selfwhere);	
}
else{
	//toltoget vegzes
	if ($event == "completed"){
		db::futat("update torrent set letoltve=letoltve+1 where tid='%d' ",$torrentid);		
	}

	
	$sockres = @fsockopen($ip, $port, $errno, $errstr, 5);
	if (!$sockres)
		$connectable = "no";
	else{
		$connectable = "yes";
		@fclose($sockres);
	}
	
	d::addText('ip',$ip);
	d::addText('port',$port);
	d::addText('connect',$connectable);
	
	
	//azonositott user a peer alapján
	if (isset($self)){
		
		//peers tablaba mentes
		$pari="UPDATE peers SET connectable='%s', uploaded='%f',downloaded ='%f', to_go ='%d', last_action = NOW(),prev_action ='%s',seeder ='%s' "
				. ($seeder == "yes" && $self["seeder"] != $seeder ? ", finishedat = " . time() : "") . " WHERE ". $selfwhere;
		db::futat($pari,$connectable,$uploaded,$downloaded,$left,$prev_action,$seeder);
		
	}
	else{		
		
		//peerbe rogzites
		$pari="INSERT INTO peers (connectable, tid, peer_id, ip, port, uploaded, downloaded, to_go, started, last_action, seeder, uid, agent, uploadoffset, downloadoffset, passkey) VALUES"
										."('%s','%d','%s','%s','%s','%d','%d','%d',NOW(),NOW(),'%s','%d','%s','%d','%d','%s')";
		db::futat($pari,$connectable, $torrentid,numericDecode($peer_id), $ip, $port, $uploaded, $downloaded, $left, $seeder, $userid, $agent, $uploaded, $downloaded, $passkey);
	}
}	
	$updateset[] = "modositva = NOW()";

	if (count($updateset)){
		$pari="UPDATE torrent SET " . join(",", $updateset) . " WHERE tid ='%d'";
	db::futat($pari,$torrentid);
}

logs::torrent($torrentid,$userid,$uploaded,$downloaded,$uploaded2,$downloaded2,$torrentLogHozAGet  );
db::hardClose();
benc_resp_raw($resp);

d::send(false); 
?>