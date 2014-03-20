{$modulnev|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
		<input  type="hidden" name="modul" value="hir_save" />
		{if $data.hid}
			<input type="hidden" name="id" value="{$data.hid}" />
		{/if}
		Dátum: <input class="skinned" type="text" name="datum" value="{$data.datum}" size="20"/>&nbsp;
		Cím: <input class="skinned" type="text" name="cim" value="{$data.cim}" size="45"/>&nbsp;

		Megjelenítés:
		<select class="skinned" name="disp">
			<option value="block" selected="selected">Hír mutatása alapértelmezettként</option>
			<option value="none">Hír elrejtése alapértelmezettként</option>
		</select>
		<br />
		<br />		
		{include file='bbcode.tpl'}
		<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$data.text}</textarea></div>
		<br /><br />
		<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
	</form>
</div>
{$modulnev|section_end}