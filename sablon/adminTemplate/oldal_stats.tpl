{$modulnev|section_open}
	<div align="center">	
		
		<h2>Összes oldal letöltés</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Idõszak{$ido}</td>
				<td>Letöltés(db)</td>
			</tr>
			{foreach from=$osszes_oldal item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num}</td>
				</tr>
			{/foreach}
		</table>
	
	<br /><div class="separator_center_long"></div><br />
		
		<h2>Összes látogató</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Idõszak{$ido}</td>
				<td>Letöltés(db)</td>
			</tr>
			{foreach from=$osszes_latogato item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num}</td>
				</tr>
			{/foreach}
		</table>
		
	<br /><div class="separator_center_long"></div><br />
		
		<h2>Látogatott fájlok</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Fájlok</td>
				<td>Letöltés(db)</td>
			</tr>
			{foreach from=$osszes_fajl item=s}
				<tr>
					<td>{$s.fajl}</td>
					<td>{$s.num}</td>
				</tr>
			{/foreach}
		</table>
		
	<br /><div class="separator_center_long"></div><br />
		
		<h2>Látogatok böngészõje</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Böngészõ</td>
				<td>DB</td>
			</tr>
			{foreach from=$osszes_bongeszok item=s}
				<tr>
					<td>{$s.nev}</td>
					<td>{$s.ert}</td>
				</tr>
			{/foreach}
		</table>
		
	<br /><div class="separator_center_long"></div><br />
		
		<h2>Látogatok OS-e</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>OS</td>
				<td>DB</td>
			</tr>
			{foreach from=$osszes_os item=s}
				<tr>
					<td>{$s.nev}</td>
					<td>{$s.ert}</td>
				</tr>
			{/foreach}
		</table>
	</div>
{$modulnev|section_end}