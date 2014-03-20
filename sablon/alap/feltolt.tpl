{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	<div id="content">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	{*
		{'Feltöltétsi segédlet'|section_open}
			<h2 >Feltöltétsi segédlet</h2>
			<div class="rights">
				{$segedlet.text}
			</div>
			{if adminlink==true}
			<div class="right">
				[ <a href="dokumentacio.php?mit=felt&mod=mod&id={$segedlet.cid}" >szerkesztés</a> ]
			</div>
			{/if}
		{'Feltöltétsi segédlet'|section_end}
	*}
	
	{'Feltöltés'|section_open}
	<div id="upload_left">
		<form method="post" action="feltolt.php" enctype="multipart/form-data" name="uploadform">
			<h2 >Általános</h2>
			<div class="tenpx">
				<table>
					{if $keresName}
					<tr>
						<td colspan="3"><span class="red">A "{$keresName}" nevû kérés teljesítése!</span></td>
					</tr>
					{/if}
					<tr>
						<td><span id="req10" class="req">*</span></td>
						<td class="right"><label for="mezo10">Torrent név:</label></td>
						<td class="left">
							<input id="mezo10" name="tname" size="72" class="skinned" type="text" {if $keresName} value="{$keresName}" readonly="readonly"{/if} />
							{if $keresId}<input  name="keresId" type="hidden"  value="{$keresId}" />{/if}
						</td>
					</tr>

					<tr>
						<td><span  class="req">*</span></td>
						<td class="right"><label for="tcategory">Kategória:</label></td>
						<td class="left">
							<select id="tcategory" name="tcategory" class="skinned" >
								{foreach from=$tipusok key=id  item=t}
								<option value="{$t.kid}">{$t.nev}</option>
								{/foreach}									
							</select>
							<span class="small">&nbsp;&nbsp;Válaszd a leginkább a torrenthez illõ kategóriát!</span>		
						</td>
					</tr>
					<tr>
						<td><span class="req">*</span></td>
						<td class="right">Scene torrent:</td>
						<td class="left">
							<label for="tsceneyes"><input id="tsceneyes" name="tcene" value="yes" checked="checked"  type="radio">Igen, eredeti, scene release</label>&nbsp;&nbsp;&nbsp;
							<label for="tsceneno"><input id="tsceneno" name="tcene" value="no"  type="radio">Nem scene release</label>
						</td>
					</tr>	
					<tr>
						<td colspan="3">						
							<span class="small">Eredeti "kiadást" (scene release) tartalmaz-e a torrented? Ha nem változtattad meg a fájlok szerkezetét, tömörítését, illetve rendelkezel eredeti NFO fájllal, válaszd az <span class="highlight">igen</span>t, ellenkezõ esetben a <span class="highlight">nem</span>et!</span>
						</td>
					<tr>
				</table>		
			</div>
			<br>
			
			<h2>Fájlok megadása</h2>	
			<div class="tenpx">						
				<table>
					<tr>
						<td><span id="req12"  class="req">*</span></td>
						<td class="right"><label for="tfile">Torrent fájl:</label></td>
						<td class="left"><input id="mezo12" name="tfile" size="61" class="skinned"  type="file"></td>
					</tr>
					<tr>
						<td><span id="req1" class="req">*</span></td>		
						<td class="right"><label for="mezo1">NFO fájl:</label></td>
						<td class="left"><input id="mezo1" name="tnfo" size="61" class="skinned"  type="file"></td>
					</tr>
					{*
						<tr>
							<td><span id="req2" class="notreq">*</span></td>
							<td class="right"><label for="ttinfo">Techinfo:</label></td>
							<td class="left"><input id="ttinfo" name="ttinfo" size="61" class="skinned" onchange="checkfilebyext('ttinfo','ntf')" type="file"></td>
						</tr>
					*}
					<tr>
						<td colspan="3">
							<span class="small">Az NFO mezõbe csak eredeti .nfo kiterjesztésû fájlt tölts fel! </span>
						</td>
					<tr>							
				</table>
			</div>
			<br>
			
			<h2>Egyéb információk</h2>
			<div class="tenpx">
				<table>
					<tr>
						<td><span id="req3" class="notreq">*</span></td>
						<td class="right"><label for="mezo3">Honlap vagy ismertetõ:</label></td>
						<td class="left"><input id="mezo3" name="homepage" size="63" class="skinned" type="text"></td>
					</tr>
					<tr>
						<td><span id="req4" class="notreq">*</span></td>		
						<td class="right"><label for="mezo4">Megjelenési év/dátum:</label></td>
						<td class="left"><input id="mezo4" name="year" size="63" class="skinned" type="text"></td>
					</tr>
					<tr>
						<td colspan="3">
							<span class="small">Amennyiben a torrented filmet tartalmaz, <a href="http://www.imdb.com/" target="_blank" title="Ugrás">IMDB</a> linket adj meg (pl.: <a href="http://imdb.com/title/tt0121403/" target="_blank">http://imdb.com/title/tt0121403/</a>), minden más torrent típus esetén megadhatsz hivatalos honlapot, információs oldalt, stb..</span>
						</td>
					<tr>							
				</table>
			</div>
			<br>
			
			<h2>Képek</h2>	
			<div class="tenpx">					
				<table>
					<tr>
						<td><span id="req5" class="notreq">*</span></td>
						<td class="right"><label for="mezo5">Elsõ kép:</label></td>

						<td class="left"><input id="mezo5" name="pic1" size="72" class="skinned" type="text"></td>
					</tr>
					<tr>
						<td><span id="req6" class="notreq">*</span></td>
						<td class="right"><label for="mezo6">Második kép:</label></td>
						<td class="left"><input id="mezo6" name="pic2" size="72" class="skinned" type="text"></td>
					</tr>
					<tr>

						<td><span id="req7" class="notreq">*</span></td>
						<td class="right"><label for="mezo7">Harmadik kép:</label></td>
						<td class="left"><input id="mezo7" name="pic3" size="72" class="skinned" type="text"></td>
					</tr>
					<tr>
						<td colspan="3">
							<span class="small">A mezõkbe egy-egy kép <a href="http://hu.wikipedia.org/wiki/Webc%C3%ADm" target="_blank" title="Mi az az URL?">URL</a>-jét írd. Képeidet feltöltheted az alábbi képtárhelyek egyikére: <a href="http://www.imageshack.us/" target="_blank" title="Ugrás">http://www.imageshack.us/</a>, <a href="http://upload.georgeownsme.com/" target="_blank" title="Ugrás">http://upload.georgeownsme.com/</a> Mindhárom mezõt töltsd ki!!</span>
						</td>
					<tr>							
				</table>
			</div>
			<br>
			
			<h2>Névtelen feltöltés</h2>	
			<div class="tenpx">
				<table>
					<tr>
						<td>
							<input type="checkbox" name="anonymous" value="igen" id="anonymous" />
						</td>
						<td>
							<label for="anonymous">
								Ha ezt az opciót választod, akkor a neved nem fog megjelenni a torrentnél!
							</label>
						</td>
					</tr>
				</table>
			</div>
			<br />
			
		</div>
		<div id="upload_right">
			<h2 >Feltöltési segédlet</h2>
			<div class="tenpx">
				{$segedlet.text}
			</div>
			{* 
			{if adminlink==true}
			<div class="tenpx">
				[ <a href="dokumentacio.php?mit=felt&mod=mod&id={$segedlet.cid}" >szerkesztés</a> ] 
			</div>
			{/if}
			*}
		</div>


		<div style="clear:both"> &nbsp; </div>

			
		
		<h2>Megjegyzések</h2>
			<span class="small"><span class="red">Figyelem!</span> A torrent megjegyzésnek meg kell felelnie a <a href="/dokumentacio.php?mit=szab#cim_90" target="_blank" >szabályzatban leírtaknak!</a></span> 
			<br />
			{include file='bbcode.tpl'}
			<div class="textarea"><textarea name="tnotes" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$dat.text}</textarea></div>
			
			
			<br /><br />

			
		<h2>Kijelentem, hogy:</h2>
		<div class="rights">					
			<input class="required" id="rulesread" name="rulesread" value="yes" type="checkbox">&nbsp;<label for="rulesread">Elolvastam a <a href="dokumentacio.php?mit=szab" target="_blank">szabályzatot</a></label><br>
			<input class="required" id="rightsread" name="rightsread" value="yes" type="checkbox">&nbsp;<label for="rightsread">Elolvastam a <a href="dokumentacio.php?mit=gyik" target="_blank">jogi nyilatkozatot</a></label><br>
			<input class="required" id="illseed" name="illseed" value="yes" type="checkbox">&nbsp;<label for="illseed">A seedelést azonnal megkezdem, és legalább plusz egy seederig folytatom</label><br>
			<br />
			<div class="center"><img class="button" id="formkuld" src="kinezet/{$ipanel.smink}/btn_upload.png" alt="Feltöltés"></div>	
		</div>
	</form>	
	
	{'Feltöltés'|section_end}
	
	</div>
</div>
<script language="javascript" src="scriptek/feltolt.js"></script>
{* a labresz csatolasa *}
{include file='labresz.tpl'}