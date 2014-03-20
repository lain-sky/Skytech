{if $kereso == true}
	{'User keresõ'|section_open}
	<div align="center">
		<form action="{$lap_cime}" method="post">
		<input  type="hidden" name="modul" value="user_mod" />
		<table>
			<tr>
				<td>UserId</td>
				<td><input type="text" class="skinned" name="user_id" value="{$udata.uid}" /></td>
			</tr>
			<tr>
				<td>User név</td>
				<td><input type="text" class="skinned" name="user_name" id="user_name" value="{$udata.name}" /></td>
			</tr>
		</table>
		<input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/>
		</form>
	</div>
	{'User keresõ'|section_end}
{/if}

{if $regForm == true }
	{$modulnev|section_open}
		<div align="center">
			<form action="{$lap_cime}" method="post">
				<input  type="hidden" name="modul" value="user_save" />
				{if $udata.uid}
					<input  type="hidden" name="modid" value="{$udata.uid}" />
				{/if}
				<table class="skinned" style="text-align:left;width:300px;">
						<tr class="head">
							<td>Név</td>
							<td>Érték</td>
						</tr>
						<tr >
							<td>Felhasználói név</td>
							<td><input type="text" name="name"  value="{$udata.name}" class="skinned" /></td>
						</tr>
						<tr>
							<td>Email cím</td>
							<td><input type="text" name="email"  value="{$udata.email}" class="skinned" /></td>
						</tr>
						{if $admin_level == 'tulcsi'}
						<tr>
							<td>Rang</td>
							<td>
								<select class="skinned" name="rang">
									{foreach from=$modRangok item=r key=i}
										<option value="{$i}"{if $i==$udata.rang}selected="selected"{/if}>{$r}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td>Statusz</td>
							<td>
								<select class="skinned" name="statusz">
									{foreach from=$modStatuszok item=r key=i}
										<option value="{$i}"{if $i==$udata.statusz}selected="selected"{/if}>{$r}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						{/if}
						
						
						<tr>
							<td>Jelszó</td>
							<td><input type="text" name="pass"   class="skinned" /></td>
						</tr>
						<tr>
							<td>Smink</td>
							<td>
								<select class="skinned" name="smink">
									{foreach from=$sminkek item=s key=i}
										<option value="{$s.ert}"{if $s.ert==$udata.smink}selected="selected"{/if}>{$s.olv}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td>Egyéni rang</td>
							<td><input type="text" name="egyedi_rang"  value="{$udata.egyedi_rang}" class="skinned" /></td>
						</tr>
						<tr>
							<td>Feltöltés</td>
							<td><input type="text" name="feltolt"  value="{$udata.feltolt}" class="skinned" /></td>
						</tr>
						<tr>
							<td>Letöltés</td>
							<td><input type="text" name="letolt"  value="{$udata.letolt}" class="skinned" /></td>
						</tr>
						<tr>
							<td>Avatar</td>
							<td><input type="text" name="avatar"  value="{$udata.avatar}" class="skinned" /></td>
						</tr>
						<tr>
							<td>Láda címe</td>
							<td><input type="text" name="ladad"  value="{$ladad.ladad}" class="skinned" /></td>
						</tr>
					</table>
					
					<br />Láda text<br />
					{include file='bbcode.tpl'}
					<div class="textarea"><textarea name="ladad_text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$ladad.ladad_text}</textarea></div>
					<br /><br />
				
				
				
				
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
