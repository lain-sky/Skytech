<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

//ez az osztály fele a lapozásért
class lapozo{
		private $cim;	// a hivatkozás címét tárolja
		public  $max;	//a maximum találatot tárolja
		private $inp;	//az egy oldalon lévõ megjelenítenivaló darabszáma
		private $page;	//a változó ami az oldalszámot adja
		private $valt;	//ez tárolja a lapozó változó nevét.
		private $maxLink=10; //ez az állítja be , hogy max hágy link jelenjen meg ezt min 3 ra kell állítani ill páratlan számra
		private $oldalDB=false;

	function __construct($cim,$inp=20,$valt='page'){
		
		if( !empty( $inp ) ){
			$inp = 20;
		}
		
		$this->inp=$inp;
		$this->valt=$valt;
		$this->cim=$this->cimTakarit($cim);
		if(!empty($_GET[$valt]) && is_numeric($_GET[$valt])) $this->page=$_GET[$valt];
		else $this->page=1;	
	}

	function szamsor(){
		$tomb=$this->oldalKorlatozas();
		$link='';
		foreach($tomb as $elem){
			if($elem==$this->page){
				$link.="<b>[". ($this->inp*($elem-1)+1).'-'.($this->inp*$elem) ."]</b>\n";
			}
			else{
				$link.="<a href='".$this->cim.$this->valt."=". $elem ."' >". ($this->inp*($elem-1)+1).'-'.($this->inp*$elem) ."</a>\n";
			}
		}
		return $link;	
	}

	function selectbe(){
		$tomb=$this->oldalDarabszam();
		$link='';
		foreach($tomb as $elem){
			if($elem==$this->page){
				$link.="<option value='".$this->cim.$this->valt."=". $elem ."' selected='selected'>[". ($this->inp*($elem-1)+1).'-'.($this->inp*$elem) ."]</option>\n";
			}
			else{
				$link.="<option value='".$this->cim.$this->valt."=". $elem ."' >". ($this->inp*($elem-1)+1).'-'.($this->inp*$elem) ."</option>\n";
			}
		}
		return $link;	
	}

	function betuvel(){
		$tomb=$this->oldalDarabszam();
		if($tomb[0]<=($this->page-1))
			$link['elozo']="<a href='".$this->cim."&amp;".$this->valt."=". ($this->page-1) ."' class='pic' >".'<img border="0" src="kinezet/'.$GLOBALS['USER']['smink'].'/mini_prev_enabled.png" alt="vissza" />'."</a>\n";
		else $link['elozo']='<img border="0" src="kinezet/'.$GLOBALS['USER']['smink'].'/mini_prev_disabled.png" alt="vissza" />';

		rsort($tomb);

		if($tomb[0]>=($this->page+1))
			$link['kovetkezo']="<a href='".$this->cim.$this->valt."=". ($this->page+1) ."' class='pic' >".'<img border="0" src="kinezet/'.$GLOBALS['USER']['smink'].'/mini_next_enabled.png" alt="tovabb" />'."</a>\n";
		else $link['kovetkezo']='<img border="0" src="kinezet/'.$GLOBALS['USER']['smink'].'/mini_next_disabled.png" alt="tovabb" />';

		return $link;
	}

	function oldalDarabszam(){
		$oldal=ceil($this->max/$this->inp);
		if($oldal == 0){
			$tomb=range(1,1);
		}
		else{
			$tomb=range(1,$oldal);
		}		
		return $tomb;
	}

	function oldalKorlatozas(){
		$tomb=$this->oldalDarabszam();
		$tomb2=$this->oldalDarabszam();
		rsort($tomb2);
		$maxLink=$this->maxLink;
		if(count($tomb)>$maxLink){
			$link[]=$this->page;
			$p1=$p2=1;
			for($i=1;$maxLink>=count($link); $i++){
				if(($i%2)==0){
					if($tomb[0]<=($link[0]-$p1)){
						$link[]=($link[0]-$p1);
						$p1++;
					}
				}
				else{
					if($tomb2[0]>=($link[0]+$p2)){
						$link[]=($link[0]+$p2);
						$p2++;
					}				
				}
				if($i==1000) break;
			}
			sort($link);
			return $link;
		}
		else{
			return $tomb;
		}	
	}

	function cimTakarit($cim){
		$mit=$this->valt."=";
		$cimreszlet=explode('?',$cim);
		if(count($cimreszlet)<2) return $cim.'?';
		$valtozok=explode('&',$cimreszlet[1]);
		foreach($valtozok as $k=>$v){
			if(strpos($v,$mit)!== false) unset($valtozok[$k]);
		}
		$modcim=$cimreszlet[0]."?". implode('&amp;',$valtozok);
		return $modcim . "&amp;";
	}

	function limitalo(){
		$limit1=($this->page-1) * $this->inp;
		$limit2=$this->inp;
		return $limit1.",".$limit2;

	}
}//end class
?>