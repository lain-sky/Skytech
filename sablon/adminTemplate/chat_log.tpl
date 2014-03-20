{'Szobak'|section_open}
<div align="center">
	
	{foreach from=$szobak item=szoba key=i}
		{if $i != 0}&nbsp;&bull;&nbsp;{/if}
		<a href="{$lap_cime}?modul=chat_log&id={$szoba.cszid}">{$szoba.nev}</a>
	{/foreach}
	
</div>
{'Szobak'|section_end}

{if $data}

{$modulnev|section_open}
<div align="center">
		<h2>{$aktszoba.nev}</h2>
		
		<table class="skinned" style="width:700px;">
			<tr class="head">
				<td>&nbsp;</td>
				<td>Üzenet</td>
				<td>&nbsp;</td>
			</tr>
	{foreach from=$data item=row key=i}
	
		{if $i is even}
			<tr class="t_even">
		{else}
			<tr class="t_odd">
		{/if}
			<td>{$i+1}</td>
			<td class="left">{$row.comment}</td>
			<td >
				<a href="{$lap_cime}?modul=chat_log_del&id={$row.id}&ret={$aktszoba.cszid}" class="confirm pic" title="Hozzászólás törlése">
					<img src="kinezet/{$ipanel.smink}/t_delete.png" alt="" class="inline" border="0">
				</a>
			</td>
		</tr>
	{/foreach}
	</table>
	<br /><br />
	[ <a href="{$lap_cime}?modul=chat_log_kiurit&id={$aktszoba.cszid}" class="confirm" title="Szoba kiürítése">Szoba kiürítése</a> ]
	
</div>
{$modulnev|section_end }
{/if}