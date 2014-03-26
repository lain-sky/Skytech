<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class forumTema extends baseModel {
	protected $table = 'forum_csoport';
	protected $idName = 'fid';

	function getChilden($id) {
		$sql = "SELECT tid AS id FROM forum_topik  WHERE " . $this->idName . " = '%d'";
		return db::getAll($sql, $id);
	}
}

?>
