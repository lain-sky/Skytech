{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}<br /><br />
	{/foreach}
	
	{if $adminlink==true}
		{'Torrent módosítás'|section_open}		
		<form method="post" action="letolt_admin.php" enctype="multipart/form-data">
			
			<table>
				<tr>
					<td>Torrent név:</td>
					<td><input id="tname" name="tname" size="72" class="skinned" type="text" value="{$name}" /></td>
				<tr>
				<tr>
					<td>Kategória:</td>
					<td>
						<select id="tcategory" name="tcategory" class="skinned" >
							{foreach from=$tipusok key=id  item=t}
								<option value="{$t.kid}" {if $t.kid==$kategoria}selected="selected"{/if} >{$t.nev}</option>
							{/foreach}									
						</select>
					</td>
				<tr>
				<tr>
					<td>NFO fájl:</td>
					<td><input id="mezo1" name="tnfo" size="61" class="skinned"  type="file"></td>
				<tr>
				<tr>
					<td>Elsõ kép:</td>
					<td><input  name="kep1" size="72" class="skinned" type="text" value="{$kep1}" /></td>
				<tr>
				<tr>
					<td>Második kép:</td>
					<td><input  name="kep2" size="72" class="skinned" type="text" value="{$kep2}" /></td>
				<tr>
				<tr>
					<td>Harmadik kép:</td>
					<td><input  name="kep3" size="72" class="skinned" type="text" value="{$kep3}" /></td>
				<tr>
				<tr>
					<td colspan="2">Torrent leírás:</td>
				<tr>
				<tr>
					<td colspan="2">
						{include file='bbcode.tpl'}
						<div class="textarea"><textarea name="megj" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$megj}</textarea></div>
					</td>
					
				<tr>
			</table>
			<input type="hidden" name="tid" value="{$tid}" />			
			<br /><br />
			<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
		</form>	
		
		{'Feltöltétsi segédlet'|section_end}	
	{/if}
	
	{if $adminlink2==true}
		{$name|section_open}		
		<form method="post" action="letolt_admin.php">			
			<table>
				<tr>
					<td colspan="2">Admin megjegyzés:</td>
				<tr>
				<tr>
					<td colspan="2">
						{include file='bbcode.tpl'}
						<div class="textarea"><textarea name="admin_megj" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$admin_megj}</textarea></div>
					</td>
					
				<tr>
			</table>
			<input type="hidden" name="tid" value="{$tid}" />			
			<br /><br />
			<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
		</form>				
		{'Feltöltétsi segédlet'|section_end}	
	{/if}
</div>
{* a labresz csatolasa *}
{include file='labresz.tpl'}