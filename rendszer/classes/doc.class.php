<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class Doc extends baseModel {
	protected $table = 'cikk';
	protected $idName = 'cid';

	static function createCache() {
		$data = array();
		foreach(array('gyik', 'szab', 'link') AS $item) {
			db::futat("SELECT cid, cim, text, mod_date AS datum, name FROM cikk c LEFT JOIN users u ON c.mod_user = u.uid WHERE mihez = '%s' ORDER BY suly, cim", $item);
			$tomb = db::tomb();
			foreach($tomb as $key => $val) {
				$tomb[$key]['text'] = bb::bbdecode($val['text']);
			}
			$data[$item] = $tomb;
		}

		return $data;
	}
}

?>
