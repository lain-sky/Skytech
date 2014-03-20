{if $modul=='cheat_stats_reszletes'}

	<div class="center">
		<table class="skinned" style="text-align:left;">
			<tr class="head">
				<td>&nbsp;</td>
				<td>User</td>
				<td>Feltöltés</td>
				<td>Letöltés</td>
				<td>Kliens IP</td>
				<td>User IP</td>
				<td>&nbsp;</td>
			</tr>
			
			{foreach from=$data item=user key=i}
				<tr>
					<td>{$i+1}</td>
					<td><a href="userinfo.php?uid={$user.uid}" target="_blank" >{$user.username}</a></td>
					<td>{$user.feltolt|b_to_s}</td>
					<td>{$user.letolt|b_to_s}</td>
					<td>{$user.kliens_ip}</td>
					<td>{$user.user_ip}</td>
					<td><a href="{$lap_cime}?modul=cheat_user&uid={$user.uid}&tid={$torrentId}" target="_blank">Info</a></td>
				</tr>
			{/foreach}
		</table>
	</div>



{/if}