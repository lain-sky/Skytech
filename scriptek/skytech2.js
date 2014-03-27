$('span.tooltip').ToolTip({
    className: 'admintooltip',
    position: 'mouse',
    delay: 200
});
$().ready(function () {
    try {
        var container = $('#hiba_div');
        $("#oldalsettings").validate({
            errorContainer: container,
            errorLabelContainer: $("ol", container),
            wrapper: 'li',
            meta: "validate",
            event: "keyup",
            rules: {
                oldal_cime: {
                    url: true
                },
                oldal_vakmail: {
                    email: true
                },
                staff_email: {
                    email: true
                },
                oldal_mail_user_id: {
                    number: true
                },
                max_user: {
                    number: true
                },
                meghivo_ido_limit: {
                    number: true
                },
                meghivo_upload_limit: {
                    number: true
                },
                min_adat_ratio: {
                    number: true
                },
            }
        })
    } catch (err) {}
});

function myform(formId) {
    $(".error").hide();
    mehet = true;
    $('.myform').each(function (i) {
        val = this.value;
        if (val != '') {
            switch (this.alt) {
            case 'num':
                if (isFinite(val) != true) {
                    this.focus();
                    form_hibakezel('num');
                    mehet = false
                }
                break
            }
        }
        if (mehet == false) return mehet
    });
    return mehet
}
function form_hibakezel(tipus) {
    $('#error_' + tipus).show();
    return false
}
$('#trackersettings').submit(function () {
    return myform('trackersettings')
});
