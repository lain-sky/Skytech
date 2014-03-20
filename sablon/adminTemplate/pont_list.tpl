{if $data}
	{$modulnev|section_open}
	<div align="center">
			<h2>{$modulnev}</h2><br />
			
			<table class="skinned" style="width:500px;">
				<tr class="head">
					<td>&nbsp;</td>
					<td>UserNév</td>
					<td>Pont</td>
				</tr>
		{foreach from=$data item=row key=i}
		
			{if $i is even}
				<tr class="t_even">
			{else}
				<tr class="t_odd">
			{/if}
				<td>{$i+1}</td>
				<td class="left">{$row.name}</td>
				<td >{$row.ossz}</td>
			</tr>
		{/foreach}
		</table>
		
		
	</div>
	{$modulnev|section_end }
{/if}




