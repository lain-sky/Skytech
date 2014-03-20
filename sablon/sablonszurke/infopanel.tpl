{* ez az infopanel és az alatta lévõ div megjelenítõ *}
<script language="javascript">
var SMINK='{$ipanel.smink}';
var SECTION_COOKIE = '{$smarty.const.SECTION_COOKIE}';
var INFOPANEL_COOKIE = '{$smarty.const.INFOPANEL_COOKIE}';
</script>

	<div id="infopanel" style="overflow: visible; display: {$ipanel.display};">
		<ul>
			<li id="ip_myavatar">
				<div id="myavatarwrapper"><img id="myavatar" src="{$ipanel.avatar}" alt="Avatarom" title="Ugrás a profilomhoz" onclick="window.location='userinfo.php?uid={$ipanel.uid}'" border="0" /></div>
			</li>
			<li id="ip_adataim">
				<div class="ip_title">Üdv újra!</div>
				<table>
					<tr>
	                	<td class="jel"><img src="kinezet/{$ipanel.smink}/ip_people.png" alt="Felhasználó neved" title="Felhasználó neved"border="0" height="27" width="22" ></td>
	                    <td class="nicknev"><span id="myname">{$ipanel.name}</span><br /><br /></td> 
					</tr>
					<tr>
	                	<td class="jel"><img src="kinezet/{$ipanel.smink}/ip_rank.png" alt="Rangod" title="Rangod" border="0" height="27" width="22" /></td>
	                    <td class="rang"><span id="myrank"><span class="rank{$ipanel.rang}">{$ipanel.rang_text}</span></span></td>
					</tr>
					<tr style="display:none;">
	                	<td class="jel"><img src="kinezet/{$ipanel.smink}/ip_rank.png" alt="Rangod" title="Rangod" border="0" height="27" width="22" /></td>
	                    <td class="rang">{$ipanel.pontok} Sky-Pont</td>
					</tr>
				</table>
			</li>
			<li id="ip_mytraffic">
				<div class="ip_title">Adatforgalmad, arányod</div>
				<div id="ratio_meter">
					<img src="kinezet/{$ipanel.smink}/rm_dn.png" alt="Letöltésed mértéke" title="Letöltésed mértéke" border="0" height="17" width="{$ipanel.letolt_csik}">
					<img src="kinezet/{$ipanel.smink}/rm_up.png" alt="Feltöltésed mértéke" title="Feltöltésed mértéke" border="0" height="17" width="{$ipanel.feltolt_csik}">
				</div>
				<div id="mytraffic">
					Letöltésed: <span class="highlight">{$ipanel.letolt|b_to_s}</span>, feltöltésed: <span class="highlight">{$ipanel.feltolt|b_to_s}</span>, arányod: <span class="{$ipanel.arany|aranyszin}">{$ipanel.arany_text}</span>
				</div>
			</li>
			<li id="ip_bookmarks">
				<div id="bookmarks_div">
					<div class="ip_title">Könyvjelzoid</div>
					<div id="bookmarks">{$ipanel.konyvjelzok}</div>
				</div>
			</li>
		</ul>
		<div id="others_nav">
			<ul>
				<li><a class="helpdesk" href="helpdesk.php" target="_self" title="Ha valami nemsikerül egyedül...">Helpdesk</a></li>
				<li><a class="chat" href="chat.php" target="_self" title="Élõben beszélgess a felhazsnálókkal...">Chat</a></li>
				<li><a class="topten" href="top10.php" target="_self" title="No commnet...">Top 10</a></li>
	            <li class="other_nav_space_left"></li>
	            <li><a class="kijelentkezem" href="belep.php?logout=true" title="Kijelentkezem!">Kijel!</a></li>
				<li><a class="beallitasaim" href="profil.php" title="Beállításaim">Beállít</a></li>
				<li><a class="torrentjeim" href="letolt.php?uid={$ipanel.uid}" title="Torrentjeim">torrent</a></li>
				<li><a class="leveleim" href="levelezes.php" title="Leveleim (Nincs új)">level</a></li>
				<li><a class="barataim" href="barat.php" title="Barátaim">barat</a></li>
				<li><a class="atadok" href="atadas.php" title="Átadok!">atad</a></li>
				<li><a class="meghivok" href="meghivo.php" title="Meghívok!">megh</a></li>   
	            <li class="other_nav_space_right"></li>
				<li><a class="linkek" href="dokumentacio.php?mit=link" target="_self" title="No commnet...">Linkek</a></li>
				<li><a class="felhasznalok" href="users.php" target="_self" title="No commnet...">Felhasználók</a></li>
				<li><a class="radio" href="radio.php" target="_self" title="No commnet...">Rádió</a></li>
			</ul> 
		</div>	
	</div>
<div id="toggle"><a id="togglebutton" href="#"  title="Kinyit/Becsuk!">&nbsp;</a></div><br /><br />
	 
<script language="javascript" src="scriptek/thickbox.js"></script>

<script type="text/javascript">
{if $ipanel.uj_level==true}
var ujUzenet=true;
{elseif $ipanel.uj_szavazas==true}
var ujSzavazas=true;
{/if}

{if $ipanel.gui=='gui'}
var GUI=true;
{else}
var GUI=false;
{/if}


</script>