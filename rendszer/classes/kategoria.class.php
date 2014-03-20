<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

class kategoria{
	  
	private function __construct(){}
	


	function getAll($text='*'){
		$sql="select ".$text." from kategoria order by kid";
		db::futat($sql);
		$tomb=db::tomb();
		return $tomb;
	}
	
	function getToLista( $file='letolt.php' ){
		$tomb=self::getAll();
		$i=1;
		$keszek[0].='<li><a href="'.$file.'?mind=mind" title="Az összes kategória">Mindent!</a></li>';
		foreach($tomb as $elem){
			$keszek[$i].='<li><a href="'.$file.'?tipus='.$elem['kid'].'" title="'.$elem['leir'].'">'.$elem['nev'].'</a></li>';
			$i=($i<5)? $i+1 : 0;
		}
		return $keszek;
	}
	
	function getForOption($text='*'){
		$tomb=self::getAll($text);
		$kesz=array();
		foreach($tomb as $key=>$val){
			$kesz[]=array('value'=>$val['kid'],'text'=>$val['nev']);
		}
		return $kesz;
	}

	




}//end class
?>