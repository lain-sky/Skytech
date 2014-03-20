{include file='fejresz.tpl'}
{* a fejlec csatolasa *}


{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	
	{'Pontjaim'|section_open}
	<div class="center">	
		<h2>Pontjaim</h2> 		
		<table class="skinned" style="width:700px;">
				<tr class="head">
					<td>&nbsp;</td>
					<td>Esemény</td>
					<td>Pontérték</td>
					<td>Dátum</td>
				</tr>
		{foreach from=$data item=row key=i}
		
			{if $i is even}
				<tr class="t_even">
			{else}
				<tr class="t_odd">
			{/if}
				<td>{$i+1}</td>
				<td class="left">{$row.eventText}</td>
				<td >{$row.pont}</td>
				<td >{$row.date}</td>
			</tr>
		{/foreach}
		</table>	
	</div>
	{'Pontjaim'|section_end}

</div>
{* a labresz csatolasa *}
{include file='labresz.tpl'}