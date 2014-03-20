{$modulnev|section_open}
<div align="center">

	
	{foreach from=$data item=rows key=k}
		<h2>{$docType[$k]}</h2>
		<table class="skinned" style="width:700px;">
			{foreach from=$rows item=doc key=i}
				{if $i is even}
					<tr class="t_even">
				{else}
					<tr class="t_odd">
				{/if}
					<td>
						<a href="dokumentacio.php?id={$doc.cid}" target="_blank" title="Dokumentum elölnézete">{$doc.cim}</a>
					</td>
					<td>
						{$doc.mod_user_name}
					</td>
					<td>
						{$doc.mod_date}
					</td>
					<td>
						<a href="{$lap_cime}?modul=doc_del&id={$doc.cid}&type={$doc.mihez}" class="confirm pic" title="Dokumentum törlése">
							<img src="kinezet/{$ipanel.smink}/t_delete.png" alt="" class="inline" border="0">
						</a>
						&nbsp;&bull;&nbsp;
						<a href="{$lap_cime}?modul=doc_mod&id={$doc.cid}" class="pic" title="Dokumentum módosítása">
							<img src="kinezet/{$ipanel.smink}/t_edit.png" alt="" class="inline" border="0">
						</a>						
					</td>
				</tr>
			{/foreach}
			
		</table>
		<br />
			<a href="{$lap_cime}?modul=doc_uj">[ új dokumentum ]</a> 
		<br /><br />
		<div class="separator_center_long" ></div>	<br />	
	{/foreach}	
	

</div>
{$modulnev|section_end}