{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
				<h2>{$modulnev}</h2>
				<table  class="skinned stats" >
					<tr>
						<td class="left">Szoba neve</td>
						<td class="left">
							<input type="text" class="skinned" name="nev" maxlength="30" value="{$mod.nev}" style="width:330px;" />
						</td>
					</tr>
					<tr>
						<td class="left">Szoba leírása</td>
						<td class="left">
							<textarea name="leiras" class="textarea" style="border:1px solid #726D5F;height:60px;width:330px;">{$mod.leiras}</textarea>
						</td>
					</tr>
				</table><br /><br />
				{if !empty($modid)}
					<input type="hidden" name="modid" value="{$modid}" />
				{/if}
				<input type="hidden" name="modul" value="{$feldolgozo_modul}" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		</div>
		{$modulnev|section_end}
		
{if empty($modid)}
	{$modulnev2|section_open}
	<div class="center">	
	<h2>Szoba lista</h2>
	<table  class="skinned stats" >
		<tr class="head">
			<td >Szoba neve</td>
			<td >Szoba leírása</td>
			<td >&nbsp;</td>
		</tr>
		{foreach from=$szobak item=s}
			<tr>
				<td class="left">{$s.nev}</td>
				<td class="left">{$s.leiras}</td>
				<!--td class="left">
					<a href="{$lap_cime}?modul=chat_szoba&modid={$s.cszid}" title="Szoba adatainak szeresztése">Szerkeszt</a>
				</td>
				<td class="left">
					<a href="{$lap_cime}?modul=chat_del_szoba&modid={$s.cszid}" title="Szoba törlése" >Töröl</a>
				</td-->
				<td>
					<a href="{$lap_cime}?modul=chat_del_szoba&modid={$s.cszid}" class="confirm pic" title="Chat szoba törlése">
						<img src="kinezet/{$ipanel.smink}/t_delete.png" alt="" class="inline" border="0">
					</a>
						&nbsp;&bull;&nbsp;
					<a href="{$lap_cime}?modul=chat_szoba&modid={$s.cszid}" class="pic" title="Chat szoba módosítása">
						<img src="kinezet/{$ipanel.smink}/t_edit.png" alt="" class="inline" border="0">
					</a>
				</td>			
			</tr>
		{foreachelse}
			<tr>
				<td colspan="3">Egy árva szobánk sincs még....</td>
			</tr>
		{/foreach}
	</table><br /><br />
	</div>
	{$modulnev|section_end}
{/if}