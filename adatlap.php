<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep();
$old=new old();


//az idezethez
if(!empty($p['idezet']) && is_numeric($p['idezet'])){
	db::futat("select text from torrent_hsz where thid='%d'",$p['idezet']);
	echo db::egy_ertek('text');
	exit;
}

if(!is_numeric($g['id']) || empty($g['id'])) {
	$OLDAL[]=hiba_uzi('A keresett torrent nem található');
} else {
	$torrent=new Torrent();
	if($torrent->checkTorrentById($g['id']) === false) {
		$OLDAL[]=hiba_uzi('A keresett torrent nem található');
	} else {
		$oldal_cime=$_SERVER["SCRIPT_NAME"] . "?id=" . $g['id'];
		$smarty->assign('oldal_cime',$oldal_cime);

		//jelentés megjenenítése
		if(!empty($_SESSION['jelentes'])) {
			$OLDAL[]=$_SESSION['jelentes'];
			unset($_SESSION['jelentes']);
		}

		//monden ellenõrizve....
		$torrent->setTorrentMegnez($g['id']);
		$ttomb=$torrent->fullLoad(array("t.tid=".$g['id']));
		$smarty->assign('t',$ttomb[0]);

		//koszonesek
		$smarty->assign('koszi',$torrent->torrentKosziLista($g['id']));

		//nyitottság  check
		$uj_hsz=($ttomb[0]['hsz_lezarva']=='no')? true:false;		
		db::futat("select uid as id from torrent_hsz where tid='%d' order by thid desc",$g['id']);
		if($USER['uid']==db::sor())
			$uj_hsz=false;	
		if($USER['rang'] < JOG_TORRENT_HOZZASZOLAS )
			$uj_hsz=false;	
		$smarty->assign('uj_hsz',$uj_hsz);

		// hsz kilista
		$sql="select t.* from torrent_hsz t where t.tid='%d' order by t.thid";
		db::futat($sql,$g['id']);

		$hsz=array();
		foreach(db::tomb() as $k=>$v) {

			$uinfo=User::load( $v['uid'] );
			$hsz[$k]=$uinfo;			
			$hsz[$k]['datum']=$v['datum'];
			$hsz[$k]['text']=bb::bbdecode($v['text']);
			$hsz[$k]['hid']=$v['thid'];

			if($v['uid']==$USER['uid']){
				$hsz[$k]['sajathsz']=true;
			}
		}

		$smarty->assign('hsz',$hsz);
		
		//jogosultság beallitas
		if($USER['rang'] >= TORRENET_ADMIN_HSZ_MIN_RANG) {
			$smarty->assign('admin_link','true');
		}

		//hsz mod
		if($g['mod']=='mod' &&  is_numeric($g['mid'])){
			db::futat("select text as id from torrent_hsz where thid='%d'",$g['mid']);
			$smarty->assign('modositas',true);
			$smarty->assign('text',db::sor());
			$smarty->assign('thid',$g['mid']);
		}

		//hsz mod save
		if(!empty($p['modtext'])   && !empty($p['thid']) ){
			$sql="update torrent_hsz set text='%s' where thid='%d'";
			$modText="\n\n\n[admin]Módosította:".$USER['name']."\nekkor:".date("Y.m.d H:i:s")."[/admin]";
			if(db::futat($sql,$p['modtext'].$modText,$p['thid'])){
				$_SESSION['jelentes']=nyugta('Módosítás sikeres volt!');
			}
			else{
				$_SESSION['jelentes']=hiba_uzi('Módosítás sikertelen');
			}
			header("Location:".$oldal_cime);		
		}

		//uj hsz
		if(!empty($p['text'])){
			$sql="insert into torrent_hsz(uid,tid,text,datum) values('%d','%d','%s',now())";
			if(db::futat($sql,$USER['uid'],$g['id'],$p['text'])){
				$_SESSION['jelentes']=nyugta('Rögzítés sikeres volt!');
			}
			else{
				$_SESSION['jelentes']=hiba_uzi('Rögzítés sikertelen');
			}
			header("Location:".$oldal_cime);
		}

		//hsz torlés
		if($g['mod']=='del' && $USER['rang']>=TORRENET_ADMIN_HSZ_MIN_RANG && is_numeric($g['mid'])){
			if(db::futat("delete from torrent_hsz where thid='%d'",$g['mid'])){
				$_SESSION['jelentes']=nyugta('Törlés sikeres volt!');
			}
			else{
				$_SESSION['jelentes']=hiba_uzi('Törlés sikertelen');
			}
			header("Location:".$oldal_cime);
		}
	}
}

$smarty->assign('OLDAL',$OLDAL);
$smarty->display('adatlap.tpl');
ob_end_flush ();
?>