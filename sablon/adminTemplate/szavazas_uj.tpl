{$modulnev|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
		<input  type="hidden" name="modul" value="szavazas_save" />
		{if $modId}
			<input type="hidden" name="id" value="{$modId}" />
			{foreach from=$form key=i item=e}
				<div class="leftcolumn" style="width: 68px;">{$e.olv}:</div>
				<div class="rightcolumn"><input name="{$e.id}" size="70" class="skinned" type="text" value="{$e.val}"></div>
			{/foreach}
		{else}
			{foreach from=$data key=i item=e}
				<div class="leftcolumn" style="width: 68px;">
					{$e.olv}:
				</div>
				<div class="rightcolumn">
					<input name="{$e.id}" size="70" class="skinned" type="text" value="{$e.val}">
				</div>
			{/foreach}			
		{/if}
			
			
				
		<br /><br />
		<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
	</form>
</div>
{$modulnev|section_end}