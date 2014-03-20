<div id="leveltartalom">	
	
	
	{if $modul=='uj' }	
		
		<div style="clear:both">
			<form action="levelezes.php" method="post">
					<div class="leftcolumn" style="width: 59px;">Címzett:</div>
					<div class="rightcolumn"><input id="cimzetuser" class="skinned" type="text" name="cimzet" {if isset($cimzet)} value="{$cimzet}" readonly="readonly" {/if} size="138"/></div>
					<div class="leftcolumn" style="width: 59px;">Tárgy:</div>
					<div class="rightcolumn"><input id="subject" class="skinned" type="text" name="tema" value="{$tema}" size="138"/></div>
				
				{include file='bbcode.tpl'}
				<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$text}</textarea></div>
				<br />
				<div class="formlayer">
					<label for="level_mentes"><input type="checkbox" name="level_mentes" value="1" id="level_mentes"/>&nbsp;Mentés az elküldött üzenetek mappába </label>
				</div>				
				<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
				{$modmezo}
			</form>
		</div>
			
			
		
		
	{elseif $modul=='lista' }
		<div id="mbuttons" class="formlayer">
			{foreach from=$vezerlo_kepek item=k}
			<input type="image" src="kinezet/{$ipanel.smink}/{$k.kep}" title="{$k.title}" id="{$k.id}" disabled="disabled" alt="{$k.alt}" />			
			{/foreach}
			
			
			<div class="help1"><span class="highlight">Segítség:</span> Jelölj ki egy levelet (bal-klikk), hogy használhasd a gombokat. Több levél szemétbe dobásához használd a jelölõnégyzeteket és a lenti hivatkozást! Kattints duplán egy levélen az elolvasásához. A gombok jelentése balról-jobbra: válasz, tobbítás, megjelölés, letöltés, szemétbe dobás.</div>
			
		</div>
					
		<table class="mails">
			<tr class="head">
				<td style="width: 26px;">&bull;</td>
				<td class="left" style="width: 142px;">{$lista_fejlec.erkezet}</td>
				<td class="left" style="width: 228px;">{$lista_fejlec.partner}</td>
				<td class="left" style="width: 483px;">{$lista_fejlec.targy}</td>
			</tr>
			{foreach from=$tartalom item=v key=i}
				<tr 
				{if $v.tipus=='k'}
					class="mail_notice" 
				{elseif $v.tipus=='r'}
					class="mail_system" 
				{else}
					class="mail_normal" 
				{/if}
				id="fej_{$v.id}" {if $v.jelolt_e=='1'}alt="1"{/if}>
					<td><input type="checkbox" id="box_{$v.id}"></td>
					<td class="center">{$v.erkezet}</td>
					<td class="left">{$v.partner}</td>
					<td class="left">
						{if $v.jelolt_e=='1'}<img src="kinezet/{$ipanel.smink}/m_marked.png"  />{/if}
						{$v.targy}
					</td>
				</tr>
				<tr  class="mail_normal" id="torzssor_{$v.id}">
					<td colspan="4">
						<div class="dialog_content" id="torzs_{$v.id}" style="display:none;">
							<div style="width:155px;float:left;padding-bottom:10px;"><img class="avatar" boreder="1" src="{$v.avatar}" /></div>					
							<div style="width:700px;float:right;text-align:left;padding-bottom:10px;">{$v.torzs}</div>				
						</div>
					</td>					
				</tr>
				
			{/foreach}
				<tr>
					<td><img src="kinezet/{$ipanel.smink}/m_selected.png" alt="" border="0"></td>
					<td class="left" colspan="3">
						<span class="highlight">
							 <a href="#" id="mind_kijelol" >[ Mindet kijelöli]</a> &bull; 
							 <a href="#" id="no_kijelol">[ Kijelölés törlése ]</a> &bull; 
							 <a href="#" id="fordit_kijelol">[ Kijelölés megfordítása ]</a>
						</span>
					</td>
				</tr>
		</table>
		<div class="legend">
			Színek jelentései: 
			<span class="leg_unread">&nbsp;Olvasatlan üzenet&nbsp;</span> &bull; 
			<span class="leg_friend">&nbsp;levél egy barátodtól&nbsp;</span> &bull; 
			<span class="leg_system">&nbsp;rendszerüzenet&nbsp;</span> &bull; 
			<span class="leg_notice">&nbsp;körlevél&nbsp;</span> &bull; 
			<span class="leg_highli">&nbsp;kijelölt levél&nbsp;</span>
		</div>

	{/if}
	
	
</div>