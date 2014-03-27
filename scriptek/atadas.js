var fadeInSuggestion = function (suggestionBox, suggestionIframe) {
        $(suggestionBox).fadeTo(300, 0.9)
    };
var fadeOutSuggestion = function (suggestionBox, suggestionIframe) {
        $(suggestionBox).fadeTo(300, 0)
    };
$('#fogado_user').Autocomplete({
    source: 'userlista.php',
    delay: 500,
    fx: {
        type: 'slide',
        duration: 400
    },
    autofill: true,
    helperClass: 'autocompleter',
    selectClass: 'selectAutocompleter',
    minchars: 2,
    onShow: fadeInSuggestion,
    onHide: fadeOutSuggestion
});
