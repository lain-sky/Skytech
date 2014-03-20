{if empty($fejlecek_torles)}{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}<br />{/foreach}
	
{/if}	
	

	
		{'Keresés a fórumokban'|section_open}
		<div align="center">
			<table  cellpadding="5" cellspacing="0" class="valasztok" align="center">
		        <tr>
					<td >Keres&eacute;s:&nbsp;</td>
					<td >
						<input class="skinned" size="30" name="keres" id="keres_text" value="{$keres_text}" type="text" />
					</td>					
					<td >
						<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image" id="keres_btn" />
							
					</td>
					<td  >&nbsp;
					{if isset($keres_reset)}
						<input type="image" src="kinezet/{$ipanel.smink}/btn_delete.png" id="keres_reset" />
					{/if}					
					</td>
				</tr>
			</table>			
		</div>		
		{'Keresés'|section_end}
	
		{foreach from=$topikok name=outer key=j item=topik}
			{$focim[$j]|section_open}
				<table class="skinned" width="100%" >
					<tr class="head">
						<td width="4%">&Aacute;llapot:</td>
						<td width="24%">Téma:</td>
						<td width="36%">Ismertet&#337;:</td>
						<td width="18%">Utolsó hozzászólás:</td>
						<td width="18%">Utolsó hozzászóló:</td>
					</tr>
					{foreach from=$topik key=i item=t}
						<tr class="{if $i is even }t_even{else}t_odd{/if}">
							<td height="43"><img src="kinezet/{$ipanel.smink}/topik_{if $t.tipus=='n'}nyitot.gif{else}zart.gif{/if}"  alt="{$t.tipus}" style="border:0px;padding:0px;"/></td> 
							<td><a href="forum_hsz.php?id={$t.tid}">{$t.tema}</a></td> 
							<td><em>{$t.ismerteto}</em></td>
							<td><strong>{$t.hsz_datum}</strong></td>
							<td><a title="Profil megtekint&eacute;se" href="userinfo.php?uid={$t.uid}"><span class="rank10">{$t.name}</span></a></td>						
						</tr>
					{/foreach}
					
				</table>
			{'csopsim'|section_end}
		{/foreach}
	
</div>

<script language="javascript" src="scriptek/keres.js" type="text/javascript"></script>


{if empty($fejlecek_torles)}
{* a labresz csatolasa *}
{include file='labresz.tpl'}
{/if}