<?php
ob_start();
define('SZINT', 666);
require_once('rendszer/mag.php');
$belep = new belep();
$old = new old();


db::futat("SELECT cim, text, cid FROM cikk WHERE cid = '15'");
$segedlet = array();
foreach(db::elso_sor() as $key => $val) {
	$segedlet[$key] = ($key == 'text') ? bb::bbdecode($val) : $val;
}

$sql = "SELECT (SELECT h.text FROM helpdesk h WHERE h.uid = u.uid) AS text, u.name, u.uid FROM users u WHERE rang = 6";
db::futat($sql);
$tomb = db::tomb();

if($USER['rang'] > 8) {
	$smarty->assign('adminpanel', true);

	if(!empty($p)) {
		if(is_array($p['idk']) && is_array($p['text']) && count($p['text']) == count($p['idk'])) {
			db::futat("TRUNCATE TABLE helpdesk");
			foreach($p['idk'] as $id) {
				$sql = "INSERT INTO helpdesk (uid, text) VALUES ('%d', '%s')";
				db::futat($sql, $id, $p['text'][$id]);
			}
			$_SESSION['uzenet'] = nyugta('A módosítások mentve');
			header('Location:helpdesk.php');
			exit;
		}
	}
	if(!empty($g['mod']) && $g['mod'] == 'igen')
		$smarty->assign('formba', true);
}

$smarty->assign('helpduser', $tomb);
$smarty->assign('helpd', $segedlet);
$smarty->assign('OLDAL', $OLDAL);
$smarty->display('helpdesk.tpl');
ob_end_flush();

?>
