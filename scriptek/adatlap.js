$('a.idezet_link').click(function () {
    hId = $(this).attr('alt');
    $.post('adatlap.php', {
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
