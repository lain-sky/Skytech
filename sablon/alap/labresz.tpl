
        <div id="foot"><p class="foot">{$smarty.const.Oldal_lablec_text} - <a href="jogi.html" title="Jogi nyilatkozat">Jogi nyilatkozat</a></p></div>
</div>
        <br />
        {php}
                define('ora_allj',microtime(true));
                $ido=round((ora_allj-ora_indul)*100,3);
                $this->assign('ido',$ido);
                $this->assign('sql',array('num'=>db::$sql_num,'time'=>round(db::$sql_time*1000),3));
                $this->assign('memo', bytes_to_string(round( memory_get_usage(), 3 )));
                @db::hardClose();
        {/php}
		<p><span class="small"><span class="highlight">Ez az oldal {$ido} mp alatt készült el, benne {$sql.num} SQL lekérdezés {$sql.time} ms alatt. Memóriahasználat: {$memo}</span></span></p>
</div>

<script type="text/javascript" src="scriptek/alap.js"></script>

<script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
        var pageTracker = _gat._getTracker("UA-4172634-1");
        pageTracker._initData();
        pageTracker._trackPageview();
</script>
{php}
if( SQL_DEBUG == true){
        echo "<br /><hr /><br />";
        echo "<table style='text-align:left;'>";
        
        foreach( db::$querys as $i=>$item){
                echo "<tr class='".(($i%2)==0? 't_even' : 't_odd' )."'><td>". nl2br( $item['query'] ) ."</td>";
                echo "<td>".round( $item['time']*1000, 3 )."ms</td></tr>";
        }
        
        echo "</table>";

}
{/php}
</body>
</html>
