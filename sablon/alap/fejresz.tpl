<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$smarty.const.Oldal_nyelve}" lang="{$smarty.const.Oldal_nyelve}">
<head>
	<title>{$smarty.const.Oldal_fejlec}</title>
	<meta name="keywords" lang="{$smarty.const.Oldal_nyelve}" content="{$smarty.const.Oldal_leiras}"/>
	<meta name="version" content="{$smarty.const.Oldal_verzio}"/>
	<meta name="author" content="{$smarty.const.Oldal_csapata}"/>
	<meta name="copyright" content="{$smarty.const.Oldal_copy}"/>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
	<link rel="stylesheet" type="text/css" href="kinezet/{if $ipanel.smink}{$ipanel.smink}{else}alap{/if}/thickbox.css" />
	<link rel="stylesheet" type="text/css" href="kinezet/{if $ipanel.smink}{$ipanel.smink}{else}alap{/if}/style.css" id="csslink"/>
	<link rel="stylesheet" type="text/css" href="kinezet/{if $ipanel.smink}{$ipanel.smink}{else}alap{/if}/prompt.css" id="csslink"/>
	<link rel="icon" href="kinezet/{if $ipanel.smink}{$ipanel.smink}{else}alap{/if}/icon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="kinezet/{if $ipanel.smink}{$ipanel.smink}{else}alap{/if}/icon.ico" type="image/x-icon"/>
	
{*		
	<link rel="alternate" href="rss/rss.xml" type="application/rss+xml" title="{$smarty.const.Oldal_neve} Torrentek"/>
	<link rel="alternate" href="rss/rssdd.xml" type="application/rss+xml" title="{$smarty.const.Oldal_neve} Torrentek Közvetlen Letöltéssel"/>
*}	
	
<!--	<script type="text/javascript" src="scriptek/jobb.js"></script> -->
	<script type="text/javascript" src="scriptek/jquery.js"></script>	
	<script type="text/javascript" src="scriptek/interface.js"></script>
	<script type="text/javascript" src="scriptek/cookie.js"></script>	
</head>
<body>
	<div id="main_container">
		<div id="logo">&nbsp;</div>
		<div id="menu">
			{$menu_kesz}
		</div>
		