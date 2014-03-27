/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
jQuery.cookie = function (k, d, a) {
    if (typeof d != 'undefined') {
        a = a || {};
        if (d === null) {
            d = '';
            a.expires = -1
        }
        var g = '';
        if (a.expires && (typeof a.expires == 'number' || a.expires.toUTCString)) {
            var f;
            if (typeof a.expires == 'number') {
                f = new Date();
                f.setTime(f.getTime() + (a.expires * 24 * 60 * 60 * 1000))
            } else {
                f = a.expires
            }
            g = '; expires=' + f.toUTCString()
        }
        var b = a.path ? '; path=' + (a.path) : '';
        var e = a.domain ? '; domain=' + (a.domain) : '';
        var l = a.secure ? '; secure' : '';
        document.cookie = [k, '=', encodeURIComponent(d), g, b, e, l].join('')
    } else {
        var h = null;
        if (document.cookie && document.cookie != '') {
            var c = document.cookie.split(';');
            for (var i = 0; i < c.length; i++) {
                var j = jQuery.trim(c[i]);
                if (j.substring(0, k.length + 1) == (k + '=')) {
                    h = decodeURIComponent(j.substring(k.length + 1));
                    break
                }
            }
        }
        return h
    }
};
