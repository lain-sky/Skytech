<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{

	case 'pont_edit':
		
		$smarty->assign('modul','pont_edit');	
		$smarty->assign('modulnev','Jutalom Pontok');
		
		if( !empty($p['user_id']) && is_numeric($p['user_id']) ){
			$searchUserId= (int)$p['user_id'];
		}
		if(!empty($p['user_name'])){
			$searchUserId= (int)User::getIdByName($p['user_name']); 
		}
		
		if(!empty($searchUserId)){
			$smarty->assign('data',User::load($searchUserId) );
		}
		
		$pontTypes=array();
		foreach( array(20,21,22,666) as $id ){
			$pontTypes[$id] = $PONT_EVENTS[$id];
		}
		
		$smarty->assign('pontTypes', $pontTypes);
	
	break;
	
	
	case 'pont_save':
		
		$uid=(int)$_POST['pontUid'];
		$event=(int)$_POST['pontTypes'];
		
		if( !empty($uid) && !empty($event) ){
			
			if( $uid != $USER['uid'] ){
				$pont=new Pont();
				$pont->addPont( $uid, $event );
				
				logs::sysLog( 'pontok' , $PONT_EVENTS[$event]['name'], 'uid='.$uid );
				
				$_SESSION['uzenet']=nyugta('A müvelet sikeres');
				
			}else{
				$_SESSION['uzenet']=hiba_uzi('Magadnak nem fogsz adni :) !! ');
			}
		}
		else{
		
			$_SESSION['uzenet']=hiba_uzi('Hiányzó adat(ok)! ');
		
		}
		
		header("Location:". $_SERVER['SCRIPT_NAME'] ."?modul=pont_edit");
		exit;
		
		
	
	break;
	
	
	case 'pont_list':
		
		$sql="select u.uid,u.name,sum(p.pont) as ossz from users u 
				left join pontok p on p.uid=u.uid
				group by u.uid 
				order by  ossz desc limit 100 ";
				
		$data=db::getAll($sql);
		
		$smarty->assign('data',$data);
		
		$smarty->assign('modul','pont_list');	
		$smarty->assign('modulnev','TOP 100 pont tulajdonos');
	
	break;
}
?>