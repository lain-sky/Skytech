{include file='fejresz.tpl'}
{* a fejlec csatolasa *}

{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	
	{'Opciók'|section_open}
		<a href="?showall=true">Összes torrent</a> | <a href="?showall=false">Seed kötelezett torrentek</a>
	{'Opciók'|section_end}
	
	{'Statisztika'|section_open}
		<table>
			<tr>
				<td>Napi helyezés:</td>
				<td>N/A</td>
				<td>* A napi helyezés óránként frissül, éjfélkor pedig nullázódik.</td>
			</tr>
			<tr>
				<td>Heti helyezés:</td>
				<td>N/A</td>
				<td>* A heti helyezés óránként frissül, vasárnaponként 23 óra 59 perckor pedig nullázódik.</td>
			</tr>
			<tr>
				<td>Havi helyezés:</td>
				<td>N/A</td>
				<td>* A havi helyezés óránként frissül, hónap elsõ napján 0 óra 1 perckor pedig nullázódik.</td>
			</tr>
			<tr>
				<td>Elmúlt havi helyezés:</td>
				<td>N/A</td>
				<td>* Az elõzõ hónapban elért helyezés. Minden hónap elsõ napján frissülõ adat.</td>
			</tr>
			<tr>
				<td>Lehetséges hit'n'runok száma:</td>
				<td>{$hrdb}</td>
				<td>* Ha minden így maradna hónap végéig, akkor ennyi hit'n'runolt torrented lenne.</td>
			</tr>
			<tr>
				<td>Hit'n'runolható torrentek száma:</td>
				<td>-</td>
				<td>* Ennyi torrentnél nincs seed-kötelezettséged. Rangonként eltérõ mennyiség.</td>
			</tr>
			<tr>
				<td>Hit'n'runolt torrentek száma:</td>
				<td>-</td>
				<td>* E hónapban jelenleg ennyi torrentnél nem tettél eleget seed-kötelezettségednek.</td>
			</tr>
		</table>
	{'Statisztika'|section_end}
	
	{"Elmúlt idõszakban futtatott torrentek ($osszdb)"|section_open}
		<table class="skinned" style="width:900px;">
			<tr class="head">
				<td>Név</td>
				<td>Start</td>
				<td>Frissítve</td>
				<td>Status</td>
				<td>Fel</td>
				<td>Le</td>
				<td>Hátravan</td>
				<td>Arány</td>
			</tr>		
			{if $db > 0}
				{foreach from=$seed key=k item=s }
				<tr class="flash">
					<td align=left><a href="adatlap.php?id={$s.tid}" target="_blank">{$s.name}</a></td>
					<td>{$s.kezdes}</td>
					<td>{$s.frissitve|d_to_s}</td>
					<td>{if $s.status == '0'}Stopped{elseif $s.status == '1'}Leech{else}Seed{/if}</td>
					<td>{$s.feltoltve|b_to_s}</td>
					<td>{$s.letoltve|b_to_s}</td>
					<td>{$s.hatravan|t_to_i}</td>
					<td>{if $s.feltoltve/$s.letoltve ==0}nincs{else}{$s.feltoltve/$s.letoltve|string_format:"%.3f"}{/if}</td>
				</tr>
				{/foreach}
			{else}
				<tr class="flash">
					<td colspan="8"><br /><FONT STYLE='font-size: 11px'>Az általad letöltött anyagokat a szabályoknak megfelelõen visszaosztottad, a listád ennek köszönhetõen üres.</FONT></td>
				</tr>
			{/if}
		</table>
	{'Elmúlt idõszakban futtatott torrentek (109)'|section_end}
	

</div>

{* a labresz csatolasa *}
{include file='labresz.tpl'}