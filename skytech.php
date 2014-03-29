<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


if(!in_array($USER['rang'], array(8, 9, 10))) {
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	header("location: 404.php");
	exit;
}

$r = &$_REQUEST;
define('ADMIN_LEVEL', 'tulcsi');
$smarty->assign('admin_level', 'tulcsi');

if(empty($r['modul'])) {
        $r['modul']='uzenofal';
}

$validModul['uzenofal']				=	array(8 => true, 9 => true, 10 => true);
$validModul['uzenofal_uj']			=	array(8 => true, 9 => true, 10 => true);
$validModul['uzenofal_mod']			=	array(8 => true, 9 => true, 10 => true);
$validModul['uzenofal_save']		=	array(8 => true, 9 => true, 10 => true);
$validModul['uzenofal_del']			=	array(8 => true, 9 => true, 10 => true);

$validModul['oldal_stats']			=   array(8 => true, 9 => true, 10 => true);
$validModul['user_stats']			=	array(8 => true, 9 => true, 10 => true);
$validModul['tracker_stats']		=	array(8 => true, 9 => true, 10 => true);
$validModul['cron_stats']			=   array(8 => true, 9 => true, 10 => true);
$validModul['user_kovetes']			=   array(8 => true, 9 => true, 10 => true);
$validModul['cheat_stats']			=	array(8 => true, 9 => true, 10 => true);
$validModul['cheat_stats_reszletes']=	array(8 => true, 9 => true, 10 => true);
$validModul['cheat_user']			=	array(8 => true, 9 => true, 10 => true);
$validModul['syslog']				=	array(8 => true, 9 => true, 10 => true);
$validModul['pontlog']				=	array(8 => true, 9 => true, 10 => true);
$validModul['falidLoginLog']		=	array(8 => true, 9 => true, 10 => true);
$validModul['falidLoginLogClear']	=	array(8 => true, 9 => true, 10 => true);

$validModul['chat_log']				=	array(8 => true, 9 => true, 10 => true);
$validModul['chat_log_del']			=	array(8 => true, 9 => true, 10 => true);
$validModul['chat_log_kiurit']		=	array(8 => true, 9 => true, 10 => true);

$validModul['temakor_lista']		=	array(8 => false, 9 => true, 10 => true);
$validModul['temakor_uj']			=	array(8 => false, 9 => true, 10 => true);
$validModul['temakor_mod']			=	array(8 => false, 9 => true, 10 => true);
$validModul['temakor_del']			=	array(8 => false, 9 => true, 10 => true);
$validModul['temakor_save']			=	array(8 => false, 9 => true, 10 => true);

$validModul['topik_uj']				=	array(8 => false, 9 => true, 10 => true);
$validModul['topik_mod']			=	array(8 => false, 9 => true, 10 => true);
$validModul['topik_save']			=	array(8 => false, 9 => true, 10 => true);
$validModul['topik_del']			=	array(8 => false, 9 => true, 10 => true);

$validModul['hir_lista']			=	array(8 => false, 9 => false, 10 => true);
$validModul['hir_uj']				=	array(8 => false, 9 => false, 10 => true);
$validModul['hir_mod']				=	array(8 => false, 9 => false, 10 => true);
$validModul['hir_save']				=	array(8 => false, 9 => false, 10 => true);
$validModul['hir_del']				=	array(8 => false, 9 => false, 10 => true);

$validModul['doc_lista']			=	array(8 => false, 9 => false, 10 => true);
$validModul['doc_uj']				=	array(8 => false, 9 => false, 10 => true);
$validModul['doc_mod']				=	array(8 => false, 9 => false, 10 => true);
$validModul['doc_save']				=	array(8 => false, 9 => false, 10 => true);
$validModul['doc_del']				=	array(8 => false, 9 => false, 10 => true);

$validModul['level_uj']				=	array(8 => false, 9 => false, 10 => true);
$validModul['level_send']			=	array(8 => false, 9 => false, 10 => true);

$validModul['warn_lista']			=	array(8 => true, 9 => true, 10 => true);
$validModul['warn_uj']				=	array(8 => true, 9 => true, 10 => true);
$validModul['warn_save']			=	array(8 => true, 9 => true, 10 => true);
$validModul['warn_del']				=	array(8 => false, 9 => true, 10 => true);

$validModul['ban_lista']			=	array(8 => true, 9 => true, 10 => true);
$validModul['ban_uj']				=	array(8 => false, 9 => true, 10 => true) ;
$validModul['ban_save']				=	array(8 => false, 9 => true, 10 => true);
$validModul['ban_del']				=	array(8 => false, 9 => true, 10 => true);

$validModul['chat_add_szoba']		=	array(8 => false, 9 => true, 10 => true);
$validModul['chat_del_szoba']		=	array(8 => false, 9 => true, 10 => true);
$validModul['chat_mod_szoba']		=	array(8 => false, 9 => true, 10 => true);
$validModul['chat_szoba']			=	array(8 => true, 9 => true, 10 => true);

$validModul['user_add']				=	array(8 => false, 9 => true, 10 => true);
$validModul['user_mod']				=	array(8 => false, 9 => true, 10 => true);
$validModul['user_save']			=	array(8 => false, 9 => true, 10 => true);

$validModul['regfalid_lista']		=	array(8 => false, 9 => true, 10 => true);
$validModul['regfalid_resend']		=	array(8 => false, 9 => true, 10 => true);
$validModul['regfalid_confirm']		=	array(8 => false, 9 => true, 10 => true);

$validModul['csoportos_meghivas']	=	array(8 => false, 9 => true, 10 => true);
$validModul['csoportos_send']		=	array(8 => false, 9 => true, 10 => true);

$validModul['szavazas_uj']			=	array(8 => false, 9 => false, 10 => true);
$validModul['szavazas_lista']		=	array(8 => false, 9 => false, 10 => true);
$validModul['szavazas_mod']			=	array(8 => false, 9 => false, 10 => true);
$validModul['szavazas_save']		=	array(8 => false, 9 => false, 10 => true);
$validModul['szavazas_del']			=	array(8 => false, 9 => false, 10 => true);

$validModul['pont_edit']			=	array(8 => false, 9 => true, 10 => true) ;
$validModul['pont_save']			=	array(8 => false, 9 => true, 10 => true);
$validModul['pont_list']			=	array(8 => false, 9 => true, 10 => true);

$validModul['torrent_setting']		=	array(8 => false, 9 => false, 10 => true);
$validModul['torrent_save']			=	array(8 => false, 9 => false, 10 => true);

$validModul['oldal_setting']		=	array(8 => false, 9 => false, 10 => true);
$validModul['tracker_setting']		=	array(8 => false, 9 => false, 10 => true);
$validModul['cron_setting']			=	array(8 => false, 9 => false, 10 => true);
$validModul['rang_setting']			=	array(8 => false, 9 => false, 10 => true);
$validModul['jog_setting']			=	array(8 => false, 9 => false, 10 => true);
$validModul['varsave']				=	array(8 => false, 9 => false, 10 => true);

$validModul['flush_cache']			=	array(8 => false, 9 => true, 10 => true);

if($validModul[$r['modul']][$USER['rang']] !== true)
        die('tiltott modul');

define('ADMIN_MODULES_DIR', CORE_DIR . 'adminModuls/');
define('ADMIN_TEMPLATES_DIR', SABLON_DIR . 'adminTemplate/');
define('SZINT_ADMIN', 951);

require_once(CLASS_DIR . 'basemodel.class.php');

switch($r['modul']) {
	case 'hir_lista':
	case 'hir_uj':
	case 'hir_mod':
	case 'hir_del':
	case 'hir_save':
		require_once(ADMIN_MODULES_DIR . 'hirModule.php');
	break;

	case 'temakor_lista':
	case 'temakor_uj':
	case 'temakor_mod':
	case 'temakor_del':
	case 'temakor_save':

	case 'topik_uj':
	case 'topik_mod':
	case 'topik_save':
	case 'topik_del':
		require_once(ADMIN_MODULES_DIR . 'forumModule.php');
	break;

	case 'szavazas_lista':
	case 'szavazas_uj':
	case 'szavazas_mod':
	case 'szavazas_del':
	case 'szavazas_save':
		require_once(ADMIN_MODULES_DIR . 'szavazasModule.php');
	break;

	case 'doc_lista':
	case 'doc_uj':
	case 'doc_mod':
	case 'doc_del':
	case 'doc_save':
		$smarty->assign('docType', $DOKUMNETUM_TIPUSOK);
		require_once(ADMIN_MODULES_DIR . 'docModule.php');
	break;

	case 'level_uj':
	case 'level_send':
		require_once(ADMIN_MODULES_DIR . 'levelModule.php');
	break;

	case 'oldal_stats':
	case 'user_stats':
	case 'tracker_stats':
	case 'cron_stats':
	case 'user_kovetes':
	case 'cheat_stats':
	case 'cheat_stats_reszletes':
	case 'cheat_user':
		require_once(ADMIN_MODULES_DIR . 'statsModule.php');
	break;

	case 'chat_log':
	case 'chat_log_del':
	case 'chat_log_kiurit':
		require_once(ADMIN_MODULES_DIR . 'chatlogModule.php');
	break;

	case 'uzenofal':
	case 'uzenofal_uj':
	case 'uzenofal_mod':
	case 'uzenofal_save':
	case 'uzenofal_del':
		require_once(ADMIN_MODULES_DIR . 'uzenofalModule.php');
	break;

	case 'syslog':
	case 'pontlog':
	case 'falidLoginLog':
	case 'falidLoginLogClear':
		require_once(ADMIN_MODULES_DIR . 'sysModule.php');
	break;

	case 'warn_lista':
	case 'warn_uj':
	case 'warn_del':
	case 'warn_save':
		require_once(ADMIN_MODULES_DIR . 'warnModule.php');
	break;

	case 'ban_lista':
	case 'ban_uj':
	case 'ban_del':
	case 'ban_save':
		require_once(ADMIN_MODULES_DIR . 'banModule.php');
	break;

	case 'chat_mod_szoba':
	case 'chat_szoba':
	case 'chat_del_szoba':
	case 'chat_add_szoba':
		require_once(ADMIN_MODULES_DIR . 'chatModule.php');
	break;

	case 'user_add':
	case 'user_mod':
	case 'user_save':
		require_once(ADMIN_MODULES_DIR . 'userModule.php');
	break;

	case 'regfalid_lista':
	case 'regfalid_resend':
	case 'regfalid_confirm':
	case 'csoportos_meghivas':
	case 'csoportos_send':
		require_once(ADMIN_MODULES_DIR . 'regfalidModule.php');
	break;
	
	case 'pont_edit':
	case 'pont_save':
	case 'pont_list':
		require_once(ADMIN_MODULES_DIR . 'pontModule.php');
	break;

	case 'torrent_save':
	case 'torrent_setting':
		require_once(ADMIN_MODULES_DIR . 'torrentModule.php');
	break;

	case 'oldal_setting':
	case 'tracker_setting':
	case 'cron_setting':
	case 'rang_setting':
	case 'jog_setting':
	case 'varsave':
		require_once(ADMIN_MODULES_DIR . 'varModule.php');
	break;

	case 'flush_cache':
		require_once(ADMIN_MODULES_DIR . 'cacheModule.php');
	break;
}

$smarty->assign('subtemplate', $smarty->_tpl_vars['modul']);
$smarty->assign('rangok', $RANGOK);
$smarty->assign('lap_cime', $_SERVER['SCRIPT_NAME']);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('modipanel.tpl');
ob_end_flush();

?>
