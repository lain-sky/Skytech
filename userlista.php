<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


header('cache-control: no-cache');
header('Content-type: text/xml; charset=iso-8859-2');
$mit = $p['value'];
db::futat("SELECT uid, name FROM users WHERE statusz = 'aktiv' AND name LIKE '" . $mit . "%' ORDER BY name");
$tomb = db::tomb();

echo '<' . chr(63) . 'xml version="1.0" encoding="ISO-8859-2" ' . chr(63) . '>';
echo "<ajaxresponse>\n";
foreach($tomb as $elem) {
	echo "<item>\n";
	echo "<text>" . $elem['name'] . "</text>\n";
	echo "<value>" . $elem['name'] . "</value>\n";
	echo "</item>\n";
}
echo "</ajaxresponse>\n";

ob_end_flush();

?>
