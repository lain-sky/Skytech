<div align="center">
	<table>
		<tr>
			<td class="dlgcell" rowspan="16" width="190">
				<p><a href="userinfo.php?uid={$uinfo.uid}" class="pic"><img class="avatar" border="0" src="{$uinfo.avatar}" alt=""/></a></p>

			</td>
			<td class="dlgcell"></td>
			<td class="dlgcell"></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Név:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.name}</p></td>
		</tr>

		<tr>
			<td class="dlgcell"><p class="right"><b>Rang:</b></p></td>
			<td class="dlgcell"><p class="left">{$RANGOK[$uinfo.rang]}
				{if $uinfo.egyedi_rang}
					&nbsp;( {$uinfo.rang_text} )
				{/if}
			</p></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Regisztrált:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.reg_date}</p></td>

		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Legutóbb itt járt:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.vizit}</p></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Hozzászólások száma:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.hszszam}&nbsp;db</p></td>
		</tr>
			<tr>
			<td class="dlgcell"><p class="right"><b>Torrent hozzászólások:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.tor_hszszam}&nbsp;db</p></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Letöltött:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.letolt|b_to_s}</p></td>
		</tr>
		<tr>

			<td class="dlgcell"><p class="right"><b>Feltöltött:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.feltolt|b_to_s}</p></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Arány:</b></p></td>
			<td class="dlgcell"><p class="left"><span class="{$uinfo.arany|aranyszin}">{$uinfo.arany_text}</span></p></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Sky-Pont:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.pontok} pont</p></td>
		</tr>

		<tr>
			<td class="dlgcell"><p class="right"><b>Lakóhely:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.orszag} {$uinfo.varos}</p></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Stílus:</b></p></td>
			<td class="dlgcell"><p class="left">{$uinfo.smink}</p></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Barátok:</b></p></td>
			<td class="dlgcell"><p class="left">
			{if $uinfo.barat==true}
				<a href="barat.php?akcio=del&uid={$uinfo.uid}" title="User törlése a barátaim közül">{$uinfo.name} törlése a barátaim közül</a>
			{else}
				<a href="barat.php?akcio=add&uid={$uinfo.uid}" title="User felvétele a batátaim közé">{$uinfo.name} felvételel a barátaim közé</a>
			{/if}			
			</p></td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>E-mail cím:</b></p></td>
			<td class="dlgcell"><p class="left">
				{if $mailNoHidden==true}
					<a title="Levél írása." href="mailto:{$uinfo.email}">{$uinfo.email}</a>
				{else}
					Rejtve!
				{/if}
				</p>
			</td>
		</tr>
		<tr>
			<td class="dlgcell"><p class="right"><b>Mailer:</b></p></td>

			<td class="dlgcell"><p class="left"><a href="levelezes.php?uid={$uinfo.uid}">Levél írása {$uinfo.name} számára</a></p></td>
		</tr>
	</table>
	<br/>
</div>	