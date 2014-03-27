$('#keres_btn').click(function () {
    text = $('#keres_text').val();
    if (text.length < 3) {
        alert('A legrövidebb keresendõ szó hossza 3 karakter!');
        return true
    }
    cim = url_szuro();
    if (cim.indexOf('=') != -1) {
        cim += "&"
    }
    cim += "keres=" + text;
    window.location = cim
});
$('#keres_reset').click(function () {
    cim = url_szuro();
    window.location = cim
});

function url_szuro() {
    cim = location.pathname + '?';
    search = location.search;
    elso = true;
    search = search.replace('?', '');
    tomb = search.split("&");
    for (i = 0; i < tomb.length; i++) {
        if (tomb[i].indexOf('keres=') == -1) {
            cim += (elso) ? tomb[i] : '&' + tomb[i];
            elso = false
        }
    }
    return cim
}
$('a.idezet_link').click(function () {
    hId = $(this).attr('alt');
    $.post('forum_hsz.php', {
        idezet: hId
    }, function (text) {
        kesz = "[quote]\n";
        kesz += text;
        kesz += "\n[/quote]\n";
        $('#box_content').val(kesz)
    });
    $('#box_content').ScrollTo('slow');
    return false
});
