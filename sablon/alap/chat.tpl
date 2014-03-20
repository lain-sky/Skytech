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

{'Chat'|section_open}

	<div id="chat_nagybox">
		<div id="chat_bal">
			<div id="chat_ablak_nagy">      
	            <div style="clear:both;" id="ful_box">
	                
	            </div>
				
				
						
			            <div  id="chat_ablak_box" >
							
						
			            </div>
						<div class="slider1"><div class="indicator"></div></div>
					
			</div>				
			<div id="bevitel">
				<h2>Üzenet küldés</h2>
				<table width="95%">
					<tr>
						<td>
							<textarea id="chat_uzi" class="textarea" style="border:1px solid #726D5F;height:60px;width:330px;"></textarea>
						</td>
						<td>Üzenet színe:
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
		<div id="chat_jobb">
			<div id="szoba_lista">
				<h2>Szoba lista</h2>
				<div id="szoba_lista_box">
				
				</div>			
			</div>
			<div id="szoba_info">
				<h2>Szoba Infó</h2>
				<div id="szoba_info_box">
				
				</div>
			</div>
		</div>

	</div>

{'Chat'|section_end}





{/if}
</div>
<script language="javascript" type="text/javascript" src="scriptek/chat.js"></script>

{* a labresz csatolasa *}
{include file='labresz.tpl'}