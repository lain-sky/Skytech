<?php
class Browser_Detection {
	function get_browser($useragent) {
		if(strpos($useragent, "MSIE") !== false && strpos($useragent, "Opera") === false && strpos($useragent, "Netscape") === false) {
			$found = preg_match("/MSIE ([0-9]{1}\.[0-9]{1,2})/", $useragent, $mathes);
			if($found)
				return array('tip' => 11, 'ver' => $mathes[1]);
		} elseif(strpos($useragent, "Gecko")) {
			$found = preg_match("/Firefox\/([0-9]{1}\.[0-9]{1}\.[0-9]{1}(\.[0-9]{2})?)/", $useragent, $mathes);
			if($found)
				return array('tip' => 1, 'ver' => $mathes[1]);

			$found = preg_match("/Netscape\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/", $useragent, $mathes);
			if($found)
				return array('tip' => 2, 'ver' => $mathes[1]);

			$found = preg_match("/Safari\/([0-9]{2,3}(\.[0-9])?)/", $useragent, $mathes);
			if($found)
				return array('tip' => 3, 'ver' => $mathes[1]);

			$found = preg_match("/Galeon\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/", $useragent, $mathes);
			if($found)
				return array('tip' => 4, 'ver' => $mathes[1]);

			$found = preg_match("/Konqueror\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/", $useragent, $mathes);
			if($found)
				return array('tip' => 5, 'ver' => $mathes[1]);

			return array('tip' => 6, 'ver' => '0');			
		} elseif(strpos($useragent, "Opera") !== false) {
			$found = preg_match("/Opera[\/ ]([0-9]{1}\.[0-9]{1}([0-9])?)/", $useragent, $mathes);
			if($found)
				return array('tip' => 7, 'ver' => $mathes[1]);
		} elseif(strpos($useragent, "Lynx") !== false) {
			$found = preg_match("/Lynx\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/", $useragent, $mathes);
			if($found)
				return array('tip' => 8, 'ver' => $mathes[1]);
		} elseif(strpos($useragent, "Netscape") !== false) {
			$found = preg_match("/Netscape\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/", $useragent, $mathes);
			if($found)
				return array('tip' => 9, 'ver' => $mathes[1]);
		} else {
			return array('tip' => 10, 'ver' => '0');
		}
	}

	function get_os($useragent) {		
		$useragent = strtolower($useragent);

		if(strpos("$useragent", "windows nt 6.1") !== false)
			return 1;		
		if(strpos("$useragent", "windows nt 5.1") !== false)
			return 2;
		elseif(strpos("$useragent", "windows 98") !== false)
			return 3;
		elseif(strpos("$useragent", "windows nt 5.0") !== false)
			return 4;
		elseif(strpos("$useragent", "windows nt 5.2") !== false)
			return 5;
		elseif (strpos("$useragent", "windows nt 6.0") !== false)
			return 6;
		elseif (strpos("$useragent", "windows nt") !== false)
			return 7;
		elseif (strpos("$useragent", "win 9x 4.90") !== false && strpos("$useragent","win me"))
			return 8;
		elseif (strpos("$useragent", "win ce") !== false)
			return 9;
		elseif (strpos("$useragent", "win 9x 4.90") !== false)
			return 10;
		elseif (strpos("$useragent", "mac os x") !== false)
			return 11;
		elseif (strpos("$useragent", "macintosh") !== false)
			return 12;
		elseif (strpos("$useragent", "linux") !== false)
			return 13;
		elseif (strpos("$useragent", "freebsd") !== false)
			return 14;
		elseif (strpos("$useragent", "symbian") !== false)
			return 15;
		else 
			return 16;
	}
}

?>
