<?php
// az oldal egyes lemeit jeleníti meg és állítja be a smartynak

class old{
	private $hol="_top"; //ahol a linkek megnyilnak
  
	function __construct(){
		call_user_func(array($this,'menu'));
		call_user_func(array($this,'infopanel'));
		call_user_func(array($this,'sectionCookies'));
		
	}


	function menu(){
		$menu_kesz='<ul style="float:left;">';
		foreach($GLOBALS["MENU_bal"] as $elem){
			$menu_kesz.='<li><a href="'.$elem['cim'].'" target="'.$this->hol.'">'.$elem['olvas'].'</a></li>';
		}
		$menu_kesz.='</ul>';
		$menu_kesz.='<ul style="float:right;padding-right:20px;">';
		foreach($GLOBALS["MENU_job"] as $elem){
			$menu_kesz.='<li><a href="'.$elem['cim'].'" target="'.$this->hol.'">'.$elem['olvas'].'</a></li>';
		}
		$menu_kesz.='</ul>';

		$GLOBALS['smarty']->assign('menu_kesz',$menu_kesz);
		
		
		
		//a kek menut készíti
		$menu_kek="<ul>";
		foreach($GLOBALS["MENU_bal"] as $elem){
			$menu_kek.='<li ><a class="'.$elem['class'].'" href="'.$elem['cim'].'" target="'.$this->hol.'">'.$elem['olvas'].'</a></li>';
		}
		$menu_kek.='<li class="nav_space"></li>';
		foreach($GLOBALS["MENU_job"] as $elem){
			$menu_kek.='<li ><a class="'.$elem['class'].'" href="'.$elem['cim'].'" target="'.$this->hol.'">'.$elem['olvas'].'</a></li>';
		}
		$menu_kek.='</ul>';

		$GLOBALS['smarty']->assign('menu_kek',$menu_kek);
	}

	// infopanel étrehozása
	function infopanel(){
		$ipanel=$GLOBALS['USER'];

		// a letöltési csík számolása
		$csik_hossz='304';
		$letolt_csik=($ipanel['letolt']>0)? round(($ipanel['letolt']/($ipanel['letolt']+$ipanel['feltolt']))*$csik_hossz) : $csik_hossz/2;
		$feltolt_csik=$csik_hossz-$letolt_csik;
		$ipanel['feltolt_csik']=$feltolt_csik;
		$ipanel['letolt_csik']=$letolt_csik;
		//unset( $_SESSION['CACHE']['konyvjelzo']);
		$ipanel['konyvjelzok']=KonyvJelzo::getKonyvLista();
		
		$ipanel['display']= ( $_COOKIE[ constant('INFOPANEL_COOKIE')  ] == 'none' )? 'none' : 'block';
		$GLOBALS['USER']['pont'] = $GLOBALS['USER']['pontok'];
		$ipanel['pont'] = intval($GLOBALS['USER']['pont']);
		$hol=explode('/',$_SERVER['SCRIPT_NAME']);
		$hol=end($hol);

		//van e uj szavazás
		if( $hol != 'index.php' ){
			$sql="select count(*)as ez  from szavazatok where uid='%d' and szid=(select szid from szavazas order by szid desc limit 1)";
			db::futat($sql,$ipanel['uid']);
			$ipanel['uj_szavazas']=(db::egy_ertek()!=1)? true : false ; 
		}
		else  $ipanel['uj_szavazas']=false;

		//van-e uj uzim?
		if($hol!='levelezes.php'){
			$sql="select count(*) as ez from levelek where tulaj='%d' and status='u'";
			db::futat($sql,$ipanel['uid']);
			$ujL=db::egy_ertek();
			if($ujL>=1){
				$ipanel['uj_level']=true;
				$ipanel['level_text']=$ujL." db új levél";
			}
			else{
				$ipanel['uj_level']=false;
				$ipanel['level_text']='Nincs új leveled!';
			}
		}
		else  $ipanel['uj_level']=false;
		
		$GLOBALS['smarty']->assign('ipanel',$ipanel);
	}


	// egy secition léterhozása 
	function section($tomb){
		$tt=call_user_func('section_open',$tomb['cim']);
		$tt.=$tomb['tt'];
		$tt.=call_user_func('section_end');		
		$GLOBALS['OLDAL'][]=$tt;		
	}

	// az user még nem szavazot és a szavazóformot állítja elõ.
	function szavazhat($mit){
		db::futat("select text, sze_id as id from szavazas_elem where szid='%d' order by id",$mit);
		$tomb=db::tomb();

		$tt='<form action="index.php" method="post" >';
		$tt.="\n<div class=\"vote\">";
		$i=1;
		foreach($tomb as $elem){
			$tt.='<p><b>'.$i.'.</b><i>Válasz:</i></p><p>&nbsp;&nbsp;<input name="voks" value="'.$elem['id'].'" type="radio">&nbsp;<b>'.$elem['text'].'</b></p><br>'."\n";
			$i++;
		}
		$tt.='<p><b>#.</b><i>Tartózkodom:</i></p><p>&nbsp;&nbsp;<input name="voks" value="1" type="radio">&nbsp;<b>Csak látni szeretném az eredményeket...</b></p>';
		$tt.='</div><br /><p><input value="Szavazok!" name="submit" src="kinezet/'.$GLOBALS['USER']['smink'].'/btn_vote.png" type="image"></p></form>';
		return $tt;
	}

	// a megadott szavazás ereményét állítja elõ
	function szavazas_eredmeny($mit){
		$data = Cache::get( CACHE_AKTIV_SZAVAZAS, $mit );	
		return $data;
	}
	
	function sectionCookies(){
		
		$cook = explode( ',' , $_COOKIE[ constant('SECTION_COOKIE') ] );
		$cook=array_flip( $cook );
		$cook=array_flip( $cook );
		$GLOBALS['SECTION_COOKIES']=$cook;
		setcookie( constant('SECTION_COOKIE'), implode( ',' , $cook ), time()+60*60*24*365 );
	
	
	}
	
}//end class
?>