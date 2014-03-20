{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	
{if !isset($vezerlo)}
		
	{'Keresés a fórum témában'|section_open}
		<div align="center">
			<table  cellpadding="5px" cellspacing="0" class="valasztok" align="center">
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
	
	
	
	{'Téma jellemzése'|section_open}	
		<table width="90%">
			<tr class="head">
				<td align="center" >{$topik.ismerteto}</td>
			</tr>			
		</table>
	{'Téma jellemzése'|section_end}<br />
	
	<div id="pagertab_upper">
			<div>
				{$betuvel.elozo}&nbsp;{$lapozo}&nbsp;{$betuvel.kovetkezo}&nbsp;&nbsp;
				<select class="skinned" size="1" name="page" id="lapozo_select_1" >
						{$selectbe}
				</select>
			</div>
	</div>
	{'Hozzászólások'|section_open}
		<h1 align="center">{$topik.tema}</h1>
		
		{foreach from=$hsz item=h}
		
		<div class="comment">
			<div class="h">
				<span class="h">elküldve
					<a title="Userinfo"	href="userinfo.php?uid={$h.uid}">
						<span class="rank{$h.rang}">{$h.name}</span>
					</a> ({$h.rang_text}) által, ekkor: {$h.datum} 
					
				{if $admin_link==true}					
					 - [<a href="{$oldal_cime}&amp;mod=del&amp;mid={$h.hid}" class="hozzaszolas_torol">Törlés</a>]
				{/if}
				{if $admin_link==true || $h.sajathsz==true}
					 - [<a href="{$oldal_cime}&amp;mod=mod&amp;mid={$h.hid}">Szerkesztés</a>]
				{/if}
				  - [<a href="#" alt="{$h.hid}" class="idezet_link">Idézet</a>]
				  - [<a href="{$oldal_cime}&amp;letolt={$h.hid}">Letölt</a>]
					
				</span>
			</div>
			<div class="i">
				<span class="i">
					letöltött: <span class="highlight">{$h.letolt|b_to_s}</span>, 
					feltöltött: <span class="highlight">{$h.feltolt|b_to_s}</span>, aránya: 
					<span class="{$h.arany|aranyszin}">{$h.arany_text}</span>
				</span>
			</div>
			<div class="l">
				<div align="center">
					<a class="pic" title="Userinfo" href="userinfo.php?uid={$h.uid}">
						<img class="avatar" border="1" src="{$h.avatar}" alt=""/>
					</a>
				</div>
			</div>
			<div class="r">
				<div class="c">{$h.text}</div>
			</div>
			<div class="f"></div>
		</div>
		<div class="separator_center_long"></div>


		{/foreach}
	</div></div>
	<div id="pagertab_lower">
		<div>
			{$betuvel.elozo}&nbsp;{$lapozo}&nbsp;{$betuvel.kovetkezo}&nbsp;&nbsp;
			<select class="skinned" size="1" name="page" id="lapozo_select_2">
					{$selectbe}
			</select>
		</div>
	</div><br /><br />
	
	
	{if $ujhsz==true }	
		{'Új hozzászólás'|section_open}
		<div align="center">	
			<form action="{$oldal_cime}" method="post">
				{include file='bbcode.tpl'}
				<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;"></textarea></div>
				<br />
				<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
				{$modmezo}
			</form>
		</div>
		{'Új hozzászólás'|section_end}
	{/if}
{/if}	

	{if $vezerlo=='mod' || $vezerlo=='torol' }	
		{$fejlec|section_open}
		<div align="center">	
			<form action="{$oldal_cime}" method="post">
				{if $vezerlo=='mod'}
				{include file='bbcode.tpl'}
				<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$dat.text}</textarea></div>
				{else}
					<div class="center">
					<p style="color:red;">Biztos törölni szeretnéd a fórum hozzászólást?</p>
					</div>					
				{/if}
				<br />
				<div class='dialog_content'><input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/></div>
				{$modmezo}
			</form>
		</div>
		{'Új hozzászólás'|section_end}
	{/if}	
</div>

<script language="javascript" src="scriptek/keres.js" type="text/javascript"></script>









{* a labresz csatolasa *}
{include file='labresz.tpl'}