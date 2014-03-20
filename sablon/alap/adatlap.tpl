{include file='fejresz.tpl'}
{* a fejlec csatolasa *}




{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	{if $modositas==true}
		{'Hozzászólás szerkesztés'|section_open}
		<div align="center">	
			<form action="{$oldal_cime}" method="post">
				{include file='bbcode.tpl'}
				<div class="textarea"><textarea name="modtext" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$text}</textarea></div>
				<br />
				<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
				<input type="hidden" name="thid" value="{$thid}" />
			</form>
		</div>	
		{'Hozzászólás szerkesztés'|section_end}
	{else}
	{'Adatlap'|section_open}
		<span style="font-size: 16px;font-weight:bold">{$t.name}</span>&nbsp;&nbsp;<a title="Torrent letöltése" href="letoltes.php?id={$t.tid}" >[letöltés]</a>
		<div class="separator_center_long"></div>
			<table class="skinned">
				<tr class="head">
					<td>Típus</td>
					<td>Feltöltõ</td>
					<td>Letölt</td>
					<td>Méret</td>
					<td>Fájlok</td>
					<td>Feltöltve</td>
					<td>Letöltve</td>
					<td>Seed</td>
					<td>Leech</td>
					<td>Megnézve</td>
				</tr>
				<tr>
					<td class="t_icon"><a href="#" title="{$t.leir}" class="pic"><img src="kinezet/{$ipanel.smink}/category_icons/{$t.kep}.png"  border="0" alt="{$t.kep}"/></a></td>
					<td><a title="Profil megtekintése" href="userinfo.php?uid={$t.uid}"><span class="rank{$t.rang}">{$t.username}</span></a></td>
					<td>
						<a href="letoltes.php?id={$t.tid}" title="Torrent letöltése" class="pic">
							<img border="0" src="kinezet/{$ipanel.smink}/torrent_download.png" alt="" title="Letöltés"/>
						</a>
					</td>
					<td>{$t.meret|b_to_s}</td>
					<td><a class="thickbox" href="letolt_admin.php?tid={$t.tid}&amp;modul=getfiles&amp;height=500&amp;width=950" title="Fájlok megtekintése">{$t.fajldb}</a></td>
					<td>{$t.datum}</td>
					<td>{$t.letoltve} alkalommal</td>
					<td><a href="peerlista.php?id={$t.tid}" title="Peerlista megtekintése">{$t.seed}</a></td>
					<td><a href="peerlista.php?id={$t.tid}" title="Peerlista megtekintése">{$t.leech}</a></td>
					<td>{$t.megnezve} alkalommal</td>
				</tr>
			</table>
				
				{if $t.nfo_name=='yes'}
				<div class="textlayer">
				<h2>NFO</h2>
				<div class="separator_left_long"></div><br>
					<div class="layer center">
						<a href="nfo.php?id={$t.tid}&amp;modul=flash&amp;height=500&amp;width=800" class="thickbox">Megjelenítés Flash Movie-ként</a>&nbsp;&bull;&nbsp;
						<a href="nfo.php?id={$t.tid}&amp;modul=image&amp;height=500&amp;width=800" class="thickbox">Megjelenítés képként</a>&nbsp;&bull;&nbsp;
						<a href="nfo.php?id={$t.tid}&amp;modul=text&amp;height=500&amp;width=800" class="thickbox" title="">Megjelenítés szövegként</a>&nbsp;&bull;&nbsp;
						<a href="nfo.php?id={$t.tid}&amp;modul=render&amp;download=1">NFO letöltése (kép)</a>&nbsp;&bull;&nbsp;
						<a href="nfo.php?id={$t.tid}&amp;modul=download">NFO letöltése (NFO fájl)</a>
					</div>
				</div>
				
				{/if}
			
				
				
			
				{if !empty($t.admin_megj)}
					<div class="textlayer">
						<h2>Moderátori megjegyzések</h2>
						<div class="separator_left_long"></div><br>
						<div class="modcomment">{$t.admin_megj}
							<br><br><br><span style="font-style: italic;">Írta: <a  href="userinfo.php?uid={$t.admin_id}" >{$t.adminname}</a>, ekkor: {$t.admin_datum}.</span>
						</div>
					</div>
				{/if}	
								
			<div class="textlayer">
				<h2>Leírás</h2>
				<div class="separator_left_long"></div>
				<br/>
				{$t.megjegyzes}
				<br />
								
			</div>
			
				{if !empty($t.kep1) || !empty($t.kep2) || !empty($t.kep3)}
					<div class="textlayer">
						<h2>Képek</h2>
						<div class="separator_left_long"></div><br>
						<div class="center">
							{if !empty($t.kep1)}
										<img src="{$t.kep1}" border="0" /><br /><br />
							{/if}
							{if !empty($t.kep2)}
								<img src="{$t.kep2}" border="0" /><br /><br />
							{/if}
							{if !empty($t.kep3)}
								<img src="{$t.kep3}" border="0" /><br /><br />
							{/if}
						</div>
					</div>
				{/if}

			
			<div class="textlayer"><span class="italic">Akik megköszönték:</span>&nbsp;&nbsp;
				<span id="thanks">{$koszi}</span>
			</div>
			<div class="textlayer" id="report" style="display: block;"><img border="0" src="kinezet/{$ipanel.smink}/attention.png" alt="" class="attention"/>Ha szabálytalanságra lettél figyelmes a torrenttel kapcsolatban, jelentsd <a href="#" onclick="return report(3)" title="Torrent jelentése">itt</a>. Akkor használd ezt a lehetõséget, ha olyan gondot észlelsz, amit csak moderátor tud megoldani.</div>
		</div>		
	{'Adatlap'|section_end}
	<br /><br />
	{'Hozzászólások'|section_open}
	
		
		{foreach from=$hsz item=h}
		
		<div class="comment">
			<div class="h">
				<span class="h">elküldve
					<a title="Userinfo"	href="userinfo.php?uid={$h.uid}">
						<span class="rank{$h.rang}">{$h.name}</span>
					</a> ({$h.rang_text}) által, ekkor: {$h.datum} 
					
				{if $admin_link==true}					
					 - [<a href="{$oldal_cime}&amp;mod=del&amp;mid={$h.hid}" class="hozzaszolas_torol">Törlés</a>]
				{/if}
				{if $admin_link==true || $h.sajathsz==true}
					 - [<a href="{$oldal_cime}&amp;mod=mod&amp;mid={$h.hid}">Szerkesztés</a>]
				{/if}
				{if $uj_hsz==true}
				  - [<a href="#" alt="{$h.hid}" class="idezet_link">Idézet</a>]
				{/if}
				</span>
			</div>
			<div class="i">
				<span class="i">
					letöltött: <span class="highlight">{$h.letolt|b_to_s}</span>, 
					feltöltött: <span class="highlight">{$h.feltolt|b_to_s}</span>, aránya: 
					<span class="{$h.arany|aranyszin}">{$h.arany_text}</span>
				</span>
			</div>
			<div class="l">
				<div align="center">
					<a class="pic" title="Userinfo" href="userinfo.php?uid={$h.uid}">
						<img class="avatar" border="1" src="{$h.avatar}" alt=""/>
					</a>
				</div>
			</div>
			<div class="r">
				<div class="c">{$h.text}</div>
			</div>
			<div class="f"></div>
		</div>
		<div class="separator_center_long"></div>


		{/foreach}
		
	
	
	
		
		{if $uj_hsz==true}			
				<br /><br />
				<div align="center">	
					<form action="{$oldal_cime}" method="post">
						{include file='bbcode.tpl'}
						<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;"></textarea></div>
						<br />
						<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
						{$modmezo}
					</form>
				</div>		
		{else}
			<div class="center"><br /><br /><p>A hozzászólásokat letiltották, vagy te írtad az utolsót, ebben az esetben használd a szerkesztés gombot.</p></div>
		{/if}
	
	
	
	{'Hozzászólások'|section_end}
	
	{/if}

<div style="clear:both"></div>
<script language="javascript" src="scriptek/letolt.js" type="text/javascript"></script>
<script language="javascript" src="scriptek/adatlap.js" type="text/javascript"></script>
{* a labresz csatolasa *}
{include file='labresz.tpl'}