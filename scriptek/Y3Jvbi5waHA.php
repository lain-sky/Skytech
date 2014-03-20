<?php

define('SZINT1',666);
define('CRON_BASEDIR','/web/sky-tech');
require_once( CRON_BASEDIR . '/rendszer/config.php');
require_once( CRON_BASEDIR . '/rendszer/cron.class.php');
require_once( CRON_BASEDIR . '/rendszer/user.class.php');
require_once( CRON_BASEDIR . '/rendszer/warn.class.php');

$cron= new cron();

echo 'OKS';
?>