{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
	<div id="content">
	{foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
	
	{'Kérés'|section_open}
	<div >
		<form method="post" action="kerek.php" id="kerek" >
			<div class="center">
				<h1>{$cim}</h1>
				<br /><br />
			</div>
			
			<table style="text-align:left;" >
				<tr>
					<td width="100px">Név</td>
					<td><input type="text" id="name" name="name" class="skinned" value="{$data.name}" size="50" /></td>
				</tr>
				<tr>
					<td>Kategória</td>
					<td>
						<select  name="kat" class="skinned" style="width:327px;" >
							{foreach from=$kats key=id  item=t}
							<option value="{$t.kid}" {if $t.kid == $data.kat_id} selected="selected"{/if} >{$t.nev}</option>
							{/foreach}									
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">Megjegyzés</td>
				</tr>
			</table>
			{include file='bbcode.tpl'}
			<div class="textarea"><textarea name="text" id="box_content" rows="15" cols="144" style="width: 905px; height: 250px;">{$data.text}</textarea></div>
			<br /><br />
			<div class="center"><img class="button" id="formkuld" src="kinezet/{$ipanel.smink}/btn_send.png" alt="Feltöltés"></div>	
			
			{if $data.kid}
				<input type="hidden" name="modId" value="{$data.kid}" />
			{/if}
			
		</form>	
	</div>	
	{'Kérés'|section_end}
	
	</div>
</div>

{literal}

<script type="text/javascript">

$('#formkuld').click(function(){
	
	if( $.trim( $('#name').val() ).length > 0 ){
		$('#kerek').submit();
	}
	else{
		alert('Legalább a nevet add meg :)');
	}

});


</script>


{/literal}




{* a labresz csatolasa *}
{include file='labresz.tpl'}