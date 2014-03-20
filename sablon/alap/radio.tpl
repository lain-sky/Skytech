{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	{'Radio-Sky'|section_open}
		<div class="center">
				<h2>Radio-Sky</h2>
			{if $skyRadioHiba}
				<p><span class="red">Sikertelen kapcsolódás</span></p>
			{else}
				<table class="stats skinned">
					{foreach from=$skyRadioData item=row}

						<tr>
							<td>{$row.text}</td>
							<td>{$row.value}</td>
						</tr>
					{/foreach}
				</table>
			{/if}
			<br /><br />
			<!--img src="kinezet/sky_radio.jpg" border="0" /-->
			<script type="text/javascript">runFlash("kinezet/banner.swf",468,60,"banner","banner")</script>
			<br /><br />
			<a href="http://usseed.tx.hu:8500/listen.pls" target="_blank">[ letöltés]</a>
			<br /><br />
		</div>	
	{'Radio-Sky'|section_end}
	
	
	{* 'Club7 Rádió'|section_open}
		<div class="center">
			<h2>Club7 Rádió</h2>
			
			{if $radioHiba}
				<p><span class="red">Sikertelen kapcsolódás</span></p>
			{else}
				<table class="stats skinned">
					{foreach from=$radioData item=row}

						<tr>
							<td>{$row.text}</td>
							<td>{$row.value}</td>
						</tr>
					{/foreach}
				</table>
			{/if}
			
			<br /><br />
			<a href="http://club7radio.hu" class="pic" target="_blank">
				<img src="http://www.club7radio.hu/partner/banner.gif" border="0" />
			</a>
				
		</div>	
	{'Club7 Rádió'|section_end *}
</div>


{* a labresz csatolasa *}
{include file='labresz.tpl'}