<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság
class Vars{	private function  __construct(){}
	
	function get($name){
		db::futat("select value from vars where var='%s'",$name);
		return db::egy_ertek('value');	
	}
	
	function getByType($type=null){
		if($type!== null){
			$sql="select * from vars where tipus='". $type ."' order by sorrend";
		}
		else{
			$sql="select * from vars ";		
		}				
		db::futat($sql);
		$kesz=array();
		foreach(db::tomb() as $val){
			$kesz[$val['var']]=$val;
		}		
		return $kesz;	
	}
	
	function getByTypeMod($type='oldal'){
		$tomb=Vars::getByType($type);
		foreach($tomb as $key => $val){
			switch($key){
				case 'oldal_admin_password':
					$tomb[$key]['value']='titok :)';
				break;
				
				case 'korlatozas_rang':
					$tomb[$key]['value']=$GLOBALS['RANGOK'][$val['value']];
				break;

				case 'adat_korlatozas':
					$tomb[$key]['value']=($val['value']=='yes')? 'Bekapcsolva':'Kikapcsolva';
				break;

				case 'slot_korlatozas':
					$tomb[$key]['value']=($val['value']=='yes')? 'Bekapcsolva':'Kikapcsolva';
				break;

				case 'tracker':
					$tomb[$key]['value']=($val['value']=='yes')? 'Bekapcsolva':'Kikapcsolva';
				break;			
			}
		}
		return $tomb;	
	}
	
	function update($var,$value){
		switch($var){
			case 'oldal_admin_password':
				$valueMod=md5($value);
			break;
			
			default:
				$valueMod=$value;
			break;
		}
		db::futat("update vars set value='%s' where var='%s' ",$valueMod,$var);	
	}
}?>