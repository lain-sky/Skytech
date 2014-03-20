<?php
class Browser_Detection{
	 
	function get_browser($useragent){
		
		if(strpos($useragent,"MSIE") !== false && strpos($useragent,"Opera") === false && strpos($useragent,"Netscape") === false)
		{
			//deal with IE
			$found = preg_match("/MSIE ([0-9]{1}\.[0-9]{1,2})/",$useragent,$mathes);
			if($found){
				//return "Internet Explorer " . $mathes[1];
				return array( 'tip'=>11,'ver'=>$mathes[1]);
			}
		}
		elseif(strpos($useragent,"Gecko"))
		{
			//deal with Gecko based
			
			//if firefox
			$found = preg_match("/Firefox\/([0-9]{1}\.[0-9]{1}\.[0-9]{1}(\.[0-9]{2})?)/",$useragent,$mathes);
			if($found)
			{
				//return "Mozilla Firefox " . $mathes[1];
				return array( 'tip'=>1,'ver'=>$mathes[1]);
			}
			
			//if Netscape (based on gecko)
			$found = preg_match("/Netscape\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$useragent,$mathes);
			if($found)
			{
				//return "Netscape " . $mathes[1];
				return array( 'tip'=>2,'ver'=>$mathes[1]);
			}
			
			//if Safari (based on gecko)
			$found = preg_match("/Safari\/([0-9]{2,3}(\.[0-9])?)/",$useragent,$mathes);
			if($found)
			{
				//return "Safari " . $mathes[1];
				return array( 'tip'=>3,'ver'=>$mathes[1]);
			}
			
			//if Galeon (based on gecko)
			$found = preg_match("/Galeon\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$useragent,$mathes);
			if($found)
			{
				//return "Galeon " . $mathes[1];
				return array( 'tip'=>4,'ver'=>$mathes[1]);
			}
			
			//if Konqueror (based on gecko)
			$found = preg_match("/Konqueror\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$useragent,$mathes);
			if($found)
			{
				//return "Konqueror " . $mathes[1];
				return array( 'tip'=>5,'ver'=>$mathes[1]);
			}		

			//no specific Gecko found
			//return generic Gecko
			//return "Gecko based";
			return array( 'tip'=>6,'ver'=>'0');			
		}
		
		elseif(strpos($useragent,"Opera") !== false)
		{
			//deal with Opera
			$found = preg_match("/Opera[\/ ]([0-9]{1}\.[0-9]{1}([0-9])?)/",$useragent,$mathes);
			if($found)
			{
				//return "Opera " . $mathes[1];
				return array( 'tip'=>7,'ver'=>$mathes[1]);
			}
		}
		elseif (strpos($useragent,"Lynx") !== false)
		{
			//deal with Lynx			
			$found = preg_match("/Lynx\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$useragent,$mathes);
			if($found)
			{
				//return "Lynx " . $mathes[1];
				return array( 'tip'=>8,'ver'=>$mathes[1]);
			}
			
		}
		elseif (strpos($useragent,"Netscape") !== false)
		{
			//NN8 with IE string
			$found = preg_match("/Netscape\/([0-9]{1}\.[0-9]{1}(\.[0-9])?)/",$useragent,$mathes);
			if($found)
			{
				//return "Netscape " . $mathes[1];
				return array( 'tip'=>9,'ver'=>$mathes[1]);
			}
		}
		else 
		{
			//unrecognized, this should be less than 1% of browsers (not counting bots like google etc)!
			//return false;
			return array( 'tip'=>10,'ver'=>'0');
		}
	}
	
	/**
	 * Get browsername and version
	 * @param string user agent	 
	 * @return string os name and version or false in unrecognized os
	 * @static 
	 * @access public
	 */
	function get_os($useragent)
	{		
		$useragent = strtolower($useragent);
		
		//check for (aaargh) most popular first		
		//winxp
		if(strpos("$useragent","windows nt 5.1") !== false)
		{
			return 2;//"Windows XP";			
		}
		elseif (strpos("$useragent","windows 98") !== false)
		{
			return 3;//"Windows 98";
		}
		elseif (strpos("$useragent","windows nt 5.0") !== false)
		{
			return 4;//"Windows 2000";
		}
		elseif (strpos("$useragent","windows nt 5.2") !== false)
		{
			return 5;//"Windows 2003 server";
		}
		elseif (strpos("$useragent","windows nt 6.0") !== false)
		{
			return 6;//"Windows Vista";
		}
		elseif (strpos("$useragent","windows nt") !== false)
		{
			return 7;//"Windows NT";
		}
		elseif (strpos("$useragent","win 9x 4.90") !== false && strpos("$useragent","win me"))
		{
			return 8;//"Windows ME";
		}
		elseif (strpos("$useragent","win ce") !== false)
		{
			return 9;//"Windows CE";
		}
		elseif (strpos("$useragent","win 9x 4.90") !== false)
		{
			return 10;//"Windows ME";
		}
		elseif (strpos("$useragent","mac os x") !== false)
		{
			return 11;//"Mac OS X";
		}
		elseif (strpos("$useragent","macintosh") !== false)
		{
			return 12;//"Macintosh";
		}
		elseif (strpos("$useragent","linux") !== false)
		{
			return 13;//"Linux";
		}
		elseif (strpos("$useragent","freebsd") !== false)
		{
			return 14;//"Free BSD";
		}
		elseif (strpos("$useragent","symbian") !== false)
		{
			return 15;//"Symbian";
		}
		else 
		{
			return 16;//ismeretlen;
		}
	}
}
?>