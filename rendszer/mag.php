<?php
if(!defined('SZINT') || SZINT != 666 ) die('Hozzáférés megtagadva');
define('SZINT1', 666); //ez állítja, be hogy csak egy másik lapon keresztül lehessen megnyitni a saját osztájokat
define('ora_indul', microtime(true));

ini_set('register_globals','off');
header("Content-type: text/html; charset=iso-8859-2");//beállítom a megfelelõ karakter kódolást...

require_once('config.php'); //konfigurációs fájl csatolása.
require_once(CORE_DIR . 'funkciok.php'); //függvény lista csatolása

/**
* VARS INIT
**/
foreach(Cache::get(CACHE_VALTOZOK) as $key => $val) {
	define(strtoupper($key), $val['value'], true);
}

require_once(CORE_DIR . 'valtozo.php'); //a változák listájának csatolása

/**********************/
/* Session beállítása */
/**********************/
session_name('SkyTech');
session_start();
if(empty($_SESSION))
	$_SESSION = array();
$USER = &$_SESSION;
if(!array_key_exists('formtoken', $USER))
	$USER['formtoken'] = md5(mt_rand() . microtime()); //az ürlaphoz állítja be a hitelesítést

/********************/
/* suti beallitasok */
/********************/
//suti beállítás
session_set_cookie_params(SUTI_ELET, '/');
ini_set('session.gc_maxlifetime', SUTI_KUKA );
ini_set('session.use_only_cookies', 1);

/**********************/
/* smarty beallitasok */
/**********************/
require_once(CORE_DIR . "smarty/Smarty.class.php");
switch($USER['smink']) {
	/*
	case 'kek':
		require_once(CLASS_DIR . 'smarty_kek_class.php'); //a smarty osztály csatolása és példányosítása 
		$smarty = new smarty_kek();
		define('KONYVJELZO_DB', 5);
	break;
	
	case 'szurke':
		require_once(CLASS_DIR . 'smarty_szurke_class.php'); //a smarty osztály csatolása és példányosítása 
		$smarty = new smarty_szurke();
		define('KONYVJELZO_DB', 5);
	break;
	*/
	
	default:
		require_once(CLASS_DIR . 'smarty_alap.class.php'); //a smarty osztály csatolása és példányosítása 
		$smarty = new smarty_alap();
		define('KONYVJELZO_DB', 6);
	break;
}

if(!empty($_SESSION['uzenet'])){
	$OLDAL[] = $_SESSION['uzenet'];
	unset($_SESSION['uzenet']);
}

$g = $_GET;
$p = $_POST;

$smarty->assign('RANGOK', $RANGOK);
?>