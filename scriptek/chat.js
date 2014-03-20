$.ajaxSetup({
	url: "chat_admin.php",
	type: "POST"
});
$().ready(function() {
	getSzobaLista();
	setFulek();
	$('#chat_uzi').keyup(function(event) {
		bill = (event.keyCode) ? event.keyCode: event.which;
		if (bill == 13) {
			uziKuld()
		}
	});
	$('#kuldes').click(function() {
		uziKuld()
	})
});
function getSzobaLista() {
	jQuery.ajaxQueue({
		data: {
			modul: 'szobalist'
		},
		success: function(html) {
			szobaListaKirak(html)
		}
	})
}
function szobaListaKirak(html) {
	mit = "#szoba_lista_box";
	$(mit).fadeTo('slow', 0,
	function() {
		$(mit).html(html)
	}).fadeTo('slow', 1,
	function() {
		setSzobaLink()
	})
}
function setSzobaLink() {
	$('.szl_click').dblclick(function() {
		mit = $(this).attr('alt');
		nev = $(this).text();
		addFul(mit, nev);
		return false
	});
	$('.szl_click').click(function() {
		mit = $(this).attr('alt');
		getSzobaInfo(mit);
		return false
	})
}
function getSzobaInfo(mit) {
	jQuery.ajaxQueue({
		data: {
			modul: 'szobainfo',
			id: mit
		},
		success: function(html) {
			szobaInfoKirak(html)
		}
	})
}
function szobaInfoKirak(html) {
	mit = "#szoba_info_box";
	$(mit).fadeTo('slow', 0,
	function() {
		$(mit).html(html)
	}).fadeTo('slow', 1)
}
function szobaBelepes(mit) {
	jQuery.ajaxQueue({
		data: {
			modul: 'szobabelep',
			id: mit
		}
	})
}
function setFulek(id) {
	$('#ful_link_' + id).click(function() {
		fulAktival(id);
		return false
	});
	$('#ful_close_' + id).click(function() {
		fulBezar(id);
		return false
	})
}
function addFul(mit, nev) {
	if (checkFul(mit) != true) {
		return false
	}
	szobaBelepes(mit);
	pos = nev.indexOf('(');
	nev = nev.substring(0, pos);
	if (nev.length > maxFulNev) {
		rovidNev = nev.substring(0, maxFulNev) + '..'
	} else {
		rovidNev = nev
	}
	ful = '<div id="ful_' + mit + '" class="ful_div" >';
	ful += '<div class="ful_bal_div"><a href="#" class="pic" id="ful_link_' + mit + '" title="' + nev + '">' + rovidNev;
	ful += '</a></div>';
	ful += '<div class="ful_jobb_div"><img src="kinezet/' + SMINK + '/tabs_del.png"  class="kat" id="ful_close_' + mit + '" /></div>';
	ful += '</div>';
	$('#ful_box').append(ful);
	ablak = '<div id="chat_ablak_' + mit + '" class="chat_ablak"></div>';
	$('#chat_ablak_box').append(ablak);
	setFulek(mit);
	fulAktival(mit)
}
function checkFul(mit) {
	if ($(".ful_div").size() >= maxFul) {
		alert("Elérted a maximálisan engedélyezett tabszámot(" + maxFul + ")");
		return false
	}
	mehet = true;
	$(".ful_div").each(function(i) {
		if (this.id == 'ful_' + mit) {
			alert("A szobában már jelen vagy!");
			mehet = false;
			return false
		}
	});
	return mehet
}
function fulBezar(id) {
	$.prompt('Biztos ki akarsz lépni a szobából?', {
		buttons: {
			Igen: true,
			Nem: false
		},
		callback: function(v, m) {
			if (v == false) return;
			$('#ful_' + id).remove();
			$('#chat_ablak_' + id).remove();
			utolsoFulAktival()
		}
	})
}
function fulAktival(id) {
	$('.ful_div_aktiv').removeClass('ful_div_aktiv').addClass('ful_div');
	$('#ful_' + id).removeClass('ful_div').addClass('ful_div_aktiv');
	$('.chat_ablak_aktiv').removeClass('chat_ablak_aktiv').addClass('chat_ablak');
	$('#chat_ablak_' + id).removeClass('chat_ablak').addClass('chat_ablak_aktiv');
	aktivFul = id
}
function utolsoFulAktival() {
	utolso = $('.ful_div:last').attr('id');
	try {
		utolso = utolso.replace('ful_', '')
	} catch(err) {
		aktivFul = 0;
		$('div.slider1').hide();
		return true
	}
	fulAktival(utolso)
}
function chatAblakFrissit() {
	if (aktivFul == 0) return true;
	jQuery.ajaxQueue({
		data: {
			modul: 'gethsz',
			id: aktivFul
		},
		success: function(html) {
			$('#chat_ablak_' + aktivFul).prepend(html);
			myscroll()
		}
	})
}
function uziKuld() {
	uzi = $('#chat_uzi').val();
	color = $('#colors').val();
	if (uzi.length < 1) return false;
	jQuery.ajaxQueue({
		data: {
			modul: 'addhsz',
			text: uzi,
			id: aktivFul,
			szin: color
		}
	});
	$('#chat_uzi').val('')
}
var aktivFul = 0;
var maxFul = 5;
var maxFulNev = 15;
var uzenetFrissites = self.setInterval("chatAblakFrissit()", 2000);
var szobaListaFrissites = self.setInterval("getSzobaLista()", 60000);
function myscroll() {
	$('.slider1').show();
	ocontainer = $('#chat_ablak_box');
	ocontent = $('.chat_ablak_aktiv');
	containerSize = jQuery.iUtil.getSize(ocontainer.get(0));
	containerPosition = jQuery.iUtil.getPosition(ocontainer.get(0));
	containerInner = jQuery.iUtil.getClient(ocontainer.get(0));
	contentSize = jQuery.iUtil.getSize(ocontent.get(0));
	$('.slider1').css('top', containerPosition.y + 'px');
	$('.slider1').css('left', '678px');
	$('.slider1').css('height', containerSize.hb + 'px');
	spaceToScroll = contentSize.hb - containerInner.h;
	$('.indicator').css('height', containerInner.h * containerSize.hb / contentSize.hb + 'px');
	$('.slider1').Slider({
		accept: '.indicator',
		onSlide: function(cordx, cordy, x, y) {
			ocontent.css('top', -spaceToScroll * cordy / 100 + 'px')
		}
	})
}