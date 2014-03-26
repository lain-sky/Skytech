<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

define('SYSTEM_OFF', false, true);

define('SQL_DEBUG', false, true); //kidobni
define('SQL_MAIL', true, true); //kidobni
define('JS_COMMPRES', false, true); //megcsinálni
define('DEBUG_MAIL', 'dave666.david@gmail.com', true); //kell egyáltalán??
define('LOAD_WIDTH', 550, true);

/*************************/
/* Adatbázis beállítások */
/*************************/
define('DB_USER','skytech', true); //az adatbázishoz kapcsolódáshoz használt felhasználói név
define('DB_PASS','qwertzuiop123456', true); //jelszó
define('DB_HOST','localhost', true); //a host ahová a mysql csatlakozik
define('DB_DATA','skytech', true); //az oldalhoz tartozó adatbázis neve

/************************/
/* könyvtár beállítások */
/************************/ 
define('ROOT_DIR', '', true);
define('WEBROOT_DIR', ROOT_DIR, true);
define('SABLON_DIR', ROOT_DIR . 'sablon/', true);
define('CORE_DIR', ROOT_DIR . 'rendszer/', true);
define('CLASS_DIR', CORE_DIR . 'classes/', true);
define('MAILER_DIR', CORE_DIR . 'phpmailer/', true);
define('CACHE_DIR', ROOT_DIR . 'cache/', true);
define('DB_CACHE_DIR', CACHE_DIR . 'db/', true);
define('SMARTY_COMPILE_DIR', CACHE_DIR . 'compile/', true);
define('JS_PRIVATE_DIR', ROOT_DIR . 'scriptek/', true);
define('JS_PUBLIC_DIR', WEBROOT_DIR . 'scriptek/', true);
define('TORRENT_PATH', ROOT_DIR . 'torrentek/', true);
define('LOGS_PATH', ROOT_DIR . 'logs/', true);


define('OLDAL_HIBA', '<b>Kedves felhasználónk!</b><br/><br/>Oldalunk jelenleg karbantartás alatt áll, kérünk nézz vissza késõbb!<br>Várható indulás 2009.11.30!<br>Megértéseteket köszönjük!<br/><br/><i>Sky-Tech Staff</i>', true);

/**
* CACHE
**/
define('CACHE_VALTOZOK', 1, true);
define('CACHE_HIREK', 2, true);
define('CACHE_INDEX_STATS', 3, true);
define('CACHE_AKTIV_USER', 4, true);
define('CACHE_AKTIV_SZAVAZAS', 5, true);
define('CACHE_DOKUMENTACIO', 6, true);
define('CACHE_KONYVJELZOK', 7, true);

$CACHE_CONFIG[CACHE_HIREK] = array(
	"type"      => "file", 
	"name"      => "hirek.cache",
	"serialize" => true,
	"create"    => array('Hir', 'createCache'),
);

$CACHE_CONFIG[CACHE_VALTOZOK] = array(
	"type"      => "file",
	"name"      => "valtozok.cache",
	"serialize" => true,
	"create"    => array('Vars', 'getByType'),
);

$CACHE_CONFIG[CACHE_INDEX_STATS] = array(
	"type"      => "file",
	"name"      => "index_stats.cache",
	"serialize" => true,
	"create"    => array('Stats', 'indexStats'),
	"time"      => 1000
);

$CACHE_CONFIG[CACHE_AKTIV_USER] = array(
	"type"      => "file",
	"name"      => "aktiv_users_stats.cache",
	"serialize" => true,
	"create"    => array('Stats', 'aktivUsers'),
	"time"      => 300
);

$CACHE_CONFIG[CACHE_AKTIV_SZAVAZAS] = array(
	"type"      => "file",
	"name"      => "aktiv_szavazas.cache",
	"serialize" => false,
	"create"    => array('Szavazas', 'getDataById'),
);

$CACHE_CONFIG[CACHE_DOKUMENTACIO] = array(
	"type"      => "file",
	"name"      => "dok.cache",
	"serialize" => true,
	"create"    => array('Doc', 'createCache'),
);

$CACHE_CONFIG[CACHE_KONYVJELZOK] = array(
	"type"      => "session",
	"name"      => "konyvjelzo",
	"serialize" => false,
	"create"    => array('KonyvJelzo', 'setKonyvLista'),
);

/**
	AutoLoad
**/
function __autoload($className) {
	$classFile = strtolower($className) . '.class.php';
	$classPath = CLASS_DIR . $classFile;
	if(is_readable($classPath)) {
		require_once($classPath);
	}
}
?>