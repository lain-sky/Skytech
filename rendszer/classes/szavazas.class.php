<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class Szavazas extends baseModel {
	protected $table = 'szavazas';
	protected $idName = 'szid';

	function getAll() {
		global $old;

		$szavazasok = array();
		$sql = "SELECT szid, cim, datum FROM szavazas ORDER BY szid DESC";

		foreach(db::getAll($sql) as $i => $elem) {
			$szavazasok[$i]['id'] = $elem['szid'];
			$szavazasok[$i]['cim'] = $elem['cim'];
			$szavazasok[$i]['datum'] = $elem['datum'];
			$szavazasok[$i]['text'] = self::getDataById($elem['szid']);
		}
		return $szavazasok;
	}

	static function getDataById($mit) {
		db::futat("SELECT text, COUNT(sza.uid) AS db FROM szavazas_elem sze LEFT JOIN szavazatok sza ON sze.sze_id = sza.sze_id WHERE sze.szid = '%d' GROUP BY sze.sze_id ORDER BY sze.sze_id", $mit);
		$tomb = db::tomb();

		$sql = "SELECT COUNT(*) AS ez FROM szavazatok WHERE szid = '%d'";
		db::futat($sql, $mit);
		$osszes = db::egy_ertek();

		//tartalom összeállítása
		$tt = "\n";
		foreach($tomb as $elem) {
			$arany = ($elem['db'] == 0) ? 0 : ($elem['db'] / $osszes);
			$tt .= '<div class="bar_rect">' . "\n";
			$tt .= '<div class="option_text">' . $elem['text'] . '</div>';
			$tt .= '<div class="option_bar" style="width:' . round(($arany * 420) + 4) . 'px;"></div>';
			$tt .= '<div class="option_votes">&nbsp;' . $elem['db'] . ' szav. (' . round(($arany * 100), 1) . '%)</div>';
			$tt .= '</div>';
		}
		$tt .= '<br><p>Összesen <span class="highlight">' . $osszes . '</span> szavazat érkezett';
		return $tt;
	}
}

?>
