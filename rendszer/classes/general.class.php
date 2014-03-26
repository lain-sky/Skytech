<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class general {
	private $s;
	private $template;
	private $tartalom;

	function __construct($type) {
		$this->s = new smarty_alap();

		switch($type) {
			case 'gyik':
				$this->s->assign('fejlec_elotag', 'GY.I.K');
				$this->template = "dokumentacio.tpl";
				$this->s->assign('nofejlec', 'nofejlec');

				$this->hir_get($type);
				$this->generateHtml();

				$fajlnev = $type . ".html";
				$this->saveHtml($fajlnev); 
			break;

			case 'szab':
				$this->s->assign('fejlec_elotag', 'Szabályzat');
				$this->template = "dokumentacio.tpl";
				$this->s->assign('nofejlec', 'nofejlec');

				$this->hir_get($type);
				$this->generateHtml();

				$fajlnev = $type . ".html";
				$this->saveHtml($fajlnev);
			break;

			case 'jogi':
				$this->s->assign('fejlec_elotag', 'Jogi nyilatkozat');
				$this->template = "dokument.tpl";
				$this->s->assign('nofejlec', 'nofejlec');
				$this->s->assign("modul", 'jogi');

				db::futat("SELECT cid, cim, text FROM cikk WHERE mihez = 'jogi' ORDER BY suly, cim");
				$t = db::elso_sor();
				$kesz['cim'] = $t['cim'];
				$kesz['cid'] = $t['cid'];
				$kesz['text'] = explode('##kep##', bb::bbdecode($t['text']);

				$this->s->assign('lista',$kesz);
				$this->generateHtml();

				$fajlnev = $type . ".html";
				$this->saveHtml($fajlnev);
			break;

			default:
				return;
			break;
		}
	}
	
	private function hir_get($type) {
		$sql = "SELECT cid, cim, text, mod_date AS datum, name FROM cikk c LEFT JOIN users u ON c.mod_user = u.uid WHERE mihez = '%s' ORDER BY suly, cim";
		db::futat($sql, $type);
		$tomb = db::tomb();

		foreach($tomb as $key => $val){
			$tomb[$key]['text'] = bb::bbdecode($val['text']);
		}
		$this->s->assign('lista', $tomb);
	}

	private function generateHtml() {
		$tt = $this->s->fetch($this->template);
		$this->tartalom = $tt;
	}

	private function saveHtml($fajlnev) {
		if(!file_exists($fajlnev))
			touch($fajlnev);
		$fajl = fopen($fajlnev, "w");
		flock($fajl, 2);
		fwrite($fajl, $this->tartalom);
		flock($fajl, 3);
		fclose($fajl);
	}
}

?>
