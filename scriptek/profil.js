function pw_sec_check(nick, theme) {
	var passw = $('#c16').val();
	var confi = $('#c17').val();
	var level = 0;
	if (passw != '') {
		if (passw.length - passw.replace(/[0-9]/g, "").length > 0) {
			var cond0 = true
		}
		if (passw.length - passw.replace(/\W/g, "").length > 0) {
			var cond1 = true
		}
		if (passw.length - passw.replace(/[A-Z]/g, "").length > 0) {
			var cond2 = true
		}
		if (passw.length - passw.replace(/[a-z]/g, "").length > 0) {
			var cond3 = true
		}
		switch (true) {
		case(cond0 && cond1 && cond2 && cond3) : level = level + 3;
			break;
		case ((cond0 && cond1 && cond2) || (cond0 && cond1 && cond3) || (cond0 && cond2 && cond3) || (cond1 && cond2 && cond3)) : level = level + 2;
			break;
		case ((cond0 && cond1) || (cond0 && cond2) || (cond0 && cond3) || (cond1 && cond2) || (cond1 && cond3) || (cond2 && cond3)) : level++;
			break
		}
		if (passw.toLowerCase().search(nick.toLowerCase()) == -1) {
			level++;
			if (passw.length < 6) level = 1;
			else level++
		} else {
			level = 1
		}
	}
	if ((passw == '') && (confi == '')) {
		$('#pwflag1').src = "kinezet/" + theme + "/pw_offline.png"
	} else {
		if (passw === confi) $('#pwflag1').attr('src', "kinezet/" + theme + "/pw_secure.png");
		else $('#pwflag1').attr('src', "kinezet/" + theme + "/pw_unsecure.png")
	}
	if (level >= 4) {
		$('#pwflag2').attr('src', "kinezet/" + theme + "/pw_secure.png")
	} else {
		if (level == 0) $('#pwflag2').attr('src', "kinezet/" + theme + "/pw_offline.png");
		else $('#pwflag2').attr('src', "kinezet/" + theme + "/pw_unsecure.png")
	}
	$('#pw_sec_lev').css("background-image", "url('kinezet/" + theme + "/pw_lev_" + level + ".png')")
}