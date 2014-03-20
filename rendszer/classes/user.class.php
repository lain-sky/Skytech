<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

class User{

	private function __construct(){}

	function getIdByName($nev){
		db::futat("select uid from users where name='%s'",$nev);
		$id=db::egy_ertek('uid');
		if(is_numeric($id)){
			return $id;
		}
		else return false;	
	}

	function getNameById($id){
		db::futat("select name from users where uid='%d'",$id);
		$name=db::egy_ertek('name');
		if(!empty($name)){
			return $name;
		}
		else return false;	
	}

	function getAvatarById($uid){
		$pari="select avatar from user_data  where uid='%d'";
		db::futat($pari,$uid);
		$avatar=db::egy_ertek('avatar');
		if(!empty($avatar) && $avatar!='avatar.png'){
			return $avatar;
		}
		else{
			$text='kinezet/'.$GLOBALS['USER']['smink'].'/avatar.png';
			return $text;
		}	
	}
	
	function load($uid){
		$sql="select u.uid,u.name,u.email,u.rang,u.vizit,u.letolt,u.feltolt,u.reg_date,u.tor_pass,u.egyedi_rang,u.statusz, ".
			"(select count(*) from forum_hsz f where f.uid=u.uid) as hozzaszolas, ".
			"(select count(*) from torrent_hsz tf where tf.uid=u.uid) as torrent_hozzaszolas, ".
			"(select smink from user_data d where d.uid=u.uid ) as smink, ".
			"(select orszag from user_data a where a.uid=u.uid ) as orszag, " .
			"(select varos from user_data t where t.uid=u.uid ) as varos, ".
			"(select avatar from user_data ta where ta.uid=u.uid ) as avatar, ".
			"(select megjelen from user_data ta where ta.uid=u.uid ) as megjelen, ".
			"(select perold from user_data ta where ta.uid=u.uid ) as perold, ".
			"(select kategoriak from user_data tk where tk.uid=u.uid ) as kategoriak, ".
			"(select uj_torrent from user_data tt where tt.uid=u.uid ) as uj_torrent, ".
			"(select sum(po.pont) from pontok po where po.uid=u.uid ) as pontok ".
			"from users u  where u.uid='%d'";
		db::futat($sql,$uid);
		$tomb=db::tomb();
		$t=$tomb[0];
		
		$kesz=array();		
		$kesz['uid']=$t['uid']; 		
		//$kesz['name']=$t['name'].(Warn::get($uid)!==true ? '&nbsp;!':''); 
		$kesz['name']=$t['name']; 
		$kesz['email']=$t['email']; 
		$kesz['feltolt']=$t['feltolt']; 
		$kesz['letolt']=$t['letolt']; 
		$kesz['arany']=($kesz['feltolt']>0 && $kesz['letolt']>0)? round(($t['feltolt']/$t['letolt']),3):0;
		$kesz['arany_text']=($kesz['arany']==0)? 'nincs' : number_format($kesz['arany'],3);
		$kesz['rang']=$t['rang'];
		$kesz['statusz']=$t['statusz'];
		$kesz['egyedi_rang']=$t['egyedi_rang'];
		$kesz['rang_text']=(!empty( $t['egyedi_rang'] ))? $t['egyedi_rang'] : $GLOBALS['RANGOK'][$t['rang']];		
		$kesz['reg_date']=date('Y.m.d H:i:s',$t['reg_date']); 
		$kesz['vizit']=date('Y.m.d H:i:s',$t['vizit']); 
		$kesz['tor_pass']=$t['tor_pass'];
		$kesz['varos']=$t['varos'];
		$kesz['orszag']=$GLOBALS['ORSZAGTOMB'][$t['orszag']];		
		$kesz['smink']=$t['smink'];
		$kesz['avatar']=(strpos($t['avatar'], 'http://')===false)? 'kinezet/'.(!empty($GLOBALS['USER']['smink'])? $GLOBALS['USER']['smink']:'alap').'/avatar.png': $t['avatar'];
		$kesz['hszszam']=$t['hozzaszolas'];
		$kesz['tor_hszszam']=$t['torrent_hozzaszolas'];
		$kesz['uj_torrent']=$t['uj_torrent'];
		$kesz['kategoriak_text']=$t['kategoriak'];
		$kesz['kategoriak_tomb']=explode(',',$t['kategoriak']);
		$kesz['megjelen']=explode('|',$t['megjelen']);
		$kesz['perold']=explode('|',$t['perold']);	
		
		$kesz['pontok']=$t['pontok'];	
		
		$kesz['gui']=$kesz['megjelen'][3];
		
		return $kesz;

	}

	function getMaxAtadas($uid){
		db::futat("select feltolt,letolt from users where uid='%d'",$uid);
		$tomb=db::tomb();
		$le=$tomb[0]['letolt'];
		$fel=$tomb[0]['feltolt'];
		$atadhato=$fel-($le*MIN_ATAD_RATIO);		
		if($atadhato>0){
			return $atadhato;
		}
		else{
			return false;
		}
	}

	function feltoltKulonbseg($uid,$mihez=0){
		$ki=User::load($uid);
		return $ki['feltolt']-$mihez;	
	}
	
	function getLadad($uid ,$konvert=true){
		db::futat("select ladad,ladad_text from user_data where uid='%d'",$uid);
		$tomb=db::elso_sor();
		$kesz['ladad']=$tomb['ladad'];
		$kesz['ladad_text']=($konvert)? bb::bbdecode($tomb['ladad_text']) : $tomb['ladad_text'];
		return $kesz;
	}

	function checkUserName($name){
		if(array_search($name,$GLOBALS['tiltott_nev'])!==false){
			return 'A kiválsztott név titló listán van';
		}		
		if(!ervenyes_nev($name)){
			return 'A kiválasztott név érvénytelen karaktereket tartalmaz! A neved csak az angol abc betûit, és számokat tartalmazhat!';
		}
		db::futat("select uid from users where name='%s'",$name);
		if(db::$sorok!==0){
			return 'Sajnálom, de már valaki használja az általad választott nevet!';
		}
		return true;		
	}

	function checkEmail($email){
		if(array_search($email,$GLOBALS['tiltott_email'])!==false){
			return 'A kiválsztott email cím titló listán van';
		}
		if(!ervenyes_email($email)){
			return 'A megadott e-mail cím érvénytelen. Csak úgy tudsz regisztrálni, ha egy érvényes, mûködõ e-mail címet adsz meg!';
		}
		db::futat("select uid from users where email='%s'",$email);		
		if(db::$sorok!==0){
			return 'Sajnálom, de már valaki használja az általad választott email címet!';
		}
		return true;
	}
	
	function update($id,$tomb,$tabla='users'){
		$up=array();
		foreach($tomb as $key=>$val){
			$up[]=$key."='".$val."'";
		}
		if(count($up)<1) return;
		$sql="update ".$tabla." set ".implode(',',$up)." where uid='".$id."'";
		return db::futat($sql);
	}


}//end class

?>