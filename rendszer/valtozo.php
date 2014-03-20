<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság


/***********************/
/* Smarty beállítások  */
/***********************/


define('SMARTY_DEF_TEMPLATE_DIR', SABLON_DIR . 'alap/'); //a smarty template_dir elérése

define('SMARTY_CACHE',false); //smarty cache lése false/true
define('SMARTY_CACHE_TIME','10'); //smarty cache idõ
define('SMARTY_DEBUG',false); //smarty debug false/true


/******************************/
/* Oldal adatainak beállítása */
/******************************/



define('Oldal_verzio', '1.3' ,true);
define('Oldal_fejlec','..::'.OLDAL_NEVE.'-'.OLDAL_JELMONDAT.'::..');
define('OLDAL_COPY', 'Copyright &copy; '.date('Y').' '.OLDAL_NEVE,true);
define('Oldal_nyelve','hu');
define('Oldal_lablec_text',OLDAL_NEVE.' Frontend v'.OLDAL_VERZIO.' '.OLDAL_COPY,true);

define('TORRENT_TRACKER',Oldal_cime."/tracker.php");


define('MAX_TORRENT_SIZE',1000000); 



define('Suti_elet',28800); //a suti életét állítjuk be (60*60*8)=28800sec=> 8h
define('Suti_kuka',(Suti_elet+600)); //a suti ennyi idõ mulva szemétnek minõsül és törli a rendszer.....



/*****************/
/* Hiba szovegek */
/*****************/

define('HIBAS_NEV','A megadott felhasználói név jelszó páros nem létezik!');
define('HIBAS_JELSZO','A megadott felhasználói név jelszó páros nem létezik!');
define('HIBA_NO_ID','Kérlek jelentkezz be!');
define('HIBA_TIMEOUT','A rendszer tétlenség miatt kiléptetet!');
define('HIBA_UJRA','Az újraellenõrzés nem sikerült lépj be újra');
define('HIBA_MEGEROSITETLEN','A felhasználói fiókod még megerõsítetlen!');
define('HIBA_NINCS_STATUS','A felhasználói fiókod megsérült!!');
define('HIBA_TOROLT_USER','A felhasználói fiókod törlõdött!!');

define('SQL_QUERY_LOG', false );
define('BELEP_HIBA_NAPI_LIMIT',7);

define('HIR_ADMIN_MIN_RANG', 9);
define('SZAVAZAS_ADMIN_MIN_RANG',9);
define('FORUM_ADMIN_MIN_RANG',8);
define('DOKUMENTUM_ADMIN_MIN_RANG',8);
define( 'TORRENET_ADMIN_MIN_RANG', 8);
define( 'TORRENET_ADMIN_HSZ_MIN_RANG', 8);
define( 'USER_ADMIN_IN_USERINFO', 8);
define( 'USER_EMAIL_NO_HIDDEN_MIN_RANG',9);
define( 'STAFF_MAIL_MIN_RANG',8);

define( 'KERESEK_ADMIN_MIN_RANG',8);




define('SECTION_COOKIE','skysection');
define('INFOPANEL_COOKIE','skyinfopanel');


/*********************************/
/* az oldal változóit tartalmazza*/
/*********************************/
  
$theme='alap'; // az alapértelmezett smink
define('MB', (1024 * 1024) );
define('GB', (1024 * MB)   );

$RANGOK=array(
        '1'   =>  'Újonc',
        '2'   =>  'Leecher',
        '3'   =>  'Felhasználó',
        '4'   =>  'Tag',
        '5'   =>  'ViP',
        '6'   =>  'Helpdesk',
        '7'   =>  '<font color="#6a97da">Feltöltõ</font>',
        '8'   =>  'Moderátor',
        '9'   =>  'Adminisztrátor',
        '10'  =>  'Tulajdonos'
);

$STATUSZOK = array(
        'uj' => 'Új',
        'aktiv' => 'Aktív',
        'passziv' => 'Passzív',
        'torolt' => 'Törölt'
);

$DOKUMNETUM_TIPUSOK=array(
        
        'bbhelp' => 'BB code help',
        'felt' => 'Feltöltés',
        'gyik' => 'GY.I.K',
        'helpd' => 'Helpdesk',
        'jogi' => 'Jogi nyilatkozat',
        'link' => 'Linkek',
        'meghivo' => 'Meghívó',
        'szab' => 'Szabályzat',
        'uzifal' => 'Üzenöfal'
);

$PONT_EVENTS[0]=array('name'=>'Bejelentkezés','value'=>1);

$PONT_EVENTS[1]=array('name'=>'Feltöltés( 500MB - 1GB )','value'=>1);
$PONT_EVENTS[2]=array('name'=>'Feltöltés( 1GB - 3GB )','value'=>2);
$PONT_EVENTS[3]=array('name'=>'Feltöltés( 3GB felett  )','value'=>3);



$PONT_EVENTS[10]=array('name'=>'Torrent feltöltés(  200MB alatt )','value'=>1);
$PONT_EVENTS[11]=array('name'=>'Torrent feltöltés( 200-800MB )','value'=>2);
$PONT_EVENTS[12]=array('name'=>'Torrent feltöltés( 800MB felett )','value'=>3);


$PONT_EVENTS[20]=array('name'=>'Sky-Tech pontjutalom','value'=>10);
$PONT_EVENTS[21]=array('name'=>'Sky-Tech pontjutalom ( közepes )','value'=>50);
$PONT_EVENTS[22]=array('name'=>'Sky-Tech pontjutalom ( nagy )','value'=>100);

$PONT_EVENTS[30]=array('name'=>'Figyelmeztetés ( warn )','value'=> -20 );
$PONT_EVENTS[31]=array('name'=>'Ideiglenes kitiltás ( ban )','value'=> -50 );

$PONT_EVENTS[40]=array('name'=>'Torrent kérése ','value'=> -5 );
$PONT_EVENTS[41]=array('name'=>'Torrent kéréshez csatlakozás ','value'=> 0 );
$PONT_EVENTS[42]=array('name'=>'Torrent teljesítése ','value'=> 0 );







$PONT_EVENTS[666]=array('name'=>'Rendszer tesztelésre ','value'=> 100 );





/*
$RANGOK=array(
        '1'   =>  'Honvéd',
        '2'   =>  'Tizedes',
        '3'   =>  'Õrmester',
        '4'   =>  'Fõtörzsõrmester',
        '5'   =>  'Zászlós',
        '6'   =>  'Hadnagy',
        '7'   =>  'Százados',
        '8'   =>  'Õrnagy',
        '9'   =>  'Ezredes',
        '10'  =>  'Tábornagy'
);
*/

$OS_TIPUSOK=array(
        
        2=>'Windows XP',
        3=>'Windows 98',
        4=>'Windows 2000',
        5=>'Windows 2003 server',
        6=>'Windows Vista',
        7=>'Windows NT',
        8=>'Windows ME',
        9=>'Windows CE',
        10=>'Windows ME',
        11=>'Mac OS X',
        12=>'Macintosh',
        13=>'Linux',
        14=>'Free BSD',
        15=>'Symbian',
        16=>'Egyéb'     
);

$BONGESZO_TIPUSOK=array(
        
        1 => 'Mozilla Firefox',
        2 => 'Netscape',
        3 => 'Safari',
        4 => 'Galeon',
        5 => 'Konqueror',
        6 => 'Gecko based',
        7 => 'Opera',
        8 => 'Lynx',
        9 => 'Netscape',
        10 => 'Egyéb',
        11 => 'Internet Explorer'
);

$NO_LOGS_FILE=array('letolt_admin.php','level.php','userlista.php','modimanel.php','chat_admin.php');



$filetypes = array(
        'ace'  =>  'ACE archívum',
        'arj'  =>  'ARJ archívum',
        'tar'  =>  'Tape Archive',
        'bz'  =>  'Bzip archívum',
        'zip'  =>  'ZIP archívum',
        'rar'  =>  'RAR archívum',
        '7z'  =>  '7-zip archívum',
        'uha'  =>  'UHA archívum',
        'wav'  =>  'Hanghullám',
        'mp3'  =>  'Mpeg Layer-3',
        'ape'  =>  "Monkey's Audio",
        'flac'  =>  'FLAC audio',
        'ogg'  =>  'OGG Vorbis audio',
        'avi'  =>  'Audio Video Interleave',
        'wmv'  =>  'Windows Media Video',
        'qt'  =>  'QuickTime video',
        'mpg'  =>  'MPEG video',
        'mpeg'  =>  'MPEG video',
        'mkv'  =>  'Matroska Video Stream',
        'ts'  =>  'Transport Stream MPEG-2 video',
        '3gp'  =>  '3GPP Multimedia fájl',
        'bmp'  =>  'Bittérkép',
        'jpg'  =>  'JPEG/JIFF kép',
        'jpeg'  =>  'JPEG/JIFF kép',
        'jpe'  =>  'JPEG/JIFF kép',
        'gif'  =>  'GIF kép',
        'png'  =>  'PNG kép',
        'tiff'  =>  'TIFF kép',
        'psd'  =>  'PhotoShop kép',
        'wmf'  =>  'Windows Metafile',
        'psp'  =>  'Paint Shop Pro kép',
        'txt'  =>  'Szöveges fájl',
        'rtf'  =>  'Rich Text fájl',
        'doc'  =>  'Word dokumentum',
        'xls'  =>  'Excel dokumentum',
        'db'  =>  'Adatbázis fájl',
        'ppt'  =>  'PowerPoint prezentáció',
        'pps'  =>  'PowerPoint vetítés',
        'ini'  =>  'Konfigurációs beállítások',
        'inf'  =>  'Telepítési információk',
        'lnk'  =>  'Parancsikon',
        'exe'  =>  'Programfájl',
        'dll'  =>  'Dinamic Link Library',
        'sys'  =>  'Rendszerfájl',
        'vxd'  =>  'Virtuális illesztõprogram',
        'hlp'  =>  'Súgófájl',
        'chm'  =>  'HTML súgófájl',
        'dat'  =>  'Adatfájl',
        'iso'  =>  'ISO lemezkép',
        'mds'  =>  'Media Descriptor',
        'mdf'  =>  'Alcohol 120% lemezkép',
        'bin'  =>  'Bináris adatfolyam',
        'cue'  =>  'Lemezkép fájl',
        'nrg'  =>  'Nero lemezkép',
        'bws'  =>  'BlindWrite lemezkép',
        'bwt'  =>  'BlindWrite lemezkép',
        'bwi'  =>  'BlindWrite lemezkép',
        'm3u'  =>  'm3u lejátszólista',
        'pls'  =>  'pls lejátszólista',
        'bat'  =>  'Windows 9x kötegfájl',
        'cmd'  =>  'Windows NT kötegfájl',
        'js'  =>  'JavaScript fájl',
        'jar'  =>  'Java archívum',
        'pdf'  =>  'Adobe PDF dokumentum',
        'cab'  =>  'CAB archívum',
        'bik'  =>  'Bink video',
        'vob'  =>  'DVD video',
        'ifo'  =>  'DVD Info fájl',
        'sfv'  =>  'Checksum fájl',
        'nfo'  =>  'Információs fájl',
        'ccd'  =>  'CloneCD lemezkép',
        'img'  =>  'CloneCD lemezkép',
        'sub'  =>  'CloneCD lemezkép'
);

$ORSZAGTOMB=array('Nincs adat','Afganisztán' ,'Albánia' ,'Algéria' ,'Andorra' ,'Angola' ,'Antigua és Barbuda' ,'Arab Emírségek' ,'Argentína' ,'Ausztrália' ,'Ausztria' ,'Azerbajdzsán' ,'Bahama-szigetek' ,'Bahrein' ,'Banglades' ,'Barbados' ,'Belgium' ,'Belize' ,'Benin' ,'Bhután' ,'Bissau-Guinea' ,'Bolívia' ,'Bosznia-Herc.' ,'Botswana' ,'Brazília' ,'Brunei' ,'Bulgária' ,'Burkina Faso' ,'Burundi' ,'Chile' ,'Ciprus' ,'Comore-szigetek' ,'Costa Rica' ,'Csád' ,'Csehország' ,'Dánia' ,'Dél-Afrikai Közt.' ,'Dominikai Közösség' ,'Dominikai Közt.' ,'Dzsibuti' ,'Ecuador' ,'Egyenlítoi Guinea' ,'Egyiptom' ,'Elefántcsontpart' ,'Eritrea' ,'Észtország' ,'Etiópia' ,'Fehéroroszo.' ,'Fidzsi-szigetek' ,'Finnország' ,'Franciaország' ,'Fülöp-szigetek' ,'Gabon' ,'Gambia' ,'Ghána' ,'Görögország' ,'Grenada' ,'Grúzia' ,'Guatemala' ,'Guinea' ,'Guyana' ,'Haiti' ,'Hollandia' ,'Honduras' ,'Horvátország' ,'India' ,'Indonézia' ,'Irak' ,'Irán' ,'Írország' ,'Izland' ,'Izrael' ,'Jamaica' ,'Japán' ,'Jemen' ,'Jordánia' ,'Jugoszlávia' ,'Kambodzsa' ,'Kamerun' ,'Kanada' ,'Katar' ,'Kazahsztán' ,'Kenya' ,'Kína' ,'Kirgizisztán' ,'Kiribati' ,'Kolumbia' ,'Kongó' ,'Korea' ,'Koreai NDK' ,'Közép-Afrikai Közt.' ,'Kuba' ,'Kuvait' ,'Laosz' ,'Lengyelország' ,'Lesotho' ,'Lettország' ,'Libanon' ,'Libéria' ,'Líbia' ,'Liechteinstein' ,'Litvánia' ,'Luxemburg' ,'Macedónia' ,'Madagaszkár' ,'Magyarország' ,'Malajzia' ,'Malawi' ,'Maldív-szigetek' ,'Mali' ,'Málta' ,'Marokkó' ,'Marshall-szigetek' ,'Mauritánia' ,'Mauritius' ,'Mexikó' ,'Mianmar' ,'Mikronézia' ,'Moldova' ,'Monaco' ,'Mongólia' ,'Mozambik' ,'Nagy-Britannia' ,'Namíbia' ,'Nauru' ,'Németország' ,'Nepál' ,'Nicaragua' ,'Niger' ,'Nigeréa' ,'Norvégia' ,'Nyugat-Szahara' ,'Olaszország' ,'Omán' ,'Oroszország' ,'Örményország' ,'Pakisztán' ,'Palau' ,'Panama' ,'Pápua Új-Guinea' ,'Paraguay' ,'Peru' ,'Portugália' ,'Románia' ,'Ruanda' ,'Saint Kitts és Nevis' ,'Saint Lucia' ,'Saint Vicent' ,'Salamon-szigetek' ,'Salvador' ,'San Marino' ,'Sao Tomé & Principe' ,'Seychelle-szk.' ,'Sierra Leone' ,'Spanyolország' ,'Sri Lanka' ,'Suriname' ,'Svájc' ,'Svédország' ,'Szamoa' ,'Szaúd-Arábia' ,'Szenegál' ,'Szerbia' ,'Szingapur' ,'Szíria' ,'Szlovákia' ,'Szlovénia' ,'Szomália' ,'Szudán' ,'Szváziföld' ,'Tádzsikisztán' ,'Tanzánia' ,'Thaiföld' ,'Togo' ,'Tonga' ,'Törökország' ,'Trinidad és Tobago' ,'Tunézia' ,'Tuvalu' ,'Türkmenisztán' ,'Uganda' ,'Új-Zéland' ,'Ukrajna' ,'Uruguay' ,'Usa' ,'Üzbegisztán' ,'Vanatu' ,'Vatikán' ,'Venezuela' ,'Vietnam' ,'Zaire' ,'Zambia' ,'Zimbabwe' ,'Zöld-foki Közt.');


$OLDAL=array();
$MENU=array();

/************/
/* Tiltások */
/************/



$tiltott_email = array(
                'sky-tech@gmail.com',
                'info@sky-tech.hu',
                'highpowersystem@gmail.com',
                'waserver@gmail.com'
                
);

$tiltott_nev= array(
                'God',
                'Saddam',
                'BinLaden',
                'Hitler',
                'darkboss',
                'darkboss555',
                'kiki',
                'Zedi'
);



/*********/
/* Menu */
/********/


$MENU_bal=array(
        array(
                "olvas"=>"<span class='menu'>Fõoldal</span>",
                "cim"=>"index.php",
                "class"=>"fooldal"
        ),
        array(
                "olvas"=>"<span class='menu'>Letöltés</span>",
                "cim"=>"letolt.php",
                "class"=>"letoltes"
        ),
        array(
                "olvas"=>"<span class='menu'>Feltöltés</span>",
                "cim"=>"feltolt.php",
                "class"=>"feltoltes"
        ),
        array(
                "olvas"=>"<span class='menu'>Kérések</span>",
                "cim"=>"keresek.php",
                "class"=>"keresek"
        ),
        array(
                "olvas"=>"<span class='highlight'>Szabályzat</span>",
                "cim"=>"dokumentacio.php?mit=szab",
                "class"=>"szabalyzat"
        ),
        array(
                "olvas"=>"<span class='highlight'>GY.I.K</span>",
                "cim"=>"dokumentacio.php?mit=gyik",
                "class"=>"gyik"
        ),
        array(
                "olvas"=>"<span class='menu'>Fórum</span>",
                "cim"=>"forum.php",
                "class"=>"forum"
        ),
        array(
                "olvas"=>"<span class='menu'>Staff</span>",
                "cim"=>"staff.php",
                "class"=>"staff"
        ),
);



$MENU_job=array(
        array(
                "olvas"=>"Admin",
                "cim"=>"skytech.php",
                "class"=>"staff"
        ),
        array(
                "olvas"=>"Kilép",
                "cim"=>"belep.php?logout=true",
                "class"=>"kilep"
        ),

);


/***********/
/* Sminkek */
/***********/



//a tömbben vannak a sminkek az olv -hoz  amegjelenõ szöveg kell az ert-hez a konyvtár neve 

$sminkek_tomb=array(

        array('olv'=>'Barna','ert'=>'alap'),
        //array('olv'=>'Kék','ert'=>'kek'),
        //array('olv'=>'Szürke','ert'=>'szurke')

);



?>
