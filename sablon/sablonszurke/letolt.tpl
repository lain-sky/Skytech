{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatol�sa *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	

	
	{'B�ng�sz�'|section_open}
		<div align="center">
			<table class="categories">
				<tr>
				{foreach from=$kategoriak item=kategoria}
					<td>
						<ul class="categories">{$kategoria}</ul>
					</td>
				{/foreach}
				</tr>
			<table>
			
			<div class="separator_center_long"></div>
			<form method="post" action="letolt.php" >
			<table  cellpadding="5px" cellspacing="0" class="valasztok" align="center">
		        <tr>
					<td >Keres�s</td>
					<td >
						<input class="skinned" size="30" name="keres_text" id="keres_text" value="{$keres_text}" type="text" />
					</td>
					<td >
						<select name="keres_tipus" class="skinned" >
							{foreach from=$keres_tipusok item=k}
							<option value="{$k.value}" {if $k.selected==true}selected="selected"{/if}>{$k.text}</option>
							{/foreach}
						</select>							
					</td>	
					<td >
						<select name="keres_status" class="skinned" >
							{foreach from=$keres_status item=k}
							<option value="{$k.value}" {if $k.selected==true}selected="selected"{/if}>{$k.text}</option>
							{/foreach}
						</select>							
					</td>	
					<td >
						<input value="Ok"  src="kinezet/{$ipanel.smink}/btn_ok.png" type="image" id="keres_btn" />
							
					</td>
					<td  >&nbsp;
					{if isset($keres_reset)}
						<input type="image" src="kinezet/{$ipanel.smink}/btn_delete.png" id="keres_reset" />
					{/if}					
					</td>
				</tr>
			</table>
			</form>			
		</div>
	{'B�ng�sz�'|section_end}
	
	{'Let�lt�sek'|section_open}	
		<div id="pagertab_upper">
			<div>
				{$betuvel.elozo}&nbsp;{$lapozo}&nbsp;{$betuvel.kovetkezo}&nbsp;&nbsp;
				<select class="skinned" size="1" name="page" id="lapozo_select">
						{$selectbe}
				</select>
			</div>
		</div>
		<table class="torrents">
			<tr class="t_head">
				<td class="t_head_icon"><a href="{$rendezlink[0]}" title="Rendez�s t�pus szerint">T�pus</a></td>
				<td class="t_head_name"><a href="{$rendezlink[1]}" title="Rendez�s n�v szerint">N�v</a></td>
				<td class="t_head_down"><a href="{$rendezlink[2]}" title="Rendez�s a befejezett let�lt�sek sz�ma szerint">DL</a></td>
				<td class="t_head_meret"><a href="{$rendezlink[7]}" title="Rendez�s a torrent m�rete szerint">M�ret</a></td>
				<td class="t_head_sele"><a href="{$rendezlink[3]}" title="Rendez�s a seederek sz�ma szerint">S</a>/
										<a href="{$rendezlink[4]}" title="Rendez�s a leecherek sz�ma szerint">L</a>
				</td>
				<td class="t_head_upby"><a href="{$rendezlink[6]}" title="Rendez�s a felt�lt� neve szerint">Felt�lt�tte</a></td>
			</tr>
			
			{foreach from=$torrentek item=t key=k}
				{include file='torrent_tabi.tpl'}			
			{/foreach}
			
		</table>
		
		<div id="pagertab_lower">
			<div>
				{$betuvel.elozo}&nbsp;{$lapozo}&nbsp;{$betuvel.kovetkezo}&nbsp;&nbsp;
				<select class="skinned" size="1" name="page">
						{$selectbe}
				</select>
			</div>
		</div>
	{'Let�lt�sek'|section_end}	

</div>
<br /><br />

<script language="javascript" src="scriptek/letolt.js"></script>


<!--

<h2>Moder�tori megjegyz�sek: (<a  class="del" href="modcomments.php?action=delete&amp;id=3" title="Megjegyz�s t�rl�se">X</a>)</h2>
<div class="separator_left_long"></div><br>
<div class="modcomment">
	megjegyz�s......<br><br><br><span style="font-style: italic;">�rta: <a style="cursor: pointer;" href="userdetails.php?uid=16" target="_blank">szicsu</a>, ekkor: 2007-10-11 08:42:55.</span>
</div>


-->

{* a labresz csatolasa *}
{include file='labresz.tpl'}