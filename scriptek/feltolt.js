$("#tsceneyes").click(csillagoz);
$("#tsceneno").click(csillagoz);
$("#tcategory").change(csillagoz);
$().ready(csillagoz);
$('#formkuld').click(ellenor);
function ellenor() {
	mehet = true;
	$(':text, :file').each(function() {
		if (mehet) {
			eId = this.id;
			sId = eId.replace('mezo', 'req');
			if ($('#' + sId).attr('class') == 'req') {
				if ($(this).val().length < 4) {
					this.focus();
					mehet = false;
					alert('Minden megcsillagozott mezõt ki kell tölteni, minimum 4 karakterrel!')
				}
			}
		}
	});
	if (mehet) {
		if (fileType('torrent', $('#mezo12').val()) == false) {
			mehet = false;
			alert('A torrent fájl nem megfelelõ!!')
		}
	}
	if (mehet) {
		if ($('#mezo1').val()) {
			if (fileType('nfo', $('#mezo1').val()) == false) {
				mehet = false;
				alert('Az nfo fájl nem megfelelõ!!')
			}
		}
	}
	if (mehet) {
		$('.required').each(function() {
			if (mehet) {
				if ($(this).attr('checked') != true) {
					this.focus();
					mehet = false;
					alert('Minden feltételt el kell fogadni!!')
				}
			}
		})
	}
	if (mehet) {
		document.uploadform.submit()
	}
}
function fileType(a, b) {
	tomb = b.split('.');
	if (tomb[tomb.length - 1] == a) {
		return true
	} else return false
}
function csillagoz() {
	if ($('#tsceneyes').attr('checked') == true) {
		$('#req1').attr('class', 'req');
		$('#req2').attr('class', 'notreq');
		$('#req3').attr('class', 'notreq');
		$('#req4').attr('class', 'notreq');
		$('#req5').attr('class', 'notreq');
		$('#req6').attr('class', 'notreq');
		$('#req7').attr('class', 'notreq')
	} else {
		$('#req1').attr('class', 'notreq');
		$('#req3').attr('class', 'req');
		$('#req4').attr('class', 'req');
		switch ($('#tcategory').val()) {
		case '3':
		case '4':
		case '5':
		case '6':
		case '7':
		case '9':
		case '10':
		case '11':
		case '13':
		case '9':
		case '24':
		case '14':
		case '15':
		case '16':
			$('#req2').attr('class', 'req');
			break;
		default:
			$('#req2').attr('class', 'notreq')
		}
		switch ($('#tcategory').val()) {
		case '3':
		case '4':
		case '5':
		case '6':
		case '7':
		case '8':
		case '10':
		case '11':
		case '13':
		case '17':
		case '18':
		case '19':
		case '9':
		case '24':
			$('#req5').attr('class', 'req');
			$('#req6').attr('class', 'req');
			$('#req7').attr('class', 'req');
			break;
		default:
			$('#req5').attr('class', 'notreq');
			$('#req6').attr('class', 'notreq');
			$('#req7').attr('class', 'notreq')
		}
	}
}