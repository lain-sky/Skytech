{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
						
				
				<input type="hidden" name="modul" value="cheat_stats" />
				Dátumtól:&nbsp;&nbsp;<input type="text" name="datumtol" id="datumtol" class="skinned" value="{$datumtol}" />
				<br /><br />
				Dátumig:&nbsp;&nbsp;<input type="text" name="datumig" id="datumig" class="skinned" value="{$datumig}" />
				<br /><br />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
		</div>		
		
		{$modulnev|section_end}
		
		{'Kiemelt fájlok'|section_open}
			<div class="center">
				
				<table class="skinned" style="text-align:left;">
					<tr class="head">
						<td>&nbsp;</td>
						<td>Torrent</td>
						<td>Feltöltés</td>
						<td>Letöltés</td>
						<td>Eltérés</td>
						<td>&nbsp;</td>
					</tr>
					
					{foreach from=$cheatFiles item=file}
						<tr>
							<td><img src="kinezet/{$ipanel.smink}/category_icons/{$file.kep}.png" class="pic" /></td>
							<td><a href="adatlap.php?id={$file.tid}" target="_blank">{$file.torrent}</a></td>
							<td>{$file.feltolt|b_to_s}</td>
							<td>{$file.letolt|b_to_s}</td>
							<td>{$file.kulonbseg|b_to_s}</td>
							<td><input type="button" value="Bõvebb" class="skinned" onClick="cheatInfo( {$file.tid} )" /></td>
						</tr>
						<tr id="tr_{$file.tid}" style="display:none">
							<td colspan="6" style="position: static;">
								<div id="div_{$file.tid}" style="display:none;">&nbsp;</div>
								<div class="center" style="padding-bottom: 15px; padding-top: 10px;">
									<img src="kinezet/alap/t_closedetails.png" alt="" onClick="becsuk( {$file.tid} );" style="cursor:pointer;" border="0">
								</div>
							</td>
						</tr>
					{/foreach}
				</table>	
					
			</div>
		{'Kiemelt fájlok'|section_end}
		
		
		{'Kiemelt Userek'|section_open}
			<div class="center">
				<table class="skinned" style="text-align:left;">
					<tr class="head">
						<td>&nbsp;</td>
						<td>User</td>
						<td>Érdekeltség</td>
						<td>Feltöltés</td>
						<td>Letöltés</td>
						
					</tr>
					
					{foreach from=$cheatUsers item=user key=i}
						<tr>
							<td>{$i+1}</td>
							<td><a href="userinfo.php?uid={$user.uid}" target="_blank" >{$user.username}</a></td>
							<td>{$user.db}&nbsp;db</td>
							<td>{$user.felt|b_to_s}</td>
							<td>{$user.let|b_to_s}</td>
						</tr>
					{/foreach}
				</table>
			</div>
		{'Kiemelt Usersk'|section_end}