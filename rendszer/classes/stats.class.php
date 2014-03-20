<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság


class Stats{
	




function torrent($order,$limit=10){
		$sql="select t.tid,t.name,t.letoltve,
		(select sum(letolt+feltolt) from peerszum psz where psz.tid=t.tid) as adat,
		(select count(*) from peers ps where ps.seeder='yes' and ps.tid=t.tid) as seed,
		(select count(*) from peers pl where pl.seeder='no'  and pl.tid=t.tid) as leech,
		(select count(*) from peers psl where  psl.tid=t.tid) as total,
		(select sum( pts.downloaded/(UNIX_TIMESTAMP(pts.last_action)-UNIX_TIMESTAMP(pts.started)))  from peers pts where pts.tid=tid) as seb
		from torrent t ";	
		
		$sql.= " order by ".$order;
		$sql.="  limit ".$limit;
		
		db::futat($sql);
		$tomb=db::tomb();
		$kesz=array();
		foreach($tomb as $key=>$val){
			//$kesz[$key]['tid']=$val['tid'];
			$kesz[$key]['name']="<a href='adatlap.php?id=".$val['tid']."'>".$val['name']."</a>";
			$kesz[$key]['letoltve']=number_format($val['letoltve']);
			$kesz[$key]['adat']=bytes_to_string($val['adat']);
			$kesz[$key]['seed']=number_format($val['seed']);
			$kesz[$key]['leech']=number_format($val['leech']);
			$kesz[$key]['total']=number_format($val['total']);
			$kesz[$key]['ratio']=( !empty($val['seed']) && !empty($val['leech']) )? round($val['seed'] / $val['leech'],3) : 0;
			$kesz[$key]['seb']=bytes_to_string($val['seb']).'/s';
		}
		return Stats::rowMake($kesz);	
	}
	
	function user($order,$limit=10){
		$sql="select u.uid,u.name,u.feltolt,u.letolt,u.reg_date,round((u.feltolt/u.letolt),3) as arany,
			(select sum( pts.downloaded/(UNIX_TIMESTAMP(pts.last_action)-UNIX_TIMESTAMP(pts.started)))  from peers pts where pts.uid=u.uid) as leseb,
			(select sum( pt.uploaded/(UNIX_TIMESTAMP(pt.last_action)-UNIX_TIMESTAMP(pt.started)))  from peers pt where pt.uid=u.uid) as felseb
			from users u";	
		
		$sql.= " order by ".$order;
		$sql.="  limit ".$limit;
		
		db::futat($sql);
		$tomb=db::tomb();
		$kesz=array();
		foreach($tomb as $key=>$val){
			//$kesz[$key]['tid']=$val['tid'];
			$kesz[$key]['name']="<a href='userinfo.php?uid=".$val['uid']."'>".$val['name']."</a>";
			$kesz[$key]['feltolt']=bytes_to_string($val['feltolt']);
			$kesz[$key]['feltoltseb']=bytes_to_string($val['felseb'])."/s";
			$kesz[$key]['letolt']=bytes_to_string($val['letolt']);
			$kesz[$key]['leseb']=bytes_to_string($val['leseb'])."/s";
			$kesz[$key]['arany']=$val['arany'];
			$kesz[$key]['csat']=date('Y-m-d H:i:s',$val['reg_date'])."&nbsp;(".time_to_string($val['reg_date']).")";
			
		}
		return Stats::rowMake($kesz);	
	}
	
	
	
	
	function rowMake($tomb){
		$kesz=array();
		
		foreach($tomb as $key=>$val){
			$kesz[]="<td>&nbsp;&nbsp;".implode('</td><td>&nbsp;&nbsp;',$val)."</td>";
		}
		return $kesz;	
	}
	
	
	function makeWhere($ig=null,$tol=null){
		if(!empty($ig) && !empty($tol)){
			$where[]="datum Between '".$tol."' and'".$ig."'";
		}
		elseif(!empty($ig)){
			$where[]="datum < '".$ig."'";
		}
		elseif(!empty($tol)){
			$where[]="datum > '".$tol."'";
		}
		else{
			return '' ;
		}
		if(count($where)!=1) return;
		$kesz=' where  ' . implode(' and ',$where);
		return $kesz;	
	}
	
	
	
	static function indexStats(){
		// összes felhasználó
		db::futat("select count(*) as db from users where statusz in('aktiv','passziv')");
		$tomb=db::tomb();
		$stat['user_db']=$tomb[0]['db'];


		// tag szám
		db::futat("select count(*) as db from users where rang='4'");
		$tomb1=db::tomb();
		$stat['user_tag']=$tomb1[0]['db'];

		//osszes letöltés
		db::futat("SELECT sum(letolt) as ossz FROM peerszum");
		$tomb2=db::tomb();
		$stat['ossz']=$tomb2[0]['ossz'];


		db::futat("select sum(letolt) as ossz from users");
		$tomb3=db::tomb();
		$stat['no_ingyen']=$tomb3[0]['ossz'];

		$stat['ingyen']=$stat['ossz'] - $stat['no_ingyen'];

		//torrent
		db::futat("select count(*) as ez from torrent");
		$stat['torrent']=db::egy_ertek();

		//peerek
		db::futat("select count(*) as ez from peers");
		$stat['peers']=db::egy_ertek();

		//seeder
		db::futat("select count(*) as ez from peers where seeder='yes'");
		$stat['seeder']=db::egy_ertek();

		//Leecher
		$stat['leecher']=$stat['peers']-$stat['seeder'];

		//Seed/Leech
		$stat['arany']=@round( (($stat['seeder']/$stat['leecher'])*100) ,2);

		//letolt seb
		db::futat("select round(sum(downloaded/(UNIX_TIMESTAMP(last_action)-UNIX_TIMESTAMP(started))))as ez from peers where seeder='no'");
		$stat['sebesseg']=db::egy_ertek() * 10;
		
		return $stat;	
	}
	
	static function aktivUsers(){
		db::futat("select uid,name,rang from users where (vizit + 1200)>'%d' and uid not in(1) order by name",time());
		return db::tomb();
	}
	
	
	
	
	
}//end class
?>