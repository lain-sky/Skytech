<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{
	
	case 'flush_cache':
		
		Cache::clearAll();
		
		$_SESSION['uzenet']=nyugta('A müvelet sikeres');
		header("Location:". $_SERVER['SCRIPT_NAME'] );
		exit;
	break;
	
	
	
}
?>