<tr id="nagy_{$t.tid}" {if $k is even}class="t_even"{else}class="t_odd"{/if}>
	<td class="t_icon">
		<a href="letolt.php?tipus={$t.kid}" title="{$t.leir}" class="pic">
			<img src="kinezet/{$ipanel.smink}/category_icons/{$t.kep}.png" alt="" border="0"/>
		</a>
	</td>
	<td class="t_name">
		<div class="t_name">
			<span class="tn_part1">
				<a href="#" rel="{$t.tid}"  title="{$t.name} -- Bõvebb információért klikk ide!" class="torrent_link"> 
					{if $t.name|count_characters > 50}
						{$t.name|substring:1:50}...
					{else}
						{$t.name}
					{/if}
					{if $t.keres_id}
					&nbsp;[&nbsp;<a href="keresek.php?id={$t.keres_id}" >Kérésre</a>&nbsp;]
					{/if}
				</a>
				<!--a href="letolt.php?ingyen=yes"  class="pic" style="display:{if $t.ingyen=='yes'}inline{else}none{/if};color:#ff0000;" id="ingyen_{$t.tid}">
					<span class="tooltip" title="Ingyenes torrent! Ezt a torrentet ha letöltöd nem adja hozzá a letöltésedhez, csak a feltöltést számolja!">[Ingyenes]</span>
				</a-->
			</span>
			<div class="tn_part2">
				<img border="0" src="kinezet/{$ipanel.smink}/torrent_bookmarkit.png" alt="{$t.tid}" style="display:{if $t.konyv>0}none{else}block{/if}" id="addk_{$t.tid}" class="addkonyv" title="Hozzáadás a könyvjelzõkhöz" />
				<img border="0" src="kinezet/{$ipanel.smink}/torrent_delbookmark.png" alt="{$t.tid}" style="display:{if $t.konyv>0}block{else}none{/if}" id="delk_{$t.tid}" class="delkonyv" title="Törlés a könyvjelzõkbõl" />
			</div>
			<div class="tn_part3">
				<img border="0" src="kinezet/{$ipanel.smink}/torrent_new.png" 						  			style="display:{if $t.uj_torrent==true}inline{else}none{/if}" class="flag_new" title="Új jelzés(ek) eltûntetése." />
				<img border="0" src="kinezet/{$ipanel.smink}/torrent_hidden.png"	id="hidden_{$t.tid}"		style="display: {if $t.hidden=='yes'}inline{else}none{/if};"  title="Rejtett torrent" />
				<img border="0" src="kinezet/{$ipanel.smink}/torrent_locked.png" 	id="hsz_tiltva_{$t.tid}"	style="display:{if $t.hsz_lezarva=='yes'}inline{else}none{/if};"  title="Zárolt hozzászólások"/>
				<img border="0" src="kinezet/{$ipanel.smink}/torrent_checked_0.png" id="noellen_{$t.tid}"		style="display:{if empty($t.admin_id)}inline{else}none;{/if};"  title="Ellenõrizetlen torrent"/>
				<img border="0" src="kinezet/{$ipanel.smink}/torrent_checked_1.png" id="ellen_{$t.tid}"			style="display:{if !empty($t.admin_id) && empty($t.admin_megj)}inline{else}none{/if};"  title="A torrent megfelel a szabályoknak"/>
				<img border="0" src="kinezet/{$ipanel.smink}/torrent_checked_2.png" id="erellen_{$t.tid}"		style="display:{if !empty($t.admin_megj)}inline{else}none{/if};"  title="A torrent nem felel meg a szabályoknak"/>
				<a href="letolt.php?ingyen=yes" class="pic"><img border="0" src="kinezet/{$ipanel.smink}/torrent_free.png" style="display:{if $t.ingyen=='yes'}inline{else}none{/if}" id="ingyen_{$t.tid}"  title="Ingyen torrent" /></a>
			</div>
		</div>
	</td>
	<td class="t_down">
		<a href="letoltes.php?id={$t.tid}" title="Torrent letöltése" class="pic">
			<img border="0" src="kinezet/{$ipanel.smink}/torrent_download.png" alt="" title="Letöltés"/>
		</a>
	</td>
	<td class="t_meret">
		{$t.meret|b_to_s}
	</td>
	<td class="t_down">
		<a href="peerlista.php?id={$t.tid}" title="Peer lista megtekintése">
			<span class="peers1">{$t.letoltve}</span>
		</a>
	</td>
	<td class="t_down">
		<a href="peerlista.php?id={$t.tid}" title="Peer lista megtekintése">
			<span class="peers1">{$t.seed}</span>
		</a>
	</td>
	<td class="t_down">
		<a href="peerlista.php?id={$t.tid}" title="Peer lista megtekintése">
			<span class="peers1">{$t.leech}</span>
		</a>
	</td>
	<td class="t_upby">
		<a title="Profil megtekintése" href="userinfo.php?uid={$t.uid}">
			<span class="rank{$t.rang}">{$t.username}</span>
		</a>
	</td>
</tr>
<tr id="kicsi_{$t.tid}" style="display:none;">
	<td colspan="8" >
		<div class="t_info"  id="div_{$t.tid}" style="display:none;opacity:0;">
			{if $admin_panel==true}
			<div class="textlayer">
				<img src="kinezet/{$ipanel.smink}/t_edit.png" alt="" class="inline" border="0">&nbsp;<a  href="letolt_admin.php?modosit={$t.tid}">Szerkesztés</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_delete.png" alt="" class="inline" border="0">&nbsp;<a  href="{$t.tid}"  class="torrent_del">Törlés</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_hide.png" alt="" class="inline" border="0">&nbsp;<a  href="{$t.tid}" class="torrent_hidden" alt="{$t.hidden}">Torrent {if $t.hidden=='yes'}megjelenít{else}elrejt{/if}</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_ingyen.gif" alt="" class="inline" border="0">&nbsp;<a  href="{$t.tid}" class="torrent_ingyen" alt="{$t.ingyen}">{if $t.ingyen=='yes'}Normal{else}Ingyen{/if} torrent</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_lock.png" alt="" class="inline" border="0">&nbsp;<a href="{$t.tid}"  {if $t.hsz_lezarva=='no'}class="hozzaszolas_letiltas">Hozzászólások letiltása{else}class="hozzaszolas_enged">Hozzászólások engedélyezése{/if}</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_check.png" alt="" class="inline" border="0">&nbsp;{if empty($t.adminname)}<a  href="{$t.tid}"  class="torrent_val" >Hitelesit</a>{else}Hitelesítette:{$t.adminname}{/if}&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_modcomment.png" alt="" class="inline" border="0">&nbsp;<a  href="letolt_admin.php?komment={$t.tid}">Megjegyzések</a>
				{if $t.keres_id && $t.keres_jovairva == 'no'}
					<span><img src="kinezet/{$ipanel.smink}/t_check.png" alt="" class="inline" border="0">&nbsp;<a  href="{$t.tid}"  class="torrent_jovair" >Pont jóváírás</a><span>
				{/if}
			</div>
			{/if}
			<div class="textlayer">
				<img src="kinezet/{$ipanel.smink}/torrent_download.png" alt="" class="inline" border="0"/>&nbsp;<a href="letoltes.php?id={$t.tid}">Letöltés</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_nfo.png" alt="" class="inline" border="0">&nbsp;{if $t.nfo_name=='yes'}<a  href="{$t.tid}"   class="nfo_view" >NFO</a>{else}NFO nem elérhetõ{/if}&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_details.png" alt="" class="inline" border="0">&nbsp;<a  href="adatlap.php?id={$t.tid}">Adatlap</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_comments.png" alt="" class="inline" border="0">&nbsp;<a  href="adatlap.php?id={$t.tid}">Hozzászólások ({$t.comment})</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_size.png" alt="" class="inline" border="0">&nbsp;Méret: {$t.meret|b_to_s}&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_files.png" alt="" class="inline" border="0">&nbsp;<a class="torrent_files" href="{$t.tid}"  title="Fájlok megtekintése">Fájlok száma: {$t.fajldb}</a>&nbsp;&nbsp;
				<img src="kinezet/{$ipanel.smink}/t_datetime.png" alt="" class="inline" border="0">&nbsp;Feltöltve: {$t.datum}
				{if $t.sajat_torrent==true && $admin_panel!=true}
					&nbsp;&nbsp;<img src="kinezet/{$ipanel.smink}/t_edit.png" alt="" class="inline" border="0">&nbsp;<a  href="letolt_admin.php?modosit={$t.tid}">Torrent szerkesztése</a>
				{/if}
			</div>
			<div class="textlayer" id="toltodiv_{$t.tid}" style="display:none;">								
				<br /><div class="center"><img src="kinezet/{$ipanel.smink}/loading.gif"  /></div><br />
			</div>
			
			<div   id="nfodiv_{$t.tid}" style="display:none;opacity:0;"></div>
			
			<div class="textlayer" id="tartalom_{$t.tid}">
				{if !empty($t.admin_megj)}
					<div id='admin_komment_{$t.tid}'>
						<h2>Moderátori megjegyzések: 
						{if admin_panel==true}(<a  class="del" alt="{$t.tid}" href="#" title="Megjegyzés törlése">X</a>){/if}</h2>
						<div class="separator_left_long"></div><br>
						<div class="modcomment">{$t.admin_megj}
							<br><br><br><span style="font-style: italic;">Írta: <a  href="userinfo.php?uid={$t.admin_id}" >{$t.adminname}</a>, ekkor: {$t.admin_datum}.</span>
						</div>
						<br /><br />
					</div>
				{/if}
				
				<h2>Leírás:</h2>
				<div class="separator_left_long"></div>
					{if !empty($t.kep1) || !empty($t.kep2) || !empty($t.kep3)  }
					<div class="center">
						{if !empty($t.kep1)}
							<a href="{$t.kep1}" class="pic thickbox" target="_blank" rel="kepcsoport_{$t.tid}" ><img src="kinezet/{$ipanel.smink}/imgview.gif" border="0" /></a>
						{/if}
						{if !empty($t.kep2)}
							<a href="{$t.kep2}" class="pic thickbox" target="_blank" rel="kepcsoport_{$t.tid}" ><img src="kinezet/{$ipanel.smink}/imgview.gif" border="0" /></a>
						{/if}
						{if !empty($t.kep3)}
							<a href="{$t.kep3}" class="pic thickbox"target="_blank" rel="kepcsoport_{$t.tid}" ><img src="kinezet/{$ipanel.smink}/imgview.gif" border="0" /></a>
						{/if}
					</div><br />						
					{/if}
					{if !empty($t.megjelen) }
						<br />Megjelenés:{$t.megjelen}
					{/if}
					{if !empty($t.honlap) }
						<br />Honlap:<a href="{$t.honlap}" target="_blank">{$t.honlap}</a>
					{/if}
					{if $t.eredeti=='y' }
						<br />Eredeti release 
					{/if}
					
				<br /><br />
				{$t.megjegyzes}
			</div>			
			<div class="center" style="padding-bottom: 15px; padding-top: 10px;">
				<a  href="#" rel="{$t.tid}" class="torrent_link_kep"><img src="kinezet/{$ipanel.smink}/t_closedetails.png" alt="" border="0"></a>
			</div>
			
		</div>						
	</td>
</tr>