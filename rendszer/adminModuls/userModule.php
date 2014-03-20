<?php
if(!defined('SZINT_ADMIN') || SZINT_ADMIN!=951 ) die('Hozzáférés megtagadva');

switch($r['modul'])	{
	
	case 'user_add':
		$smarty->assign('modul','user_add');
		$smarty->assign('modulnev','User hozzáadása');
		$smarty->assign('sminkek',$sminkek_tomb);
		$smarty->assign('modRangok', adminUserRangFilter($RANGOK) );
		$smarty->assign('modStatuszok', $STATUSZOK );			
		
		if( !empty($_SESSION['saveData']) && is_array($_SESSION['saveData']) ){
			foreach($_SESSION['saveData'] as $key=>$data ){
				$smarty->assign($key,$data);
			}
			unset($_SESSION['saveData']);
		}
		$smarty->assign('regForm',true);
		
	break;
	
		
	case 'user_mod':
		$smarty->assign('modul','user_add');
		$smarty->assign('modulnev','User hozzáadása');
		$smarty->assign('kereso',true);
		
		
		if( !empty($p['user_id']) && is_numeric($p['user_id']) ){
			$searchUserId= (int)$p['user_id'];
		}
		
		if( !empty($r['id']) && is_numeric($r['id']) ){
			$searchUserId= (int)$r['id'];
		}
		
		if(!empty($p['user_name'])){
			$searchUserId= (int)User::getIdByName($p['user_name']); 
		}
		
		if(!empty($searchUserId)){
		
		//d( User::load($searchUserId) );
			$smarty->assign('udata',User::load($searchUserId) );
			$smarty->assign('ladad',User::getLadad($searchUserId , false));
			$smarty->assign('regForm',true);
			$smarty->assign('sminkek',$sminkek_tomb);
			$smarty->assign('modRangok', adminUserRangFilter($RANGOK) );	
			$smarty->assign('modStatuszok', $STATUSZOK );	
		}
		
		
	
	break;
	
	
	
	case 'user_save':
		
		
		if(!empty($p['modid'])){
			
			$load=User::load($p['modid']);
				
				if( $load['uid'] == 1  ){
					$_SESSION['uzenet']=hiba_uzi('Hehe !!!');
					header('Location:'.$_SERVER['SCRIPT_NAME']);
					exit;	
				}
			
			//adatok ellenörzese
			if($load['name']==$p['name']) $checkName=true;
			else $checkName=User::checkUserName($p['name']);
			
			if($load['email']==$p['email']) $checkEmail=true;
			else $checkEmail=User::checkEmail($p['email']);			

			switch(true){
				case $checkName!==true :
					$_SESSION['uzenet']=hiba_uzi($checkName);
				break;
				case $checkEmail!==true:
					$_SESSION['uzenet']=hiba_uzi($checkEmail);
				break;
				
				default:
					//ok minden rogzites;
						$vadat= veletlen_adat($p['name']);
						$pass=md5($p['name'].$p['pass']);
						$fel=(!empty($p['feltolt']))? $p['feltolt'] :0;
						$le=(!empty($p['letolt']))? $p['letolt'] :0;
						$egyedi_rang=( !empty($p['egyedi_rang']) )? $p['egyedi_rang'] : '' ;
						$avatar=(!empty($p['avatar']))? $p['avatar'] :'avatar.png';
						$ladad=(!empty($p['ladad']))? $p['ladad'] :'';
						$ladad_text=(!empty($p['ladad_text']))? $p['ladad_text'] :'';
						
						
						$tomb1=array('name'=>$p['name'],'feltolt'=>$fel,"letolt"=>$le,"email"=>$p['email'],'egyedi_rang'=>$egyedi_rang);
						if(!empty($p['pass']) ){
							$tomb1['pass']=$pass;
						}
						
						if( ADMIN_LEVEL === 'tulcsi' ){
							$tomb1['rang']=$p['rang'];
							$tomb1['statusz']=$p['statusz'];
						}
						
						
						$tomb2=array('ladad'=>$ladad,'ladad_text'=>$ladad_text,'avatar'=>$avatar,'smink'=>$p['smink']);

						User::update($p['modid'],$tomb1,'users');
						User::update($p['modid'],$tomb2,'user_data');

						logs::sysLog( 'user_admin' , 'profil_edit', 'uid='. $p['modid']  );		

						$_SESSION['uzenet']=nyugta('User módosítás sikeres');
						header('Location:'.$_SERVER['SCRIPT_NAME']);
						exit;	
				break;
			}
		
				header('Location:'.$_SERVER['SCRIPT_NAME']);
				exit;
		}
		else{
		
			$checkName=User::checkUserName($p['name']);
			$checkEmail=User::checkEmail($p['email']);
			
			$p['pass'] = trim($p['pass']);
			//d($p,1);
			switch(true){
				case $checkName!==true :
					$_SESSION['uzenet']=hiba_uzi($checkName);
				break;
				case $checkEmail!==true:
					$_SESSION['uzenet']=hiba_uzi($checkEmail);
				break;
				
				case empty( $p['pass'] ):
					$_SESSION['uzenet']=hiba_uzi('Nem megfelelo jelszo');
				break;
				default:
					//ok minden rogzites;
						$vadat= veletlen_adat($p['name']);
						$pass=md5($p['name'] . $p['pass']);
						$fel=(!empty($p['feltolt']))? $p['feltolt'] :0;
						$le=(!empty($p['letolt']))? $p['letolt'] :0;
						$avatar=(!empty($p['avatar']))? $p['avatar'] :'avatar.png';
						$ladad=(!empty($p['ladad']))? $p['ladad'] :'';
						$ladad_text=(!empty($p['ladad_text']))? $p['ladad_text'] :'';						

						db::futat("insert into users (pass,tor_pass,name,email,statusz,reg_date,rang,feltolt,letolt) values('%s','%s','%s','%s','aktiv','%d','%d','%f','%f')",$pass,$vadat['passkey'],$p['name'],$p['email'],time(),$p['rang'],$fel,$le);
						$newUid=db::$id;
						db::futat("insert into user_data(uid,ladad,ladad_text,smink,avatar) values ('%d','%s','%s','%s','%s')",$newUid,$ladad,$ladad_text,$p['smink'],$avatar);		
						
						logs::sysLog( 'user_admin' , 'user rogzietes', 'uid='. $newUid  );	
						
						$_SESSION['uzenet']=nyugta('User rögzítése sikeres');
						header('Location:'.$_SERVER['SCRIPT_NAME']);						
						exit;
				break;
			}

			$saveData['udata']=array(
								"name"=>$p['name'],
								"smink"=>$p['smink'],
								"feltolt"=>$p['feltolt'],
								"letolt"=>$p['letolt'],
								"rang"=>$p['rang'],
								"smink"=>$p['smink'],
								"avatar"=>$p['avatar'],
								"email"=>$p['email']
								);
			$saveData['ladad'] = array(
								"ladad"=>$p['ladad'],
								"ladad_text"=>$p['ladad_text']
								);
								
			$_SESSION['saveData']=$saveData;			
			header('Location:'.$_SERVER['SCRIPT_NAME']."?modul=user_add");						
			exit;
		}		
	
	break;
	
}

function adminUserRangFilter( $array ){
	
	if( ADMIN_LEVEL === 'tulcsi' ){
		return $array;
	}
	
	$kesz=array();
	foreach($array as $i=>$row ){
		if( $i < 8 ){
			$kesz[$i]=$row;
		}
	}
	return $kesz;
}

?>