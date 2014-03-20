<?php
ob_start();
define('SZINT',666);
require_once('rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése


//csak 8 vagy annál nagyobb user léphet be
if( !in_array( $USER['rang'] , array(8,9,10) ) ){
        header("HTTP/1.1 404 Not Found");  
        header("Status: 404 Not Found"); 
        header("location: 404.php");
        exit;
                
}

define('MODI_LOGIN_NAME', 'monika' );
define('ADMIN_LOGIN_NAME', 'andika' );
define('TULAJ_LOGIN_NAME', 'tundi');

// login ablak
$valid_passwords = array ( 
        MODI_LOGIN_NAME =>      'b8604eccc47c6c5dc98ebee81b3766fc',
        ADMIN_LOGIN_NAME=>      '9d49b2670d9382cb5a0b674f760fa51e',
        TULAJ_LOGIN_NAME=>      'd93412ba51cf5e7b8223f13eb0ce01ba'      
);
$valid_users = array_keys( $valid_passwords );

$user = $_SERVER['PHP_AUTH_USER'] = 'tundi';
$pass = $_SERVER['PHP_AUTH_PW'] = 'd93412ba51cf5e7b8223f13eb0ce01ba';
//$validated = ( in_array( $user, $valid_users ) ) && ( $pass == $valid_passwords[$user] );
/*if (!isset($_SERVER['PHP_AUTH_USER'])) {
 header('WWW-Authenticate: Basic realm="Add meg a felhasználói neved és jelszavad!"');
 header('HTTP/1.0 401 Unauthorized');
 die("-Kismalac, Kismalac engedj be!<br /> -Nem engedlek lóf@sz a segedbe! :D ");
} 
function user_pass_ok($usr, $pas) {
	if(($usr == 'tundi') && ($pas == 'd93412ba51cf5e7b8223f13eb0ce01ba'))
		return true;
	else
		return false;
}
if (!isset($_SERVER['PHP_AUTH_USER'])) {
	header('WWW-Authenticate: Basic realm="Endless-HQ"');
	header('HTTP/1.0 401 Unauthorized');
	echo '<h2>Védett tartalom, csak regisztrált felhasználók érhetik el!</h2>';
} else {
	if (!user_pass_ok($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])) {
		die("-Kismalac, Kismalac engedj be!<br /> -Nem engedlek lóf@sz a segedbe! :D ");
	}
}



if( $_SERVER['PHP_AUTH_USER'] == MODI_LOGIN_NAME){
        if( (int)$USER['rang'] !== 8 ){
                die("-Kismalac, Kismalac engedj be!<br /> -Nem engedlek lóf@sz a segedbe! :D ");
        }
        else{
                $smarty->assign('admin_level', 'modi' );
        }
}
elseif( $_SERVER['PHP_AUTH_USER'] == ADMIN_LOGIN_NAME ){
        if( (int)$USER['rang'] !== 9 ){
                die("-Kismalac, Kismalac engedj be!<br /> -Nem engedlek lóf@sz a segedbe! :D ");
        }
        else{
                $smarty->assign('admin_level', 'admin' );
        }
}
elseif( $_SERVER['PHP_AUTH_USER'] == TULAJ_LOGIN_NAME ){
        if( (int)$USER['rang'] !== 10){
                die("-Kismalac, Kismalac engedj be!<br /> -Nem engedlek lóf@sz a segedbe! :) ");
        }
        else{
                define('ADMIN_LEVEL', 'tulcsi');
                $smarty->assign('admin_level', 'tulcsi' );
        }
}
else{
        die("-Kismalac, Kismalac engedj be!<br /> -Nem engedlek lóf@sz a segedbe! :D ");
}
*/


//die('itt...');

//innen indulhat a moka
$r=&$_REQUEST;
define('ADMIN_LEVEL', 'tulcsi');
$smarty->assign('admin_level', 'tulcsi' );
if( empty($r['modul']) ){
        $r['modul']='uzenofal';
}

$validModul['uzenofal']=                array(8=>true, 9=>true, 10=>true );
$validModul['uzenofal_uj']=     		array(8=>true, 9=>true, 10=>true );
$validModul['uzenofal_mod']=    		array(8=>true, 9=>true, 10=>true );
$validModul['uzenofal_save']=   		array(8=>true, 9=>true, 10=>true );
$validModul['uzenofal_del']=    		array(8=>true, 9=>true, 10=>true );

$validModul['oldal_stats']=             array(8=>true, 9=>true, 10=>true );
$validModul['user_stats']=              array(8=>true, 9=>true, 10=>true );
$validModul['tracker_stats']=   		array(8=>true, 9=>true, 10=>true );
$validModul['cron_stats']=              array(8=>true, 9=>true, 10=>true );
$validModul['user_kovetes']=    		array(8=>true, 9=>true, 10=>true );
$validModul['cheat_stats']=             array(8=>true, 9=>true, 10=>true );
$validModul['cheat_stats_reszletes']=array(8=>true, 9=>true, 10=>true );
$validModul['cheat_user']=              array(8=>true, 9=>true, 10=>true );
$validModul['syslog']=                  array(8=>true, 9=>true, 10=>true );
$validModul['pontlog']=                 array(8=>true, 9=>true, 10=>true );
$validModul['falidLoginLog']=   		array(8=>true, 9=>true, 10=>true );
$validModul['falidLoginLogClear']=		array(8=>true, 9=>true, 10=>true );

$validModul['chat_log']=                array(8=>true, 9=>true, 10=>true );
$validModul['chat_log_del']=            array(8=>true, 9=>true, 10=>true );
$validModul['chat_log_kiurit']=         array(8=>true, 9=>true, 10=>true );

$validModul['temakor_lista']=   		array(8=>false, 9=>true, 10=>true );
$validModul['temakor_uj']=              array(8=>false, 9=>true, 10=>true );
$validModul['temakor_mod']=             array(8=>false, 9=>true, 10=>true );
$validModul['temakor_del']=             array(8=>false, 9=>true, 10=>true );
$validModul['temakor_save']=    		array(8=>false, 9=>true, 10=>true );

$validModul['topik_uj']=                array(8=>false, 9=>true, 10=>true );
$validModul['topik_mod']=               array(8=>false, 9=>true, 10=>true );
$validModul['topik_save']=              array(8=>false, 9=>true, 10=>true );
$validModul['topik_del']=               array(8=>false, 9=>true, 10=>true );

$validModul['hir_lista']=               array(8=>false, 9=>false, 10=>true );
$validModul['hir_uj']=                  array(8=>false, 9=>false, 10=>true );
$validModul['hir_mod']=                 array(8=>false, 9=>false, 10=>true );
$validModul['hir_save']=                array(8=>false, 9=>false, 10=>true );
$validModul['hir_del']=                 array(8=>false, 9=>false, 10=>true );

$validModul['doc_lista']=               array(8=>false, 9=>false, 10=>true );
$validModul['doc_uj']=                  array(8=>false, 9=>false, 10=>true );
$validModul['doc_mod']=                 array(8=>false, 9=>false, 10=>true );
$validModul['doc_save']=                array(8=>false, 9=>false, 10=>true );
$validModul['doc_del']=                 array(8=>false, 9=>false, 10=>true );

$validModul['level_uj']=                array(8=>false, 9=>false, 10=>true );
$validModul['level_send']=              array(8=>false, 9=>false, 10=>true );

$validModul['warn_lista']=              array(8=>true, 9=>true, 10=>true );
$validModul['warn_uj']=                 array(8=>true, 9=>true, 10=>true );
$validModul['warn_save']=               array(8=>true, 9=>true, 10=>true );
$validModul['warn_del']=                array(8=>false, 9=>true, 10=>true );

$validModul['ban_lista']=               array(8=>true, 9=>true, 10=>true );
$validModul['ban_uj']=                  array(8=>false, 9=>true, 10=>true );
$validModul['ban_save']=                array(8=>false, 9=>true, 10=>true );
$validModul['ban_del']=                 array(8=>false, 9=>true, 10=>true );

$validModul['chat_add_szoba']=  		array(8=>false, 9=>true, 10=>true );
$validModul['chat_del_szoba']=  		array(8=>false, 9=>true, 10=>true );
$validModul['chat_mod_szoba']=  		array(8=>false, 9=>true, 10=>true );
$validModul['chat_szoba']=              array(8=>true, 9=>true, 10=>true );

$validModul['user_add']=                array(8=>false, 9=>true, 10=>true );
$validModul['user_mod']=                array(8=>false, 9=>true, 10=>true );
$validModul['user_save']=               array(8=>false, 9=>true, 10=>true );

$validModul['regfalid_lista']=          array(8=>false, 9=>true, 10=>true );
$validModul['regfalid_resend']=         array(8=>false, 9=>true, 10=>true );
$validModul['regfalid_confirm']=        array(8=>false, 9=>true, 10=>true );

$validModul['csoportos_meghivas']=      array(8=>false, 9=>true, 10=>true );
$validModul['csoportos_send']=          array(8=>false, 9=>true, 10=>true );

$validModul['szavazas_uj']=             array(8=>false, 9=>false, 10=>true );
$validModul['szavazas_lista']=          array(8=>false, 9=>false, 10=>true );
$validModul['szavazas_mod']=            array(8=>false, 9=>false, 10=>true );
$validModul['szavazas_save']=           array(8=>false, 9=>false, 10=>true );
$validModul['szavazas_del']=            array(8=>false, 9=>false, 10=>true );

$validModul['pont_edit']=               array(8=>false, 9=>true, 10=>true );
$validModul['pont_save']=               array(8=>false, 9=>true, 10=>true );
$validModul['pont_list']=               array(8=>false, 9=>true, 10=>true );

$validModul['torrent_setting']=         array(8=>false, 9=>false, 10=>true );
$validModul['torrent_save']=            array(8=>false, 9=>false, 10=>true );

$validModul['oldal_setting']=   		array(8=>false, 9=>false, 10=>true );
$validModul['tracker_setting']= 		array(8=>false, 9=>false, 10=>true );
$validModul['cron_setting']=    		array(8=>false, 9=>false, 10=>true );
$validModul['rang_setting']=   			array(8=>false, 9=>false, 10=>true );
$validModul['jog_setting']=             array(8=>false, 9=>false, 10=>true );
$validModul['varsave']=                 array(8=>false, 9=>false, 10=>true );

$validModul['flush_cache']=             array(8=>false, 9=>true, 10=>true );

if( $validModul[ $r['modul'] ][$USER['rang']]!== true ){
        die('tiltott modul');
}

define('ADMIN_MODULES_DIR',CORE_DIR . 'adminModuls/');
define('ADMIN_TEMPLATES_DIR', SABLON_DIR . 'adminTemplate/');
define('SZINT_ADMIN', 951 );

require_once(CLASS_DIR . 'basemodel.class.php');

switch($r['modul']){
        /*** HIREK ***/
        case 'hir_lista':
        case 'hir_uj':
        case 'hir_mod':
        case 'hir_del':
        case 'hir_save':
                require_once( ADMIN_MODULES_DIR.'hirModule.php');    
        break;
        
        /*** FÓRUM ***/
        case 'temakor_lista':
        case 'temakor_uj':
        case 'temakor_mod':
        case 'temakor_del':
        case 'temakor_save':
        
        case 'topik_uj':
        case 'topik_mod':
        case 'topik_save':
        case 'topik_del':
                require_once( ADMIN_MODULES_DIR.'forumModule.php');
        break;
        
        /*** SZAVAZAS ***/
        case 'szavazas_lista':
        case 'szavazas_uj':
        case 'szavazas_mod':
        case 'szavazas_del':
        case 'szavazas_save':
                require_once( ADMIN_MODULES_DIR.'szavazasModule.php');
        break;
        
        /*** Dokumentumok ***/
        case 'doc_lista':
        case 'doc_uj':
        case 'doc_mod':
        case 'doc_del':
        case 'doc_save':
                $smarty->assign('docType',$DOKUMNETUM_TIPUSOK);
                require_once( ADMIN_MODULES_DIR.'docModule.php'); 
        break;
        
        case 'level_uj':
        case 'level_send':
                require_once( ADMIN_MODULES_DIR.'levelModule.php');
        break;
        
        /*** Statisztika ***/
        case 'oldal_stats':     
        case 'user_stats':
        case 'tracker_stats':           
        case 'cron_stats':
        case 'user_kovetes':
        case 'cheat_stats':
        case 'cheat_stats_reszletes':
        case 'cheat_user':
                require_once( ADMIN_MODULES_DIR.'statsModule.php');
        break;
        
        /*** CHAT LOG ***/
        case 'chat_log':
        case 'chat_log_del':
        case 'chat_log_kiurit':
                require_once( ADMIN_MODULES_DIR.'chatlogModule.php');
        break;
        
        /**
        * UZENOFAL
        **/
        case 'uzenofal':
        case 'uzenofal_uj':
        case 'uzenofal_mod':
        case 'uzenofal_save':
        case 'uzenofal_del':
                require_once( ADMIN_MODULES_DIR.'uzenofalModule.php');
        break;
        
        /*** SYS_LOG ***/
        case 'syslog':
        case 'pontlog':
        case 'falidLoginLog':
        case 'falidLoginLogClear':
                        require_once( ADMIN_MODULES_DIR.'sysModule.php');
        break;
        
        /*** WARN ***/
        case 'warn_lista':
        case 'warn_uj':
        case 'warn_del':
        case 'warn_save':
                require_once( ADMIN_MODULES_DIR.'warnModule.php');
        break;
        
        /*** BAN ***/
        case 'ban_lista':
        case 'ban_uj':
        case 'ban_del':
        case 'ban_save':
                require_once( ADMIN_MODULES_DIR.'banModule.php');
        break;
        
        /*** Chat ***/
        case 'chat_mod_szoba':
        case 'chat_szoba':
        case 'chat_del_szoba':
        case 'chat_add_szoba':
                require_once( ADMIN_MODULES_DIR.'chatModule.php');
        break;
        
        /*** USER ***/
        case 'user_add':
        case 'user_mod':
        case 'user_save':
                require_once( ADMIN_MODULES_DIR.'userModule.php');
        break;
        
        /*** REG UJRA ***/
        case 'regfalid_lista':
        case 'regfalid_resend':
        case 'regfalid_confirm':
        case 'csoportos_meghivas':      
        case 'csoportos_send':
                require_once( ADMIN_MODULES_DIR.'regfalidModule.php');
        break;
        
        /*** PONTOK ***/
        case 'pont_edit':
        case 'pont_save':
        case 'pont_list':
                require_once( ADMIN_MODULES_DIR.'pontModule.php');
        break;
        
        /*** TORRENT ***/
        case 'torrent_save':
        case 'torrent_setting':
                require_once( ADMIN_MODULES_DIR.'torrentModule.php');
        break;
        
        /*** RENDSZER ADMIN ***/
        case 'oldal_setting':
        case 'tracker_setting':
        case 'cron_setting':
        case 'rang_setting':
        case 'jog_setting':
        case 'varsave':
                require_once( ADMIN_MODULES_DIR.'varModule.php');
        break;
        
        /** CACHE **/
        case 'flush_cache':
                require_once( ADMIN_MODULES_DIR.'cacheModule.php');
        break;
}

$smarty->assign('subtemplate', $smarty->_tpl_vars['modul']);
$smarty->assign('rangok',$RANGOK);
$smarty->assign('lap_cime',$_SERVER['SCRIPT_NAME']);
$smarty->assign('OLDAL',$OLDAL);
$smarty->display('modipanel.tpl');
ob_end_flush ();
?>

