{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	
	
	{foreach from=$data item=row}
		
		{$row.user.name|section_open}
			<div class="center">
				<h2><a href="userinfo.php?uid={$row.user.uid}">{$row.user.name} munkái</a></h2>
				
				{foreach from=$row.img item=kep}
					<img src="{$kep}" class="pic" alt="Betoltesi hiba" />
					<br /><br />
				{/foreach}
				
				{foreach from=$row.flash item=flash}
					<object type="application/x-shockwave-flash" data="{$flash.src}" width="{$flash.width}" height="{$flash.height}">
						<param name="movie" value="{$flash.src}"/>
						<param name="quality" value="high"/>
					</object>
				{/foreach}
			</div>
		{'user'|section_end}
	{/foreach}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
</div>











{* a labresz csatolasa *}
{include file='labresz.tpl'}