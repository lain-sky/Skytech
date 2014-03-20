{'Keresõ'|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
	<input  type="hidden" name="modul" value="pontlog" />
	<table>
		<tr>
			<td>UserId</td>
			<td><input type="text" class="skinned" name="user_id" value="{$data.user_id}" /></td>
		</tr>
		<tr>
			<td>User név</td>
			<td><input type="text" class="skinned" name="user_name" id="user_name" value="{$data.user_name}" /></td>
		</tr>
		<tr>
			<td>Dátumtól</td>
			<td><input type="text" class="skinned" name="datum_tol"  value="{$data.datum_tol}" /></td>
		</tr>
		<tr>
			<td>Dátumig</td>
			<td><input type="text" class="skinned" name="datum_ig"  value="{$data.datum_ig}" /></td>
		</tr>
	</table>
	<input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/>
	</form>
</div>
{'Keresõ'|section_end}






{if $pontLog}

{$modulnev|section_open}
<div align="center">

	
		<h2>Pont Log</h2>
		<table class="skinned" style="width:700px;">
		<tr class="head">
			<td>&nbsp;</td>
			<td>Esemény</td>
			<td>Pont érték</td>
			<td>Dátum</td>
			<td>User</td>
		</tr>
		{foreach from=$pontLog item=row key=i}
			{if $i is even}
				<tr class="t_even">
			{else}
				<tr class="t_odd">
			{/if}
				<td>
					{$i+1}
				</td>
				<td class="left">
					{$row.eventText}
				</td>
				<td>
					{$row.pont}
				</td>
				<td>
					{$row.date}
				</td>
				<td>
					{$row.user_name}
				</td>
			</tr>
		{/foreach}	
		</table>
		
		<br /><br />
		<div class="separator_center_long" ></div>	<br />	
	

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