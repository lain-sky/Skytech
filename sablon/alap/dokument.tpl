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
	<br /><br />
	
	{if $modul=='jogi'}
		{'Jogi nyilatkozat'|section_open}
			<h1 id="cim_{$lista.cid}" >{$lista.cim}</h1>
				
				{foreach from=$lista.text item=t key=i}
					{if $i>0}<div class="center"><h1>&sect;</h1></div>{/if}
					<div class="rights">
						{$t}
					</div>
				{/foreach}
				
				<div class="right">
					<span class="small">
						{if $admin_link=='true' &&  $nofejlec!='nofejlec'}
							&nbsp;&bull;&nbsp;[ <a href="{$oldal_cime}&mod=mod&id={$lista.cid}" >szerkesztés</a> ]					
						{/if}
					&nbsp;&bull;&nbsp;[ <a href="#infopanel" class="scroll" >Oldal tetejére</a> ]
					</span>&nbsp;&nbsp;&nbsp;
				</div> 
		
		{'Jogi nyilatkozat'|section_end}
	{/if}
	

	
</div>











{* a labresz csatolasa *}
{include file='labresz.tpl'}