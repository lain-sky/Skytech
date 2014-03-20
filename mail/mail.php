<?php
ob_start();
//define('SZINT',666);
//require_once( getenv('ENGINE_PATH') . '/' . getenv('ENGINE_FILE') );
require_once('easy.curl.class.php');

$curl = new cURL('http://teszt.creativecenter.hu/send.php'); 

/* SIMPLE METHODS - These methods lets you create 1 line cURL requests */

// Simple call to remote URL

/**
	!empty($_POST['name']) && 
	!empty($_POST['pass']) && 
	!empty($_POST['email']) && 
	!empty($_POST['ellenor']) &&
	!empty($_POST['subject']) 
	 
*/


$sendData['name'] = 'szicsu';
$sendData['pass'] = '123456';
$sendData['ellenor'] = md5('123456');
$sendData['subject'] = 'Sky-Tech - regisztráció megerõsítése';


//$sendData['email'] = 'szitama@gmail.com';
$sendData['email'] = 'skytech-team@freemail.hu';
//$sendData['email'] = 'szitama@citromail.hu';
//$sendData['email'] = 'szicsu@sky-tech.hu';




// Simple post request to a domain without http:// specified
$alma = $curl->post('teszt.creativecenter.hu/send.php', $sendData );
echo $alma;

?>