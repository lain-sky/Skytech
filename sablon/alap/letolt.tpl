{include file='fejresz.tpl'}
{* a fejlec csatolasa *}



{* infopanel csatolása *}
{include file='infopanel.tpl'}


<div id="body">
        {foreach from=$OLDAL key=i item=ertek}{$ertek}{/foreach}
        

        
        {'Böngészõ'|section_open}
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
                                        <td >Keresés</td>
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
        {'Böngészõ'|section_end}
        <div style="width:100%;text-align:center;padding-bottom:20px;clear:both;height:60px;">  
                        <div style="width:470px;float:left;margin:auto;margin-left:18px;margin-right:5px;">
                                <script type="text/javascript"><!--
                                        google_ad_client = "pub-0288142790605333";
                                        /* 468x60, létrehozva 2008.11.12. */
                                        google_ad_slot = "4479421840";
                                        google_ad_width = 468;
                                        google_ad_height = 60;
                                        //-->

                                </script><br>
                                <img border=0 width="460" src='http://sky-tech.hu/kiado.png'></a>
                                <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                        </div>
                        <div id="adContnet" style="width:450px;float:left;margin:auto;">&nbsp;</div>
                        <script type="text/javascript" src="/scriptek/swfobject.js"></script>
                        <img border=0 width="460" src='http://sky-tech.hu/kiado.png'></a>


                </div>
                <div style="clear:both;"></div>
                
                <div id="pagertab_upper">
                        <div>
                                {$betuvel.elozo}&nbsp;{$lapozo}{$betuvel.kovetkezo}
                                <select class="skinned" size="1" name="page" id="lapozo_select_1">
                                                {$selectbe}
                                </select>
                        </div>
                </div>
                <table class="torrents">
                        <tr class="t_head">
                                <td class="t_head_icon"><a href="{$rendezlink[0]}" title="Rendezés típus szerint">Típus.</a></td>
                                <td class="t_head_name"><a href="{$rendezlink[1]}" title="Rendezés név szerint">Név</a></td>
                                <td class="t_head_down"><a href="{$rendezlink[2]}" title="Rendezés a befejezett letöltések száma szerint">DL</a></td>
                                <td class="t_head_meret"><a href="{$rendezlink[7]}" title="Rendezés a torrent mérete szerint">Méret</a></td>
                                <td class="t_head_sele"><a href="{$rendezlink[3]}" title="Rendezés a seederek száma szerint">S</a>/
                                <td class="t_head_sele1"><a href="{$rendezlink[4]}" title="Rendezés a leecherek száma szerint">L</a>
                                <td class="t_head_sele2"><a href="{$rendezlink[5]}" title="Letöltések száma szerint">D</a>
                                                                                
                                </td>
                                <td class="t_head_upby"><a href="{$rendezlink[6]}" title="Rendezés a feltöltõ neve szerint">Feltöltötte</a></td>
                        </tr>
                        {if count($torrentek) >0}
                                {foreach from=$torrentek item=t key=k}
                                        {include file='torrent_tabi.tpl'}                       
                                {/foreach}
                        {else}
                        <tr>
                                <td colspan="6"><br /><p class="red">Nincs találat!</p><br /></td>
                        </tr>
                        {/if}
                        
                </table>
                
                <div id="pagertab_lower">
                        <div>
                                {$betuvel.elozo}&nbsp;{$lapozo}{$betuvel.kovetkezo}
                                <select class="skinned" size="1" name="page" id="lapozo_select_2">
                                                {$selectbe}
                                </select>
                        </div>
                </div>
</div>
<br /><br />

<script language="javascript" src="scriptek/letolt.js"></script>


<!--

<h2>Moderátori megjegyzések: (<a  class="del" href="modcomments.php?action=delete&amp;id=3" title="Megjegyzés törlése">X</a>)</h2>
<div class="separator_left_long"></div><br>
<div class="modcomment">
        megjegyzés......<br><br><br><span style="font-style: italic;">Írta: <a style="cursor: pointer;" href="userdetails.php?uid=16" target="_blank">szicsu</a>, ekkor: 2007-10-11 08:42:55.</span>
</div>


-->

{* a labresz csatolasa *}
{include file='labresz.tpl'}
