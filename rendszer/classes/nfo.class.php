<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

class Nfo{

	private function  __construct(){}
	
	function add($fajl,$name,$id){
		$tomb=@file($fajl);
		if(count($tomb)<1) return false;
		
		$sql="insert into nfo(nid,name,nfo) values('%d','%s','%s')";
		if(db::futat($sql,$id,$name,implode('',$tomb) ) ){
			return true;
		}else return false;
	}
	
	function del($id){
		db::futat("delete from nfo where nid='%d'",$id);
	}
	
	function getAll($id){
		db::futat("select nid,name,nfo from nfo where nid='%d'",$id);
		$t=db::elso_sor();
		return array('name'=>$t['name'],'nfo'=>$t['nfo']);
	}
	
	function check($id){
		if(!is_numeric($id)) return false;
		db::futat("select count(*) from nfo where nid='%d'",$id);
		if(db::$sorok!=1) return false;
		return true;
	}
}
?>