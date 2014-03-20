var toltoDiv = '#toltodiv';
var helyId = '#asztal';
var tartId = '#leveltartalom';
var cimId = 'level.php?mit=';
var keszvagy_e = true;
var setUjLevelIdozito;
var setSorAkcioIdozito;
var saveClassNameArray = new Array();
var kijeloltLevel = 0;
$('#uj_level').click(function() {
	oldalLeker('uj_level', 'uj_level');
	return false
});
$('#bejovo_level').click(function() {
	oldalLeker('bejovo_level', 'bejovo_level');
	return false
});
$('#szemetes').click(function() {
	oldalLeker('szemetes', 'szemetes');
	return false
});
$('#kuldott_level').click(function() {
	oldalLeker('kuldott_level', 'kuldott_level');
	return false
});
$().ready(function() {
	if (userPara == 1) {
		$(toltoDiv).fadeTo(0, 0);
		setUjLevel()
	} else {
		oldalLeker('bejovo_level')
	}
});
function asztalBecsuk() {
	$(helyId).slideUp(500,
	function() {
		$(toltoDiv).fadeTo('normal', 1);
		$(tartId).remove()
	})
}
function asztalKinyit() {
	$(toltoDiv).fadeTo('normal', 0);
	$(helyId).slideDown(500);
	window.setTimeout("oldalGorget();", 550)
}
function asztalOldal(mit) {
	$(helyId).load(cimId + mit, {
		limit: 25
	},
	function() {
		asztalKinyit()
	})
}
function oldalLeker(mit, icon) {
	keszvagy_e = false;
	asztalBecsuk();
	window.setTimeout("asztalOldal('" + mit + "');", 550);
	modLehetosegekKep(icon);
	switch (icon) {
	case 'uj_level':
		setUjLevel();
		break;
	default:
		setSorAkcio()
	}
}
function oldalGorget() {
	$('#ide_scroll').ScrollTo('slow');
	keszvagy_e = true
}
function kijeloltLevelSzamol() {
	kijeloltLevel = $("input:checked").length
}
var fadeInSuggestion = function(suggestionBox, suggestionIframe) {
	$(suggestionBox).fadeTo(300, 0.9)
};
var fadeOutSuggestion = function(suggestionBox, suggestionIframe) {
	$(suggestionBox).fadeTo(300, 0)
};
function setUjLevel() {
	if (keszvagy_e) {
		$('#cimzetuser').Autocomplete({
			source: 'userlista.php',
			delay: 500,
			fx: {
				type: 'slide',
				duration: 400
			},
			autofill: true,
			helperClass: 'autocompleter',
			selectClass: 'selectAutocompleter',
			minchars: 2,
			onShow: fadeInSuggestion,
			onHide: fadeOutSuggestion
		})
	} else {
		setUjLevelIdozito = window.setTimeout("setUjLevel();", 100)
	}
}
function setSorAkcio() {
	if (keszvagy_e) {
		setSorKatt();
		setLevelKijeloles()
	} else {
		setSorAkcioIdozito = window.setTimeout("setSorAkcio();", 100)
	}
}
function setSorKatt() {
	tomb = document.getElementsByTagName("tr");
	for (i = 0; i < tomb.length; i++) {
		tid = tomb.item(i).id;
		if (tid.indexOf('fej_') > -1) {
			modId = '#' + tid;
			$(modId).dblclick(function() {
				mailToggle(this);
				$.get(cimId + 'level_olvasott', {
					lid: this.id
				})
			}).click(function() {
				selectSor(this)
			});
			cnm = tomb.item(i).className;
			clId = idClear(tid);
			saveClassNameArray[clId] = cnm
		}
	}
}
function selectSor(e) {
	sorId = '#' + e.id;
	boxId = '#' + e.id;
	clId = idClear(e.id);
	cName = saveClassNameArray[clId];
	boxId = boxId.replace('fej', 'box');
	if ($(boxId).attr("checked")) {
		$(boxId).attr("checked", false);
		$(sorId).removeClass("mail_highli").addClass(cName)
	} else {
		$(boxId).attr("checked", true);
		$(sorId).removeClass(cName).addClass("mail_highli")
	}
	setUzenetFunkcioJog()
}
function idClear(i) {
	kesz = i.replace('fej_', '');
	kesz = kesz.replace('box_', '');
	return kesz
}
function mailToggle(e) {
	torzsId = '#' + e.id;
	torzsId = torzsId.replace('fej', 'torzs');
	if ($(torzsId).css("display") == 'none') {
		$(torzsId).css('opacity', 0);
		$(torzsId).show(300,
		function() {
			$(torzsId).fadeTo(300, 1)
		})
	} else {
		$(torzsId).fadeTo(300, 0,
		function() {
			$(torzsId).hide(300)
		})
	}
}
function modLehetosegekKep(e) {
	kepId = e + '_kep';
	aktiv = '_active';
	tomb = document.getElementsByTagName("img");
	for (i = 0; i < tomb.length; i++) {
		if (tomb.item(i).className == 'mailerbtn') {
			kId = tomb.item(i).id;
			kSrc = tomb.item(i).src;
			if (kepId == kId) {
				if (kSrc.indexOf(aktiv) < 0) {
					modSrc = kSrc.replace('.png', '') + aktiv + '.png';
					tomb.item(i).src = modSrc
				}
			} else {
				if (kSrc.indexOf(aktiv) > -1) {
					modSrc = kSrc.replace(aktiv, '');
					tomb.item(i).src = modSrc
				}
			}
		}
	}
}
function setLevelKijeloles() {
	$('#mind_kijelol').click(function() {
		chekModosit(1);
		return false
	});
	$('#no_kijelol').click(function() {
		chekModosit(2);
		return false
	});
	$('#fordit_kijelol').click(function() {
		chekModosit(3);
		return false
	});
	$('#kis_level_valasz').click(function() {
		levelValasz()
	});
	$('#kis_level_tovabb').click(function() {
		levelTovabbKuld()
	});
	$('#kis_level_megjel').click(function() {
		levelJelolesek()
	});
	$('#kis_level_letolt').click(function() {
		levelekLeTolt()
	});
	$('#kis_level_kukaba').click(function() {
		levelekSzemetbeDob()
	});
	$('#kis_level_vegleges_torles').click(function() {
		levelekVeglegesTorles()
	})
}
function chekModosit(mod) {
	tomb = document.getElementsByTagName("input");
	for (i = 0; i < tomb.length; i++) {
		if (tomb.item(i).type == 'checkbox') {
			boxId = tomb.item(i).id;
			mboxId = '#' + boxId;
			clId = idClear(boxId);
			cName = saveClassNameArray[clId];
			sorId = '#fej_' + clId;
			msorId = 'fej_' + clId;
			switch (mod) {
			case 1:
				$(mboxId).attr('checked', true);
				$(sorId).removeClass(cName).addClass("mail_highli");
				break;
			case 2:
				$(mboxId).attr('checked', false);
				$(sorId).removeClass("mail_highli").addClass(cName);
				break;
			case 3:
				chObj = new Object();
				chObj.id = msorId;
				selectSor(chObj);
				break
			}
		}
	}
	setUzenetFunkcioJog()
}
function setUzenetFunkcioJog() {
	kijeloltLevelSzamol();
	$('#mbuttons > :image').each(function(i) {
		switch (this.alt) {
		case '0':
			if (kijeloltLevel > 0) {
				uzenetFunkcioEnged(this)
			} else {
				uzenetFunkcioTilt(this)
			}
			break;
		case '1':
			if (kijeloltLevel == 1) {
				uzenetFunkcioEnged(this)
			} else {
				uzenetFunkcioTilt(this)
			}
			break
		}
	})
}
function uzenetFunkcioEnged(e) {
	e.disabled = false;
	e.src = e.src.replace('_disabled', '')
}
function uzenetFunkcioTilt(e) {
	e.disabled = true;
	if (e.src.indexOf('_disabled') < 0) {
		e.src = e.src.replace('.png', '_disabled.png')
	}
}
function setUzenetStatus(i, s) {
	$.post('level.php', {
		status: s,
		mid: i
	})
}
function levelekSzemetbeDob() {
	elso = true;
	idK = '';
	$("input:checked").each(function(i) {
		levelSzemetbeDob(idClear(this.id));
		idK += (elso) ? idClear(this.id) : ';' + idClear(this.id);
		elso = false
	});
	setUzenetFunkcioJog();
	setUzenetStatus(idK, 's')
}
function levelSzemetbeDob(lId) {
	sorId = '#fej_' + lId;
	torzsSorId = '#torzssor_' + lId;
	$(sorId).remove();
	$(torzsSorId).remove()
}
function levelTovabbKuld() {
	lId = $("input:checked:first").attr('id');
	lId = idClear(lId);
	oldalLeker('level_tovabb&mid=' + lId, 'uj_level')
}
function levelValasz() {
	lId = $("input:checked:first").attr('id');
	lId = idClear(lId);
	oldalLeker('level_valasz&mid=' + lId, 'uj_level')
}
function levelekLeTolt() {
	elso = true;
	idK = '';
	$("input:checked").each(function(i) {
		idK += (elso) ? idClear(this.id) : ';' + idClear(this.id);
		elso = false
	});
	form = "<form id='letolt_form' action='level.php' method='post'>";
	form += "<input type='hidden' name='letolt' value='1' />";
	form += "<input type='hidden' name='mid' value='" + idK + "' />";
	form += "</form>";
	$(tartId).append(form);
	$('#letolt_form').submit().remove()
}
function levelJelolesek() {
	elso = true;
	idK = '';
	tip = '';
	$("input:checked").each(function(i) {
		lId = idClear(this.id);
		s = levelJelol(lId);
		idK += (elso) ? lId + ',' + s: ';' + lId + ',' + s;
		elso = false
	});
	$.post('level.php', {
		jeloles: '1',
		mid: idK
	})
}
function levelJelol(i) {
	sorId = '#fej_' + i;
	if ($(sorId).attr('alt') == 1) {
		tdText = $(sorId + '>td:eq(3)').text();
		$(sorId + '>td:eq(3)').text(tdText);
		$(sorId).attr('alt', '0');
		return '0'
	} else {
		imgText = '<img src="kinezet/' + SMINK + '/m_marked.png"  />';
		$(sorId + '>td:eq(3)').prepend(imgText);
		$(sorId).attr('alt', '1');
		return '1'
	}
}
function levelekVeglegesTorles() {
	i = $("input:checked").length;
	kerdes = 'Biztos, hogy véglegesen törölni szeretné a ' + i + ' db levelet?';
	if (confirm(kerdes) == true) {
		elso = true;
		idK = '';
		$("input:checked").each(function() {
			lId = idClear(this.id);
			idK += (elso) ? lId: ';' + lId;
			elso = false;
			levelSzemetbeDob(lId)
		});
		$.post('level.php', {
			torles: '1',
			mid: idK
		})
	}
}