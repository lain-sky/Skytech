<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{

	
	case 'oldal_stats':
		$smarty->assign('modulnev','Oldal statisztika');
		$smarty->assign('modul','oldal_stats');			

		$where=Stats::makeWhere($p['ig'],$p['tol']);
		
		switch($p['bontas']){
			case 'havi':
				$ido='(hónap)';
				$bontas="substr( datum , 6, 2)";
			break;
			case 'napi':
				$ido='(nap)';
				$bontas=" substr(datum,3,8)";
			break;
			default :
				$ido='(hét)';
				$bontas="week(datum)";
			break;
		}
		
		$smarty->assign('ido',$ido);
		$smarty->assign('tol',$p['tol']);
		$smarty->assign('ig',$p['ig']);

		//osszes oldal kukucs
		$sql="select count(*) as num, ".$bontas."  as ido from logs_user ".$where." group by  ido order by ido desc";
		db::futat($sql);
		$smarty->assign("osszes_oldal",db::tomb());		

		//osszes latogato
		$sql="select count(distinct(uid)) as num, ".$bontas."  as ido from logs_user ".$where."  group by  ido order by ido desc";
		db::futat($sql);
		$smarty->assign("osszes_latogato",db::tomb());
		
		//oldal látogatások
		$sql="select count(fajl) as num, fajl from logs_user ".$where." group by fajl order by num desc";
		db::futat($sql);
		$smarty->assign("osszes_fajl",db::tomb());

		//bongészõk
		$sql="select count(bongeszo) as num,concat_ws(' ',bongeszo,bongeszo_ver) as bong,bongeszo,bongeszo_ver from logs_user ".$where." group by bong order by num desc";
		db::futat($sql);
		foreach(db::tomb() as $key=>$val){
			$osszes_bongeszok[]=array("nev"=>$BONGESZO_TIPUSOK[$val['bongeszo']] ." ".$val['bongeszo_ver'],"ert"=>$val['num']);
		}
		$smarty->assign("osszes_bongeszok",$osszes_bongeszok);

		//os
		$sql="select count(os) as num, os from logs_user ".$where." group by os order by num desc";
		db::futat($sql);
		foreach(db::tomb() as $key=>$val){
			$osszes_os[]=array("nev"=>$OS_TIPUSOK[$val['os']],"ert"=>$val['num']);
		}
		$smarty->assign("osszes_os",$osszes_os);
	break;

	
	
	
	
	
	
	
	
	
	
	
	

	case 'user_stats':
		$smarty->assign('modulnev','User statisztika');
		$smarty->assign('modul','user_stats');		

		$where=Stats::makeWhere($p['ig'],$p['tol']);

		switch($p['bontas']){
			case 'havi':
				$ido='(hónap)';
				$bontas="substr( datum , 6, 2)";
				$bontas2="substr( from_unixtime(reg_date) , 6, 2)";
			break;
			case 'napi':
				$ido='(nap)';
				$bontas=" substr(datum,3,8)";
				$bontas2=" substr(from_unixtime(reg_date),3,8)";	
			break;
			default :
				$ido='(hét)';
				$bontas="week(datum)";
				$bontas2="week(from_unixtime(reg_date)) ";
			break;
		}

		$smarty->assign('ido',$ido);
		$smarty->assign('tol',$p['tol']);
		$smarty->assign('ig',$p['ig']);		

		//regisztrált tagok száma
		$sql="select count(*) as num,".$bontas2." as ido from users ".$where." group by ido";
		db::futat($sql);
		$smarty->assign("regek",db::tomb());

		//meghívások szama
		$sql="select count(*) as num,".$bontas." as ido from meghivo ".$where." group by ido";
		db::futat($sql);
		$smarty->assign("meghivok",db::tomb());

		//meghivokból való reg
		$sql="select count(*) as num,".$bontas." as ido from meghivo ".(!empty($where)? " meghivott is not null " : " where meghivott is not null ")." group by ido";
		db::futat($sql);
		$smarty->assign("meghivo_reg",db::tomb());

		
		//rangok eloszlasa
		$sql="select count(rang) as num, rang from users ".$where." group by rang order by num desc";
		db::futat($sql);
		foreach(db::tomb() as $key=>$val){
			$tomb[]=array("nev"=>$RANGOK[$val['rang']],"ert"=>$val['num']);
		}
		$smarty->assign("rangok",$tomb);
	break;	
	
	
	
	
	
	
	
	
	
	

	case 'tracker_stats':
		$smarty->assign('modulnev','Tracker statisztika');
		$smarty->assign('modul','tracker_stats');		

		$where=Stats::makeWhere($p['ig'],$p['tol']);
		switch($p['bontas']){

			case 'havi':
				$ido='(hónap)';
				$bontas="substr( datum , 6, 2)";
			break;
			case 'napi':
				$ido='(nap)';
				$bontas=" substr(datum,3,8)";		
			break;
			default :
				$ido='(hét)';
				$bontas="week(datum)";
			break;
		}

		$smarty->assign('ido',$ido);
		$smarty->assign('tol',$p['tol']);
		$smarty->assign('ig',$p['ig']);		

		//feltoltesek
		$sql="select sum(fel) as num,".$bontas." as ido from logs_torrent ".$where." group by ido";
		db::futat($sql);
		$smarty->assign("feltoltes",db::tomb());

		//letoltes
		$sql="select sum(le) as num,".$bontas." as ido from logs_torrent ".$where." group by ido";
		db::futat($sql);
		$smarty->assign("letoltes",db::tomb());

		//eltérés
		$sql="select abs( sum(le)-sum(fel) ) as num,".$bontas." as ido from logs_torrent ".$where." group by ido";
		db::futat($sql);
		$smarty->assign("elteres",db::tomb());

		//feltotés-kategoria
		$sql="select sum(l.fel) as num, (select k.nev from kategoria k where k.kid=(select t.kid from torrent t where t.tid=l.tid)) as ido from logs_torrent l ".$where." group by ido  order by num desc";
		db::futat($sql);
		$smarty->assign("feltoltes_kat",db::tomb());

		//letoltes-kategoria
		$sql="select sum(l.le) as num, (select k.nev from kategoria k where k.kid=(select t.kid from torrent t where t.tid=l.tid)) as ido from logs_torrent l ".$where." group by ido  order by num desc";
		db::futat($sql);
		$smarty->assign("letoltes_kat",db::tomb());

		//eltérés-kategoria
		$sql="select abs( sum(l.fel)-sum(l.le) )as num, (select k.nev from kategoria k where k.kid=(select t.kid from torrent t where t.tid=l.tid)) as ido from logs_torrent l ".$where." group by ido  order by num desc";
		db::futat($sql);
		$smarty->assign("elteres_kat",db::tomb());
	break;	
	
	
	
	
	
	
	
	case 'cron_stats':
		$smarty->assign('modulnev','Cron statisztika');
		$smarty->assign('modul','cron_stats');	
		
		$where=Stats::makeWhere($p['ig'],$p['tol']);
		switch($p['bontas']){

			case 'havi':
				$ido='(hónap)';
				$bontas="substr( datum , 6, 2)";
			break;
			case 'napi':
				$ido='(nap)';
				$bontas=" substr(datum,3,8)";		
			break;
			default :
				$ido='(hét)';
				$bontas="week(datum)";
			break;
		}

		$smarty->assign('ido',$ido);
		$smarty->assign('tol',$p['tol']);
		$smarty->assign('ig',$p['ig']);		

		
		$cr=array(
			array('nev'=>'rang','id'=>1),
			array('nev'=>'peers','id'=>2),
			array('nev'=>'chat','id'=>3),
			array('nev'=>'logs','id'=>4),
			array('nev'=>'reg','id'=>5),
			array('nev'=>'warn','id'=>6),
		);
		
		foreach( $cr as $val){
			$sql="select sum(sor) as num,count(*) as db ,".$bontas." as ido from logs_cron where type='%d' group by ido";
			db::futat($sql,$val['id']);
			$smarty->assign($val['nev'],db::tomb());
		}
			
		
	break;
	
	
	
	
	
	
	
	
	
	
	case 'cheat_stats':
		$smarty->assign('modul','cheat_stats');	
		$smarty->assign('modulnev','Cheat');	
		
		$where=" where  torrent is not null ";
		if( empty($_POST['datumtol'])){
			$_POST['datumtol']=date('Y-m-d');
		}
		
		if( !empty( $_POST['datumtol'] ) && !empty( $_POST['datumig'] )){
			$where.=" and date between '" .$_POST['datumtol']. "' and '".$_POST['datumig']."'";
		}
		elseif( !empty( $_POST['datumtol'] ) ){
			$where.=" and date >= '" .$_POST['datumtol']. "'";
		}
		
		
		$smarty->assign('datumtol',$_POST['datumtol']);
		$smarty->assign('datumig',$_POST['datumig']);
		
		
		$sql="select * from cheat_files " . $where . " order by kulonbseg desc limit 100";
				
/*
		$sql="		
SELECT 
l.tid,
( select t.name from torrent t where t.tid=l.tid ) as torrent, 
(select k.kep from kategoria k where k.kid= (select t2.kid from torrent t2 where t2.tid=l.tid) ) as kep,
substring(l.datum , 1,10) as date,
sum(l.fel) as feltolt,
sum(l.le) as letolt,
( sum(l.fel) - sum(l.le)  ) as kulonbseg
 FROM `logs_torrent` l
group by l.tid  order by kulonbseg desc 
";
	*/	
		
		
		
		db::futat($sql);
		$cheatFiles=db::tomb();
		$smarty->assign('cheatFiles', $cheatFiles );
		
		$cheatFilesIds=array();
		foreach($cheatFiles as $item) $cheatFilesIds[]=$item['tid'] ;
		
		if(count($cheatFilesIds)>=1){
		
			$sql="
				SELECT l.uid, (select name from users u where u.uid=l.uid) as username,
				sum(feltolt) as felt,sum(letolt) as let,count(*) as db 
				FROM peerszum l WHERE l.tid in( ". implode(',',$cheatFilesIds) .") 
				group by l.uid order by db desc limit 100
			";
			db::futat($sql);
			$cheatUsers=db::tomb();
			$smarty->assign('cheatUsers',$cheatUsers);	
		}
		
	break;
	
	
	
	
	
	
	
	case 'cheat_stats_reszletes':
		
		$smarty->assign('modul','cheat_stats_reszletes');
		$torrentId=$_POST['tid'];
		//$datumTol=$_POST['datumtol'];
		//$datumIg=$_POST['datumig'];
		
		$where="tid='".$torrentId."'";
		
		if( !empty( $datumTol ) && !empty( $datumIg )){
			$where.=" date between '" .$datumTol. "' and '".$datumIg."'";
		}
		elseif( !empty( $datumTol ) ){
			$where.="  date >= '" .$datumTol. "'";
		}
		
		
		
		
		$sql="
			SELECT 
			(select name from users u where u.uid=l.uid)as username,
			sum(fel) as feltolt,
			sum(le) as letolt,
			l.ip as kliens_ip,
			(select u2.ip from users u2 where u2.uid=l.uid) as user_ip,
			l.uid 

			FROM logs_torrent l WHERE ".$where." group by l.uid,l.ip
		";
		
		db::futat($sql);
		$smarty->assign('torrentId',$torrentId);
		$smarty->assign( 'data',db::tomb() );
		echo $smarty->fetch('skytech.tpl');
		die( );
		
		
	break;
	
	case 'cheat_user':
		$smarty->assign('modul','cheat_user');	
		$smarty->assign('modulnev','Cheat Users');
		
		$torrentId=$_REQUEST['tid'];
		$userId=$_REQUEST['uid'];
		$datumTol=$_REQUEST['datumtol'];
		$datumIg=$_REQUEST['datumig'];
		
		$smarty->assign('datumtol',$datumTol);
		$smarty->assign('datumig',$datumIg);
		$smarty->assign('uid',$userId);
		$smarty->assign('tid',$torrentId);
		
		
		
		if( !empty($torrentId) && !empty($userId) ){
		
			$smarty->assign('userName', User::getNameById( $userId ) );
			$smarty->assign('torrentName', Torrent::getNameById( $torrentId ) );
			
			
			
			$where=" tid='".$torrentId."' and uid='".$userId."'";
			
			if( !empty( $datumTol ) && !empty( $datumIg )){
				$where.=" and date between '" .$datumTol. "' and '".$datumIg."'";
			}
			elseif( !empty( $datumTol ) ){
				$where.="and  date >= '" .$datumTol. "'";
			}
			
			$sql="select * from cheat_users where " . $where;
			/*
			$sql="select
l.tid,
l.uid,
l.fel,
round( ( l.fel / ( select value from vars where var='tracker_auto_refresh')) ) as felseb,
l.le,
round( ( l.le / ( select value from vars where var='tracker_auto_refresh')) ) as leseb,
l.ip,
l.datum,
substring(l.datum , 1,10 ) as date
from logs_torrent l  where " . $where;
			*/
			//d($sql);
			db::futat($sql);
			$smarty->assign('data', db::tomb() );
			
		}
		
	break;
	
	
	
	
	
	
	
	
	
	
	

	case 'user_kovetes':
		$smarty->assign('modul','user_kovetes');	
		$smarty->assign('modulnev','User Követés');
		
		$userId=$_POST['uid'];
		$datumTol=$_POST['datumtol'];
		$datumIg=$_POST['datumig'];
		
		
		$smarty->assign('datumtol',$datumTol);
		$smarty->assign('datumig',$datumIg);
		$smarty->assign('uid',$userId);
		
		if( !empty($userId) && $userId != 1 ){
		
			$smarty->assign('userName', User::getNameById( $userId ) );
			
			$where="  uid='".$userId."'";
			
			if( !empty( $datumTol ) && !empty( $datumIg )){
				$where.=" and datum between '" .$datumTol. "' and '".$datumIg."'";
			}
			elseif( !empty( $datumTol ) ){
				$where.="and  datum >= '" .$datumTol. "'";
			}
			
			$sql="select * from logs_user where " . $where ." order by lid";
			db::futat($sql);
			$kesz=array();
			
			foreach(db::tomb() as $i=>$row ){
				foreach( $row as $key=>$val ){
					switch($key){
						
						case 'os':
							$kesz[$i][$key]=$OS_TIPUSOK[$val];
						break;
						
						case 'bongeszo':
							$kesz[$i][$key]=$BONGESZO_TIPUSOK[$val];
						break;
						
						default:
							$kesz[$i][$key]=$val;
						break;
					
					}
				
				}
			}
			
			
			$smarty->assign('data', $kesz );
		}
		
	break;
	
	
	
	
	
	
	
	
	case 'uzenofal':
		$smarty->assign('modul','uzenofal');	
		$smarty->assign('modulnev','Üzenõfal');	
		
		$data=array();
		db::futat("select cim,text,cid from cikk where mihez='uzifal'");
		foreach( db::tomb() as $i=>$row){
			
			foreach($row as $key=>$val){
				$data[$i][$key]=($key=='text')? bb::bbdecode($val) : $val ;
			}
		
		}
		$smarty->assign('data',$data);		
	break;
	
}
?>