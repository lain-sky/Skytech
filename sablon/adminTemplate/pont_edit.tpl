{'User keresõ'|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
	<input  type="hidden" name="modul" value="pont_edit" />
	<table>
		<tr>
			<td>UserId</td>
			<td><input type="text" class="skinned" name="user_id" value="{$data.uid}" /></td>
		</tr>
		<tr>
			<td>User név</td>
			<td><input type="text" class="skinned" name="user_name" id="user_name" value="{$data.name}" /></td>
		</tr>
	</table>
	<input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/>
	</form>
</div>
{'User keresõ'|section_end}


{if $data}
	{'Userinfo'|section_open}
	<div align="center">
		{assign var='uinfo' value=$data}
		{assign var='mailNoHidden' value=true}
		{include file='userinfo_tabi.tpl'}
	</div>
	{'Userinfo'|section_end}


	{$modulnev|section_open}
	<div align="center">
		<form action="{$lap_cime}" method="post">
			<input  type="hidden" name="modul" value="pont_save" />
			<input  type="hidden" name="pontUid" value="{$data.uid}" />
			<h2>Jutalom pontok</h2>
			<table>
				<tr>
					<td>Jutalom típusa</td>
					<td>
						<select name="pontTypes" class="skinned" >
							{foreach from=$pontTypes item=row key=i}
								<option value="{$i}">{$row.name} ({$row.value} Sky-Pont)</option>
							{/foreach}
						</select>
					
					</td>
				</tr>
			</table>
			<br />
			<input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/>
		</form>
	</div>
	{$modulnev|section_end}
{/if}

{literal}
<script type="text/javascript">

var fadeInSuggestion = function(suggestionBox, suggestionIframe) 
{
	$(suggestionBox).fadeTo(300,0.9);
};
var fadeOutSuggestion = function(suggestionBox, suggestionIframe) 
{
	$(suggestionBox).fadeTo(300,0);
};


$('#user_name').Autocomplete({
	source: 'userlista.php',
	delay: 500,
	fx: {
		type: 'slide',
		duration: 400
	},
	autofill: true,
	helperClass: 'autocompleter',
	selectClass: 'selectAutocompleter',
	minchars: 2,
	onShow : fadeInSuggestion,
	onHide : fadeOutSuggestion
});	
</script>
{/literal}