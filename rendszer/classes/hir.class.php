<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class Hir extends baseModel {
	protected $table = 'hirek';
	protected $idName = 'hid';

	public static function createCache() {
		db::futat("SELECT hid AS id, cim, text, datum, disp FROM hirek ORDER BY datum DESC");
		$hirek = db::tomb();

		foreach($hirek as $key => $val) {
			$hirek[$key]['text'] = bb::bbdecode($val['text']);
		}
		
		return $hirek;
	}
}

?>
