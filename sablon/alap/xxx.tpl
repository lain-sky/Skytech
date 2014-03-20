{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	<div class="center">
		<br /><br />
			<h1>Hamarosan</h1>
		<br /><br />
	</div>
</div>











{* a labresz csatolasa *}
{include file='labresz.tpl'}