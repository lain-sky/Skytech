<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$torrent= new Torrent();
$konyv= new KonyvJelzo();


//aszinkron mûveletek
switch($g['modul']){
	case "hitelesit":
		$tomb=array('admin_id'=>$USER['uid']);
		$torrent->update($g['tid'],$tomb);
		logs::sysLog( 'torrent_admin' , 'hitelesít', 'tid='. $g['tid']  );
		echo $USER['name'];
	break;	

	case "hsz_letilt":
		$tomb=array('hsz_lezarva'=>'yes');
		$torrent->update($g['tid'],$tomb);
		logs::sysLog( 'torrent_admin' , 'hsz letiltás', 'tid='. $g['tid']  );
	break;	

	case "hsz_enged":
		$tomb=array('hsz_lezarva'=>'no');
		$torrent->update($g['tid'],$tomb);
		logs::sysLog( 'torrent_admin' , 'hsz engedélyezés', 'tid='. $g['tid']  );
	break;	

	case "admin_komment_del":
		$tomb=array('admin_megj'=>'');
		$torrent->update($g['tid'],$tomb);
		logs::sysLog( 'torrent_admin' , 'admin komment del', 'tid='. $g['tid']  );
	break;	

	case "torrent_del":
		$torrent->delTorrent($g['tid']);
		logs::sysLog( 'torrent_admin' , 'torrent del', 'tid='. $g['tid']  );
	break;	

	case "koszi":
		echo $torrent->torrentKoszi($g['tid']);
	break;		

	case "addkonyv":
		echo $konyv->addKonyv($g['tid']);
	break;	

	case "delkonyv":
		echo $konyv->delKonyv($g['tid']);
	break;

	case "lapoz":
		echo $torrent->getKonyvLista($g['tid']);
	break;
	
	case 'getnfo':
		echo 
		'<div class="layer">
			<div class="layer">
				<a href="nfo.php?id='.$g['tid'].'&amp;modul=flash&amp;height=500&amp;width=800" class="thickbox">Megjelenítés Flash Movie-ként</a>&nbsp;&bull;&nbsp;
				<a href="nfo.php?id='.$g['tid'].'&amp;modul=image&amp;height=500&amp;width=800" class="thickbox">Megjelenítés képként</a>&nbsp;&bull;&nbsp;
				<a href="nfo.php?id='.$g['tid'].'&amp;modul=text&amp;height=500&amp;width=800" class="thickbox" title="">Megjelenítés szövegként</a>&nbsp;&bull;&nbsp;
				<a href="nfo.php?id='.$g['tid'].'&amp;modul=render&amp;download=1">NFO letöltése (kép)</a>&nbsp;&bull;&nbsp;
				<a href="nfo.php?id='.$g['tid'].'&amp;modul=download">NFO letöltése (NFO fájl)</a>
			</div>
		</div>';
		echo '<script type="text/javascript">tb_init("a.thickbox, area.thickbox, input.thickbox");</script>';
	break;	

	case 'getfiles':
		echo $torrent->getFileList($g['tid']);
	break;

	case 'uj_torrent':
		$tomb=array('uj_torrent'=>time());
		User:: update($USER['uid'],$tomb,'user_data');
	break;	

	case 'ingyen_no':
		$tomb=array('ingyen'=>'no');
		$torrent->update($g['tid'],$tomb);
		logs::sysLog( 'torrent_admin' , 'nem ingyen torrent', 'tid='. $g['tid']  );
	break;

	case 'ingyen_yes':
		$tomb=array('ingyen'=>'yes');
		$torrent->update($g['tid'],$tomb);
		logs::sysLog( 'torrent_admin' , 'ingyen torrent', 'tid='. $g['tid']  );
	break;

	case 'hidden_no':
		$tomb=array('hidden'=>'no');
		$torrent->update($g['tid'],$tomb);
		logs::sysLog( 'torrent_admin' , 'nem rejtett torrent', 'tid='. $g['tid']  );
	break;

	case 'hidden_yes':
		$tomb=array('hidden'=>'yes');
		$torrent->update($g['tid'],$tomb);
		logs::sysLog( 'torrent_admin' , 'rejtett torrent', 'tid='. $g['tid']  );
	break;
}

$old=new old(); //oldalelemek betöltése
// torrent adatainak módosítása
if(is_numeric($g['modosit']) && ($USER['rang'] >= TORRENET_ADMIN_MIN_RANG || $torrent->getTulaj($g['modosit'])==$USER['uid']) ){	
	$tomb=$torrent->fullLoad(array("t.tid='".$g['modosit']."'"),'','',0);
	$t=$tomb[0];
	$smarty->assign('name',$t['name']);
	$smarty->assign('tipusok',kategoria::getAll('kid,nev'));
	$smarty->assign('kategoria',$t['kid']);
	$smarty->assign('megj',$t['megjegyzes']);
	$smarty->assign('adminlink',true);
	$smarty->assign('tid',$g['modosit']);
	$smarty->assign('kep1',$t['kep1']);
	$smarty->assign('kep2',$t['kep2']);
	$smarty->assign('kep3',$t['kep3']);
	$smarty->display('letolt_admin.tpl');
}

if(!empty($p['tname']) && is_numeric($p['tid']) && ($USER['rang'] >= TORRENET_ADMIN_MIN_RANG || $torrent->getTulaj($p['tid'])==$USER['uid'] ) ){
	$torrent->update($p['tid'],array("name"=>$p['tname']),false);
	$torrent->update($p['tid'],array("megjegyzes"=>$p['megj']),false);
	$torrent->update($p['tid'],array("kid"=>$p['tcategory']),false);
	$torrent->update($p['tid'],array("kep1"=>$p['kep1']),false);
	$torrent->update($p['tid'],array("kep2"=>$p['kep2']),false);
	$torrent->update($p['tid'],array("kep3"=>$p['kep3']),false);	

	$f=$_FILES;
	$hiba=array();	

	if(!empty($f['tnfo']) && !empty($f['tnfo']["name"]) && !empty($f['tnfo']["tmp_name"])){
		$nfoName=$f['tnfo']["name"];
		$nfoTemp=$f['tnfo']["tmp_name"];

		if($f['tnfo']['type']!="application/octet-stream" && $f['tnfo']['type']!="application/x-nfo"){
			$hiba[]="Az nfo formátuma nem megfelelõ!";
		}

		if (!preg_match('/^(.+)\.nfo$/si', $nfoName, $nfomatches)){
			$hiba[]="Az nfo fájl kiterjesztése nem mgefelelõ!";
		}			

		if(count($hiba)>0){
			
			$OLDAL[]=hiba_uzi( implode('<br />',$hiba) );
			$smarty->display('letolt_admin.tpl');
		}
		else{
			Nfo::del($p['tid']);
			if(Nfo::add($nfoTemp,$nfoName,$p['tid'])){
				$torrent->update($rogzitett,array('nfo_name'=>'yes'),false);
			}
		}	
	}

	if(count($hiba)<1){
		$_SESSION['uzenet']=nyugta('A módosítás sikerült');
		header("Location:letolt.php");
		exit;
	}
}

//admin megjegyzés
if(is_numeric($g['komment']) && $USER['rang'] >= TORRENET_ADMIN_MIN_RANG ){	

	$tomb=$torrent->fullLoad(array("t.tid='".$g['komment']."'"),'','',0);
	$t=$tomb[0];
	$smarty->assign('name',$t['name']." - admin komment");
	$smarty->assign('admin_megj',$t['admin_megj']);
	$smarty->assign('adminlink2',true);
	$smarty->assign('tid',$g['komment']);
	$smarty->assign('OLDAL',$OLDAL);
	$smarty->display('letolt_admin.tpl');
}

if(!empty($p['admin_megj']) && is_numeric($p['tid']) && $USER['rang'] >= TORRENET_ADMIN_MIN_RANG ){
	$ok1=$torrent->update($p['tid'],array("admin_megj"=>$p['admin_megj']));
	$ok2=$torrent->update($p['tid'],array("admin_datum"=>date('Y-m-d H:i:s')));
	$ok3=$torrent->update($p['tid'],array("admin_id"=>$USER['uid']));

	if($ok1 && $ok2 && $ok3){
		$OLDAL[]=nyugta("Módosítás sikeres!");
	}
	else{
		$OLDAL[]=hiba_uzi("Módosítás sikertelen");
	}
	$smarty->assign('OLDAL',$OLDAL);
	$smarty->display('letolt_admin.tpl');
}
ob_end_flush ();
?>