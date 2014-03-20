{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
		
	{'Használati útmutató'|section_open}
		{if $formba==true}
			<form method="post" action="helpdesk.php">
				<table class="skinned" >
				{foreach from=$helpduser item=u}
					<tr>
						<td>{$u.name}<input  type="hidden" name="idk[{$u.uid}]" value="{$u.uid}" /></td>
						<td><input class="skinned" type="text" value="{$u.text}" name="text[{$u.uid}]" size="130" /></td>
					<tr>
				{/foreach}
					<tr>
						<td colspan="2">
							<input name="submit" value="Ok" type="image" src="kinezet/{$ipanel.smink}/btn_ok.png"/>
						</td>
					</tr>
				</table>
			</form>
	
	
		{else}		
			<h2>{$helpd.cim}</h2> 		
			<br />
			{$helpd.text}
			<br />		
			{if $adminpanel==true}
			<div style="width:100%;text-align:right;">
				[ <a href="dokumentacio.php?mit=helpd&mod=mod&id={$helpd.cid}" >szerkesztés</a> ]
			</div><br />
			{/if}
			<br />
			<table style="width:100%" >
				{foreach from=$helpduser item=u}
					<tr>
						<td width="20%"><img src="kinezet/{$ipanel.smink}/menu_bullet.png" border='0'>&nbsp;&nbsp;
							<a href="userinfo.php?uid={$u.uid}">{$u.name}</a></td>
						<td>{$u.text}</td>
					<tr>
				{/foreach}
			</table>
			{if $adminpanel==true}
			{/if}
		{/if}
	{'helpd'|section_end}

	
</div>
{* a labresz csatolasa *}
{include file='labresz.tpl'}