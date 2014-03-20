{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	
	{'Átadás'|section_open}
	<br /><br />
		
			
		<form method="post" action="atadas.php">
		<table class="skinned" style="text-align:left;">
			<tr>
				<td><img src="kinezet/{$ipanel.smink}/warned.png" border='0' /></td>
				<td>Figyelem úgy adhatsz át feltöltést, hogy az arányodnak 1.5 felett kell maradnia!</td>
			</tr>
			<tr>
				<td>Kedvezményezet</td>
				<td><input type="text" name="fogado_user"  id="fogado_user" class="skinned" /></td>
			</tr>
			<tr>
				<td>Menniység:</td>
				<td>
					<input type="text" name="mennyiseg" class="skinned"  />&nbsp;
					<select name="egyseg" class="skinned">
						<option value='mb' selected="selected">MB</option>
						<option value='gb' >GB</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Max. átadható</td>
				<td>{$max|b_to_s}</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image" id="keres_btn" />
				</td>
			</tr>
		</table>
		</form>
		
		
		<br /><br />
	{'Átadás'|section_end}
	
</div>
<script language="javascript" src="scriptek/atadas.js"></script>
{* a labresz csatolasa *}
{include file='labresz.tpl'}