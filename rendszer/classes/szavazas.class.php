<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság 



class Szavazas extends baseModel {

	protected $table='szavazas';
	protected $idName='szid';
	
	
	function getAll(){
		global $old;
		
		$szavazasok=array();
		$sql="select szid,cim,datum from szavazas order by szid desc " ;
		
		foreach( db::getAll($sql) as $i=>$elem ){
			
			$szavazasok[$i]['id']=$elem['szid'];
			$szavazasok[$i]['cim']=$elem['cim'];
			$szavazasok[$i]['datum']=$elem['datum'];
			$szavazasok[$i]['text']=self::getDataById( $elem['szid'] );
		}
		return $szavazasok;
	}
	
	static function getDataById( $mit ){
		db::futat("select text,count(sza.uid) as db from szavazas_elem sze left join szavazatok sza on sze.sze_id=sza.sze_id where sze.szid='%d'  group by sze.sze_id order by sze.sze_id ",$mit);
		$tomb=db::tomb();
		
		$sql="select count(*) as ez from szavazatok where szid='%d'";
		db::futat($sql,$mit);
		$osszes=db::egy_ertek();
		
		
		//tartalom összeállítása
		$tt="\n";
		foreach($tomb as $elem){
			$arany=($elem['db']==0)? 0:($elem['db']/$osszes);
			$tt.='<div class="bar_rect">'."\n";
			$tt.='<div class="option_text">'.$elem['text'].'</div>';
			$tt.='<div class="option_bar" style="width:'.round(($arany*420)+4).'px;"></div>';
			$tt.='<div class="option_votes">&nbsp;'.$elem['db'].' szav. ('.round(($arany*100),1).'%)</div>';
			$tt.='</div>';		
		}
		$tt.='<br><p>Összesen <span class="highlight">'.$osszes.'</span> szavazat érkezett ';
		return $tt;	
		
		
	}



}//end class
?>