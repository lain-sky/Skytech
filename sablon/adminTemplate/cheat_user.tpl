{$modulnev|section_open}
<div class="center">
	<form method="post" action="{$lap_cime}" >				
		<input type="hidden" name="modul" value="cheat_user" />
		
		<table style="margin:auto;">
			<tr>
				<td>UserId*:</td>
				<td><input type="text" name="uid"  class="skinned" value="{$uid}" /></td>
			</tr>
			<tr>
				<td>TorrentId*:</td>
				<td><input type="text" name="tid"  class="skinned" value="{$tid}" /></td>
			</tr>						
			<tr>
				<td>Dátumtól:</td>
				<td><input type="text" name="datumtol" id="datumtol" class="skinned" value="{$datumtol}" /></td>
			</tr>
			<tr>
				<td>Dátumig:</td>
				<td><input type="text" name="datumig" id="datumig" class="skinned" value="{$datumig}" /></td>
			</tr>								
		</table>
						
		<br /><br />
		<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
	</form>

</div>		

{$modulnev|section_end}	
	{if $data}
		{'Találatok'|section_open}
			<div class="center">
				<table style="margin:auto;">
					<tr>
						<td>Torrent:</td>
						<td><a href="adatlap.php?id={$tid}" target="_blank">{$torrentName}</a></td>
					</tr>
					<tr>
						<td>User:</td>
						<td><a href="userinfo.php?uid={$uid}" target="_blank" >{$userName}</a></td>
					</tr>
				</table>
				<br /><br />
			
			
				<table class="skinned" style="text-align:left;">
					<tr class="head">
						<td>&nbsp;</td>
						<td>Feltöltés</td>
						<td>Sebesség</td>
						<td>Letöltés</td>
						<td>Sebesség</td>
						<td>IP</td>
						<td>Rögzítve</td>						
					</tr>
					
					{foreach from=$data item=user key=i}
						<tr>
							<td>{$i+1}</td>
							<td>{$user.fel|b_to_s}</td>
							<td>{$user.felseb|b_to_s}/s</td>
							<td>{$user.le|b_to_s}</td>
							<td>{$user.leseb|b_to_s}/s</td>
							<td>{$user.ip}</td>
							<td>{$user.datum}</td>
						</tr>
					{foreachelse}	
						<tr>
							<td colspan="7">
								nincs talalálat!
							</td>
						</tr>
					{/foreach}
				</table>
			</div>
		{'Találatok'|section_end}
	{/if}
	
	
	