{$modulnev|section_open}
<div align="center">

	
		<h2>Warn Lista</h2>
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
					<a href="{$lap_cime}?modul=warn_del&id={$row.wid}" class="confirm pic" title="Warn törlése">
						<img src="kinezet/{$ipanel.smink}/t_delete.png" alt="" class="inline" border="0">
					</a>
				</td>
			</tr>
		{foreachelse}
			<tr>
				<td colspan="6">Nagyon jók az userek, mert nincs aktív warn </td>
			<td>
		{/foreach}	
		</table>
		<br />
			<a href="{$lap_cime}?modul=warn_uj">[ új WARN ]</a>
		<br /><br />
		<div class="separator_center_long" ></div>	<br />	
	

</div>
{$modulnev|section_end}