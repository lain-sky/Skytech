<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek


// bejovo modosítások feldolgozása
if(!empty($_POST)){
	$p=&$_POST;	

	//user jelszó ellenõrzés
	db::futat("select uid from users where uid='%d' and pass='%s'",$USER['uid'],md5($USER['name'].$p['confirmation']));
	if(db::$sorok==0){
		$OLDAL[]=hiba_uzi('A jelszavadat helytelenül adtad meg!');
	}
	elseif(db::$sorok==1){
		// a mentenivaló mentése		

		//az oldalon megjelenõ obj megjelenésének beáálítása
		$perold=array(
			0=>(is_numeric($p['torrperold']) && $p['torrperold']>=10 && $p['torrperold']<=100)?  $p['torrperold']:20,
			1=>(is_numeric($p['hszperold']) && $p['hszperold']>=10 && $p['hszperold']<=100)?  $p['hszperold']:20,
			2=>(is_numeric($p['mailperold']) && $p['mailperold']>=10 && $p['mailperold']<=100)?  $p['mailperold']:20
		);
		$perold=implode('|',$perold);

		//megjelenõ uzik
		$megjelen=implode('|',$p['megjelen']);	

		//avatar		
		$avatar=(!empty($p['avatar']))? $p['avatar']:'avatar.png';		

		//smink egyenlõre még nem aktuális
		$smink='alap';//$p['smink'];

		//kategoriak
		if(!empty($p['kategoriak'])){
			$kat=implode(',',$p['kategoriak']);
		}
		else{
			$kat=NULL;
		}

		//rogzítés
		$user_data_pari="update user_data set privat='%s',nem='%s',orszag='%d',varos='%s',avatar='%s',ladad='%s',ladad_text='%s',megjelen='%s',perold='%s',smink='%s',kategoriak='%s'  where uid='%d'";
		if(db::futat($user_data_pari,$p['privat'],$p['nemed'],$p['orszag'],$p['varos'],$avatar,$p['ladad'],$p['ladad_text'],$megjelen,$perold,$smink,$kat,$USER['uid'])===true){
			$OLDAL[]=nyugta('Az opcionális adatok módosítva');
			//log::get_user_data($USER['uid'],$USER);	
		}
		else{
			$OLDAL[]=hiba_uzi('Hiba az adatrögzítés közben');
		}

		/*****************************/
		/* biztonsági adatok mentése */
		/*****************************/		

		//jelszó csere
		// meg van adva mind a két jelszó	
		if(!empty($p['pw1']) && !empty($p['pw2'])){
			if($p['pw1']!==$p['pw2']){
				$OLDAL[]=hiba_uzi('A megadott jelszavak nem egyeznek meg!');
			}
			//jelszavak megegyeznek de megnézzük a szintet
			else{
				// a jelszó ok mentés és email ki!!!
				if( strlen( $p['pw1'] )  < 5 ){
					$OLDAL[]=hiba_uzi('Az jelszavadnak legalább 5 karakternek kell lennie!!');
				}				
				else{
					$ellenor=veletlen_ellenor();
					$pari="insert into regisztral(uid,date,type,tema,ellenor) values('%d','%d','%s','%s','%s')";
					if(db::futat($pari,$USER['uid'],time(),'new_pass',$p['pw1'],md5($ellenor))!==true){
						$OLDAL[]=hiba_uzi('Adatrögzítési hiba! Próbáld újra!');
					}
					else{
						//adatrogzítés ok és email indul :)
						require_once( CLASS_DIR . 'mailer.class.php');
						
						if (sendEmail($USER['email'], $USER['email'], OLDAL_NEVE." - jelszócsere megerõsítése", uj_jelszo_mail(array('name'=>$USER['name'],'pass'=>$p['pw1'],'ellenor'=>$ellenor))) )
							$OLDAL[]=nyugta("Címedre (<span class=\"highlight\">".$USER['email']."</span>) megerõsítõ e-mailt küldtünk. Jelszavad csak a megerõsítés után változik meg! Ha nem kapnád meg a levelet kérlek jelezd a staffnak!");
						else
							$OLDAL[]=hiba-uzi("Levélkiküldési hiba! Próbáld meg újra, ha nem sikerülne kérlek jelezd a staffnak!");
					}
				}
			}//jelszocsere end
		}//if jelszavak end	

		//passkey cserélye
		if($p['newpasskey'] == 'yes') {
			$pari="update users set tor_pass='%s' where uid='%d' ";
			if(db::futat($pari,veletlen_torrent_pass(),$USER['uid'])===true){
				$OLDAL[]=nyugta("Új azonosítót (passkey-t) kaptál! <span class=\"highlight\">Minden le- és feltöltés alatt álló .torrent fájlt újra le kell töltened!</span>");
			}
			else{
				$OLDAL[]=hiba_uzi('A passkeye cseréje sikertelen');
			}
		}

		//email csere		
		if($p['email']!==$USER['email']){
			if(!empty($p['pw1']) && !empty($p['pw2'])){
				$OLDAL[]=hiba_uzi("Nem történt e-mail cím csere, mert jelszó cserét is kértél!");
			}
			else{
				$OLDAL[]=nyugta('Kidolgozás folymatban');
			}
		}		
	}// egy találtai sor end
	else{
		$OLDAL[]=hiba_uzi('Ismeretlen hiba!');
	}

	//useradatok betoltes
	$userAdat=User::load($USER['uid']);
	foreach($userAdat as $key=>$val){
		$USER[$key]=$val;
	}			

	$_SESSION['uzenet']=end($OLDAL);
	header("Location:".$_SERVER['SCRIPT_NAME']);
	die('ariranyitas');
}

$old=new old(); //oldalelemek betöltése
//tobbi adat betoltese
$sql="select privat,nem,orszag,varos,ladad,ladad_text from user_data where uid='%d'";
db::futat($sql,$USER['uid']);
$t=db::elso_sor();

if(!empty($_SESSION['uzenet'])){
	$OLDAL[]=$_SESSION['uzenet'];
	unset($_SESSION['uzenet']);
}

//Privát uzik
$privat_uzi=array(
	"mindenki"=>"Mindenkitõl",
	"staff"=>"Csak barátoktól, és a Stafftól",
	"barat"=>"Csak a Stafftól"	
);
$privat_uzi_old=$t['privat'];
$smarty->assign('privat_uzi',$privat_uzi);
$smarty->assign('privat_uzi_old',$privat_uzi_old);

//User neme
$nem=array(
	"fiu"=>"Kisfiú vagyok",
	"lany"=>"Kislány vagyok",
	"mas"=>"Más egyéb vagyok",
	"titok"=>"Nem árulom el"
);
$nem_old=$t['nem'];
$smarty->assign('nem',$nem);
$smarty->assign('nem_old',$nem_old);

//országok
$orszag_ertek=range(0,192);
$orszag_old=$t['orszag'];
$smarty->assign('orszag',$ORSZAGTOMB);
$smarty->assign('orszag_ertek',$orszag_ertek);
$smarty->assign('orszag_old',$orszag_old);

//város
$varos_old=$t['varos'];
$smarty->assign('varos_old',$varos_old);

//avatar
$avatar_url=($USER['avatar']=='avatar.png')? 'kinezet/'.$USER['smink'].'/avatar.png' : $USER['avatar'];
$avatar_text=($USER['avatar']==$avatar_url)? $USER['avatar']:'';
$smarty->assign('avatar_url',$avatar_url);
$smarty->assign('avatar_text',$avatar_text);

//kategoriak
$kategoriak=array();
foreach(kategoria::getAll() as $key=>$val){
	$kategoriak[$key]['id']=$val['kid'];
	$kategoriak[$key]['nev']=$val['nev'];
	$kategoriak[$key]['title']=$val['leir'];
	$kategoriak[$key]['checked']=in_array($val['kid'],$USER['kategoriak_tomb']);
}
$smarty->assign('kategoriak',$kategoriak);

//ladad
$ladad=$t['ladad'];
$ladad_text=$t['ladad_text'];
$smarty->assign('ladad',$ladad);
$smarty->assign('ladad_text',$ladad_text);

//oldalbeallitas
$megjelen=array(
	'avatar'=>'Avatarok megjelenítése',
	'ujtorr'=>'"Új torrent" jelzések kézi törlése',
	'modi'=>'Moderátor jelzések',
	'gui'=>'GUI animációk engedélyezése'
);
$megjelen_old=$USER['megjelen'];
$smarty->assign('megjelen',$megjelen);
$smarty->assign('megjelen_old',$megjelen_old);

// odj. egy oldalon
$perold=array(
	'torr'=>$USER['perold'][0],
	'hsz'=>$USER['perold'][1],
	'mail'=>$USER['perold'][2]
);
$smarty->assign('perold',$perold);

//sminkek beállítása
foreach($sminkek_tomb as $key=>$tomb){
	if($tomb['ert']==$USER['smink']){
		$sminkek_tomb[$key]['check']=true;
	}
}

$smarty->assign('sminkek_tomb',$sminkek_tomb);
$smarty->assign('email_cim',$USER['email']);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('profil.tpl');
ob_end_flush ();
?>