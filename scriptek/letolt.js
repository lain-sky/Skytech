var adminOldal = "letolt_admin.php?";
var tempTar = 'a';
$('.flag_new').click(function () {
    aSzinkron(1, 'uj_torrent');
    $('.flag_new').hide()
});
$('a.torrent_files').bind('click', getFajlLista);
$('a.nfo_view').bind('click', getNfoFile);

function getFajlLista() {
    divId = "#nfodiv_" + $(this).attr("href");
    id = $(this).attr("href");
    szinkron(id, 'getfiles', divId);
    $(divId).show('slow', function () {
        $(divId).fadeTo('slow', 1, function () {})
    });
    $(this).unbind();
    $(this).bind('click', nfoDivClear);
    return false
}
function getNfoFile() {
    divId = "#nfodiv_" + $(this).attr("href");
    id = $(this).attr("href");
    szinkron(id, 'getnfo', divId);
    $(divId).show('slow', function () {
        $(divId).fadeTo('slow', 1, function () {})
    });
    $(this).unbind();
    $(this).bind('click', nfoDivClear);
    return false
}
function nfoDivClear() {
    divId = "#nfodiv_" + $(this).attr("href");
    $(divId).fadeTo('slow', 0, function () {
        $(divId).hide('slow', function () {
            $(divId).empty()
        })
    });
    $(this).unbind();
    azonosit = $(this).attr("class");
    switch (azonosit) {
    case 'torrent_files':
        $(this).bind('click', getFajlLista);
        break;
    case 'nfo_view':
        $(this).bind('click', getNfoFile);
        break
    }
    return false
}
$('.torrent_ingyen').click(function () {
    tId = $(this).attr('href');
    kepId = "#ingyen_" + tId;
    milyen = $(this).attr('alt');
    if (milyen == "yes") {
        aSzinkron(tId, 'ingyen_no');
        $(kepId).css('display', 'none');
        $(this).text('Ingyen torrent');
        $(this).attr('alt', 'no')
    } else {
        aSzinkron(tId, 'ingyen_yes');
        $(kepId).css('display', 'inline');
        $(this).text('Normal torrent');
        $(this).attr('alt', 'yes')
    }
    return false
});
$('.torrent_hidden').click(function () {
    tId = $(this).attr('href');
    kepId = "#hidden_" + tId;
    milyen = $(this).attr('alt');
    if (milyen == "yes") {
        aSzinkron(tId, 'hidden_no');
        $(kepId).css('display', 'none');
        $(this).text('Torrent elrejt');
        $(this).attr('alt', 'no')
    } else {
        aSzinkron(tId, 'hidden_yes');
        $(kepId).css('display', 'inline');
        $(this).text('Torrent megjelenít');
        $(this).attr('alt', 'yes')
    }
    return false
});

function aSzinkron(a, b) {
    $.get(adminOldal, {
        modul: b,
        tid: a
    })
}
function szinkron(b, c, d) {
    $.get(adminOldal, {
        modul: c,
        tid: b
    }, function (a) {
        $(d).html(a);
        if (c == 'addkonyv' || c == 'delkonyv') {
            ipanelGombBeallitas()
        }
    })
}
function imgToggle(a) {
    mit = '#' + a;
    if ($(mit).css("display") == 'none') {
        $(mit).css("display", 'inline')
    } else {
        $(mit).css("display", 'none')
    }
    return true
}
function divBeKiCsuk(a) {
    trId = a;
    trId = trId.replace('div', 'kicsi');
    if ($(a).css("display") == 'none') {
        $(trId).css("display", '');
        $(a).show('slow', function () {
            $(a).fadeTo('slow', 1, function () {
                cimkehezGorget(a)
            })
        })
    } else {
        $(a).fadeTo('slow', 0, function () {
            $(a).hide('slow', function () {
                cimkehezGorget(a);
                $(trId).css("display", 'none')
            })
        })
    }
}
function cimkehezGorget(a) {
    hova = a.replace('div', 'nagy');
    $(hova).ScrollTo('slow')
}
$("a.torrent_link,a.torrent_link_kep").click(function () {
    divId = "#div_" + $(this).attr("rel");
    divBeKiCsuk(divId);
    return false
});
$("a.hozzaszolas_letiltas").bind("click", hozzaszolasTilt);
$("a.hozzaszolas_enged").bind("click", hozzaszolasEnged);

function hozzaszolasTilt() {
    if (confirm('Biztos le akarod tiltani a hozzászólásokat?') == true) {
        sorId = $(this).attr("href");
        aSzinkron(sorId, "hsz_letilt");
        imgToggle('hsz_tiltva_' + sorId);
        $(this).removeClass('hozzaszolas_letiltas');
        $(this).addClass('hozzaszolas_enged');
        $(this).text('Hozzászólások engedélyezése');
        $(this).unbind("click", hozzaszolasTilt);
        $(this).bind("click", hozzaszolasEnged)
    }
    return false
}
function hozzaszolasEnged() {
    if (confirm('Biztos le engedélyezni akarod a hozzászólásokat?') == true) {
        sorId = $(this).attr("href");
        aSzinkron(sorId, "hsz_enged");
        imgToggle('hsz_tiltva_' + sorId);
        $(this).removeClass('hozzaszolas_enged');
        $(this).addClass('hozzaszolas_letiltas');
        $(this).text('Hozzászólások letiltása');
        $(this).unbind("click", hozzaszolasEnged);
        $(this).bind("click", hozzaszolasTilt)
    }
    return false
}
$('a.torrent_val').bind("click", torrentVal);

function torrentVal() {
    sorId = $(this).attr("href");
    $('#noellen_' + sorId).css({
        display: 'none'
    });
    $('#ellen_' + sorId).css({
        display: 'inline'
    });
    $(this).unbind("click", torrentVal);
    $(this).bind("click", uresKat);
    $(this).html('Hitelesitette:<span id="hitelesit_' + sorId + '"></span>');
    szinkron(sorId, "hitelesit", "#hitelesit_" + sorId);
    return false
}
function uresKat() {
    return false
}
$('a.torrent_del').click(function () {
    var a = $(this).attr("href");
    $.prompt('Biztos, hogy véglegesen törlöd a torrentet?', {
        buttons: {
            Igen: true,
            Nem: false
        },
        callback: function (v, m) {
            if (v == false) return;
            aSzinkron(a, "torrent_del");
            $('#kicsi_' + a).remove();
            $('#nagy_' + a).remove()
        }
    });
    return false
});
$('img.addkonyv').click(function () {
    tid = $(this).attr("alt");
    szinkron(tid, 'addkonyv', '#bookmarks');
    $(this).hide();
    $('#delk_' + tid).show()
});
$('img.delkonyv').click(function () {
    tid = $(this).attr("alt");
    szinkron(tid, 'delkonyv', '#bookmarks');
    $(this).hide();
    $('#addk_' + tid).show()
});
$('a.del').click(function () {
    if (confirm('Biztos törölni akarod az admin megjegyzést?') == true) {
        sorId = $(this).attr("alt");
        aSzinkron(sorId, "admin_komment_del");
        $('#admin_komment_' + sorId).fadeTo('slow', 0, function () {
            $('#admin_komment_' + sorId).hide('slow', function () {
                $('#admin_komment_' + sorId).remove()
            })
        })
    }
    return false
});
$('a.torrent_koszi').click(function () {
    id = $(this).attr("href");
    $('#thanks').fadeTo('slow', 0, function () {
        szinkron(id, 'koszi', '#thanks');
        $('#thanks').fadeTo('slow', 1)
    });
    return false
});
