{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	{'BB code teszt'|section_open}	
		{if !empty($teszt_text)}
			<div class="rights">
				{$teszt_text}
			</div>
			<br /><br />
		{/if}
		<form method="post" action="bbcode_teszt.php">		
			{include file='bbcode.tpl'}
			<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$text}</textarea></div>
			<div class='center'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
		<form>
	
	{'BB code teszt'|section_end}
	
	
	{*'BB code manual'|section_open}	
			<h2>{$segedlet.cim}</h2>
			<div class="rights">
				{$segedlet.text}
			</div>
			{if adminlink==true}
			<div class="right">
				[ <a href="dokumentacio.php?mit=bbhelp&mod=mod&id={$segedlet.cid}" >szerkesztés</a> ]
			</div>
			{/if}
	{'BB code manual'|section_end*}
	
	
	
	
	
		{'Mintak'|section_open}	
	<div align="center">
				  <div class="UserBox"><DIV ALIGN="center" CLASS="forUsers"><table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Vastag</p></td>
	</tr>

	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">A szöveget vastagbetüssé (bold-dá) alakítja.</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[b]<i>Szöveg</i>[/b]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[b]Ez egy vastag szöveg.[/b]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>

		<td ><p class="left"><span style="font-weight:bold">Ez egy vastag szöveg.</span></p></td>
	</tr>
		
	</table>

<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Dölt</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">A szöveget döltté (italic-ké) alakítja.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[i]<i>Szöveg</i>[/i]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[i]Ez egy dölt szöveg.[/i]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><span style="font-style:italic">Ez egy dölt szöveg.</span></p></td>
	</tr>
	</table>

<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Aláhúzás</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">A szöveget aláhúzottá alakítja.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[u]<i>Szöveg</i>[/u]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[u]Ez egy aláhúzott szöveg.[/u]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><span style="text-decoration:underline">Ez egy aláhúzott szöveg.</span></p></td>
	</tr>
	</table>

<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Szín (elsõ változat)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Megváltoztatja a szöveg színét.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[color=<i>szín</i>]<i>Szöveg</i>[/color]</p></td>
	</tr>
	<tr>

		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[color=blue]Ez egy kék szöveg.[/color]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><span style="color:blue">Ez egy kék szöveg.</span></p></td>
	</tr>

		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>
		<td><p class="left">Használd az alap színeket, mert nem minden böngészö támogat minden színt! (piros, kék, sárga, zöld stb.)</p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Szín (második változat)</p></td>

	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Megváltoztatja a szöveg színét</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>

		<td><p class="left">[color=#<i>RGBkód</i>]<i>Szöveg</i>[/color]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[color=#ff0000]Ez vörös színü szöveg.[/color]</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><span style="color:#ff0000">Ez vörös színü szöveg.</span></p></td>
	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>

		<td><p class="left">6 decimális számból kell állnia az RGB-nek</p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Méret</p></td>
	</tr>
	<tr>

		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Megváltoztatja a betük méretét</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[size=<i>mérték</i>]<i>szöveg</i>[/size]</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[size=10pt]Ez a szöveg '10pt' méretû.[/size]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>

		<td ><p class="left"><span style="font-size:10pt">Ez a szöveg '10pt' méretû.</span></p></td>
	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>
		<td><p class="left"><i>mérték</i> lehet pixelben (px), vagy pointsban (pt) mért.</p></td>
	</tr>

	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Betütípus</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beállítja a szöveg betütípusát.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[font=<i>neve</i>]<i>Szöveg</i>[/font]</p></td>
	</tr>
	<tr>

		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[font=Impact]Helló mi&uacute;js&aacute;g ?[/font]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><span style="font-family:Impact">Helló mi&uacute;js&aacute;g ?</span></p></td>
	</tr>

	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Link (1.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy linket.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[url]<i>Az URL</i>[/url]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[url]http://sky-t.eu/[/url]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><a href="http://anonym.to/?http://sky-t.eu/" target="_blank" class="bb-url">http://sky-t.eu/</a></p></td>
	</tr>
		<tr>

		<td><p class="left">&nbsp;Megjegyzés:</p></td>
		<td><p class="left">Minden URL automatikus link lesz.</p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Link (2.)</p></td>

	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy linket.</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>

		<td><p class="left">[url=<i>URL</i>]<i>Link szövege</i>[/url]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[url=http://sky-t.eu/]Sky-Tech[/url]</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><a href="http://anonym.to/?http://sky-t.eu/" target="_blank" class="bb-url">Sky-Tech</a></p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>

		<td colspan="2"><p class="tbl_colhead">e-mail (1.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy e-mail linket.</p></td>
	</tr>
	<tr>

		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[email]<i>A levélcím</i>[/email]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[email]webmaster@sky-t.eu[/email]</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><a href="mailto:webmaster@sky-t.eu " class="bb-email">webmaster@sky-t.eu </a></p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>

		<td colspan="2"><p class="tbl_colhead">e-mail (2.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy e-mail linket.</p></td>
	</tr>
	<tr>

		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[email=<i>address</i>]<i>Írj nekünk egy levelet!</i>[/email]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[email=webmaster@sky-t.eu]Írj nekünk egy levelet![/email]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><a href="mailto:webmaster@sky-t.eu" class="bb-email">Írj nekünk egy levelet!</a></p></td>
	</tr>
	</table>

<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Google keresés</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy google keresés linket.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[google]<i>A keresendõ kulcsszavak</i>[/google]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[google]Pizza[/google]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><a href="http://www.google.com/search?hl=hu&q=Pizza" title="Google keresés: Pizza" target="_blank" class="bb-url">pizza</a><sup><span style="font-size: 7pt;"><span style="color: #1645AE;">G</span><span style="color: #D62408;">o</span><span style="color: #EFBA00;">o</span><span style="color: #1645AE;">g</span><span style="color: #007D08;">l</span><span style="color: #D62408;">e</span></span></sup></p></td>

	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>
		<td><p class="left">Ne használj &amp; jelet a keresendõ szövegben!</p></td>
	</tr>
	</table>
<br/>

<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Kép (1.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy képet.</p></td>
	</tr>

	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[img=<i>URL</i>]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[img=http://kepfeltolto.hu/i/?57087]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><img border="0" src="http://kepfeltolto.hu/i/?57087" alt="http://kepfeltolto.hu/i/?57087" class="bb-image" /></p></td>
	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>

		<td><p class="left">A kép csak <b>.gif</b>, <b>.jpg</b> vagy <b>.png</b> kiterjesztésü lehet!</p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">

	<tr>
		<td colspan="2"><p class="tbl_colhead">Kép (2.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy képet.</p></td>
	</tr>

	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[img]<i>URL</i>[/img]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[img]http://kepfeltolto.hu/i/?57087[/img]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><img border="0" src="http://kepfeltolto.hu/i/?57087" alt="http://kepfeltolto.hu/i/?57087" class="bb-image" /></p></td>
	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>

		<td><p class="left">A kép csak <b>.gif</b>, <b>.jpg</b> vagy <b>.png</b> kiterjesztésü lehet!</p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">

	<tr>
		<td colspan="2"><p class="tbl_colhead">Kép (3.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr fix szélességû egy képet.</p></td>
	</tr>

	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[imgw=<i>URL</i>]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[imgw=vmi]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><img border="0" width="550" src="Link" alt="link" class="bb-image"/><br/><span class="small">Ez egy átméretezett kép, <a class="browser" href="link" target="_blank">kattints ide</a> az eredeti méretben való megjelenítéséhez.</span></p></td>
	</tr>

		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>
		<td><p class="left">A kép csak <b>.gif</b>, <b>.jpg</b> vagy <b>.png</b> kiterjesztésü lehet!</p></td>
	</tr>

	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Kép (4.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr fix szélességû egy képet.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[imgw]<i>URL</i>[/img]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[imgw]Link[/imgw]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><img border="0" width="550" src="Link" alt="Link" class="bb-image"/><br/><span class="small">Ez egy átméretezett kép, <a class="browser" href="Link" target="_blank">kattints ide</a> az eredeti méretben való megjelenítéséhez.</span></p></td>
	</tr>

		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>
		<td><p class="left">A kép csak <b>.gif</b>, <b>.jpg</b> vagy <b>.png</b> kiterjesztésü lehet!</p></td>
	</tr>

	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Kép (5.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy fix méretû képet.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[imgx='szeles'x'magas']<i>URL</i>[/imgx]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[imgx=400x20]Link[/imgx]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><img border="0" width="400" height="20" src="Link" alt="Link" class="bb-image" /></p></td>
	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>

		<td><p class="left">A kép csak <b>.gif</b>, <b>.jpg</b> vagy <b>.png</b> kiterjesztésü lehet!</p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">

	<tr>
		<td colspan="2"><p class="tbl_colhead">Idézet (1.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy idézetet.</p></td>
	</tr>

	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[quote]<i>Idézet</i>[/quote]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[quote]Ilyen egy idezet....[/quote]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><div><p class="left"><b>Idézet:</b></p><div class="bb-quote">Ilyen egy idezet....</div></div></p></td>
	</tr>
	</table>

<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Idézet (2.)</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy idézetet.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[quote=<i>Idézett ember</i>]<i>Idézett szöveg</i>[/quote]</p></td>
	</tr>
	<tr>

		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[quote=Dzsó bácsi]Idézet szövege.[/quote]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><div>
		    <p class="left"><b>Barbara &iacute;rta:</b></p><div class="bb-quote">Idézet szövege.</div></div></p></td>

	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Lista</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>

		<td><p class="left">Beszúr egy listát.</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[*]<i>Szöveg</i></p></td>
	</tr>
	<tr>

		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[*]Elsõ sor<br/>[*]Második sor</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left">&bull;&nbsp;Elsõ sor<br/>&bull;&nbsp;Második sor</p></td>

	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Youtube video</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>

		<td><p class="left">Beszúr egy youtube videot.</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[youtube]<i>youtube video azonosito</i>[/youtube]</p></td>
	</tr>

	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[youtube]UBecXMTU2v4[/youtube]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><div align="center"><object classid="clsid:D27CDB6E-AE6D-11CF-96B8-444553540000" id="flash" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" border="0" width="610" height="502"><param name="movie" value="http://www.youtube.com/v/UBecXMTU2v4" ><param name="quality" value="High"><param name="allowScriptAccess" value="never" /><param name="wmode" value="transparent" /><param name="bgcolor" value="#616161" /><embed allowScriptAccess="never" src="http://www.youtube.com/v/UBecXMTU2v4" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="flash" wmode="transparent" width="610" height="502"></object></div></p></td>

	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>
		<td><p class="left">Csak és kizárólag a 11 jegy&#369; video azonosítót kell beírni se nem többet, se kevesebbet!</p></td>
	</tr>
	</table>

<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Youtube video</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy youtube videot.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[youtube=youtube_video_azonosito]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[youtube=orSb10O_Bg8]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><div align="center"><object classid="clsid:D27CDB6E-AE6D-11CF-96B8-444553540000" id="flash" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" border="0" width="610" height="502"><param name="movie" value="http://www.youtube.com/v/orSb10O_Bg8" ><param name="quality" value="High"><param name="allowScriptAccess" value="never" /><param name="wmode" value="transparent" /><param name="bgcolor" value="#616161" /><embed allowScriptAccess="never" src="http://www.youtube.com/v/orSb10O_Bg8" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="flash" wmode="transparent" width="610" height="502"></object></div></p></td>
	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>

		<td><p class="left">Csak és kizárólag a 11 jegy&#369; video azonosítót kell beírni se nem többet, se kevesebbet!</p></td>
	</tr>
	</table>
<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Youtube video</p></td>
	</tr>

	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy youtube videot ami 200 pixel széles és 150 pixel magas lesz.</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[youtube=200x150]<i>youtube video azonosito</i>[/youtube]</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>
		<td><p class="left">[youtube=200x150]Rh7qwF23ijI[/youtube]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>

		<td ><p class="left"><div align="center"><object classid="clsid:D27CDB6E-AE6D-11CF-96B8-444553540000" id="flash" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" border="0" width="200" height="150"><param name="movie" value="http://www.youtube.com/v/Rh7qwF23ijI"><param name="allowScriptAccess" value="never" /><param name="wmode" value="transparent" /><param name="quality" value="High"><param name="bgcolor" value="#616161" /><embed allowScriptAccess="never" src="http://www.youtube.com/v/Rh7qwF23ijI" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="flash" wmode="transparent" width="200" height="150"></object></div></p></td>
	</tr>
		<tr>
		<td><p class="left">&nbsp;Megjegyzés:</p></td>
		<td><p class="left">Csak és kizárólag a 11 jegy&#369; video azonosítót kell beírni se nem többet, se kevesebbet!</p></td>
	</tr>
	</table>

<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Video</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy lejátszható videot.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[wmp]<i>video url-je</i>[/wmp]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[wmp]Link[/wmp]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><div align="center"><object id="mediaPlayer" width="400" height="350" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject"><param name="fileName" value="Link"><param name="animationatStart" value="true"><param name="transparentatStart" value="false"><param name="autoStart" value="false"><param name="showControls" value="true"><param name="stretchToFit" value="false"><param name="ShowStatusBar" value="false"><param name="loop" value="0"><embed type="application/x-mplayer2" pluginspage="http://microsoft.com/windows/mediaplayer/en/download/" src="Link" width="400" height="350" autostart="0" transparentatStart="0" showcontrols="1" stretchToFit="0" ShowStatusBar="0" loop="0"></embed>
  </object></div></p></td>
	</tr>
	</table>

<br/>
<table width="100%" style="border:1px; border-style:dashed;">
	<tr>
		<td colspan="2"><p class="tbl_colhead">Video</p></td>
	</tr>
	<tr>
		<td width="20%"><p class="left">&nbsp;Leírás</p></td>
		<td><p class="left">Beszúr egy lejátszható videot, ami 250x200 pixelen fog megjelenni.</p></td>

	</tr>
	<tr>
		<td><p class="left">&nbsp;Használata:</p></td>
		<td><p class="left">[wmp=250x200]<i>video url-je</i>[/wmp]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Példa:</p></td>

		<td><p class="left">[wmp=250x200]Link[/wmp]</p></td>
	</tr>
	<tr>
		<td><p class="left">&nbsp;Eredmény:</p></td>
		<td ><p class="left"><div align="center"><object id="mediaPlayer" width="250" height="200" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject"><param name="fileName" value="Link"><param name="animationatStart" value="true"><param name="transparentatStart" value="false"><param name="autoStart" value="false"><param name="showControls" value="true"><param name="stretchToFit" value="false"><param name="ShowStatusBar" value="false"><param name="loop" value="0"><embed type="application/x-mplayer2" pluginspage="http://microsoft.com/windows/mediaplayer/en/download/" src="Link" width="250" height="200" autostart="0" transparentatStart="0" showcontrols="1" stretchToFit="0" ShowStatusBar="0" loop="0"></embed>
  </object></div></p></td>
	</tr>
	</table>

<br/>
</div></div></div>
	{'Mintak'|section_end}
	
	
	
	
</div>
{* a labresz csatolasa *}
{include file='labresz.tpl'}