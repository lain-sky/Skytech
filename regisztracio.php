<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');

//ha van bejövõ regisztrációs adat
if(!empty($_POST['nu_name']) || !empty($_POST['nu_email'])){
	$hiba=array(); //a hibák listája!
	$pname=$_POST['nu_name'];
	$pemail=$_POST['nu_email'];

	//elfogadások	
	if($_POST['rules_read']!='OK' || $_POST['faq_read']!='OK' || $_POST['rights_read']!='OK' ) $hiba[0]='Minden dokumentumot el kell olvasni!';

	if(count($hiba)==0){
		//a beküldött mezõ adatok
		if(strlen($pname)<4 || strlen($pname)>15) $hiba[1]='A felhasználói név hossza nem megfelelõ(4-15 karakter közöttinek kell lennie)!';
		if(strlen($pemail)<8 || strlen($pemail)>40) $hiba[2]='Az email cím hossza nem megfelelõ(8-40 karakter közöttinek kell lennie)!';
	}

	if(count($hiba)==0){
		//az user nev alaposabb vizsgálata		
		if(array_search($pname,$tiltott_nev)!==false) $hiba[20]='A kiválsztott név titló listán van';
		if(!ervenyes_nev($pname)) $hiba[20]='A kiválasztott név érvénytelen karaktereket tartalmaz! A neved csak az angol abc betûit, és számokat tartalmazhat!';
		db::futat("select uid from users where name='%s'",$pname);
		if(db::$sorok!==0) $hiba[20]='Sajnálom, de már valaki használja az általad választott nevet!';
	}

	if(count($hiba)==0){
		//az email cím alaposabb vizsgálata		
		if(array_search($pemail,$tiltott_email)!==false) $hiba[30]='A kiválsztott email cím titló listán van';
		if(!ervenyes_email($pemail)) $hiba[30]='A megadott e-mail cím érvénytelen. Csak úgy tudsz regisztrálni, ha egy érvényes, mûködõ e-mail címet adsz meg!';
		db::futat("select uid from users where email='%s'",$pemail);
		if(db::$sorok!==0) $hiba[30]='Sajnálom, de már valaki használja az általad választott email címet!';
	}

	//hibák kiírása és újra mindent!
	if(count($hiba)!=0){		
		$tomb['name']=$pname;
		$tomb['email']=$pemail;
		if(!empty($_SESSION['marad']) && $_SESSION['marad']===true){
			$tomb['marad']=true;
		}		
		$smarty->assign('hiba',$hiba);
		$smarty->assign('form_value',$tomb);
		$smarty->display('regisztracio.tpl');	
	}

	// minden adat rendben és indul az adatrögzítés és mail kiküldés			
	else{
		//user adat rogzítés
		$vadat= veletlen_adat($pname);
		db::futat("insert into users (pass,tor_pass,name,email,statusz,reg_date) values('%s','%s','%s','%s','uj','%d')",$vadat['passhash'],$vadat['passkey'],$pname,$pemail,time());
		$uid=db::$id;
		$ellenor=veletlen_ellenor();

		//az ellenõrzõ adatok rogzítése
		db::futat("insert into regisztral(uid,date,type,tema,ellenor) values('%d','%d','reg','','%s')",$uid,time(),md5($ellenor));

		//email kiküldése
		require_once( CLASS_DIR . 'mailer.class.php');
		if (sendEmail($pemail, $pname, OLDAL_NEVE." - regisztráció megerõsítése", reg_mail(array('name'=>$pname,'pass'=>$vadat['password'],'ellenor'=>$ellenor))) )
			$mailUzi=uzi('Sikeres regisztráció',"Gratulálunk, sikeresen regisztráltad magad. Hamarosan egy megerõsítõ e-mail érkezik az e-mail címedre (<span class=\"highlight\">".$pemail."</span>). A megerõsítés után bejelentkezhetsz. Amenniyben nem kapnád meg a mailt, kérlek jelezd a staff@sky-tech.hu címen!");
		else
			$mailUzi=hiba_uzi('Sikertelen regisztráció!<br />Kérlek jelezd a staff@sky-tech.hu -n');

		//ha meghivoval került be
		if(!empty($_SESSION['meghivo']) && is_numeric($_SESSION['meghivo']) ){
			db::futat("update meghivo set meghivott='%d' where mid='%d' ",$uid,$_SESSION['meghivo']);
			unset($_SESSION['meghivo']);
			unset($_SESSION['marad']);
		}

		//siker megjelenítése
		$smarty->assign('uzi',$mailUzi);
		$smarty->display('regisztracio.tpl');
	}	
}

//jelszó emlékesztelo  
elseif(!empty($_POST['new_pass_email'])){
	die('hehe');
	db::futat("select uid,name from users where email='%s'",$_POST['new_pass_email']);
	if(db::$sorok!=1){
		$smarty->assign('uzi',uzi('Hiba!',"A megadott e-mail cím nincs regisztrálva"));
	}
	else{
		$tomb=db::tomb();
		$ellenor=veletlen_ellenor();
		$pari="insert into regisztral(uid,date,type,ellenor) values('%d','%d','emlekeszteto','%s')";
		db::futat($pari,$tomb[0]['uid'],time(),md5($ellenor));

		//indul a mail
		sendEmail($_POSR['new_pass_email'], $_POSR['new_pass_email'], OLDAL_NEVE." - elfelejtett jelszó", elfelejtet_jelszo_mail(array('name'=>$USER['name'],'ellenor'=>$ellenor)));
		$smarty->assign('uzi',uzi('Sikeres jelszó emlékesztetõ',"Hamarosan egy megerõsítõ e-mail érkezik az e-mail címedre (<span class=\"highlight\">".$_POSR['new_pass_email']."</span>). A megerõsítés után megkapod az új véletlen jelszavadat.<BR>".elfelejtet_jelszo_mail(array('name'=>$USER['name'],'ellenor'=>$ellenor))));
	}
}

// megerõsítés ellenõrzés
elseif(!empty($_GET['mod'])){
	$gmod=as_md5($_GET['mod']);
	$hiba=0;

	//van e ilyen ellenõrzõ
	if($hiba==0){
		db::futat("select r.type,r.date,r.tema,r.rid,r.uid,u.name from regisztral r left join users u on r.uid=u.uid where ellenor='%s'",md5($gmod));
		if(db::$sorok!=1){
			$smarty->assign('uzi',uzi('Hiba!',"Nem létezik kérés az adott ellenõrzõ összeggel!"));
			$hiba++;
		}		
	}

	//lejárt-e az ellenõrzõ
	if($hiba==0){
		$tomb=db::tomb();
		$tomb=$tomb[0];
		if((time()-$tomb['date'])>(60*60*24*3)){
			db::futat("delete from regisztral where rid='%s'",$tomb['rid']);
			$smarty->assign('uzi',uzi('Hiba!',"A kérés három napnál régebbi, már nem használható fel!"));
			$hiba++;
		}
	}

	//minden leellenõrizve most mehetnek a rögzítések
	if($hiba==0){
		//regisztáció
		if($tomb['type'] == 'reg') {
			db::futat("UPDATE users SET statusz='aktiv' WHERE `uid`='%d'", $tomb['uid']);			
			$smarty->assign('uzi',uzi('Sikeres megerõsítés!',"Felhasználói fiókodat sikeresen megerõsítettük!"));

			
			db::futat(" select uid from user_data where uid='%d' ",$tomb['uid']);
			if( db::$sorok !=1 ){
				//új user adatok rogzitese
				db::futat("insert into user_data(uid) values ('%d')",$tomb['uid']);
			}
		}

		//uj jelszo
		elseif($tomb['type'] == 'new_pass'){
			db::futat("update users set pass='%s' where uid='%d'",md5($tomb['name'].$tomb['tema']),$tomb['uid']);
			$smarty->assign('uzi',uzi('Sikeres megerõsítés!',"Jelszavadat sikeresen módosítottuk!"));
		}

		//meghivo
		elseif($tomb['type']=='meghivo'){
			$sql="select email,mid from meghivo where mid=(select tema from regisztral where rid='%d')";
			db::futat($sql,$tomb['rid']);
			$tomb=db::tomb();
			$smarty->assign('form_value',array('email'=>$tomb[0]['email'],'marad'=>true));
			$_SESSION['meghivo']=$tomb[0]['mid'];
			$_SESSION['marad']=true;				
		}
		
		//jelszo emlekezteto
		elseif($tomb['type'] == 'emlekez'){
			db::futat("update users set pass='%s' where uid='%d'",md5($tomb['name'].$tomb['tema']),$tomb['uid']);
			$smarty->assign('uzi',uzi('Sikeres megerõsítés!',"Jelszavadat sikeresen módosítottuk!"));
		}

		// az adott azonosító törlése
		db::futat("delete from regisztral where rid='%s'",$tomb['rid']);
	}

	$smarty->display('regisztracio.tpl');
}

// alapból a regisztráló oldal
else{
	// a max user szám ellenõrzése
	db::futat("SELECT count( * ) AS db FROM users WHERE statusz != 'delete' ");	
	if(db::egy_ertek('db')>Max_user){
		// hehe nincs reg :)
		$smarty->assign('uzi','Regisztráció lezárva, csak meghívóval lehet bekerülni!');
	}

	// reg form kiirása
	$smarty->display('regisztracio.tpl');
}

ob_end_flush ();
?>