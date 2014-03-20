{$modulnev|section_open}
<div align="center">	
		
		<h2>Feltötések</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Idõszak{$ido}</td>
				<td>Adat mennyiség</td>
			</tr>
			{foreach from=$feltoltes item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num|b_to_s}</td>
				</tr>
			{/foreach}
		</table>
	
	<br /><div class="separator_center_long"></div><br />	

		<h2>Letötések</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Idõszak{$ido}</td>
				<td>Adat mennyiség</td>
			</tr>
			{foreach from=$letoltes item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num|b_to_s}</td>
				</tr>
			{/foreach}
		</table>
	
	<br /><div class="separator_center_long"></div><br />	

		<h2>Eltérés</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Idõszak{$ido}</td>
				<td>Adat mennyiség</td>
			</tr>
			{foreach from=$elteres item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num|b_to_s}</td>
				</tr>
			{/foreach}
		</table>
	
	<br /><div class="separator_center_long"></div><br />

		<h2>Feltötések kategoriára bontva</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Kategória</td>
				<td>Adat mennyiség</td>
			</tr>
			{foreach from=$feltoltes_kat item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num|b_to_s}</td>
				</tr>
			{/foreach}
		</table>
	
	
	<br /><div class="separator_center_long"></div><br />

		<h2>Letötések kategoriára bontva</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Kategória</td>
				<td>Adat mennyiség</td>
			</tr>
			{foreach from=$letoltes_kat item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num|b_to_s}</td>
				</tr>
			{/foreach}
		</table>
	
	<br /><div class="separator_center_long"></div><br />

		<h2>Eltérések kategoriára bontva</h2>
		<table  class="stats skinned" >
			<tr class="head">
				<td>Kategória</td>
				<td>Adat mennyiség</td>
			</tr>
			{foreach from=$elteres_kat item=s}
				<tr>
					<td>{$s.ido}</td>
					<td>{$s.num|b_to_s}</td>
				</tr>
			{/foreach}
		</table>
	
</div>
{$modulnev|section_end}