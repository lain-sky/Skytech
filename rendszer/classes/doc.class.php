<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság 



class Doc extends baseModel {

	protected $table='cikk';
	protected $idName='cid';
	
	static function createCache(){
		$data=array();
		foreach( array('gyik','szab','link' ) as $item ){
		
			db::futat("select cid,cim,text,mod_date as datum,name from cikk c left join users u on c.mod_user=u.uid where mihez='%s' order by suly,cim",$item);
			$tomb=db::tomb();
			foreach($tomb as $key=>$val){
				$tomb[$key]['text']=bb::bbdecode($val['text']);
			}
			$data[ $item ] = $tomb;
		}
		return $data;	
	}




}//end class
?>