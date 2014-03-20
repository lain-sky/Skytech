{$modulnev|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
		<input  type="hidden" name="modul" value="uzenofal_save" />
		<input  type="hidden" name="disp" value="block" />
		<!-- input  type="hidden" name="datum" value=""/-->
		{if $data.cid}
			<input type="hidden" name="id" value="{$data.cid}" />
		{/if}
		Cím: <input class="skinned" type="text" name="cim" value="{$data.cim}" size="45"/>&nbsp;

		
		{include file='bbcode.tpl'}
		<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$data.text}</textarea></div>
		<br /><br />
		<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
	</form>
</div>
{$modulnev|section_end}