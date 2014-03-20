<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

class smarty_alap extends Smarty{

 	
	public function __construct(){		
		parent::Smarty();
		
		$this->template_dir = SABLON_DIR . "alap/" ;
		$this->compile_dir = SMARTY_COMPILE_DIR . "alap/";
		
		$this->debugging = SMARTY_DEBUG; //hibakereséshez
		$this->cache=SMARTY_CACHE;	//a cache engedélyezése
		$this->cache_lifetime=SMARTY_CACHE_TIME; //a cache idõ beállítása
		//$this->security=true;
		
		
		
		
		$this->register_modifier('section_end','section_end');
		$this->register_modifier('section_open','section_open');
		$this->register_modifier('b_to_s','bytes_to_string');
		$this->register_modifier('t_to_s','time_to_string');
		$this->register_modifier('aranyszin','aranyszin');
		$this->register_modifier('hiba_uzi','hiba_uzi');
		$this->register_modifier('nyugta','nyugta');
		$this->register_modifier('d','d');
	}	
}


?>