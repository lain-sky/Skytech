<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$smarty.const.Oldal_nyelve}" lang="{$smarty.const.Oldal_nyelve}">
<head>
	<title>{$smarty.const.Oldal_fejlec}</title>
	<link rel="stylesheet" type="text/css" href="kinezet/{if $ipanel.smink}{$ipanel.smink}{else}alap{/if}/style.css" id="csslink"/>
	{literal}
	<script type="text/javascript">
	
		function masol(e){
		
			hova=parent.window.document.getElementById('box_content');
			mit=e.title;
			hova.value=hova.value+mit;
		}
	
	</script>
	{/literal}
</head>
<body>
	{foreach from=$kodok item=b}
		<img src="kinezet/smilies/{$b.kep}" title="{$b.kod}" class="kat" onclick='masol(this);' />	
	{/foreach}
	


</body>
</html>