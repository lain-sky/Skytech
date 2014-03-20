{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	
	
	
	
	<script type="text/javascript" src="scriptek/interface_elem/ifxscrollto.js"></script>
	<script language="javascript">var userPara=0; </script>
	<div id='ide_scroll' ></div>
	
	{'Lehetõségek'|section_open}
		<div class="center">
			<a class="pic" href="levelezes.php?module=uj" title="Levél írása"id="uj_level"><img id="uj_level_kep" class="mailerbtn" border="0" src="kinezet/{$ipanel.smink}/m_compose.png" alt="Levél írása"/></a>
			<a class="pic" href="levelezes.php?module=olvas" title="Levelek olvasása" id="bejovo_level"><img id="bejovo_level_kep" class="mailerbtn" border="0" src="kinezet/{$ipanel.smink}/m_inbox.png" alt="Levelek olasása"/></a>
			<a class="pic" href="levelezes.php?module=kuldott" title="Elküldött levelek" id="kuldott_level"><img id="kuldott_level_kep" class="mailerbtn" border="0" src="kinezet/{$ipanel.smink}/m_sentbox.png" alt="Elküldött levelek"/></a>
			<a class="pic" href="levelezes.php?module=szemetes" title="Levelek törlése" id="szemetes"><img id="szemetes_kep" class="mailerbtn" border="0" src="kinezet/{$ipanel.smink}/m_trash.png" alt="Levelek törlése"/></a>
		</div>
	{'Lehetõségek'|section_end}
	
	{'Levelezés'|section_open}
		<div class="center" id="toltodiv">
			<img src="kinezet/{$ipanel.smink}/loading.gif"  />
		</div>
		<div class="center" id="asztal">
		{if $userpara==1}
			{include file='level.tpl'}
			<script language="javascript">userPara=1; </script>
		{/if}
		
		</div>
	{'Levelezés'|section_end}
	
	
	

</div>

<script language="javascript" src="scriptek/level.js"></script>











{* a labresz csatolasa *}
{include file='labresz.tpl'}