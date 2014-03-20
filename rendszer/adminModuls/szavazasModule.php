<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{
	
	case 'szavazas_lista':
		$smarty->assign('modul','szavazas_lista');	
		$smarty->assign('modulnev','Szavazások');
		
		$szav=new Szavazas();
		$smarty->assign('szavazasok',$szav->getAll() );
	
	break;
	
	case 'szavazas_uj':
		$smarty->assign('modul','szavazas_uj');	
		$smarty->assign('modulnev','Új szavazás létrehozása');	
		$form[]=array("olv"=>"Kérdés","id"=>"kerdes");
		for($i=1;$i<11;$i++){
			$form[]=array("olv"=>"Válasz ".$i,"id"=>"valasz[".$i."]");
		}
		$smarty->assign('data',$form);		
	
	break;
	
	case 'szavazas_mod':
		
		$smarty->assign('modul','szavazas_uj');	
		$smarty->assign('modulnev','Szavazás szeresztése');
		
	
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
		$smarty->assign('modId',$g['id']);
		
	break;
	
	
	case 'szavazas_save':
		
		if( !empty( $_POST['id'] ) && is_numeric( $_POST['id'] ) ){
			
			db::futat("update szavazas set cim='%s' where szid='%d'",$p['kerdes'],$p['id']);

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
					db::futat("insert into szavazas_elem(szid,text) values('%d','%s')",$p['id'],$v);
				}
			}				
			
			logs::sysLog( 'szavazas' , 'szavazás szerkesztése', 'szid='. $p['id']  );
		}
		else{
		
			db::futat("insert into szavazas(cim,datum) values('%s',now())",$p['kerdes']);
			$szavaz_id=db::$id;
			foreach($p['valasz'] as $v){
				if(!empty($v)){
					db::futat("insert into szavazas_elem(szid,text) values('%d','%s')",$szavaz_id,$v);
				}
			}
			
			logs::sysLog( 'szavazas' , 'szavazás létrehozása', 'szid='. $szavaz_id  );
		}		
		
		db::futat("select szid  from szavazas order by szid desc limit 0,1");
		$tomb=db::tomb();
		Cache::set( CACHE_AKTIV_SZAVAZAS, $tomb[0]['szid'] );
		
		$_SESSION['uzenet']=nyugta('A müvelet sikeres');
		header("Location:". $_SERVER['SCRIPT_NAME'] ."?modul=szavazas_lista");
		exit;
	
	break;
	
	case 'szavazas_del':
		db::futat("delete from szavazas where szid='%d'",$g['id']);
		db::futat("delete from szavazas_elem where szid='%d'",$g['id']);
		db::futat("delete from szavazatok where szid='%d'",$g['id']);
		
		logs::sysLog( 'szavazas' , 'szavazás törlése', 'szid='. $g['id']  );
		
		
		db::futat("select szid  from szavazas order by szid desc limit 0,1");
		$tomb=db::tomb();
		Cache::set( CACHE_AKTIV_SZAVAZAS, $tomb[0]['szid'] );
		
		$_SESSION['uzenet']=nyugta('A müvelet sikeres');
		header("Location:". $_SERVER['SCRIPT_NAME'] ."?modul=szavazas_lista");
		exit;		
	break;
	
	
	
}
?>