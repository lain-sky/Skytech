{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	
	{'Vezérlõpult'|section_open}
		<table class="categories">
			<tr>				
				<td>
					<ul class="categories">
						<li><a href="{$lap_cime}?modul=hirek" >Új hír hozzáadása</a></li>
						<li><a href="{$lap_cime}?modul=szavazas" >Új szavazas hozzáadása</a></li>
						<li><a href="{$lap_cime}?modul=topik" >Új topik hozzáadása</a></li>
						<li><a href="{$lap_cime}?modul=chat_szoba" >Chat szobák</a></li>
						<li><a href="{$lap_cime}?modul=csoportos_meghivas" >Csoportos meghívás</a></li>
					</ul>
				</td>
				<td>
					<ul class="categories">
						<li><a href="{$lap_cime}?modul=uj_user" >Új user hozzáadása</a></li>
						<li><a href="{$lap_cime}?modul=regUjra" >Reg újraküldése</a></li>
						<li><a href="{$lap_cime}?modul=user_mod" >User adatmódosítás</a></li>
						<li><a href="{$lap_cime}?modul=uzenofal" style="color:red;" >Üzenõfal</a></li>						
					</ul>
				</td>
				<td>
					<ul class="categories">
						<li><a href="{$lap_cime}?modul=oldal_stats" >Oldal statisztika</a></li>
						<li><a href="{$lap_cime}?modul=user_stats" >User statisztika</a></li>
						<li><a href="{$lap_cime}?modul=user_kovetes" >User Követes</a></li>
						<li><a href="{$lap_cime}?modul=tracker_stats" >Tracker statisztika</a></li>
						<li><a href="{$lap_cime}?modul=cron_stats" >Cron statisztika</a></li>
						<li><a href="{$lap_cime}?modul=cheat_stats" >Cheat statisztika</a></li>
						<li><a href="{$lap_cime}?modul=cheat_user" >Cheat Users</a></li>
						
					</ul>
				</td>
				<td>
					<ul class="categories">
						{if $SUPER_USER==true}
						<li><a href="{$lap_cime}?modul=oldal_setting" >Oldal beállítások</a></li>
						<li><a href="{$lap_cime}?modul=tracker_setting" >Tracker beállítások</a></li>
						<li><a href="{$lap_cime}?modul=torrent_setting" >Torrent beállítások</a></li>
						<li><a href="{$lap_cime}?modul=cron_setting" >Cron beállítások</a></li>
						<li><a href="{$lap_cime}?modul=rang_setting" >Rang beállítások</a></li>
						<li><a href="{$lap_cime}?modul=jog_setting" >Jogosultság beállítások</a></li>
						<li><a href="{$lap_cime}?modul=cron_manual_run" >Cron manuális futatás</a></li>
						<li><a href="{$lap_cime}?modul=trackerDebug" >szicsunak</a></li>
						{/if}
					</ul>
				</td>					
			</tr>			
			
		</table>
	
	{'Tartalom beküldés'|section_end}
		
		
		
	{if $modul=='oldal_stats' || $modul=='user_stats' || $modul=='tracker_stats'|| $modul=='cron_stats'}
	{'Találatok szûkítése'|section_open}
		<form method="post" action="{$lap_cime}">
			<div align="center">
				<table  cellpadding="30px" cellspacing="0" class="valasztok" align="center">
			       <tr>
						<td>
							Dátum tól:&nbsp;<input type="text" name="tol" class="skinned" value="{$tol}" /><br /><br />
							Dátum ig&nbsp;:&nbsp;<input type="text" name="ig" class="skinned" value="{$ig}" />
						</td>
						<td>
							<label for="napi"><input type="radio" name="bontas" value="napi" id="napi"   />&nbsp;Napi bontás</label><br />
							<label for="heti"><input type="radio" name="bontas" value="heti" id="heti" checked="checked"/>&nbsp;Heti bontás</label><br />
							<label for="havi"><input type="radio" name="bontas" value="havi" id="havi"  	/>&nbsp;Havi bontás</label><br />					
						</td>
					</tr>
				</table>	
				<input type="hidden" name="modul" value="{$modul}" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />						
			</div>		
		</form>		
		{'Találatok szûkítése'|section_end}
	{/if}
	

	
	
	
	{if $modul=="hirek"}
		{include file='hirek.tpl'}	
		
	
	
	
	{elseif $modul=="szavazas"}
		{include file='szavazas.tpl'}
		
	
	
	
	
	{elseif $modul=="topik"}
		{include file='forum.tpl'}
	
	
	
	
	
	
	{elseif $modul=='uzenofal'}
		
		{$modulnev|section_open}
			{foreach from=$data item=cikk}
				<div>
					<h1>{$cikk.cim}</h1>
					<div class="rights">{$cikk.text}</div>
					<div class="right">
						<span class="small">
							[ <a href="dokumentacio.php?mit=uzifal&mod=mod&id={$cikk.cid}" target="_blank" >szerkesztés</a> ]
						</span>
					</div>
				</div>
			{/foreach}
		{$modulnev|section_end}
	
	
	
	{elseif $modul=='user'}
		
		{if $userkereso==true}
			{'User keresõ'|section_open}
			<form method="post" action="{$lap_cime}">
			<div align="center">
				<table  cellpadding="5px" cellspacing="0" class="valasztok" align="center">
			        <tr>
						<td >Keresés:&nbsp;</td>
						<td >
							<input type="hidden" name="modul"  value="user_mod" class="skinned" />
							<input type="text" name="mod_user"  id="mod_user" class="skinned" />
						</td>					
						<td >
							<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image" id="keres_btn" />
								
						</td>
					</tr>
				</table>			
			</div>
			</form>
			{'Keresés'|section_end}
		{/if}
		{if $userform==true}
		<br />
		{$modulnev|section_open}
			<br />
			<div class="center">
			<form method="post" action="{$lap_cime}">
			<input type="hidden" name="modul" value="user_save" />
			{if !empty($modid)}
				<input type="hidden" name="modid" value="{$modid}" />
			{/if}
				<table class="skinned" style="text-align:left;width:300px;">
					<tr class="head">
						<td>Név</td>
						<td>Érték</td>
					</tr>
					<tr >
						<td>Felhasználói név</td>
						<td><input type="text" name="name"  value="{$udata.name}" class="skinned" /></td>
					</tr>
					<tr>
						<td>Email cím</td>
						<td><input type="text" name="email"  value="{$udata.email}" class="skinned" /></td>
					</tr>
					<tr>
						<td>Rang</td>
						<td>
							<select class="skinned" name="rang">
								{foreach from=$rangok item=r key=i}
									<option value="{$i}"{if $i==$udata.rang}selected="selected"{/if}>{$r}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>Jelszó</td>
						<td><input type="text" name="pass"   class="skinned" /></td>
					</tr>
					<tr>
						<td>Smink</td>
						<td>
							<select class="skinned" name="smink">
								{foreach from=$sminkek item=s key=i}
									<option value="{$s.ert}"{if $s.ert==$udata.smink}selected="selected"{/if}>{$s.olv}</option>
								{/foreach}
							</select>
						</td>
					</tr>
					<tr>
						<td>Egyéni rang</td>
						<td><input type="text" name="egyedi_rang"  value="{$udata.egyedi_rang}" class="skinned" /></td>
					</tr>
					<tr>
						<td>Feltöltés</td>
						<td><input type="text" name="feltolt"  value="{$udata.feltolt}" class="skinned" /></td>
					</tr>
					<tr>
						<td>Letöltés</td>
						<td><input type="text" name="letolt"  value="{$udata.letolt}" class="skinned" /></td>
					</tr>
					<tr>
						<td>Avatar</td>
						<td><input type="text" name="avatar"  value="{$udata.avatar}" class="skinned" /></td>
					</tr>
					<tr>
						<td>Láda címe</td>
						<td><input type="text" name="ladad"  value="{$ladad.ladad}" class="skinned" /></td>
					</tr>
				</table>
				
				<br />Láda text<br />
				{include file='bbcode.tpl'}
				<div class="textarea"><textarea name="ladad_text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$ladad.ladad_text}</textarea></div>
				<br /><br />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image" id="keres_btn" />
			</form>
			</div>
		{$modulnev|section_end}
		<br />			
		{/if}
		
		
		
		
		
		
		
		
	{elseif $modul=='oldal_stats'}			
		
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
	
	
	
	
	
	
	
	{elseif $modul=='user_stats'}			
		
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
	

	
	{elseif $modul=='tracker_stats'}			
		
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
		
		
		
		
	{elseif $modul=='cron_stats'}			
		
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
		
		
		
		
		
		
		
	
	{elseif $modul=='oldal_setting'}
		<script language="javascript" src="scriptek/validate.pack.js"></script>		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" id="oldalsettings">			
				<h1 style="color:#ff0000;">Figyelem!<br />A hibás beállítások, az oldal TELJES összeomlásához vezethet!!</h1>
			
				<br />
				<table  class="skinned" >
						<tr class="head">
							<td>Változó</td>
							<td>Jelenleg</td>
							<td width="250px">Új érték</td>
						</tr>
						{foreach from=$vars item=v}
							<tr>
								<td class="left"><span class="tooltip" title="{$v.leiras}">{$v.name}</span></td>
								<td class="left">{$v.value}</td>
								<td class="left"><input type="text" id="{$v.var}" name="param[{$v.var}]" class="skinned" style="width:250px;" /></td>
							</tr>
						{/foreach}					
				</table><br /><br />
				<input type="hidden" name="modul" value="varsave" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
			<div id="hiba_div" style="display:none;">
				<ol>
					<li><label for="oldal_cime" class="error">Az oldal címe szabványos url hivatkozásnak kell lennie!</label></li>
					<li><label for="oldal_vakmail" class="error">Az oldal vak mailnak szabványos email címnek kell lennie!</label></li>
					<li><label for="staff_email" class="error">A staff mailnak szabványos email címnek kell lennie!</label></li>
					<li><label for="oldal_mail_user_id" class="error">A oldal mail user id csak szám lehet!</label></li>
					<li><label for="max_user" class="error">A max user szam csak  szám lehet!!</label></li>
					<li><label for="meghivo_ido_limit" class="error">A meghivo ido limit csak szám lehet!!</label></li>
					<li><label for="meghivo_upload_limit" class="error">A meghívó upload limit csak szám lehet!!</label></li>
					<li><label for="min_adat_ratio" class="error">Az ratió csak szám lehet</label></li>
						
				</ol>
			</div>
		
		</div>		
		{$modulnev|section_end}
		
		
		
		
		
		
		
	{elseif $modul=='tracker_setting'}
		<!--script language="javascript" src="scriptek/validate.pack.js"></script-->		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" id="trackersettings">			
				<h1 style="color:#ff0000;">Figyelem!<br />A hibás beállítások, az tracker TELJES összeomlásához vezethet!!</h1>
			
				<br />
				<table  class="skinned" >
						<tr class="head">
							<td>Változó</td>
							<td>Jelenleg</td>
							<td width="250px">Új érték</td>
						</tr>
						{foreach from=$vars item=v}
							<tr>
								<td class="left"><span class="tooltip" title="{$v.leiras}">{$v.name}</span></td>
								<td class="left">{$v.value}</td>
								<td class="left">
								{if $v.var=='korlatozas_rang'}
									<select class="skinned" name="param[{$v.var}]">
										<option></option>
										{foreach from=$rangok item=r key=i}
											<option value="{$i}">{$r}</option>
										{/foreach}
									</select>
								{elseif $v.var=='adat_korlatozas' || $v.var=='slot_korlatozas' || $v.var=='tracker'}
									<label for="{$v.var}_yes" ><input type="radio" id="{$v.var}_yes" name="param[{$v.var}]" class="skinned" value="yes" />Bekapcsol</label> &nbsp;&nbsp;
									<label for="{$v.var}_no" ><input type="radio" id="{$v.var}_no" name="param[{$v.var}]" class="skinned" value="no" />Kikapcsol</label> 
								{elseif $v.var=='tracker_kikapcsol_text'}
									<input type="text" id="{$v.var}" name="param[{$v.var}]" class="skinned myform" style="width:250px;"  />								
								{else}
									<input type="text" id="{$v.var}" name="param[{$v.var}]" class="skinned myform" style="width:250px;" alt="num" />
								{/if}
								</td>
							</tr>
						{/foreach}					
				</table><br /><br />
				<input type="hidden" name="modul" value="varsave" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
			<div id="hiba_div" >			
				<p class="error" id="error_num" style="display:none;">A mezõbe csak szám kerülhet!!!</p>
			</div>
		
		</div>		
		{$modulnev|section_end}
		
		
	{elseif $modul=='torrent_setting'}			
		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
				<h2>Ingyen torrent</h2>			
				<br />
				<table  class="skinned" >
						<tr>
							<td  class="left">Kategóriára</td>
							<td  class="left">
								<select name="kategoria" class="skinned" >
									<option value="mind">Összes kategóriára</option>
									{foreach from=$kategoriak item=k}
									<option value="{$k.value}">{$k.text}</option>
									{/foreach}
								</select>	
							</td>							
						</tr>						
						<tr>
							<td class="left">Feladat</td>
							<td class="left">
								<label for="ingyen_yes"><input type="radio" name="feladat" value="ingyen_yes" id="ingyen_yes">&nbsp;A kijelöltek ingyen torrentek</label><br />
								<label for="ingyen_no"><input type="radio" name="feladat" value="ingyen_no" id="ingyen_no">&nbsp;A kijelöltek NEM ingyen torrentek</label>
							</td>
							
						</tr>
										
				</table><br /><br />
				<input type="hidden" name="modul" value="torrent_save" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		</div>
		
		{$modulnev|section_end}
		
		{elseif $modul=='cron_setting'}
			
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
				<h1 style="color:#ff0000;">Figyelem!<br />A hibás beállítások, az oldal TELJES összeomlásához vezethet!!</h1>
			
				<br />
				<table  class="skinned" >
						<tr class="head">
							<td>Változó</td>
							<td>Jelenleg</td>
							<td width="250px">Új érték</td>
						</tr>
						{foreach from=$vars item=v}
							<tr>
								<td class="left"><span class="tooltip" title="{$v.leiras}">{$v.name}</span></td>
								<td class="left">{$v.value}</td>
								<td class="left"><input type="text" id="{$v.var}" name="param[{$v.var}]" class="skinned" style="width:250px;" /></td>
							</tr>
						{/foreach}					
				</table><br /><br />
				<input type="hidden" name="modul" value="varsave" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
		</div>		
		{$modulnev|section_end}
		
		
		
		
		{elseif $modul=='rang_setting'}
			
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
				<h1 style="color:#ff0000;">Figyelem!<br />A hibás beállítások, az oldal TELJES összeomlásához vezethet!!</h1>
			
				<br />
				<table  class="skinned" >
						<tr class="head">
							<td>Változó</td>
							<td>Jelenleg</td>
							<td width="250px">Új érték</td>
						</tr>
						{foreach from=$vars item=v}
							<tr>
								<td class="left"><span class="tooltip" title="{$v.leiras}">{$v.name}</span></td>
								<td class="left">{$v.value}</td>
								<td class="left"><input type="text" id="{$v.var}" name="param[{$v.var}]" class="skinned" style="width:250px;" /></td>
							</tr>
						{/foreach}					
				</table><br /><br />
				<input type="hidden" name="modul" value="varsave" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
		</div>		
		{$modulnev|section_end}
		
		
	{elseif $modul=='jog_setting'}			
		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
				<h1 style="color:#ff0000;">Figyelem!<br />A hibás beállítások, az oldal TELJES összeomlásához vezethet!!</h1>
			
				<br />
				<table  class="skinned" >
						<tr class="head">
							<td>Változó</td>
							<td>Jelenleg</td>
							<td width="250px">Új érték</td>
						</tr>
						{foreach from=$vars item=v}
							<tr>
								<td class="left"><span class="tooltip" title="{$v.leiras}">{$v.name}</span></td>
								<td class="left">{$rangok[$v.value]}</td>
								<td class="left">
									<select id="{$v.var}" name="param[{$v.var}]" class="skinned" style="width:250px;" >
										{foreach from=$rangok item=rang_nev key=rang}
											<option value="{$rang}" {if $rang==$v.value}selected="selected" {/if}>{$rang_nev}</option> 
										{/foreach}									
									</select>
								</td>
							</tr>
						{/foreach}					
				</table><br /><br />
				<input type="hidden" name="modul" value="varsave" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
		</div>		
		
		{$modulnev|section_end}
		
		
		
	{elseif $modul=='chat_szoba'}			
		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
				<h2>{$modulnev}</h2>
				<table  class="skinned stats" >
					<tr>
						<td class="left">Szoba neve</td>
						<td class="left">
							<input type="text" class="skinned" name="nev" maxlength="30" value="{$mod.nev}" style="width:330px;" />
						</td>
					</tr>
					<tr>
						<td class="left">Szoba leírása</td>
						<td class="left">
							<textarea name="leiras" class="textarea" style="border:1px solid #726D5F;height:60px;width:330px;">{$mod.leiras}</textarea>
						</td>
					</tr>
				</table><br /><br />
				{if !empty($modid)}
					<input type="hidden" name="modid" value="{$modid}" />
				{/if}
				<input type="hidden" name="modul" value="{$feldolgozo_modul}" />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		</div>
		{$modulnev|section_end}
		
		{if empty($modid)}
			{$modulnev2|section_open}
			<div class="center">	
				<h2>Szoba lista</h2>
				<table  class="skinned stats" >
					<tr class="head">
						<td >Szoba neve</td>
						<td >Szoba leírása</td>
						<td >&nbsp;</td>
						<td >&nbsp;</td>
					</tr>
					{foreach from=$szobak item=s}
						<tr>
							<td class="left">{$s.nev}</td>
							<td class="left">{$s.leiras}</td>
							<td class="left">
								<a href="{$lap_cime}?modul=chat_szoba&modid={$s.cszid}" title="Szoba adatainak szeresztése">Szerkeszt</a>
							</td>
							<td class="left">
								<a href="{$lap_cime}?modul=chat_del_szoba&modid={$s.cszid}" title="Szoba törlése" onclick="return confirm('Biztos törölni szeretnéd a szobát?')">Töröl</a>
							</td>						
						</tr>
					{foreachelse}
						<tr>
							<td colspan="4">Egy árva szobánk sincs még....</td>
						</tr>
					{/foreach}
				</table><br /><br />
			</div>
			{$modulnev|section_end}
		{/if}
		
		
		
		
	{elseif $modul=='csoportos_meghivas'}			
		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" enctype="multipart/form-data">			
				<h2 style="color:#ff0000;">
					A fájlban az e-mail címeket külön sorba rakjátok! Maximum 50 db cím lehet a listában!! 
				</h2>
			
				
				<input type="hidden" name="modul" value="csoportos_meghivas" />
				Fájl:&nbsp;&nbsp;<input type="file" name="lista" class="skinned" />
				<br /><br />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
		</div>		
		
		{$modulnev|section_end}
		
		{if $cimek}
		{'Címlista'|section_open}
			<div class="center">
				<form method="post" action="{$lap_cime}">
					<h2>Címlista</h2>
					<table class="skinned stats">
						
						{foreach from=$cimek item=cim}
							<tr>
								<td><input type="checkbox" name="cimek[]" checked="checked" value="{$cim}" /></td>
								<td>{$cim}</td>
							</tr>
						{/foreach}
						<tr>
							<td colspan="2">
								<input type="hidden" name="modul" value="csoportos_send" />
								<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />
							</td>
						</tr>
					</table>
				</form>
			</div>		
		{'Címlista'|section_end}
		{/if}
		
		
	{elseif $modul=='trackerDebug'}			
		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
				<h2 style="color:#ff0000;">
					Csak szicsunak !!!
				</h2>
			
				
				<input type="hidden" name="modul" value="trackerDebug" />
				Where:&nbsp;&nbsp;<input type="text" name="where" class="skinned" />
				<br /><br />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
		</div>		
		
		{$modulnev|section_end}
		
		{if $tomb}
		{'Debug'|section_open}
			
			{foreach from=$tomb item=row}
				<pre>
					{$row}
				</pre>
				<br /><hr /><br />
			{/foreach}
						
		{'Debug'|section_end}
		{/if}
		
		
	{elseif $modul=='regUjra'}			
		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >			
						
				
				<input type="hidden" name="modul" value="regUjra" />
				Email cím:&nbsp;&nbsp;<input type="text" name="mail" class="skinned" />
				<br /><br />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
		</div>		
		
		{$modulnev|section_end}
		
	{elseif $modul=='cheat_stats'}			
		
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
		
		
		
		
	{elseif $modul=='cheat_user'}			
		
		{$modulnev|section_open}
		<div class="center">
			<form method="post" action="{$lap_cime}" >				
				<input type="hidden" name="modul" value="cheat_user" />
				
				<table style="margin:auto;">
					<tr>
						<td>UserId*:</td>
						<td><input type="text" name="uid"  class="skinned" value="{$uid}" /></td>
					</tr>
					<tr>
						<td>TorrentId*:</td>
						<td><input type="text" name="tid"  class="skinned" value="{$tid}" /></td>
					</tr>						
					<tr>
						<td>Dátumtól:</td>
						<td><input type="text" name="datumtol" id="datumtol" class="skinned" value="{$datumtol}" /></td>
					</tr>
					<tr>
						<td>Dátumig:</td>
						<td><input type="text" name="datumig" id="datumig" class="skinned" value="{$datumig}" /></td>
					</tr>								
				</table>
								
				<br /><br />
				<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
			</form>
		
		</div>		
		
		{$modulnev|section_end}	
			{if $data}
				{'Találatok'|section_open}
					<div class="center">
						<table style="margin:auto;">
							<tr>
								<td>Torrent:</td>
								<td><a href="adatlap.php?id={$tid}" target="_blank">{$torrentName}</a></td>
							</tr>
							<tr>
								<td>User:</td>
								<td><a href="userinfo.php?uid={$uid}" target="_blank" >{$userName}</a></td>
							</tr>
						</table>
						<br /><br />
					
					
						<table class="skinned" style="text-align:left;">
							<tr class="head">
								<td>&nbsp;</td>
								<td>Feltöltés</td>
								<td>Sebesség</td>
								<td>Letöltés</td>
								<td>Sebesség</td>
								<td>IP</td>
								<td>Rögzítve</td>						
							</tr>
							
							{foreach from=$data item=user key=i}
								<tr>
									<td>{$i+1}</td>
									<td>{$user.fel|b_to_s}</td>
									<td>{$user.felseb|b_to_s}/s</td>
									<td>{$user.le|b_to_s}</td>
									<td>{$user.leseb|b_to_s}/s</td>
									<td>{$user.ip}</td>
									<td>{$user.datum}</td>
								</tr>
							{foreachelse}	
								<tr>
									<td colspan="7">
										nincs talalálat!
									</td>
								</tr>
							{/foreach}
						</table>
					</div>
				{'Találatok'|section_end}
			{/if}
			
			
		{elseif $modul=='user_kovetes'}			
		
			{$modulnev|section_open}
			<div class="center">
				<form method="post" action="{$lap_cime}" >				
					<input type="hidden" name="modul" value="user_kovetes" />
					
					<table style="margin:auto;">
						<tr>
							<td>UserId*:</td>
							<td><input type="text" name="uid"  class="skinned" value="{$uid}" /></td>
						</tr>
						<tr>
							<td>Dátumtól:</td>
							<td><input type="text" name="datumtol" id="datumtol" class="skinned" value="{$datumtol}" /></td>
						</tr>
						<tr>
							<td>Dátumig:</td>
							<td><input type="text" name="datumig" id="datumig" class="skinned" value="{$datumig}" /></td>
						</tr>								
					</table>
									
					<br /><br />
					<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image"  />	
				</form>
			
			</div>		
			
			{$modulnev|section_end}	
				{if $data}
					{'Találatok'|section_open}
						<div class="center">
							<table style="margin:auto;">
								<tr>
									<td>User:</td>
									<td><a href="userinfo.php?uid={$uid}" target="_blank" >{$userName}</a></td>
								</tr>
							</table>
							<br /><br />
						
						
							<table class="skinned" style="text-align:left;">
								<tr class="head">
									<td>&nbsp;</td>
									<td>Oldal</td>
									<td>OS</td>
									<td>Böngészö</td>
									<td>IP</td>
									<td>Rögzítve</td>						
								</tr>
								
								{foreach from=$data item=user key=i}
									<tr>
										<td>{$i+1}</td>
										<td><a href="{$user.fajl}?{$user.qstring}" target="_blank" >{$user.fajl}</a></td>
										<td>{$user.os}</td>
										<td>{$user.bongeszo} {$user.bongeszo_ver}</td>
										<td>{$user.ip}</td>
										<td>{$user.datum}</td>
									</tr>
								{foreachelse}	
									<tr>
										<td colspan="7">
											nincs talalálat!
										</td>
									</tr>
								{/foreach}
							</table>
						</div>
					{'Találatok'|section_end}
				{/if}
		
	{/if}


</div>
<script language="javascript" src="scriptek/skytech2.js"></script>
{* a labresz csatolasa *}

<script type="text/javascript">
var AJAXURL='{$lap_cime}';
{literal}
 function cheatInfo( fileId ){
	
	$.post( AJAXURL,
		{
			modul:'cheat_stats_reszletes',
			tid: fileId,
			datumtol: $('#datumtol').val(),
			datumig: $('#datumig').val()
		},
		function( html ){
			$('#div_'+fileId).html(html);
			
		}
	);
	$('#tr_'+fileId).css("display",'');	
	$('#div_'+fileId).slideDown('slow');
	
 }
 
 function becsuk( fileId ){
	$('#div_'+fileId).slideUp('slow', function(){
		$('#tr_'+fileId).css("display",'none');	
	});	
 }
</script>
{/literal}

{include file='labresz.tpl'}