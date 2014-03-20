{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}
<script language="javascript" type="text/javascript" src="scriptek/ajaxqueue.js"></script>
<script language="javascript" type="text/javascript" src="scriptek/hotkeys.js"></script>
{literal}
 <script type="text/javascript">
           
 </script>
{/literal}

<div id="body">
	{foreach from=$OLDAL key=i item=ertek}
		{$ertek}
	{/foreach}

{ if $mehet== true}

{'Üzenõfal'|section_open}
<div class="center"> 
	<div id="uzifal_doboz_nagy">
		<div id="uzifal_doboz">
			<div id="uzifal">
			</div>
		</div>
	</div>
	
	<div id="bevitel">
		<div style="width:100%;text-align:left;padding-left:10px;">
			<h2>Üzenet küldés</h2>
		</div>
		<table width="95%">
			<tr>
				<td rowspan="2">
					<textarea id="chat_uzi" class="textarea" style="border:1px solid #726D5F;height:60px;width:330px;"></textarea>
				</td>
				<td colspan="2">
					<img src="kinezet/smilies/smile1.gif" title=":)" class="kat copy" />
					<img src="kinezet/smilies/wink.gif" title=";)" class="kat copy" />
					<img src="kinezet/smilies/grin.gif" title=":D" class="kat copy" />	
					<img src="kinezet/smilies/sad.gif" title=":(" class="kat copy" />	
					<img src="kinezet/smilies/cry.gif" title=":'(" class="kat copy" />	
					<img src="kinezet/smilies/laugh.gif" title=":lol:" class="kat copy" />
					<img src="kinezet/smilies/yes.gif" title=":yes:" class="kat copy" />	
					<img src="kinezet/smilies/no.gif" title=":no:" class="kat copy" />
					<img src="kinezet/smilies/question.gif" title=":?:" class="kat copy" />	
					<img src="kinezet/smilies/excl.gif" title=":!:" class="kat copy" />						
				</td>
			</tr>	
			<tr>		
				<td>Üzenet szine:
					<select size="1" name="color" id="colors">
						<option  value="alap">Alapérték</option>
						
						<option style="background-color: black; color: black;" value="black">Fekete</option>

						<option style="background-color: white; color: white;" value="white">Fehér</option>
						<option style="background-color: green; color: green;" value="green">Zöld</option>
						<option style="background-color: maroon; color: maroon;" value="maroon">Gesztenye</option>
						<option style="background-color: olive; color: olive;" value="olive">Oliva</option>
						<option style="background-color: navy; color: navy;" value="navy">Mélykék</option>
						<option style="background-color: purple; color: purple;" value="purple">Lila</option>

						<option style="background-color: gray; color: gray;" value="gray">Szürke</option>
						<option style="background-color: yellow; color: yellow;" value="yellow">Sárga</option>
						<option style="background-color: lime; color: lime;" value="lime">Lime</option>
						<option style="background-color: aqua; color: aqua;" value="aqua">Cián</option>
						<option style="background-color: fuchsia; color: fuchsia;" value="fuchsia">Ciklámen</option>
						<option style="background-color: silver; color: silver;" value="silver">Ezüst</option>

						<option style="background-color: red; color: red;" value="red">Piros</option>
						<option style="background-color: blue; color: blue;" value="blue">Kék</option>
						<option style="background-color: teal; color: teal;" value="teal">Pávakék</option>
					</select>
				</td>
				
				<td>
					<input  src="kinezet/{$ipanel.smink}/btn_send.png" type="image" id="kuldes" />
				</td>
			</table>
	</div>	
</div>
<script type="text/javascript">

var UZENOFAL_REFRESH_TIME = 4000;
</script>
<script type="text/javascript" src="scriptek/uzifal.js"></script>

{'Chat'|section_end}




{/if}
</div>

{literal}
<!--script type="text/javascript">

var UZENOFAL_REFRESH_TIME = 4000;
</script>
<script type="text/javascript" src="scriptek/uzifal.js"></script -->

{/literal}
{* a labresz csatolasa *}
{include file='labresz.tpl'}