{$modulnev|section_open}
<div class="center">
	<form method="post" action="{$lap_cime}" id="trackersettings">			
		<h1 style="color:#ff0000;">Figyelem!<br />A hibás beállítások, az tracker TELJES összeomlásához vezethet!!</h1>
	
		<br />
		<table  class="skinned" >
				<tr class="head">
					<td>Változó</td>
					<td>Jelenleg</td>
					<td width="250px">Új érték</td>
				</tr>
				{foreach from=$vars item=v}
					<tr>
						<td class="left"><span class="tooltip" title="{$v.leiras}">{$v.name}</span></td>
						<td class="left">{$v.value}</td>
						<td class="left">
						{if $v.var=='korlatozas_rang'}
							<select class="skinned" name="param[{$v.var}]">
								<option></option>
								{foreach from=$rangok item=r key=i}
									<option value="{$i}">{$r}</option>
								{/foreach}
							</select>
						{elseif $v.var=='adat_korlatozas' || $v.var=='slot_korlatozas' || $v.var=='tracker'}
							<label for="{$v.var}_yes" ><input type="radio" id="{$v.var}_yes" name="param[{$v.var}]" class="skinned" value="yes" />Bekapcsol</label> &nbsp;&nbsp;
							<label for="{$v.var}_no" ><input type="radio" id="{$v.var}_no" name="param[{$v.var}]" class="skinned" value="no" />Kikapcsol</label> 
						{elseif $v.var=='tracker_kikapcsol_text'}
							<input type="text" id="{$v.var}" name="param[{$v.var}]" class="skinned myform" style="width:250px;"  />								
						{else}
							<input type="text" id="{$v.var}" name="param[{$v.var}]" class="skinned myform" style="width:250px;" alt="num" />
						{/if}
						</td>
					</tr>
				{/foreach}					
		</table><br /><br />
		<input type="hidden" name="modul" value="varsave" />
		<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
	</form>

	<div id="hiba_div" >			
		<p class="error" id="error_num" style="display:none;">A mezõbe csak szám kerülhet!!!</p>
	</div>

</div>		
{$modulnev|section_end}