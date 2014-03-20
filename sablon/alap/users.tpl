{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	
	{'Keresés'|section_open}
		<div align="center">
		{foreach from=$betuk item=b}
			<a href="users.php?betu={$b|lower}">&nbsp;{$b}&nbsp;</a>
		{/foreach}
		<br /><br />
		<form method="get" action="users.php">
			<table  cellpadding="5px" cellspacing="0" class="valasztok" align="center">
		        <tr>
					<td >Keresés</td>
					<td >
						<input class="skinned" size="30" name="keres" id="keres_text" value="{$keres_text}" type="text" />
					</td>					
					<td >
						<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image" id="keres_btn" />
							
					</td>					
				</tr>
			</table>
		</form>
		</div>		
		{'Keresés'|section_end}
		
		
		<div id="pagertab_upper">
			<div>
				{$betuvel.elozo}&nbsp;{$lapozo}&nbsp;{$betuvel.kovetkezo}&nbsp;&nbsp;
				<select class="skinned" size="1" name="page" id="lapozo_select_1">
						{$selectbe}
				</select>
			</div>
		</div>
		{'Találatok'|section_open}
		<div class="center">
			<table class="skinned" style="width:750px;">
				<tr class="head">
					<td>&nbsp;</td>	
					<td>Felhasználónév</td>
					<td>Regisztrált</td>
					<td>Utolsó látogatás</td>
					<td>Város</td>
					<td>Rang</td>
				</tr>
					{foreach from=$adat item=uinfo key=i}
						<tr class="{if $i is even }t_even{else}t_odd{/if}">
							<td><img class="avatar" style="height:30px;width:33px;" border="0" src="{$uinfo.avatar}" alt=""/></td>
							<td><a href="#" class="user_link_kep" alt="{$i}">{$uinfo.name}</a></td>
							<td>{$uinfo.reg_date}</td>
							<td>{$uinfo.vizit}</td>
							<td>{$uinfo.varos}</td>
							<td>{$uinfo.rang_text}</td>
						</tr>
						<tr style="display:none;" id="user_tr_{$i}">
							<td colspan="6">
								<div   style="display:none;opacity:0;" id="user_div_{$i}">
									{include file='userinfo_tabi.tpl'}
											
									<div class="center" style="padding-bottom: 15px; padding-top: 10px;">
										<a  href="#" alt="{$i}" class="pic user_link_kep"><img src="kinezet/{$ipanel.smink}/t_closedetails.png" alt="" border="0"></a>
									</div>
								</div>

							</td>							
						</tr>
					{foreachelse}
						<tr>
							<td colspan="6">
								NINCS TALÁLAT<br />
								próbáld meg a helyetesítõ katakterek használatát (* , ?) !
							
							</td>
						</tr>
					{/foreach}
					
					
			</table>
		</div>	
			</div>
		</div>
		<div id="pagertab_lower">
			<div>
				{$betuvel.elozo}&nbsp;{$lapozo}&nbsp;{$betuvel.kovetkezo}&nbsp;&nbsp;
				<select class="skinned" size="1" name="page" id="lapozo_select_2">
						{$selectbe}
				</select>
			</div>
		</div>
		<br /><br />	
</div>
{* a labresz csatolasa *}
{include file='labresz.tpl'}