/*** ez a script gyujtemény felel az általános scriptekért ****/

//uj szavazas és új level..
$().ready(function(){
	try{
		if(ujSzavazas){
			$.prompt('Új szavazás, megnézed?',{
				buttons: { Igen : true, Nem: false },
				callback: function(v,m){
					if(v==false)return;
					window.location.href='index.php';
				}	     
			});	
		}
	}catch(err){}

	try{	
		if(ujUzenet){		
			$.prompt('Új üzeneted érkezet, megnézed?',{
				buttons: { Igen : true, Nem: false },
				callback: function(v,m){
					if(v==false)return;
						window.location.href='levelezes.php';
				}	     
			});	
		}
	}catch(err){}
});



//hsz torles 
$('.hozzaszolas_torol').click(function(){
	var torolHszCel=$(this).attr('href');
	$.prompt('Biztos törölni szeretnéd a hozzászólást?',{
		buttons: { Igen : true, Nem: false },
		callback: function(v,m){
			if(v==false) return;
			window.location.href=torolHszCel;
		}	     
	});	
	return false;
});


//hirek törléséhez
$(".hirtorol").click(function(){
	var torolHirId=$(this).attr('alt');
	$.prompt('Biztos törölni szeretnéd a hírt?',{
		buttons: { Igen : true, Nem: false },
		callback: function(v,m){
			if(v==false)return;
			$.post('hirek.php',{action : 'torol', hid : torolHirId});
			$('#hirdiv_'+torolHirId).fadeTo('slow',0).hide('slow',function(){
				$('#hirdiv_'+torolHirId).remove();
			});
		}	     
	});	
	return false;
});



//szavazas torlese
$(".szavaztorol").click(function(){
	var torolSzavazId=$(this).attr('alt');
	$.prompt('Biztos törölni szeretnéd a szavazást?',{
		buttons: { Igen : true, Nem: false },
		callback: function(v,m){
			if(v==false)return;
			$.post('szavazas.php',{modmezo : 'del', modid : torolSzavazId},function(){
				window.location.reload()
			});			
		}	     
	});
	return false;
});

//dokumentacio torlese
$(".dokmentacio_torlese").click(function(){
	dokTorolId=$(this).attr('alt');
	dokTorolFeldolg=$(this).attr('href');
	$.prompt('Biztos törölni szeretnéd a bejegyzést?',{
		buttons: { Igen : true, Nem: false },
		callback: function(v,m){
			if(v==false)return;			
			$.post(dokTorolFeldolg,{modmezo : 'del', modid : dokTorolId},function(){
				$("#dokumentacio_div_"+dokTorolId).fadeTo('slow',0).hide('slow',function(){
					$("#dokumentacio_div_"+dokTorolId).remove();
				});
			});
		}	   
	});
	return false;


});


//var SECTION_COOKIE = 'skysection';
//var INFOPANEL_COOKIE = 'skyinfopanel';



//info panel elrejtése  megjelenítése
$('#togglebutton').click(function(){
	if($('#infopanel').css("display")=='block'){
		$('#infopanel').fadeTo('slow',0);
		$('#infopanel').slideUp( 'fast');
		$.cookie(INFOPANEL_COOKIE, 'none');
	}	
	else{
		$('#infopanel').slideDown( 'fast');
		$('#infopanel').fadeTo('slow',1);
		$.cookie(INFOPANEL_COOKIE, 'block');
	}
	return false;	
});


//a selection elrejtése/megjelenítése
$('.section_link').click(function(){
	mit=$(this).attr("href");
	if($(mit).css("display")=='block'){
		$(mit).fadeTo('slow',0);
		$(mit).slideUp('fast');
		$(mit+'_span').removeClass("section_expanded");
		$(mit+'_span').addClass("section_collapsed");
		sectionCookie( mit , 'add');
			
	}	
	else{
		$(mit).slideDown('fast');
		$(mit).fadeTo('slow',1);		
		$(mit+'_span').removeClass("section_collapsed");
		$(mit+'_span').addClass("section_expanded");	
		sectionCookie( mit , 'remove');
	}
	return false;	
});

function sectionCookie( id , type ){
	id=id.replace('#','');
	try{
		array=$.cookie(SECTION_COOKIE).split(';');
	}catch(err){
		array=[];
	}
	
	if( type == 'remove' ){
		for(i=0; i < array.length; i++ ){
			if( array[i] == id ){
				array[i] = null;
			}
		}
	}
	else{
		if( $.inArray(id, array) == -1 ){
			array.push(id);
		}
	}
	array = $.unique( array );
	$.cookie(SECTION_COOKIE, array.join(';') );
	
	//alert($.cookie(SECTION_COOKIE) );

}


//az section belüli menupontok pl hirek elrejtése/megjelenítése
$('.al_section').click(function(){
	mit=$(this).attr("href");
	if($(mit+'_div').css("display")=='block'){
		$(mit+'_div').fadeTo('slow',0);
		$(mit+'_div').slideUp('fast');
		$(mit+'_kep').attr({ src: "kinezet/"+SMINK+"/expand.png"});			
	}	
	else{
		$(mit+'_div').slideDown('fast');
		$(mit+'_div').fadeTo('slow',1);		
		$(mit+'_kep').attr({ src: "kinezet/"+SMINK+"/collapse.png"});
		
	} 
	return false;	
});


// a scrollozás
$('.scroll').click(function(){
	mit=$(this).attr("href");
	$(mit).ScrollTo('slow');
	return false;
});

//az eltuno_dialog eltuntetese;
$().ready(function(){
	$('#eltuno_dialog').fadeTo(8000,0,function(){
		$('#eltuno_dialog').hide('slow',function(){
			$('#eltuno_dialog').remove();
		});
	});
});





//a profil beállításnál a visszaállítás
$('#avatar_regi').click(function(){
	regi=$('#avatar_regi').attr('href');
	$('#avatar_kep').attr({src: regi});
	$('#avatar_url').val(regi);
	return false;
});

// a profil beállításnál az avatar elölnézet.
$('#avatarelol').click(function(){	
	if($('#avatar_regi').attr('href')=='#'){
		$('#avatar_regi').attr({href: $('#avatar_kep').attr('src')} );	
	}
	$('#avatar_kep').attr({src:$('#avatar_url').val()});	
	return false;
});


//infopanelen a konyvjelzõtorles
$().ready(function(){
	ipanelGombBeallitas();
});
function ipanelGombBeallitas(){
	$('div.deletebookmark > a.pic').click(function(){
		ipanelKonyvjelzoDel($(this).attr("href"));
		return false;
	});
	
	$('#bookmarkpager > a.pic').click(function(){
		ipanelKonyvLapoz($(this).attr("href"));
		return false;
	});
}
function ipanelKonyvjelzoDel(id){
	$('#bookmarks').fadeTo('slow',0,function(){
		$.get('letolt_admin.php',{modul:'delkonyv',tid:id},function(html){
			$('#bookmarks').html(html);
			$('#bookmarks').fadeTo('slow',1);
			ipanelGombBeallitas();
		});
	});
	$('#addk_'+id).show();
	$('#delk_'+id).hide();
	return false;
}

function ipanelKonyvLapoz(old){
	$('#bookmarks').fadeTo('slow',0,function(){
		$.get('letolt_admin.php',{modul:'lapoz',tid:old},function(html){
			$('#bookmarks').html(html);
			$('#bookmarks').fadeTo('slow',1);			
			ipanelGombBeallitas();
		});	
	});
	
}


//az uzenoablakmeg jelenitese
$().ready(function(){
	windowX = (window.screen.width-450)/2;
	$('#uizablak').fadeTo(0,1).css('margin-left',windowX);
	$('#uziablak_alap').fadeTo(0,0);
	$('#uziablak_alap').show().fadeTo('slow',0.7,function(){
		$('#uizablak').animate( { top:"300px"}, 1000 )
						.animate( { top:"200px"}, 300 )
						.animate( { top:"201px"}, 5000 )
						.animate( { top:"-300px"}, 1000,function(){
							$('#uziablak_alap').fadeTo('slow',0,function(){
								$('#uziablak_alap').hide();
							});
						});
	});
});

//a lapozo seletjehez tartozo script
$('#lapozo_select_1 , #lapozo_select_2').change(function () {
	ez=$(this).attr('id');
	$("#"+ ez +" > option:selected").each(function () {
		window.location=$(this).val();
	});
});

//user lista mozgato

$('.user_link_kep').click(function(){
	
	id=$(this).attr('alt');
	trId="#user_tr_"+id;
	divId="#user_div_"+id;
	
	
	
	if($(divId).css("display")=='none'){
		$(trId).css("display",'');
		$(divId).show('slow',function(){
			$(divId).fadeTo('slow',1);
		});
	}
	else{		
		$(divId).fadeTo('slow',0,function(){
			$(divId).hide('slow',function(){
				$(trId).css("display",'none');
			});
		});	
	}
	
	return false;
});

       


