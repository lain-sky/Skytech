<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése

/**************/
/* Rögzítések */
/**************/

if(!empty($p) && $USER['rang'] >= SZAVAZAS_ADMIN_MIN_RANG){

	// új szavazás rögzítése
	if($p['modmezo']=='uj'){
		if(db::futat("insert into szavazas(cim,datum) values('%s',now())",$p['kerdes'])===true){
			$szavaz_id=db::$id;
			foreach($p['valasz'] as $v){
				if(!empty($v)){
					db::futat("insert into szavazas_elem(szid,text) values('%d','%s')",$szavaz_id,$v);
				}
			}
			$_SESSION['uzenet']=nyugta('Az új szavazás rögzítés sikerült');
			header("Location:".$p['vissza']);
			exit;
		}
		else{
			$OLDAL[]=hiba_uzi('A rögzítés sikertelen :(');
		}
	}
	// módosítások mentése

	elseif($p['modmezo']=='mod' && is_numeric($p['modid'])){	

		if(!empty($p['kerdes'])){
			if(db::futat("update szavazas set cim='%s' where szid='%d'",$p['kerdes'],$p['modid'])===true){

				//a régi mezõk bejárása
				foreach($p['regi'] as $key=>$val){
					// ha a régi mezõ tartalma be van állítva, akkor felülírja a régi adatokat
					if(!empty($val)){
						db::futat("update szavazas_elem set text='%s' where sze_id='%d'",$val,$key);
					}
					// ha üres, akkor törli a szavazás elemét és a hozzátatozó voksokat is
					else{
						db::futat("delete from szavazas_elem where  sze_id='%d'",$key);
						db::futat("delete from szavazatok where sze_id='%d'",$key);
					}
				}		

				// az új mezõk rögzítése ha van tartalmuk
				foreach($p['valasz'] as $v){
					if(!empty($v)){
						db::futat("insert into szavazas_elem(szid,text) values('%d','%s')",$p['modid'],$v);
					}
				}				
				$_SESSION['uzenet']=nyugta('A módosítás sikerült');
				header("Location:".$p['vissza']);
				exit;	
			}
			else{
				$OLDAL[]=hiba_uzi('A módosítás sikertelen');	
			}		
		}
		else{
			$OLDAL[]=hiba_uzi('A kérdés címe nem volt kitöltve ezért nem végeztem mûveletet');
		}
	}

	// a szavazás törlése
	elseif($p['modmezo']=='del' && is_numeric($p['modid'])){
		if(db::futat("delete from szavazas where szid='%d'",$p['modid'])===true){
			db::futat("delete from szavazas_elem where szid='%d'",$p['modid']);
			db::futat("delete from szavazatok where szid='%d'",$p['modid']);
			/*
			$_SESSION['uzenet']=nyugta('A törlés sikerült');
			header("Location:".$p['vissza']);
			exit;
			*/
			die('ok');
		}
		else{
			$OLDAL[]=hiba_uzi('A törlés sikertelen');
		}
	}
}

/************************/
/* A szavazás mûveletek */
/************************/

if(!empty($g) && $USER['rang'] >= SZAVAZAS_ADMIN_MIN_RANG){

	//a form feldolgozója
	$smarty->assign('feldolgozo',$_SERVER["SCRIPT_NAME"]);
	$smarty->assign('vissza',$g['vissza']);

	// új szavazás létrehozása
	if($g['mit']=='uj'){
		//a form elemi
		$form[]=array("olv"=>"Kérdés","id"=>"kerdes");
		for($i=1;$i<11;$i++){
			$form[]=array("olv"=>"Válasz ".$i,"id"=>"valasz[".$i."]");
		}	
		$smarty->assign('form',$form);
		$smarty->assign('modmezo','<input type="hidden" name="modmezo" value="uj" />');
		$smarty->assign('fejlec','Új szvazás');
	}

	//szavazás módosítás
	elseif($g['mit']=='mod' && is_numeric($g['id'])){
		//szavazas címe
		db::futat("select cim from szavazas where szid='%d'",$g['id']);
		$cim=db::tomb();
		$form[]=array("olv"=>"Kérdés","id"=>"kerdes","val"=>$cim[0]['cim']);

		//mezõk és neveik
		db::futat("select sze_id,text from szavazas_elem where szid='%d' order by szid",$g['id']);
		$tomb=db::tomb();

		//a meglévõ elemek feltöltése
		foreach($tomb as $i=>$elem){
			$form[]=array("olv"=>"Válasz ".($i+1),"id"=>"regi[".$elem['sze_id']."]","val"=>$elem['text']);
		}

		//plusz mezõk 
		for($i=count($tomb);$i<11;$i++){
			$form[]=array("olv"=>"Válasz ".$i,"id"=>"valasz[".$i."]");
		}	

		$smarty->assign('form',$form);
		$smarty->assign('modmezo','<input type="hidden" name="modmezo" value="mod" /><input type="hidden" name="modid" value="'.$g['id'].'" />');
		$smarty->assign('fejlec','Szavazás módosítása');
	}

	// szavazás módosítása
	elseif($g['mit']=='del' && is_numeric($g['id'])){
		$smarty->assign('modmezo','<input type="hidden" name="modmezo" value="del" /><input type="hidden" name="modid" value="'.$g['id'].'" />');
		$smarty->assign('fejlec','Szavazás törlése');
	}
	else{
		$OLDAL[]=hiba_uzi('Vak vágány :(');		
	}
}

//szavazások listája
else{
	//csak az utolsó 15 szavzást jelenítem csak meg, ha igény van rá akkor majd állítunk rajta.
	db::futat("select szid,cim,datum from szavazas order by szid desc limit 0,15");
	$tomb=db::tomb();
	$szavazasok=array();
	foreach($tomb as $i=>$elem){
		$szavazasok[$i]['cim']=$elem['cim'];
		$szavazasok[$i]['datum']=$elem['datum'];
		$szavazasok[$i]['text']=$old->szavazas_eredmeny($elem['szid']);
		if($USER['rang'] >= SZAVAZAS_ADMIN_MIN_RANG){
			$szavazasok[$i]['link']='<a href="szavazas.php?mit=mod&id='.$elem['szid'].'">Szavazás szerkesztése</a> &bull; ';
			$szavazasok[$i]['link'].='<a href="szavazas.php?mit=del&id='.$elem['szid'].'"class="szavaztorol" alt="'.$elem['szid'].'">Szavazás törlése</a> &bull; ';
			$szavazasok[$i]['link'].='<a href="szavazas.php?mit=uj">Új szavazás</a>';
		}		
	}	
	$smarty->assign('szavazasok',$szavazasok);
}

$smarty->assign('OLDAL',$OLDAL);
$smarty->display('szavazas.tpl');
ob_end_flush ();
?>