{$modulnev|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
		Csoport neve: <input class="skinned" type="text" name="cim" value="{$data.cim}" size="50"/>&nbsp;
	<br />
	
	{if $data.fid }
		<input  type="hidden" name="id" value="{$data.fid}" />
	{/if}
	
		<input  type="hidden" name="modul" value="temakor_save" />
		<div class='dialog_content'>
			<input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/>
		</div>
	</form>
</div>
{$modulnev|section_end}