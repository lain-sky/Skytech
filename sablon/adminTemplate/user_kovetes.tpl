{$modulnev|section_open}
<div class="center">
<form method="post" action="{$lap_cime}" >				
	<input type="hidden" name="modul" value="user_kovetes" />
	
	<table style="margin:auto;">
		<tr>
			<td>UserId*:</td>
			<td><input type="text" name="uid"  class="skinned" value="{$uid}" /></td>
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
					<td>User:</td>
					<td><a href="userinfo.php?uid={$uid}" target="_blank" >{$userName}</a></td>
				</tr>
			</table>
			<br /><br />
		
		
			<table class="skinned" style="text-align:left;">
				<tr class="head">
					<td>&nbsp;</td>
					<td>Oldal</td>
					<td>OS</td>
					<td>Böngészö</td>
					<td>IP</td>
					<td>Rögzítve</td>						
				</tr>
				
				{foreach from=$data item=user key=i}
					<tr>
						<td>{$i+1}</td>
						<td><a href="{$user.fajl}?{$user.qstring}" target="_blank" >{$user.fajl}</a></td>
						<td>{$user.os}</td>
						<td>{$user.bongeszo} {$user.bongeszo_ver}</td>
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