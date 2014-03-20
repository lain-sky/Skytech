{$modulnev|section_open}
<div align="center">

	
		<h2>BAN Lista</h2>
		<table class="skinned" style="width:700px;">
			<tr class="head">
				<td>User</td>
				<td>Ok</td>
				<td>Lejár</td>
				<td>Kiosztva</td>
				<td>Admin</td>
				<td>&nbsp;</td>
			</tr>
		{foreach from=$data item=row key=i}
			{if $i is even}
				<tr class="t_even">
			{else}
				<tr class="t_odd">
			{/if}
				<td>
					{$row.user}
				</td>
				<td>
					{$row.text}
				</td>
				<td>
					{$row.lejar}
				</td>
					<td>
					{$row.datum}
				</td>
				<td>
					{$row.admin}
				</td>
				<td>
					<a href="{$lap_cime}?modul=ban_del&id={$row.wid}" class="confirm pic" title="Ban törlése">
						<img src="kinezet/{$ipanel.smink}/t_delete.png" alt="" class="inline" border="0">
					</a>
				</td>
			</tr>
		{/foreach}	
		</table>
		<br />
			<a href="{$lap_cime}?modul=ban_uj">[ új BAN ]</a>
		<br /><br />
		<div class="separator_center_long" ></div>	<br />	
	

</div>
{$modulnev|section_end}