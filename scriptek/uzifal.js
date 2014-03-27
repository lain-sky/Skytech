var UZANOFALTOPICID = 14;
var FRISTUPDATE = 'yes';
$().ready(function () {
    contentUpdate()
});

function contentUpdate() {
    jQuery.ajaxQueue({
        url: "chat_admin.php",
        type: "POST",
        data: {
            modul: 'gethsz',
            id: UZANOFALTOPICID,
            extra: FRISTUPDATE
        },
        success: function (a) {
            $('#uzifal').prepend(a)
        }
    });
    FRISTUPDATE = 'no'
}
$('#chat_uzi').bind('keypress', function (e) {
    (e.keyCode) ? keyCode = e.keyCode : keyCode = e.which;
    if (keyCode == 13) {
        sendComment();
        return false
    }
    return true
});
$('#kuldes').bind('click', function () {
    sendComment();
    return false
});

function sendComment() {
    var a = $('#chat_uzi').val();
    var b = $('#colors').val();
    if (a.length < 1) return false;
    jQuery.ajaxQueue({
        url: "chat_admin.php",
        type: "POST",
        data: {
            modul: 'addhsz',
            text: a,
            id: UZANOFALTOPICID,
            szin: b
        }
    });
    $('#chat_uzi').val('')
}
$('.copy').bind('click', function () {
    newVal = $('#chat_uzi').val() + $(this).attr('title');
    $('#chat_uzi').val(newVal)
});
var uzenetFrissites = self.setInterval("contentUpdate()", UZENOFAL_REFRESH_TIME);