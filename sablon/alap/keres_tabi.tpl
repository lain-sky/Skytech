<tr id="nagy_{$t.kid}" {if $k is even}class="t_even"{else}class="t_odd"{/if}>
	<td class="t_icon">
		<a href="keresek.php?tipus={$t.kid}" title="{$t.leir}" class="pic">
			<img src="kinezet/{$ipanel.smink}/category_icons/{$t.kep}.png" alt="" border="0"/>
		</a>
	</td>
	<td class="t_name">
		<div class="t_name">
			<span class="tn_part1">
				<a href="#" rel="{$t.kid}"  title="{$t.name} -- Bõvebb információért klikk ide!" class="torrent_link"> 
					{if $t.name|count_characters > 65}
						{$t.name|substring:1:65}...
					{else}
						{$t.name}
					{/if}
				</a>
			</span>
			<div class="tn_part2">
				{if $t.status=='teljesitve'}
					<img border="0" src="kinezet/{$ipanel.smink}/torrent_locked.png" alt="{$t.tid}" style="display:block"  title="A kérést teljesítették" />
				{/if}
			</div>
			<div class="tn_part3">&nbsp;</div>
		</div>
	</td>
	<td class="t_down">
		{$t.kertek}
	</td>
	<td class="t_meret">
		{$t.pontok} Sky-Pont
	</td>
	<td class="t_sele">
		{$t.kerve}
	</td>
	<td class="t_upby">
		<a title="Profil megtekintése" href="userinfo.php?uid={$t.uid}">
			<span class="rank{$t.rang}">{$t.username}</span>
		</a>
	</td>
</tr>
<tr id="kicsi_{$t.kid}" style="display:none;">
	<td colspan="6" >
		<div class="t_info"  id="div_{$t.kid}" style="display:none;opacity:0;">
			<div class="textlayer">
				{if ($t.sajat==true || $admin_panel==true) && $t.status !='teljesitve' }
					<img src="kinezet/{$ipanel.smink}/t_edit.png" alt="" class="inline" border="0">&nbsp;<a  href="kerek.php?modosit={$t.kid}">Kérés szerkesztése</a>&nbsp;&nbsp;
				{/if}
				
				{if $admin_panel==true}
					<img src="kinezet/{$ipanel.smink}/t_delete.png" alt="" class="inline" border="0">&nbsp;<a  href="{$t.kid}"  class="keres_del">Kérés törlése</a>&nbsp;&nbsp;
				{/if}
				
				{if $t.status !='teljesitve'}
					<img src="kinezet/{$ipanel.smink}/t_comments.png" alt="" class="inline" border="0">&nbsp;<a  href="{$t.kid}"  class="keres_csatlakozas">Csatlakozás a kéréshez</a>&nbsp;&nbsp;
					<img src="kinezet/{$ipanel.smink}/torrent_upload.png" alt="" class="inline" border="0">&nbsp;<a  href="feltolt.php?keres={$t.kid}" >Kérés teljesítése</a>&nbsp;&nbsp;
				{/if}
			</div>
			
			{*
			<div class="textlayer" id="toltodiv_{$t.kid}" style="display:none;">								
				<br /><div class="center"><img src="kinezet/{$ipanel.smink}/loading.gif"  /></div><br />
			</div>
			*}
			
			
			<div   id="nfodiv_{$t.kid}" style="display:none;opacity:0;"></div>
			
			{if $t.megjegyzes }
			<div class="textlayer" id="tartalom_{$t.kid}">
								
				<h2>Leírás:</h2>
				<div class="separator_left_long"></div>
				<br />
					{$t.megjegyzes}
			</div>			
			{/if}
			<div class="center" style="padding-bottom: 15px; padding-top: 10px;">
				<a  href="#" rel="{$t.kid}" class="torrent_link_kep"><img src="kinezet/{$ipanel.smink}/t_closedetails.png" alt="" border="0"></a>
			</div>
			
		</div>						
	</td>
</tr>