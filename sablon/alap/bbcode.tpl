{* ez a sablon felel bbcode beviteléért *}

<script language="javascript" type="text/javascript">
var  textarea_id='box_content', theme='{$ipanel.smink}';
</script>
<script language="javascript" src="scriptek/bbcode.js" type="text/javascript"></script>
<div class="bbtoolbar">
	<div class="bbtoolbar_left"></div>
	<div class="bbtoolbar_cell">
		<select size="1" name="size" id="sizes">
			<option value="8pt">8</option>

			<option value="9pt">9</option>
			<option value="10pt" selected="selected">10</option>
			<option value="12pt">12</option>
			<option value="14pt">14</option>
			<option value="16pt">16</option>
			<option value="18pt">18</option>

			<option value="20pt">20</option>
			<option value="22pt">22</option>
			<option value="24pt">24</option>
			<option value="30pt">30</option>
			<option value="36pt">36</option>
			<option value="48pt">48</option>

			<option value="72pt">72</option>
		</select>
	</div>
	<div class="bbtoolbar_cell"><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_size.png" alt="Betûméret" title="Betûméret" id="size" onclick="javascript: addbbm('size')"/></div>
	<div class="bbtoolbar_separator"></div>
	<div class="bbtoolbar_cell">
		<select size="1" name="color" id="colors">
			<option style="background-color: black; color: black;" value="black" selected="selected">Fekete</option>

			<option style="background-color: white; color: white;" value="white">Fehér</option>
			<option style="background-color: green; color: green;" value="green">Zöld</option>
			<option style="background-color: maroon; color: maroon;" value="maroon">Gesztenye</option>
			<option style="background-color: olive; color: olive;" value="olive">Oliva</option>
			<option style="background-color: navy; color: navy;" value="navy">Mélykék</option>
			<option style="background-color: purple; color: purple;" value="purple">Lila</option>

			<option style="background-color: gray; color: gray;" value="gray">Szürke</option>
			<option style="background-color: yellow; color: yellow;" value="yellow">Sárga</option>
			<option style="background-color: lime; color: lime;" value="lime">Lime</option>
			<option style="background-color: aqua; color: aqua;" value="aqua">Cián</option>
			<option style="background-color: fuchsia; color: fuchsia;" value="fuchsia">Ciklámen</option>
			<option style="background-color: silver; color: silver;" value="silver">Ezüst</option>

			<option style="background-color: red; color: red;" value="red">Piros</option>
			<option style="background-color: blue; color: blue;" value="blue">Kék</option>
			<option style="background-color: teal; color: teal;" value="teal">Pávakék</option>
		</select>
	</div>
	<div class="bbtoolbar_cell"><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_color.png" alt="Betûszín" title="Betûszín" id="color" onclick="javascript: addbbm('color')"/></div>
	<div class="bbtoolbar_separator"></div>

	<div class="bbtoolbar_cell"><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_bold.png" alt="Félkövér" title="Félkövér" id="bold" onclick="javascript: addbbm('bold')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_italic.png" alt="Dõlt" title="Dõlt" id="italic" onclick="javascript: addbbm('italic')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_underline.png" alt="Aláhúzott" title="Aláhúzott" id="underline" onclick="javascript: addbbm('underline')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_overline.png" alt="Föléhúzott" title="Föléhúzott" id="overline" onclick="javascript: addbbm('overline')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_linetrough.png" alt="Áthúzott" title="Áthúzott" id="linetrough" onclick="javascript: addbbm('linetrough')"/></div>
	<div class="bbtoolbar_separator"></div>
	<div class="bbtoolbar_cell"><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_alignleft.png" alt="Balra zárt" title="Balra zárt" id="alignleft" onclick="javascript: addbbm('alignleft')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_aligncenter.png" alt="Középre zárt" title="Középre zárt" id="aligncenter" onclick="javascript: addbbm('aligncenter')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_alignright.png" alt="Jobbra zárt" title="Jobbra zárt" id="alignright" onclick="javascript: addbbm('alignright')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_alignjustify.png" alt="Sorkizárt" title="Sorkizárt" id="alignjustify" onclick="javascript: addbbm('alignjustify')"/></div>
	<div class="bbtoolbar_separator"></div>
	<div class="bbtoolbar_cell"><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_manual.png" alt="Idézet" title="Idézet" id="quote" onclick="javascript: addbbm('quote')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_quote.png" alt="Idézet" title="Idézet"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_wizard.png" alt="Idézet" title="Idézet" id="quote_w" onclick="javascript: addbbw('Az idézet szövege:', 'quote')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_smilies.png"  class="thickbox kat" alt="smiley.php?TB_iframe=true&amp;height=500&amp;width=800" title="Hangulatjelek" id="smilies" /></div>
	<div class="bbtoolbar_separator"></div>
	<div class="bbtoolbar_cell"><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_manual.png" alt="Hivatkozás" title="Hivatkozás" id="url" onclick="javascript: addbbm('url')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_url.png" alt="Hivatkozás" title="Hivatkozás"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_wizard.png" alt="Hivatkozás" title="Hivatkozás" id="url_w" onclick="javascript: addbbw('A kívánt hivatkozás:', 'url')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_manual.png" alt="e-mail" title="e-mail" id="mail" onclick="javascript: addbbm('mail')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_email.png" alt="e-mail" title="e-mail"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_wizard.png" alt="e-mail" title="e-mail" id="mail_w" onclick="javascript: addbbw('A címzett e-mail címe:', 'mail')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_manual.png" alt="Google keresés" title="Google keresés" id="google" onclick="javascript: addbbm('google')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_google.png" alt="Google keresés" title="Google keresés"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_wizard.png" alt="Google keresés" title="Google keresés" id="google_w" onclick="javascript: addbbw('A keresendõ kifejezés:', 'google')"/></div>
	<div class="bbtoolbar_separator"></div>
	<div class="bbtoolbar_cell"><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_manual.png" alt="Kép" title="Kép" id="picture" onclick="javascript: addbbm('picture')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_image.png" alt="Kép" title="Kép"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_wizard.png" alt="Kép" title="Kép" id="picture_w" onclick="javascript: addbbw('A kívánt kép URL-je:', 'picture')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_manual.png" alt="Adobe Flash" title="Adobe Flash" id="flash" onclick="javascript: addbbm('flash')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_flash.png" alt="Adobe Flash" title="Adobe Flash"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_wizard.png" alt="Adobe Flash" title="Adobe Flash" id="flash_w" onclick="javascript: addbbw('A flash movie URL-je:', 'flash')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_manual.png" alt="Multimédia" title="Multimédia" id="media" onclick="javascript: addbbm('media')"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_media.png" alt="Multimédia" title="Multimédia"/><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_wizard.png" alt="Multimédia" title="Multimédia" id="media_w" onclick="javascript: addbbw('A médiafájl URL-je:', 'media')"/></div>

	<div class="bbtoolbar_separator"></div>
	<div class="bbtoolbar_cell"><a class="pic" href="bbcode_teszt.php" target="_blank"><img border="0" src="kinezet/{$ipanel.smink}/bbtoolbar_help.png" alt="Súgó" title="Súgó"/></a></div>
	<div class="bbtoolbar_right"></div>
</div>
<script type="text/javascript">tb_init("img.thickbox");</script>