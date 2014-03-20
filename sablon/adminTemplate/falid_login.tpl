{if $data}
	{$modulnev|section_open}
	<div align="center">
			<h2>falid Login ( {$datum} )</h2><br />
			
			<table class="skinned" style="width:500px;">
				<tr class="head">
					<td>&nbsp;</td>
					<td><a href="{$lap_cime}?modul=falidLoginLog&group=username" title="UserName alapján csoportba rendezés">UserNév</a></td>
					<td><a href="{$lap_cime}?modul=falidLoginLog&group=ip" title="IP alapján csoportba rendezés">IP</a></td>
					<td>Alkalom</td>
					<td>&nbsp;</td>
				</tr>
		{foreach from=$data item=row key=i}
		
			{if $i is even}
				<tr class="t_even">
			{else}
				<tr class="t_odd">
			{/if}
				<td>{$i+1}</td>
				<td class="left">{$row.username}</td>
				<td >{$row.ip}</td>
				<td >{$row.db}</td>
				<td >
					<a href="{$lap_cime}?modul=falidLoginLogClear&name={$row.username}&ip={$row.ip}&group={$group}" class="confirm pic" title="Hibás bejelntkezések törlése">
						<img src="kinezet/{$ipanel.smink}/t_delete.png" alt="" class="inline" border="0">
					</a>
				</td>
			</tr>
		{/foreach}
		</table>
		
		
	</div>
	{$modulnev|section_end }
{/if}




