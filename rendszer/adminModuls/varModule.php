<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{
		
	case 'oldal_setting':
		$smarty->assign('modulnev','Oldal beállítások');
		$smarty->assign('modul','var_setting');		
		$smarty->assign('vars',Vars::getByTypeMod('oldal'));		
	break;

	case 'tracker_setting':
		$smarty->assign('modulnev','Tracker beállítások');
		$smarty->assign('modul','var_tracker_setting');
		$smarty->assign('vars',Vars::getByTypeMod('tracker'));
		$smarty->assign('rangok',$RANGOK);
	break;

	case 'cron_setting':
		$smarty->assign('modulnev','Cron beállítások');
		$smarty->assign('modul','var_setting');
		$smarty->assign('vars',Vars::getByTypeMod('cron'));
	break;		
	
	case 'rang_setting':
		$smarty->assign('modulnev','Rang beállítások');
		$smarty->assign('modul','var_setting');
		$smarty->assign('vars',Vars::getByTypeMod('rang'));
	break;
	
	case 'jog_setting':
		$smarty->assign('modulnev','Jogosultság beállítások');
		$smarty->assign('modul','var_setting');		
		$smarty->assign('vars',Vars::getByTypeMod('jog'));
		$smarty->assign('rangok',$RANGOK);
	break;

	case 'varsave':
		
		if(!empty($p['param'])){
			foreach($p['param'] as $key=>$val){
				if(!empty($val)){
					Vars::update($key,$val);
				}
			}
			Cache::set( CACHE_VALTOZOK );
			$_SESSION['uzenet']=nyugta('Ha látod ezt az üzit, akkor az oldal módosítások nem okoztak végzetes hibát :)');
			header('Location:'.$_SERVER['SCRIPT_NAME']);
			exit;		
		}
	break;	


	
	
}
?>