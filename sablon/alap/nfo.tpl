<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$smarty.const.Oldal_nyelve}" lang="{$smarty.const.Oldal_nyelve}">
<head>
	<title>{$smarty.const.Oldal_fejlec}</title>
	<link rel="stylesheet" type="text/css" href="kinezet/{if $ipanel.smink}{$ipanel.smink}{else}alap{/if}/style.css" id="csslink"/>
</head>
<body>
	{if $modul=='text'}
		<pre class='nfo' >{$tNfo}</pre>
	{elseif $modul=='image'}
		<img class="nfo" border="0" src="nfo.php?id={$tNfo}&amp;modul=render" alt="" />
	{elseif $modul=='flash'}
		<object class="nfo" type="application/x-shockwave-flash" data="kinezet/view.swf" width="{$width}" height="{$height}">
			<param name="flashvars" value="file=nfo.php?id={$tNfo}" />
			<param name="movie" value="kinezet/view.swf"/>
			<param name="quality" value="high"/>
			<param name="bgcolor" value="#{$NFO_flashbackground}" />
		</object>
	{/if}
	
</body>
</html>