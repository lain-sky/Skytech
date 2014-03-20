{$modulnev|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
	<input  type="hidden" name="modul" value="topik_save" />
	<table>
		<tr>
			<td>Topik címe:</td>
			<td><input class="skinned" type="text" name="tema" value="{$data.tema}" size="50"/></td>					
		</tr>
		<tr>
			<td>Ismertetõ:</td>
			<td><input class="skinned" type="text" name="ismerteto" value="{$data.ismerteto}" size="50"/></td>					
		</tr>
		<tr>
			<td>Csoport:</td>
			<td>
				<select name="csoport" class="skinned">
					{foreach from=$csoportok key=i item=c}
						<option value="{$c.fid}" {if $c.fid==$data.fid}selected="selected"{/if}>{$c.cim}</option>
					{/foreach}
				</select>
			</td>					
		</tr>
		<tr>
			<td>Min. rang:</td>
			<td>
				<select name="minrang" class="skinned" >
					{foreach from=$rangok key=id item=rang}
						<option value="{$id}" {if $id==$data.minrang}selected="selected"{/if}>{$rang}</option>
					{/foreach}
				</select>
			</td>					
		</tr>
		<tr>
			<td>Státusz:</td>
			<td>
				<label><input type="radio" name="status" value="n" checked="checked" />Nyitot</label>&nbsp;&nbsp;
				<label><input type="radio" name="status" value="z"  {if $data.status=='z'}checked="checked"{/if}/>Zárt</label>
			</td>					
		</tr>
		
		<tr>
		<td colspan="2">&nbsp;
			{if $data.tid }
				<input type="hidden" name="id" value="{$data.tid}" />
			{/if}
			
		</td>
		</tr>
		<tr>
			<td colspan="2" valign="center" style="text-align:center;">
				<input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/>
			</td>
		</tr>
	</table>
	</form>
	
	
	
	
	
	
	
	
	
	
	
	
</div>
{$modulnev|section_end}