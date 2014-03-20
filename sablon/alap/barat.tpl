{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	{'Barátaim'|section_open}
		{foreach from=$baratok item=uinfo}			
			<div class="friend">
				<div class="avatar"><a href="userinfo.php?uid={$uinfo.uid}" class="pic" title="userinfo"><img border="0" src="{$uinfo.avatar}" alt="avatar" class="avatar"/></a></div>
				<div class="info">
					<div class="l">Neve:</div>
					<div class="r">{$uinfo.name}</div>
					<div class="l">Rangja:</div>
					<div class="r">{$uinfo.rang_text} </div>
					<div class="l">Legutóbb itt járt:</div>
					<div class="r">{$uinfo.vizit}</div>
					<div class="l">Csatlakozott:</div>
					<div class="r">{$uinfo.reg_date}</div>
					<div class="l">Neme:</div>
					<div class="r">Nincs adat</div>
					<div class="l">Lakhelye:</div>
					<div class="r">{$uinfo.orszag}, {$uinfo.varos}</div>
					<div class="l">Aránya:</div>
					<div class="r"><span class="{$uinfo.arany|aranyszin}">{$uinfo.arany_text}</span> (le: <span class="highlight">{$uinfo.letolt|b_to_s}</span>, fel: <span class="highlight">{$uinfo.feltolt|b_to_s}</span>)</div>
					<div class="l">Lehetõségeid:</div>
					<div class="r"><a href="levelezes.php?uid={$uinfo.uid}">Üzenet írása {$uinfo.name} barátodnak</a> &bull; <span class="highlight">{$uinfo.name} [<a href="barat.php?akcio=del&uid={$uinfo.uid}" title="User törlése a barátaim közül">törlés</a>] a barátaid közül</span></div>
				</div>
				<div class="foot">&nbsp;</div>
			</div>			
		{/foreach}
	{'Barátok'|section_end}
	
</div>
{* a labresz csatolasa *}
{include file='labresz.tpl'}