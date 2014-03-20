{'Keresõ'|section_open}
<div align="center">
	<form action="{$lap_cime}" method="post">
	<input  type="hidden" name="modul" value="regfalid_lista" />
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

{$modulnev|section_open}
<div align="center">

	
		<h2>Meg nem erosített regisztraciok</h2>
		<table class="skinned" style="width:700px;">
		<tr class="head">
			<td>&nbsp;</td>
			<td>User Name</td>
			<td>Email</td>
			<td>Regisztralt</td>
			<td>&nbsp;</td>
		</tr>
		{foreach from=$errorList item=row key=i}
			{if $i is even}
				<tr class="t_even">
			{else}
				<tr class="t_odd">
			{/if}
				<td>{$i+1}</td>
				<td>
					{$row.name}
				</td>
				<td >
					{$row.email}
				</td>
				<td>
					{$row.reg_date}
				</td>
				<td>
					<a href="{$lap_cime}?modul=regfalid_resend&id={$row.uid}" class="confirm pic" title="Regisztració újarküldése!">
						<img src="kinezet/{$ipanel.smink}/t_files.png" alt="" class="inline" border="0">
					</a>
					&nbsp;&bull;&nbsp;
					<a href="{$lap_cime}?modul=regfalid_confirm&id={$row.uid}" class="confirm pic" title="Regisztráció megerosítése">
						<img src="kinezet/{$ipanel.smink}/t_edit.png" alt="" class="inline" border="0">
					</a>
				</td>
			</tr>
			
		{foreachelse}
			<tr>
				<td colspan="5">Nincs találat</td>
			</tr>
		{/foreach}	
		</table>
		
		<br /><br />
		<div class="separator_center_long" ></div>	<br />	
	

</div>
{$modulnev|section_end}




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