<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

class Torrent{
	
	public $name; 	//torrent neve
	public $kid; 	//kategória id
	public $eredeti='n'; //eredeti e
	public $honlap;	//kapcsolódó url
	public $megjelen; //megjelenés dátuma
	public $megjegyzes; //megjegyzés a torrenthez
	public $kep1;		//torrenthez tartozó képek
	public $kep2;
	public $kep3;
	public $uid; 	//feltolto
	public $datum;	//feltoltes _datuma
	public $search_text;
	public $meret;
	public $fajl_db;
	public $fajlok;
	public $tempname;
	public $info_hash;
	public $nfo;
	public $nfo_temp;
	public $anonymous='no';
	public $keresId;

	function __construct(){
		$this->uid=$GLOBALS['USER']['uid'];
		$this->datum=date('Y-m-d H:i:s');
		$this->urang=$GLOBALS['USER']['rang'];
		$this->nfo='no';
	
	}

	function add(){
		$pari="insert into torrent(kid,uid,name,search_text,datum,fajl_db,meret,kep1,kep2,kep3,megjelen,megjegyzes,eredeti,info_hash,nfo_name,honlap,anonymous,keres_id) values".
								 "('%d','%d','%s','%s','%s','%d','%f','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d')";
		$ok=db::futat($pari
					,$this->kid
					,$this->uid
					,$this->name
					,$this->search_text
					,$this->datum
					,$this->fajl_db
					,$this->meret
					,$this->kep1
					,$this->kep2
					,$this->kep3
					,$this->megjelen					
					,$this->megjegyzes
					,$this->eredeti
					,md5($this->info_hash)
					,$this->nfo
					,$this->honlap
					,$this->anonymous
					,$this->keresId
					);
		if($ok){
			return $this->fajlRogzit(db::$id);
		}
		else{
			return false;
		}
	}
	
	function update($id,$tomb,$admin_jog=true){
		if($admin_jog){
			if($GLOBALS['USER']['rang']  < TORRENET_ADMIN_MIN_RANG) return false;
		}
		
		$mod=array();
		foreach($tomb as $key=>$val){
			$mod[]=$key."='".addslashes($val)."'";
		}
		if(count($mod)>0){
			$pari="update torrent set ".implode(',',$mod) ." where tid='%d'";
			$ok=db::futat($pari,$id);
			return $ok;
		}
		return false;
	}
	
	function fajlRogzit($tid){
		foreach($this->fajlok as $tomb){
			$pari="insert into torrent_files(tid,name,size) values('%d','%s','%f')";
			db::futat($pari,$tid,$tomb[0],$tomb[1]);
		}
		return $this->fajlMasol($tid);
	}
	
	function fajlMasol($tid){
		$fajl=$this->getTorrentFileName($tid);
		if (move_uploaded_file($this->tempname, $fajl)) {
			return $tid;
		}else return false;
	}
	
	
	function nfoMasol($tid){
		$fajl=$this->getNfoFileName($tid);
		if (move_uploaded_file($this->nfo_temp, $fajl)) {
			return true;
		}else return false;	
	}
	
	function getTrackerUrl(){
		$url=TORRENT_TRACKER ."?passkey=".$GLOBALS['USER']['tor_pass'];		
		return  $url;
	}
	
	function getTorrentById($id){
		db::futat("select * from torrent where tid='%d'",$id);
		if(db::$sorok<1) return false;
		$tomb=db::tomb();
		return $tomb[0];
	}
	
	function checkTorrentById($id){		
		db::futat("select count(*) as db from torrent where tid='%d'",$id);
		if(db::egy_ertek('db')!=1) return false;
		
		$fajl=$this->getTorrentFileName($id);
		if(@!is_file($fajl)) return false;
		if(@!is_readable($fajl)) return false;
		return true;
	}
	
	function checkTorrentByInfoHash($hash){
		db::futat("select count(*) as db from torrent where tid='%d'",$id);
		if(db::egy_ertek('db')!=1) return false;
	
	}
	
	function getTorrentFileName($id){
		$fajl=TORRENT_PATH . $id . ".torrent";
		return $fajl;
	}
	
	function getNfoFileName($id){
		$fajl=NFO_PATH . $id . ".nfo";
		return $fajl;
	}
	
	function getNfoTartalom($id){
		$fajl=$this->getNfoFileName($id);
		if(@!is_file($fajl)) return 'A NFO már nincs meg a szerveren!';
		$tomb=@file($fajl);
		$str=implode('<br />',$tomb);
		//$str=iconv("UTF-8",	"ISO-8859-2", ""); 
		return 	$str;
	}
	
	function getFileList($id){
		$sql="select name,size from torrent_files where tid='%d'";
		db::futat($sql,$id);
		$tt="<table style='width:916px;' class='skinned'><tr class='head'><td>Név</td><td>Kiterjesztés</td><td>Típus</td><td>Méret</td></tr>";
		foreach(db::tomb() as $key=>$val){
			$tt.="<tr class='flash'>\n<td class='left'style='width: 550px;'>".$val['name']."</td>";
			$kit=explode('.',$val['name']);
			$tt.="<td>".$kit[count($kit)-1]."</td>";
			$tt.="<td>".getfiletype($kit[count($kit)-1])."</td>";
			$tt.="<td>".bytes_to_string($val['size'])."</td>\n</tr>\n";
		}
		return $tt;
	}
	
	function setTorrentMegnez($id){
		db::futat("update torrent set megnezve=megnezve+1 where tid='%d'",$id);
	}
	
	function delTorrent($id){
		if($GLOBALS['USER']['rang']   < TORRENET_ADMIN_MIN_RANG ) return false;
		db::futat("delete from torrent where tid='%d'",$id);
		db::futat("delete from torrent_files where tid='%d'",$id);
		Nfo::del($id);
		@unlink($this->getTorrentFileName($id));
	}
	
	
	function fullLoad($where=array(),$order='',$limit='',$dekod=1){
		$sql="select SQL_CALC_FOUND_ROWS 
				t.tid,t.uid,t.name,t.nfo_name,t.datum,UNIX_TIMESTAMP(t.datum) as tdatum,t.meret,t.letoltve,t.seeders,t.leechers,t.megnezve,t.kid,
				t.kep1,t.kep2,t.kep3,t.megjelen,t.honlap,t.megjegyzes,t.eredeti,t.admin_megj,t.admin_datum,t.admin_id,t.hsz_lezarva,t.ingyen,t.hidden,t.anonymous,t.keres_id,t.keres_jovairva,
				(select count(*) from torrent_files where tid=t.tid)as fajldb,
				(select name from users u where u.uid=t.uid)as username,
				(select rang from users u where u.uid=t.uid)as rang,
				(select nev from kategoria k where k.kid=t.kid)as nev,
				(select leir from kategoria k where k.kid=t.kid)as leir,
				(select kep from kategoria k where k.kid=t.kid)as kep,
				(select name from users u where u.uid=t.admin_id)as adminname,
				(select count(*) from peers p where  p.tid=t.tid and seeder='yes' ) as seed,
				(select count(*) from peers p where  p.tid=t.tid and seeder='no' ) as leech,
				(select count(*) from torrent_hsz p where p.tid=t.tid ) as comment,
				(select count(*) from torrent_konyv p where p.tid=t.tid and p.uid='".$GLOBALS['USER']['uid']."' ) as konyv
				from torrent t ";
		
		$tomb=array();
		if($GLOBALS['USER']['rang'] >= TORRENET_ADMIN_MIN_RANG){
		
		}
		else{
			//$tomb[]="(uid=".$GLOBALS['USER']['uid']." or  (select count(*) from peers p where  p.tid=t.tid  ) > 0  )";
			$tomb[]=" t.hidden='no' ";
		}
		
		
		foreach($where as $val){
			$tomb[]=$val;
		}
		if(count($tomb)>0){
			$sql.=" where " . implode(' and ',$tomb);
		}
		if(!empty($order))
		$sql.=" order by " . $order;
		
		if(!empty($limit)){
			$sql.=" limit " . $limit;
		}
		
		db::futat($sql);
		$nagytomb=db::tomb();
		if($dekod!=1){
			return $nagytomb;
		}
		
		$kesz=array();
		foreach($nagytomb as $key=>$val){
						
					
			foreach($val as $k=>$v){				
				if($k=='megjegyzes' || $k=='admin_megj'){
					$kesz[$key][$k]=bb::bbdecode($v);
				}
				else{
					$kesz[$key][$k]=$v;
				}			
			}
			
			
			if($GLOBALS['USER']['uj_torrent'] < $val['tdatum']){
				$kesz[$key]['uj_torrent']=true;
			}
			else{
				$kesz[$key]['uj_torrent']=false;
			}

			if($GLOBALS['USER']['uid']==$val['uid']){
				$kesz[$key]['sajat_torrent']=true;
			}
			else{
				$kesz[$key]['sajat_torrent']=false;
			}
			
			if($val['anonymous']=='yes' && $GLOBALS['USER']['rang'] < TORRENET_ADMIN_MIN_RANG ){
				$kesz[$key]['uid']=4;
				$kesz[$key]['rang']=1;
				$kesz[$key]['username']='Anonymous';
			}
			
			
			
		}
		return $kesz;	
	}
	
	
	

	function torrentKoszi($tid){		
		$sql="insert into torrent_koszi(tid,uid) values('%d','%d')";
		db::futat($sql,$tid,$this->uid);
		return $this->torrentKosziLista($tid);
	}
	
	
	function torrentKosziLista($tid){
		$sql="select u.rang,u.uid,u.name from torrent_koszi t left join users u on t.uid=u.uid where t.tid='%d'";
		db::futat($sql,$tid);
		$tomb=db::tomb();
		
		$kesz=array();
		foreach($tomb as $val){
			$kesz[]="<a href='userinfo.php?uid=".$val['uid']."'><span class='rank".$val['rang']."' >".$val['name']."</span></a>";
		}
		return implode(',',$kesz).$this->torrentKosziCheck($tid);;
	}
	
	function torrentKosziCheck($tid){
		$uid=$GLOBALS['USER']['uid'];
		$sql="select * from torrent_koszi where uid='%d' and tid='%d'";
		db::futat($sql,$uid,$tid);
		
		if(db::$sorok<1){
			return '<a href="'.$tid.'" class="torrent_koszi">&nbsp;&nbsp;Köszönöm!</a>';
		}
		else return ;
	}
	
	
	 
	 function getTulaj($tid){
		db::futat("select uid from torrent where tid='%d'",$tid);
		return db::egy_ertek('uid');
	 }
	 
	 
	 function isUnique( $infoHash ){
		$sql="select count(*) as db from torrent where info_hash='%s' ";
		db::futat($sql,$infoHash);
		
		if( db::egy_ertek('db') == 0){
			return true;
		}
		else{
			return false;
		}
	 }
	 
	 
	function getNameById($id){
		db::futat("select name from torrent where tid='%d'",$id);
		$name=db::egy_ertek('name');
		if(!empty($name)){
			return $name;
		}
		else return false;	
	}



}//end class
?>