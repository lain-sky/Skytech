
{$modulnev|section_open}
<div class="center">
	<form method="post" action="{$lap_cime}" >			
		<h2>Ingyen torrent</h2>			
		<br />
		<table  class="skinned" >
				<tr>
					<td  class="left">Kategóriára</td>
					<td  class="left">
						<select name="kategoria" class="skinned" >
							<option value="mind">Összes kategóriára</option>
							{foreach from=$kategoriak item=k}
							<option value="{$k.value}">{$k.text}</option>
							{/foreach}
						</select>	
					</td>							
				</tr>						
				<tr>
					<td class="left">Feladat</td>
					<td class="left">
						<label for="ingyen_yes"><input type="radio" name="feladat" value="ingyen_yes" id="ingyen_yes">&nbsp;A kijelöltek ingyen torrentek</label><br />
						<label for="ingyen_no"><input type="radio" name="feladat" value="ingyen_no" id="ingyen_no">&nbsp;A kijelöltek NEM ingyen torrentek</label>
					</td>
					
				</tr>
								
		</table><br /><br />
		<input type="hidden" name="modul" value="torrent_save" />
		<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
	</form>
</div>

{$modulnev|section_end}