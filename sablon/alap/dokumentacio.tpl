{include file='fejresz.tpl'}
{* a fejlec csatolasa *}

{if $nofejlec!='nofejlec'}
	{* infopanel csatolása *}
	{include file='infopanel.tpl'}
{else}
	<div id="infopanel" style="display:none"></div>
{/if}


<script type="text/javascript" src="scriptek/interface_elem/ifxscrollto.js"></script>

<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}<br />{/foreach}
	
		{if isset($lista)}
		{'Tartalom:'|section_open}
			{if $admin_link=='true'}<p><img border="0" src="kinezet/{$ipanel.smink}/collapse.png" />&nbsp;<a href="{$oldal_cime}&mod=uj">Új {$fejlec_elotag}</a></p><br />{/if}
			<ul>
			{foreach from=$lista key=i item=l}
				<li><a href="#cim_{$l.cid}" class="scroll" >{$l.cim}</a></li>
			{/foreach}
			</ul>
		{'Tartalom:'|section_end}
	
		
		{$fejlec_elotag|section_open}
			{foreach from=$lista key=i item=l}
			<div id="dokumentacio_div_{$l.cid}">
				<h1 id="cim_{$l.cid}" >{$l.cim}</h1>
				<div class="rights">{$l.text}</div>
				<div class="right">
					<span class="small">{if $nofejlec!='nofejlec'}Utoljára {$l.name} szerkesztette, ekkor: {$l.datum}{/if}
						&nbsp;&bull;&nbsp;[ <a href="#infopanel" class="scroll" >Oldal tetejére</a> ]
					</span>&nbsp;&nbsp;&nbsp;
				</div>
				<br>
			</div>
			{/foreach}
		
		{$fejlec_elotag|section_end}		
	
	{/if}	
</div>











{* a labresz csatolasa *}
{include file='labresz.tpl'}