{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	
{if isset($user_neve)}
	
	
	{$user_neve|section_open}
		
		{include file='userinfo_tabi.tpl'}
		
	{'userinfo'|section_end}
	
	{if $warn }
		
		{'Figyelmeztetés'|section_open}
		
			<div class="center">
				<table style="text-align:left;">
					<tr>
						<td rowspan="3" width="100"><img src="kinezet/{$ipanel.smink}/warned.png" class="pic" /></td>
						<td width="100" >Kiosztva</td>
						<td >{$warn.datum}</td>
					</tr>
					<tr>
						<td>Lejár</td>
						<td>{$warn.lejar}</td>
					</tr>
					<tr>
						<td>Ok</td>
						<td>{$warn.text}</td>
					</tr>
				
				</table>
			</div>
		
		{'figyu'|section_end}
	{/if}
	
	
	{if !empty($ladad.ladad)}
		{$ladad.ladad|section_open}
		<br />
		{$ladad.ladad_text}
		<br />
		{'ladad'|section_end}
	{/if}
	
	
	
	{if count($aktivtorrent)>0}
	<h2>&nbsp;&nbsp;Aktív torrentek</h2>
	<table class="torrents" >
		<tr class="t_head">
			<td class="t_head_icon"><a href="#" title="Rendezés típus szerint">Típus</a></td>
			<td class="t_head_name"><a href="#" title="Rendezés név szerint">Név</a></td>
			<td class="t_head_down"><a href="#" title="Rendezés a befejezett letöltések száma szerint">DL</a></td>
			<td class="t_head_meret"><a href="#" title="Rendezés a mérete szerint">Méret</a></td>
			<td class="t_head_sele"><a href="#" title="Rendezés a seederek száma szerint">S</a>/<a href="#" title="Rendezés a leecherek száma szerint">L</a></td>
			<td class="t_head_upby"><a href="#" title="Rendezés a feltöltõ neve szerint">Feltöltötte</a></td>
		</tr>	
		{foreach from=$aktivtorrent item=t key=k}
				{include file='torrent_tabi.tpl'}			
		{/foreach}
	</table><br /><br />
	{/if}
	
	{if count($sajattorrent)>0}	
	<h2>&nbsp;&nbsp;Feltöltött torrentek</h2>
	<table class="torrents" >
		<tr class="t_head">
			<td class="t_head_icon"><a href="#" title="Rendezés típus szerint">Típus</a></td>
			<td class="t_head_name"><a href="#" title="Rendezés név szerint">Név</a></td>
			<td class="t_head_down"><a href="#" title="Rendezés a befejezett letöltések száma szerint">DL</a></td>
			<td class="t_head_meret"><a href="#" title="Rendezés a mérete szerint">Méret</a></td>
			<td class="t_head_sele"><a href="#" title="Rendezés a seederek száma szerint">S</a>/<a href="#" title="Rendezés a leecherek száma szerint">L</a></td>
			<td class="t_head_upby"><a href="#" title="Rendezés a feltöltõ neve szerint">Feltöltötte</a></td>
		</tr>	
		{foreach from=$sajattorrent item=t key=k}
				{include file='torrent_tabi.tpl'}			
		{/foreach}
	</table><br /><br />	
	{/if}
	
	
{/if}
</div>


<script language="javascript" src="scriptek/letolt.js"></script>
{* a labresz csatolasa *}
{include file='labresz.tpl'}