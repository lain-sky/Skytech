<?php 
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class KonyvJelzo {
	function addKonyv($tid) {
		db::futat("INSERT INTO torrent_konyv (tid, uid) VALUES('%d', '%d')", $tid, $GLOBALS['USER']['uid']);
		Cache::set(CACHE_KONYVJELZOK);
		return self::getKonyvLista();
	}

	function delKonyv($tid) {
		db::futat("DELETE FROM torrent_konyv WHERE uid = '%d' AND tid = '%d'", $GLOBALS['USER']['uid'], $tid);
		Cache::set(CACHE_KONYVJELZOK);
		return self::getKonyvLista();
	}

	function getKonyvLista($oldal = 0) {
		$data = Cache::get(CACHE_KONYVJELZOK);
		return $data[$oldal];
	}

	function setKonyvLista() {
		$sql = "SELECT k.tid, k.tkid, t.name FROM torrent_konyv k LEFT JOIN torrent t ON k.tid = t.tid WHERE k.uid = '%d' ORDER BY k.tkid";
		db::futat($sql, $GLOBALS['USER']['uid']);
		$tomb = db::tomb();
		if(count($tomb) < 1)
			return array(0 => '<div class="bookmark">Egy könyvjelzõd sincs <img src="kinezet/smilies/smile1.gif" alt="" class="smiley" border="0"></div>');
		else {
			$kesz = array();
			$item = '';
			foreach($tomb as $key => $val) {
				$item .= '<div class="bookmark">';
				$item .= '<a href="adatlap.php?id=' . $val['tid'] . '" title="Ugrás">';
				$item .= (strlen($val['name']) > 35) ? substr($val['name'], 0, 35) . "..." : $val['name'];
				$item .= '</a></div><div class="deletebookmark"><a href="' . $val['tid'] . '" class="pic" title="Törlés">';
				$item .= '<img border="0" src="kinezet/' . $GLOBALS['USER']['smink'] . '/bookmarks_del.png" alt=""/></a></div>' . "\n";

				$oldal = $key / KONYVJELZO_DB;
				if($key != 0 && is_int($oldal)) {
					$item .= self::konyvLapozo(count($kesz), count($tomb), KONYVJELZO_DB);
					$kesz[] = $item;
					$item = '';
				}
			}
			$item .= self::konyvLapozo(count($kesz), count($tomb), KONYVJELZO_DB);
			$kesz[] = $item;
			return $kesz;
		}
	}

	function konyvLapozo($old, $szum, $limit) {
		if($szum > $limit) {
			$oldalak = ceil($szum / $limit) - 1;
			$kesz = '<div id="bookmarkpager">';
			$kesz .= '<span id="crbookmarkpage">' . ($old + 1) . '. oldal</span>';
			$kesz .= '<a href="';
			$kesz .= (($old - 1) < 0) ? 0 : ($old - 1);
			$kesz .= '" class="pic" title="Elõzõ oldal">';
			$kesz .= '<img border="0" src="kinezet/' . $GLOBALS['USER']['smink'] . '/bookmarks_prev.png" alt="<"/></a>';
			$kesz .= '<img id="bookmarks_pager" border="0" src="kinezet/' . $GLOBALS['USER']['smink'] . '/bookmarks_pager.png" alt="-"/>';
			$kesz .= '<a href="';
			$kesz .= (($old + 1) > $oldalak) ? $oldalak : ($old + 1);
			$kesz .= '" class="pic" title="Következõ oldal">';
			$kesz .= '<img border="0" src="kinezet/' . $GLOBALS['USER']['smink'] . '/bookmarks_next.png" alt=">"/></a></div>';
			return $kesz;
		}
		else return '';
	 }
}

?>
