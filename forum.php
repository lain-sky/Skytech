<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése


$smarty->assign('oldal_cime',$_SERVER['SCRIPT_NAME']);

if(empty($g['keres'])){
$pari="
select f.cim as focim,f.fid,t.status as tipus,t.tid,t.tema,t.minrang,t.ismerteto,
(select datum from forum_hsz where tid=t.tid order by hid desc limit 1)as hsz_date,
(select uid from forum_hsz where tid=t.tid order by hid desc limit 1)as uid,
(select name from forum_hsz fh left join users u on fh.uid=u.uid  where tid=t.tid order by hid desc limit 1)as name,
(select rang from forum_hsz fh left join users u on fh.uid=u.uid  where tid=t.tid order by hid desc limit 1)as rang
from forum_csoport f
left join forum_topik t on f.fid=t.fid
";
}
else{
$pari="
select f.cim as focim,f.fid,t.status as tipus,t.tid,t.tema,t.minrang,t.ismerteto,max(h.datum) as hsz_date,u.uid,u.name,u.rang from forum_csoport f
left join forum_topik t on f.fid=t.fid
left join forum_hsz h on t.tid=h.tid
left join users u on h.uid=u.uid
where t.ismerteto like '%".$g['keres']."%' or t.tema like '%".$g['keres']."%' 
group by t.tid
";
$smarty->assign('keres_text',$g['keres']);
$smarty->assign('keres_reset',$_SERVER['REQUEST_URI']);
}

db::futat($pari);
$tomb=db::tomb();

$topikok=array();
$focim=array();
foreach($tomb as $k=>$v){	
	$topikok[$v['fid']][]=array("tipus"=>$v['tipus'],"tid"=>$v['tid'],"tema"=>$v['tema'],"ismerteto"=>$v['ismerteto'],"hsz_datum"=>@date('Y.m.d H:i:s',$v['hsz_date']),"uid"=>$v['uid'],"name"=>$v['name'],"rang"=>$v['rang'],'minrang'=>$v['minrang']);
	$focim[$v['fid']]=$v['focim'] ;
}
//hsz szamolas
foreach($focim as $key=>$val){
	$sql="select sum(".
		"(select count(*) from forum_hsz h where t.tid=h.tid) "
		.") as num from forum_topik t where t.fid='%d' ";
	db::futat($sql,$key);
	$focim[$key]=$val . " &nbsp;&bull;&nbsp; Hozzászólások összesen ".db::egy_ertek('num')." db" ;
}


$smarty->assign('topikok',$topikok);
$smarty->assign('focim',$focim);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('forum.tpl');
ob_end_flush ();
?>