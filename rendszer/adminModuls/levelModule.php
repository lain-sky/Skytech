<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{
	
		
	case 'level_uj':
		$smarty->assign('modul','level_uj');	
		$smarty->assign('modulnev','Új hír létrehozása');
		$smarty->assign('data', array('datum'=>date('Y-m-d H:i:s')) );
	
	break;
	
	
	case 'level_send':
		
		$targy=$p['tema'];
		$torzs=$p['text'];
		$where=" and rang in(". implode(',', $p['kinek'] ) .")";
		level::korlevel($targy,$torzs,$where);
		
		logs::sysLog( 'korlevel' , 'új körlevél', 'kiknek ='. implode(',', $p['kinek'] )  );
		
		$_SESSION['uzenet']=nyugta('A müvelet sikeres');
		header("Location:". $_SERVER['SCRIPT_NAME'] ."?modul=level_uj");
		exit;		
	break;
	
	
	
}
?>