{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
{foreach from=$OLDAL key=i item=ertek}{$ertek}<br />{/foreach}
	
	<form action="profil.php" method="post">
	
	
	{'Személyes beállítások'|section_open}
		<table class="settings_sheet">
			<tr>
				<td class="left">PM-ek fogadása:</td>
				<td class="right">			
					{html_radios name='privat' options=$privat_uzi selected=$privat_uzi_old separator='&nbsp;'}
				</td>
			</tr>
			<tr>
				<td class="left">Nemed:</td>
				<td class="right">
					{html_radios name='nemed' options=$nem selected=$nem_old separator='&nbsp;'}				
				</td>
			</tr>
			<tr>
				<td class="left">Lakóhelyed:</td>
				<td class="right">
					<label for="orszag">Ország:</label>&nbsp;
					<select id="orszag" name="orszag" class="skinned">
						{html_options values=$orszag_ertek output=$orszag selected=$orszag_old}					
					</select>
					<label for="c14">Város/község/falu:</label>&nbsp;<input type="text" id="c14" name="varos" value="{$varos_old}" size="22" class="skinned"/>&nbsp;
					<a href="http://www.frappr.com/?a=constellation_map&mapid=137440291277" target="_blank">Jelöld be magad a térképen!</a>
				</td>
			</tr>
		</table>
	{'Személyes beállítások'|section_end}
	
	{'Avatarod'|section_open}
	<table>
		<tr>
			<td>
				<img id="avatar_kep" class="avatar" border="0" src="{$avatar_url}" alt="Avatarod"/>
			</td>
			<td class="avatardialog">
				Írd be az <span class="highlight">új avatarod</span> URL-jét, majd kattints az elõnézet gombra:
				<br />
				<input id="avatar_url" class="skinned" type="text" name="avatar" value="{$avatar_text}" size="60"/>&nbsp;<a class="pic" href="#" id="avatarelol" title="Elõnézet"><img id="refreshavatar" border="0" src="kinezet/{$ipanel.smink}/refreshavatar.png" alt="Elõnézet"/></a><a class="pic" href="#" id="avatar_regi"  title="Jelenlegi visszaállítása"><img id="restoreavatar" border="0" src="kinezet/{$ipanel.smink}/restoreavatar.png" alt="Jelenlegi visszaállítása"/></a>
				<br />
				<br />
				<p class="justify">A képed ne legyen <span class="highlight">150</span> pixelnél szélesebb, illetve <span class="highlight">300</span> pixelnél magasabb. A támogatott formátumok a következõk: <span class="highlight">JPG</span>, <span class="highlight">GIF</span>, <span class="highlight">PNG</span>, <span class="highlight">BMP</span>. Avatarod ne tartalmazzon erõszakot, szélsõséges nézeteket, pornográfiát szemléltetõ elemeket! Az avatar szabályok áthágásáért <span class="highlight">kitiltás</span> jár!<br /><br />Ha nem megfelelõ a képed mérete, használj egy képszerkesztõ programot (pl. <a href="http://www.irfanview.com/" target="_blank">InfranView</a>) az átméretezéshez.</p>

				<div id="pre_warn" style="display: none"><br /><span class="red"><span class="italic">Elõnézet! Mentés legalul!</span></span></div>
			</td>
		</tr>
	</table>
	{'Avatarod'|section_end}
	
	{'Alapértelemzet kategóriák'|section_open}
		<div style="clear:both">
		{foreach from=$kategoriak item=k}
			<div style="width:20%;float:left;">
				<label for="kategoriak_{$k.id}">
					<input type="checkbox" class="skinned"  id="kategoriak_{$k.id}" name="kategoriak[]" value="{$k.id}" title="{$k.title}" {if $k.checked==true}checked="checked"{/if} />&nbsp;{$k.nev}
				</label>
			</div>
		{/foreach}
		</div>
		<br /><br /><br /><br /><br /><br />
	{'Alapértelemzet kategóriák'|section_end}

	{'Ládád tesztreszabása'|section_open}	
		A ládád címe: <input class="skinned" type="text" name="ladad" value="{$ladad}" size="133"/>&nbsp;
		<br />
		<br />
		A ládád tartalma: (használhatsz <a href="bbcode_teszt.php" title="BB kódok ismertetõje" target="_blank">BB kódokat</a> és <a href="smilies.php" title="Smileyk listája" target="_blank">smileykat</a> is, max 1024 karakter.)
		<br />
		
		{include file='bbcode.tpl'}
		<div class="textarea"><textarea name="ladad_text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$ladad_text}</textarea></div>
	{'Ládád tesztreszabása'|section_end}
	
	
	
	
	{'Oldal beállításai'|section_open}
		{html_checkboxes name='megjelen' options=$megjelen  selected=$megjelen_old separator='&nbsp;'}
		<br />
		<br />
		<label for="c5">Torrentek száma egy oldalon:</label>&nbsp;<input type="text" id="c5" name="torrperold" value="{$perold.torr}" size="2" class="skinned"/>&nbsp;
		<label for="c6">Hozzászólások száma egy oldalon:</label>&nbsp;<input type="text" id="c6" name="hszperold" value="{$perold.hsz}" size="2" class="skinned"/>&nbsp;
		<label for="c20">Levelek száma egy oldalon:</label>&nbsp;<input type="text" id="c20" name="mailperold" value="{$perold.mail}" size="2" class="skinned"/>&nbsp;
	
		<span class="small">&nbsp;A mezõkbe 10 és 100 közötti számot írhatsz.</span>
	{'Oldal beállításai'|section_end}
	
	
	{* 'Oldal stílus - Kattints a neked leginkább tetszõre!'|section_open}
	<table class="stylepreviews">

		<tr>
			{foreach from=$sminkek_tomb key=i item=smink}
			<td>
				<img class="stylepreview" border="0" src="kinezet/{$smink.ert}/style_preview.png" alt="{$smink.olv}" /><br /><br />
				<span class="highlight"><label for="smink_{$i}" ><input type="radio" name="smink" id="smink_{$i}" value="{$smink.ert}" {if $smink.check==true} checked="checked" {/if} />&nbsp;{$smink.olv}</label></span>
			</td>
			{/foreach}
		</tr>

	</table>
	{'Oldal stílus - Kattints a neked leginkább tetszõre!'|section_end *}
	
	{*
	{'Alapértelmezett kategóriák (ezek jelennek meg alapból a letöltés oldalon)'|section_open}
	<table  class="categories">
		<tr>

			<td>
				<ul class="categories_settings">
				</ul>
			</td>
			<td>
				<ul class="categories_settings">
				</ul>
			</td>
			<td>

				<ul class="categories_settings">
				</ul>
			</td>
			<td>
				<ul class="categories_settings">
				</ul>
			</td>
			<td>
				<ul class="categories_settings">

				</ul>
			</td>
			<td>
				<ul class="categories_settings">
				</ul>
			</td>
		</tr>
	</table>	
	{'Alapértelmezett kategóriák (ezek jelennek meg alapból a letöltés oldalon)'|section_end}
	*}
	
	{'Biztonsági és fiók beállítások'|section_open}
	<table class="settings_sheet">
		<tr>
			<td class="left">e-mail címed:</td>
			<td class="right">

				<input type="text" id="c15" name="email" value="{$email_cim}" size="54" class="skinned"/>&nbsp;
			</td>
		</tr>
		<tr>
			<td class="left"></td>
			<td class="right">
				<span class="small"><span class="red">Figyelem!</span> A jelenlegi és az új címedre egyaránt küldünk megerõsítõ e-mailt. Címed <span class="hightlight">csak</span> akkor változik meg, ha mindkét megerõsítést visszaigazolod a küldött levelekben lévõ hivatkozással!</span>

			</td>
		</tr>
				<tr>
					<td colspan="2"></td>
				</tr>
		<tr>
			<td class="left">Új jelszó:</td>
			<td class="right">

				<input type="password" id="c16" name="pw1" size="54" onkeyup="pw_sec_check('{$ipanel.name}','{$ipanel.smink}')" class="skinned"/>&nbsp;
			</td>
		</tr>
		<tr>
			<td class="left">Megerõsítés:</td>
			<td class="right">
				<input type="password" id="c17" name="pw2" size="54" onkeyup="pw_sec_check('{$ipanel.name}','{$ipanel.smink}')" class="skinned"/>&nbsp;
				<img id="pwflag1" border="0" src="kinezet/{$ipanel.smink}/pw_offline.png" alt=""/>

			</td>
		</tr>
		<tr>
			<td class="left">Jelszó biztonsági szintje:</td>
			<td class="right">
				<input type="text" id="pw_sec_lev" name="-" value="" size="54" disabled="disabled" class="skinned"/>&nbsp;
				<img id="pwflag2" border="0" src="kinezet/{$ipanel.smink}/pw_offline.png" alt=""/>
			</td>

		</tr>
		<tr>
			<td class="left"></td>
			<td class="right">
				<span class="small"><span class="red">Figyelem!</span> Jelenlegi e-mail címedre megerõsítõ e-mailt küldünk. Jelszavad <span class="hightlight">csak</span> akkor változik meg ha megérkezik a megerõsítés! Jelszavadnak minimum 5 karakter hosszúnak kell lennie! A "Jelszó biztonsági szintje" tájékoztató jellegû! </span>
			</td>

		</tr>
				<tr>
					<td colspan="2"></td>
				</tr>
		<tr>
			<td class="left">Passkey csere:</td>
			<td class="right">
				<input type="checkbox" id="c18" name="newpasskey" value="yes"/>&nbsp;<label for="c18">Új azonosítót (passkey-t) kérek!</label>&nbsp;

			</td>
		</tr>
		<tr>
			<td class="left"></td>
			<td class="right">
				<span class="small"><span class="red">Figyelem!</span> Az azonosítód megváltozása miatt minden le- illetve feltöltés alatt álló .torrent fájlt újra le kell töltened!</span>
			</td>

		</tr>
				<tr>
					<td colspan="2"></td>
				</tr>
		<tr>
			<td class="left">Fiók hibernálása:</td>
			<td class="right">
				<input type="checkbox" id="c19" name="hibernate" value="yes"/>&nbsp;<label for="c19">Fiókom hibernálást kérem!</label>&nbsp;

			</td>
		</tr>
		<tr>
			<td class="left"></td>
			<td class="right">
				<span class="small"><span class="red">Figyelem!</span> Mialatt fiókod hibernálva van, nem férhetsz hozzá, csak ha feloldod. A feloldáshoz a jelszavad szükséges. Ha a fiókod hibernálva van, három hónap inaktivitás után sem törli a rendszer.</span>
			</td>

		</tr>
	</table>
	{'Biztonsági és fiók beállítások'|section_end}
	
	{'Megerõsítés'|section_open}
		<div style="text-align:center">
			<span class="highlight"><span class="big">A változások mentéséhez kérlek, írd be a <span class="red">jelenlegi</span> jelszavad!</span></span>
			<div class="confirm"><input type="password" name="confirmation" size="22"/></div>
			<input  type="image"  border="0" src="kinezet/{$ipanel.smink}/btn_save.png" alt="Mentés" class="profile_btn" />
			<img class="profile_btn" border="0" src="kinezet/{$ipanel.smink}/btn_cancel.png" alt="Mégsem" onclick="window.location='index.php'"/>
		</div>
	{'Megerõsítés'|section_end}
	</form>
</div>








<script language="javascript" src="scriptek/profil.js"></script>		

{* a labresz csatolasa *}
{include file='labresz.tpl'}