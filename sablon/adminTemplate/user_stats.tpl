{$modulnev|section_open}
<div align="center">	
		
		<h2>Regisztrált felhasználók száma</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Idõszak{$ido}</td>
				<td>Felhasználók(db)</td>
			</tr>
			{foreach from=$regek item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num}</td>
				</tr>
			{/foreach}
		</table>
	
	<br /><div class="separator_center_long"></div><br />
	
		<h2>Meghívások száma</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Idõszak{$ido}</td>
				<td>Meghívások(db)</td>
			</tr>
			{foreach from=$meghivok item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num}</td>
				</tr>
			{/foreach}
		</table>
	
	<br /><div class="separator_center_long"></div><br />
		
		<h2>Meghívásokból való regisztrálás</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Idõszak{$ido}</td>
				<td>Regisztrálsok(db)</td>
			</tr>
			{foreach from=$meghivo_reg item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num}</td>
				</tr>
			{/foreach}
		</table>
	
	<br /><div class="separator_center_long"></div><br />
		
		<h2>Rangok eloszlása</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Rang</td>
				<td>Felhasználó(db)</td>
			</tr>
			{foreach from=$rangok item=s}
				<tr>
					<td>{$s.nev}</td>
					<td>{$s.ert}</td>
				</tr>
			{/foreach}
		</table>			


</div>
{$modulnev|section_end}