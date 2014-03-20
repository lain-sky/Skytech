var buttonstates = new Array();
function gettag(tag, which) {
	switch(tag) {
		case 'size':
			x = document.getElementById('sizes');
			o = "[size="+x.options[x.selectedIndex].value+"]";
			c = "[/size]";
			break;
		case 'color':
			x = document.getElementById('colors');
			o = "[color="+x.options[x.selectedIndex].value+"]";
			c = "[/color]";
			break;
		case 'bold':
			o = "[b]";
			c = "[/b]";
			break;
		case 'italic':
			o = "[i]";
			c = "[/i]";
			break;
		case 'underline':
			o = "[u]";
			c = "[/u]";
			break;
		case 'overline':
			o = "[o]";
			c = "[/o]";
			break;
		case 'linetrough':
			o = "[x]";
			c = "[/x]";
			break;
		case 'alignleft':
			o = "[align=left]";
			c = "[/align]";
			break;
		case 'aligncenter':
			o = "[align=center]";
			c = "[/align]";
			break;
		case 'alignright':
			o = "[align=right]";
			c = "[/align]";
			break;
		case 'alignjustify':
			o = "[align=justify]";
			c = "[/align]";
			break;
		case 'quote':
			o = "[quote]";
			c = "[/quote]";
			break;
		case 'url':
			o = "[url]";
			c = "[/url]";
			break;
		case 'mail':
			o = "[email]";
			c = "[/email]";
			break;
		case 'google':
			o = "[google]";
			c = "[/google]";
			break;
		case 'picture':
			o = "[img]";
			c = "[/img]";
			break;
		case 'flash':
			o = "[swf=400x300]";
			c = "[/swf]";
			break;
		case 'media':
			o = "[wmp=400x300]";
			c = "[/wmp]";
			break;
	}
	if(which == 'o') return o;
	if(which == 'c') return c;
}

function getpic(tag) {
	pic = tag;
	switch(tag) {
		case 'quote':
			pic = "manual";
			break;
		case 'url':
			pic = "manual";
			break;
		case 'mail':
			pic = "manual";
			break;
		case 'google':
			pic = "manual";
			break;
		case 'picture':
			pic = "manual";
			break;
		case 'flash':
			pic = "manual";
			break;
		case 'media':
			pic = "manual";
			break;
	}
	return pic;
}

function addbbt(tag) {
	pic = getpic(tag);
	if(buttonstates[tag] != 1) {
		buttonstates[tag] = 1;
		o = gettag(tag, 'o');
		document.getElementById(textarea_id).value = document.getElementById(textarea_id).value+o;
		document.getElementById(tag).src="kinezet/"+theme+"/bbtoolbar_"+pic+"_active.png";
	}
	else {
		buttonstates[tag] = 0;
		c = gettag(tag, 'c');
		document.getElementById(textarea_id).value = document.getElementById(textarea_id).value+c;
		document.getElementById(tag).src="kinezet/"+theme+"/bbtoolbar_"+pic+".png";
	}
}

function addbbw(prompttext, tag) {
	o = gettag(tag, 'o');
	c = gettag(tag, 'c');
	input = prompt(prompttext, "");
	document.getElementById(textarea_id).value = document.getElementById(textarea_id).value+o+input+c;
}

function smileyselector() {
	link = 'smileyselector.php?form='+form+'&text='+text;
	newwin = window.open(link,'moresmile','height=500,width=550,resizable=no,scrollbars=yes');
	if(window.focus) newwin.focus();
}

function addbbm(tag) {
	textarea = document.getElementById(textarea_id);
	o = gettag(tag, 'o');
	c = gettag(tag, 'c');
	if(!textarea.setSelectionRange) {
		var selected = document.selection.createRange().text;
		if(selected.length <= 0)
			addbbt(tag);
		else
			document.selection.createRange().text = o+selected+c;
	}
	else {
		var pretext = textarea.value.substring(0, textarea.selectionStart);
		var codetext = o+textarea.value.substring(textarea.selectionStart, textarea.selectionEnd)+c;
		var posttext = textarea.value.substring(textarea.selectionEnd, textarea.value.length);
		if(codetext == o+c)
			addbbt(tag);
		else
			textarea.value = pretext + codetext + posttext;
	}
	textarea.focus();
}