var AJAXURL = 'level.php';
$('.staffLevelBovebb').click(function () {
    levelId = $(this).attr('alt');
    $.post(AJAXURL, {
        modul: 'staffLevelBovebb',
        level: levelId
    }, function (a) {
        $('#div_' + levelId).html(a)
    });
    $('#tr_' + levelId).css("display", '');
    $('#nagyDiv_' + levelId).slideDown('slow');
    return false
});
$('.staffLevelBovebbClose').bind('click', function () {
    levelId = $(this).attr('alt');
    $('#nagyDiv_' + levelId).slideUp('slow', function () {
        $('#tr_' + levelId).css("display", 'none')
    });
    return false
});

function staffLevelTorol(a) {
    $.prompt('Biztos törölni szeretnéd?', {
        buttons: {
            Igen: true,
            Nem: false
        },
        callback: function (v, m) {
            if (v == false) return;
            $.post(AJAXURL, {
                modul: 'staffLevelTorol',
                level: a
            });
            $('#staffLevelBecsuk_' + a).trigger('click');
            $('#staffLevel_' + a).fadeTo("slow", 0);
            $('#staffLevel_' + a).slideUp("slow")
        }
    });
    return false
}
function staffLevelValasz(a, b, c) {
    $('#parent').val(a);
    $('#subject').val('RE: ' + b);
    $('#box_content').val("\n\n\n" + $(c).text());
    $('#box_content').ScrollTo('slow');
    return false
}
