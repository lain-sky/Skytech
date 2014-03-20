<?php
ob_start();
define('SZINT',666);
require_once('../rendszer/mag.php');
$belep=new belep(); // user belépés chek
$old=new old(); //oldalelemek betöltése

header("cache-control: no-cache");
header("Content-type: text/xml; charset=iso-8859-2");
$mit=$_POST['value'];
db::futat("select uid,name from users where statusz='aktiv' and name like '".$mit."%' order by name");
$tomb=db::tomb();

echo '<'.chr(63).'xml version="1.0" encoding="ISO-8859-2" '.chr(63).'>';
echo "<ajaxresponse>\n";
	foreach($tomb as $elem){
		echo "<item>\n";
		echo "<text>".$elem['name']."</text>\n";
		echo "<value>".$elem['name']."</value>\n";		
		echo "</item>\n";
	}
echo "</ajaxresponse>\n";

ob_end_flush ();
?>