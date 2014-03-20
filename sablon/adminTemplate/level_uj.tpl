{$modulnev|section_open}
<div align="center">
	
	<div style="clear:both">
		<form action="{$lap_cime}" method="post">
			<input  type="hidden" name="modul" value="level_send" />
			<div style="text-align:left;">	
				<table >
					<tr>
						<td valign="top">Címzettek:</td>
						<td>
							<select name="kinek[]" class="skinned" multiple="multiple">
								{foreach from=$rangok item=rang key=k}
									<option value="{$k}" {if $k==1}selected="selected"{/if}>{$rang}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>Tárgy:</td>
						<td><input id="subject" class="skinned" type="text" name="tema" style="width:400px;"  /></td>
					</tr>
				</table>
		
			<br /> 
			Levél szövege:</div>
			{include file='bbcode.tpl'}
			<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 350px;"></textarea></div>
			<br />
							
			<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
		</form>
	</div>
</div>
{$modulnev|section_end}