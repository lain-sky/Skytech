<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése


$sql="select 
(select name from users where uid=p.uid)as username,
(select rang from users where uid=p.uid)as rang,
p.connectable as modozat,
p.uploaded as fel,
p.downloaded as le,
ps.feltolt as szum_fel,
ps.letolt as szum_le,
(select meret from torrent where tid=p.tid) as szum,
UNIX_TIMESTAMP(p.last_action) as time_end,
UNIX_TIMESTAMP(p.started) as time_start,
p.agent as kliens,
p.seeder,p.uid
from peerszum ps
join peers p  on ps.uid=p.uid and ps.tid=p.tid
where p.tid='%d' ";

db::futat($sql,$g['id']);
$tomb=db::tomb();
$kesz=array();

foreach($tomb as $p){
	$tk=$p['time_end']-$p['time_start'];

	$kesz[$p['seeder']][]=array(
		"uid"=>$p['uid'],
		"rang"=>$p['rang'],
		"name"=>$p['username'],
		"mod"=>$p['modozat'],
		"feltolt"=>$p['szum_fel'],
		"feltolt_seb"=>@round($p['fel']/$tk),
		"letolt"=>$p['szum_le'],
		"letolt_seb"=>@round($p['le']/$tk),
		"arany"=>@round(($p['szum_fel']/($p['szum_le']+1)),3),
		"allapot"=>@round((($p['szum_le']/$p['szum'])*100),2),
		"kliens"=>$p['kliens'],
		"csat"=>$p['time_start'],
		"fris"=>$p['time_end']	
	);
}

$torrent=torrent::fullLoad(array('tid='.$g['id']) );
$smarty->assign('torrent',$torrent[0] );
$smarty->assign('seed',$kesz['yes']);
$smarty->assign('leech',$kesz['no']);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('peerlista.tpl');
ob_end_flush ();
?>