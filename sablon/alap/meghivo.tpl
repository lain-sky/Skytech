{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
	
	
	{'Meghívó'|section_open}
		<h2>{$meghivotext.cim}</h2> 		
		<br />
		{$meghivotext.text}
		<br /><br /><br />
		<div class="separator_center_long"></div>
		
		{if $kuldhet==true}
			<br />
			<form method="post" action="meghivo.php">
				<table >
					<tr>
						<td>Email cím:</td>
						<td><input type="text" name="meghivo" class="skinned"/></td>
						<td><input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image" id="keres_btn" /></td>
					</tr>
				</table>
			</form>
			<br />
			<p>3 nap elteltével a felhasználatlan meghivók érvénytelenné válnak és törlõdnek a rendszerbõl mintha el sem küldted volna.</p>
		{else}
			<br />
			<p>Jelenleg nem küldhetsz meghívót.</p>
		{/if}
		<br /><br />
		{if $adminpanel==true}
		<div style="width:100%;text-align:right;">
			[ <a href="dokumentacio.php?mit=meghivo&mod=mod&id={$meghivotext.cid}" >szerkesztés</a> ]
		</div>
		{/if}
	{'Meghívó'|section_end}

	{'Statisztika'|section_open}
	
		<br />
		Utolsó meghívód elküldve: {$s_datum}<br />
		Utolsó meghívód óta feltöltöttél: {$s_up|b_to_s}-t
		<br /><br />

		{if !empty($meghivott)}
			<div class="center">
				<table class="skinned" >
					<tr class="head">
						<td>Meghívott emali cím</td>
						<td>Dátum</td>
						<td>Felhasználva</td>
					</tr>
					{foreach from=$meghivott item=m}
						<tr>
							<td>{$m.email}</td>
							<td>{$m.datum}</td>
							<td>{$m.link}</td>
						</tr>
					{/foreach}
				</table>
			</div>					
		{else}
			<p>Még nem hívtál meg senkit!</p>
		{/if}

	{'Statisztika'|section_end}





	
	
	
	
	
	

</div>
{* a labresz csatolasa *}
{include file='labresz.tpl'}