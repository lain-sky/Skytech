<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{
	
	case 'doc_lista':
		$smarty->assign('modul','doc_lista');	
		$smarty->assign('modulnev','Documentumok');
		
		
		$doc=new Doc();
		$kesz=array();
		foreach( $doc->getAll() as $row ){
			$row['mod_user_name']=User::getNameById($row['mod_user']);
			$kesz[$row['mihez']][]=$row;
		}
		
		//d($kesz,1);
		$smarty->assign('data',$kesz );
	
	break;
	
	case 'doc_uj':
		$smarty->assign('modul','doc_uj');	
		$smarty->assign('modulnev','Új doc létrehozása');
		
	
	break;
	
	case 'doc_mod':
		$smarty->assign('modul','doc_uj');	
		$smarty->assign('modulnev','Dokumentum szeresztése');
		
		$modId=(int)$g['id'];
		$doc=new Doc();
		$smarty->assign('data', $doc->getById( $modId ) );
		
	break;
	
	
	case 'doc_save':
		
		$doc= new Doc();	
		
		$data['cim']=$p['cim'];
		$data['text']=$p['text'];
		$data['suly']=$p['suly'];
		$data['mihez']=$p['mihez'];
		$data['mod_user']=$USER['uid'];
		$data['mod_date']=date('Y-m-d H:i:s');
		
		
		$modId=(int)$p['id'];
		
		if(!empty($modId)){
		
			logs::sysLog( 'doc' , 'doc modositas', 'docId='. $modId  );
			$doc->update( array('cid'=>$modId),$data);
		}
		else{
			logs::sysLog( 'doc' , 'új doc', 'docCim='. $p['cim']  );
			$doc->add($data);
		}
		
		new general( $p['mihez'] );
		Cache::set( CACHE_DOKUMENTACIO );
		
		$_SESSION['uzenet']=nyugta('A müvelet sikeres');
		header("Location:". $_SERVER['SCRIPT_NAME'] ."?modul=doc_lista");
		exit;
	
	break;
	
	case 'doc_del':
		$doc= new Doc();
		$modId=(int)$g['id'];
		
		logs::sysLog( 'doc' , 'doc törlés', 'docId='. $modId  );
		$doc->del(  array('cid'=>$modId) );
		
		new general($g['type']);
		Cache::set( CACHE_DOKUMENTACIO );
		
		$_SESSION['uzenet']=nyugta('A müvelet sikeres');
		header("Location:". $_SERVER['SCRIPT_NAME'] ."?modul=doc_lista");
		exit;		
	break;
	
	
	
}
?>