var bongeszoHibaText = 'Az oldal megtekintéséhez Firefox böngészõ ajánlott.<br />';
var popupHibaText = 'Az oldal helyes mûködéséhez engedélyezni kell a felugró ablakokat!<br />';
var bongeszoHiba = true;
var popupHiba = true;
var hibaText = '';
jQuery.each(jQuery.browser, function (i, val) {
    if (i == 'mozilla' && val == true) {
        bongeszoHiba = false
    }
});
if (bongeszoHiba) {
    hibaText += bongeszoHibaText
}
try {
    ablak = window.open('about:blank', 'tesztablak', 'width=0,height=0');
    if (ablak) {
        ablak.close();
        popupHiba = false
    }
} catch (err) {}
if (popupHiba) {
    hibaText += popupHibaText
}
var tt = "<div id=''><div  class='dialog' style='width: 450px;'><div class='dialog_header'><span class='dialog_title red'>Figyelmeztetés</span></div><div class='dialog_content'>" + hibaText + "</div></div><br /></div>";
if (hibaText != '') {
    regi = $('#content').html();
    uj = tt + regi;
    $('#content').html(uj)
}
