{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	
	{'Staff'|section_open}
		{foreach name=rangokrabont from=$staff item=rang key=cim}
			<h2>{$cim}</h2>
			<div class="rights">
				{foreach name=userrebont from=$rang key=i item=user}
					
					<div class="staff_block">
						<a href="userinfo.php?uid={$user.uid}" title="{$user.statusz}">
							<img src="kinezet/{$ipanel.smink}/{$user.kep}" border='0' alt="S" />&nbsp;&nbsp;{$user.nev}
						</a>
					</div>					
				
				{/foreach}
			</div>
			<br /><br />
		{/foreach}		
	{'Staff'|section_end}
	
	{if $staffAdmin == true}
		{'Levelek:)'|section_open}
			<table class="skinned">
				<tr class="head">
					<td>&nbsp;</td>
					<td>Feladó</td>
					<td>Tárgy</td>
					<td>Lead</td>
					<td>Válaszok</td>
					<td>&nbsp;</td>
				</tr>
				{foreach from=$levelek item=level key=k}
					<tr {if $k is even}class="t_even"{else}class="t_odd"{/if} id="staffLevel_{$level.lid}">
						<td>{$k+1}</td>
						<td>{$level.partner_nev}</td>
						<td>{$level.targy}</td>
						<td align="left">{$level.lead}</td>
						<td>{$level.valaszok} db</td>
						<td><input type="button" value="Bövebb" class="skinned staffLevelBovebb" alt="{$level.lid}" /></td>
					</tr>
					<tr id="tr_{$level.lid}" style="display:none">
						<td colspan="6" style="position: static;">
							<div id="nagyDiv_{$level.lid}" style="display:none;">
							<div id="div_{$level.lid}" >&nbsp;</div>
							<div class="center" style="padding-bottom: 15px; padding-top: 10px;">
								<img src="kinezet/{$ipanel.smink}/t_closedetails.png" alt="{$level.lid}" id="staffLevelBecsuk_{$level.lid}" class="staffLevelBovebbClose"  style="cursor:pointer;" border="0">
							</div>
						</td>
					</tr>
				{/foreach}
				
				
			</table>
		{'Levélírás'|section_end}
		<script type="text/javascript" src="scriptek/staff.js"></script>
	{/if}
	
	
	{'Levélírás'|section_open}
		<br /><br />
			<div class="center"><h1>Levél írás</h1></div><br />
			<div class="rights">
				<table width="100%">
					<tr>
						<td><img src="kinezet/{$ipanel.smink}/warned.png" border='0' alt="Figyelem" /></td>
						<td>
							Nem válaszolunk, olyan kérdésekre, ami megtalálható a 
							<a href="dokumentacio.php?mit=szab">Szabályzatban</a>, a 
							<a href="dokumentacio.php?mit=gyik">Gy.I.K.-ben</a>, a 
							<a href="dokumentacio.php?mit=link">Linkek között</a>, vagy a 
							<a href="forum.php">fórumban!</a>
						</td>
					</tr>
				</table>
			</div><br /><br />
			<form method="post" action="staff.php">
				
				<div class="leftcolumn" style="width: 59px;">Tárgy:</div>
				<div class="rightcolumn"><input id="subject" class="skinned" type="text" name="tema" value="{$tema}" size="120"/></div>
				
				{if $staffAdmin == true}
				<input type="hidden" id="parent" name="parent" value="0" />
				<input type="hidden"  name="valasz" value="igen" />
				{/if}
				
				{include file='bbcode.tpl'}
				<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$text}</textarea></div>
				<br />
				<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
			</form>
	{'Levélírás'|section_end}
	
	
	
	
</div>
{* a labresz csatolasa *}
{include file='labresz.tpl'}