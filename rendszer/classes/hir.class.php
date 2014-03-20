<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság 



class Hir extends baseModel {

	protected $table='hirek';
	protected $idName='hid';
	
	public static function createCache(){
		
		db::futat("select hid as id,cim,text,datum,disp from hirek order by datum desc");
		$hirek=db::tomb();

		foreach($hirek as $key=>$val){
			$hirek[$key]['text']=bb::bbdecode($val['text']);
		}
		
		return $hirek;
	}




}//end class
?>