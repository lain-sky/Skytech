{$modulnev|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
		<input  type="hidden" name="modul" value="doc_save" />
		{if $data.cid}
			<input type="hidden" name="id" value="{$data.cid}" />
		{/if}
		Cím: <input class="skinned" type="text" name="cim" value="{$data.cim}" size="45"/>
		&nbsp;&nbsp;
		Kategória
		<select class="skinned" name="mihez">
			{foreach from=$docType item=row key=k}
				<option value="{$k}" {if $k == $data.mihez }selected="selected"{/if}>{$row}</option>
			{/foreach}
		</select>
		&nbsp;&nbsp;
		Súly: <input class="skinned" type="text" name="suly" value="{$data.suly}" style="width:30px;" size="3"/>
		&nbsp; ( alap:100 )
		<br />
		<br />		
		{include file='bbcode.tpl'}
		<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 500px;">{$data.text}</textarea></div>
		<br /><br />
		<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
	</form>
</div>
{$modulnev|section_end}