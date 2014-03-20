{$modulnev|section_open}
<div align="center">	
		
	<h2>Rang update</h2>
	<table  class="stats skinned" >
		<tr class="head">
			<td>Idõszak{$ido}</td>
			<td>Futás(db)</td>
			<td>Érintett sorok(db)</td>
		</tr>
		{foreach from=$rang item=s}
			<tr>
				<td>{$s.ido}</td>
				<td>{$s.db}</td>
				<td>{$s.num}</td>
			</tr>
		{/foreach}
	</table>	
	
	<br /><div class="separator_center_long"></div><br />	

	<h2>Peers takarítás</h2>
	<table  class="stats skinned" >
		<tr class="head">
			<td>Idõszak{$ido}</td>
			<td>Futás(db)</td>
			<td>Érintett sorok(db)</td>
		</tr>
		{foreach from=$peers item=s}
			<tr>
				<td>{$s.ido}</td>
				<td>{$s.db}</td>
				<td>{$s.num}</td>
			</tr>
		{/foreach}
	</table>

	<br /><div class="separator_center_long"></div><br />	

	<h2>Chat takarítás</h2>
	<table  class="stats skinned" >
		<tr class="head">
			<td>Idõszak{$ido}</td>
			<td>Futás(db)</td>
			<td>Érintett sorok(db)</td>
		</tr>
		{foreach from=$chat item=s}
			<tr>
				<td>{$s.ido}</td>
				<td>{$s.db}</td>
				<td>{$s.num}</td>
			</tr>
		{/foreach}
	</table>

	<br /><div class="separator_center_long"></div><br />	

	<h2>Logs takarítás</h2>
	<table  class="stats skinned" >
		<tr class="head">
			<td>Idõszak{$ido}</td>
			<td>Futás(db)</td>
			<td>Érintett sorok(db)</td>
		</tr>
		{foreach from=$logs item=s}
			<tr>
				<td>{$s.ido}</td>
				<td>{$s.db}</td>
				<td>{$s.num}</td>
			</tr>
		{/foreach}
	</table>
	
	<br /><div class="separator_center_long"></div><br />	

	<h2>Reg,meghivo takarítás</h2>
	<table  class="stats skinned" >
		<tr class="head">
			<td>Idõszak{$ido}</td>
			<td>Futás(db)</td>
			<td>Érintett sorok(db)</td>
		</tr>
		{foreach from=$reg item=s}
			<tr>
				<td>{$s.ido}</td>
				<td>{$s.db}</td>
				<td>{$s.num}</td>
			</tr>
		{/foreach}
	</table>			

	<br /><div class="separator_center_long"></div><br />	

	<h2>Warn,ban takarítás</h2>
	<table  class="stats skinned" >
		<tr class="head">
			<td>Idõszak{$ido}</td>
			<td>Futás(db)</td>
			<td>Érintett sorok(db)</td>
		</tr>
		{foreach from=$warn item=s}
			<tr>
				<td>{$s.ido}</td>
				<td>{$s.db}</td>
				<td>{$s.num}</td>
			</tr>
		{/foreach}
	</table>			


	
</div>
{$modulnev|section_end}