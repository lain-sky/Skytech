<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

class hitnrun{

	function __construct(){
		$this->uid=$GLOBALS['USER']['uid'];
		$this->datum=date('Y-m-d H:i:s');
	
	}

	function add($tid, $down) {
		$pari="insert into hitnrun(uid,tid,kezdes,frissitve,status,letoltve) values".
								"('%d','%d','%s','%s','%d','%f')";
		db::futat($pari,$this->uid,$tid,$this->datum,$this->datum,1,$down);
	}

	function update($id,$stat,$up,$down,$req){
		$pari="update hitnrun set frissitve='%s',status='%d',feltoltve='%f',letoltve='%f',hatravan='%d' where hid='%d'";
		return db::futat($pari,$this->datum,$stat,$up,$down,$req,$id);
	}

	function getegy($uid,$tid) {
		$pari="select hid,status,feltoltve,letoltve,hatravan from hitnrun where uid='%d' and tid='%d'";
		db::futat($pari,$uid,$tid);
		if(db::$sorok == 0)
			return false;
		else
			return db::tomb();
	}

	function getall() {
		$pari="select h.hid,h.tid,h.kezdes,h.frissitve,h.status,h.feltoltve,h.letoltve,h.hatravan,t.name from hitnrun h left join torrent t on h.tid=t.tid where h.uid='%d'";
		db::futat($pari,$this->uid);
		return db::tomb();
	}

	function getReq() {
		$pari="select h.hid,h.tid,h.kezdes,h.frissitve,h.status,h.feltoltve,h.letoltve,h.hatravan,t.name from hitnrun h left join torrent t on h.tid=t.tid where h.uid='%d' and h.hatravan>0";
		db::futat($pari,$this->uid);
		return db::tomb();
	}	
}//end class
?>