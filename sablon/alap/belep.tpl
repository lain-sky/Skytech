{include file='fejresz.tpl'}
{* a fejlec csatolasa *}


<div id="body"><br />
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}
</div>




<div id="content" >
	
	{if $modul=='emlekez'}
	
	{'Emlékeztetõ'|section_open}
		<form action="belep.php" method="post" >
			<div class="center">
				<p>Ha elfelejtetted volna jelszavad itt kérhetsz újat</p><br /> 
				<table class="stats skinned">
					<tr>
						<td>Felhasználói név:</td>
						<td><input type="text" name="{$formtoken}" size="20" class="skinned" /></td>
					</tr>
					<tr>
						<td>Email cím:</td>
						<td><input type="text" name="emailcim"  size="20" class="skinned" /></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input name="submit" value="Ok" type="image" src="kinezet/alap/btn_ok.png"/></td>
					</tr>
				</table>
			</div>
		</form>
		
		<!--div class="center">
			Technikai okok miatt szünetel minden e-mail küldés.<br />
Legkésõbb 2009.01.01. -re kijavítjuk a hibát.<br />

Megértéseteket köszönjük: Sky-Tech Staff 
		</div-->
			
	{'Emlékeztetõ'|section_end}
	
	{else}
	<div class="section" >
		<div class="section_header"><span class="section_expanded">Nem vagy bejelentkezve!</span></div>
		<div class="section_content" >
			<table style="width: 900px;">
				<tr>
					<td style="padding: 20px;">
						<div class="center">
							<h1>Üdvözlünk a {$smarty.const.OLDAL_NEVE} oldalán!</h1>
							<br/><br/>
							<p class="justify">Ez egy privát közösségi oldal.<br/>
							Megtekintése és használata kizárólag a közösség tagjainak részére engedélyezett!<br/><br/>
							Elfelejtetted a jelszavad? <a href="belep.php?emlekez=teto">Itt kérhetsz újat!</a> Az oldal használatához a Cookie-kat engedélyezned kell!<br/><br/></p>
						</div>
					</td>
					<td>
						<div class="dialog" style="width:270px;">
							<div class="dialog_header">
								<span class="dialog_title">Bejelentkezés</span>
							</div>
							{if $hiba != ''}<span class="red">{$hiba}</span>{/if}
							<div class="dialog_contet" style="padding:7px;">
								<form method="post" action="belep.php" name="login" >
									<div class="leftcolumn" style="width: 97px;">Felhasználónév:</div>
									<div class="rightcolumn"><input type="text" name="nev" size="20" class="skinned"/></div>
									<div class="leftcolumn" style="width: 97px;">Jelszó:</div>
									{* <div class="rightcolumn"><input type="password" name="{$formtoken}" size="20" class="skinned" /></div> *}
									<div class="rightcolumn"><input type="password" name="jelszavacska" size="20" class="skinned" /></div>
									Csökkentett biztonságú bejelentkezés: <input type="checkbox" name="lowsecu"/><br /><br />
									<input value="Bejelentkezés" name="submit" type="image" src="kinezet/alap/btn_login.png" />
									<a class="pic" href="regisztracio.php"><img border="0" src="kinezet/alap/btn_signup.png" alt="Regisztráció" /></a>
								</form>
							</div>
						</div>						
					</td>
				</tr>
			</table>
		</div>
	</div>
	{/if}
	
	
	
</div>































<br>







{*
<script type="text/javascript" src="scriptek/belep.js"></script>
 a labresz csatolasa *}
{include file='labresz.tpl'}