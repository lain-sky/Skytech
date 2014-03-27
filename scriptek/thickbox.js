/*
 * Thickbox 3 - One Box To Rule Them All.
 * By Cody Lindley (http://www.codylindley.com)
 * Copyright (c) 2007 cody lindley
 * Licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php
*/

var tb_pathToImage = "kinezet/"+SMINK+"/loading.gif";

$(document).ready(function () {
    tb_init('a.thickbox, area.thickbox, input.thickbox');
    imgLoader = new Image();
    imgLoader.src = tb_pathToImage
});

function tb_init(b) {
    $(b).click(function () {
        var t = this.title || this.name || null;
        var a = this.href || this.alt;
        var g = this.rel || false;
        tb_show(t, a, g);
        this.blur();
        return false
    })
}
function tb_show(d, f, g) {
    try {
        if (typeof document.body.style.maxHeight === "undefined") {
            $("body", "html").css({
                height: "100%",
                width: "100%"
            });
            $("html").css("overflow", "hidden");
            if (document.getElementById("TB_HideSelect") === null) {
                $("body").append("<iframe id='TB_HideSelect'></iframe><div id='TB_overlay'></div><div id='TB_window'></div>");
                $("#TB_overlay").click(tb_remove)
            }
        } else {
            if (document.getElementById("TB_overlay") === null) {
                $("body").append("<div id='TB_overlay'></div><div id='TB_window'></div>");
                $("#TB_overlay").click(tb_remove)
            }
        }
        if (tb_detectMacXFF()) {
            $("#TB_overlay").addClass("TB_overlayMacFFBGHack")
        } else {
            $("#TB_overlay").addClass("TB_overlayBG")
        }
        if (d === null) {
            d = ""
        }
        $("body").append("<div id='TB_load'><img src='" + imgLoader.src + "' /></div>");
        $('#TB_load').show();
        var h;
        if (f.indexOf("?") !== -1) {
            h = f.substr(0, f.indexOf("?"))
        } else {
            h = f
        }
        var i = /\.jpg$|\.jpeg$|\.png$|\.gif$|\.bmp$/;
        var j = h.toLowerCase().match(i);
        if (j == '.jpg' || j == '.jpeg' || j == '.png' || j == '.gif' || j == '.bmp') {
            TB_PrevCaption = "";
            TB_PrevURL = "";
            TB_PrevHTML = "";
            TB_NextCaption = "";
            TB_NextURL = "";
            TB_NextHTML = "";
            TB_imageCount = "";
            TB_FoundURL = false;
            if (g) {
                TB_TempArray = $("a[@rel=" + g + "]").get();
                for (TB_Counter = 0;
                ((TB_Counter < TB_TempArray.length) && (TB_NextHTML === "")); TB_Counter++) {
                    var k = TB_TempArray[TB_Counter].href.toLowerCase().match(i);
                    if (!(TB_TempArray[TB_Counter].href == f)) {
                        if (TB_FoundURL) {
                            TB_NextCaption = TB_TempArray[TB_Counter].title;
                            TB_NextURL = TB_TempArray[TB_Counter].href;
                            TB_NextHTML = "<span id='TB_next'>&nbsp;&nbsp;<a href='#'>Next &gt;</a></span>"
                        } else {
                            TB_PrevCaption = TB_TempArray[TB_Counter].title;
                            TB_PrevURL = TB_TempArray[TB_Counter].href;
                            TB_PrevHTML = "<span id='TB_prev'>&nbsp;&nbsp;<a href='#'>&lt; Prev</a></span>"
                        }
                    } else {
                        TB_FoundURL = true;
                        TB_imageCount = "Image " + (TB_Counter + 1) + " of " + (TB_TempArray.length)
                    }
                }
            }
            imgPreloader = new Image();
            imgPreloader.onload = function () {
                imgPreloader.onload = null;
                var a = tb_getPageSize();
                var x = a[0] - 150;
                var y = a[1] - 150;
                var b = imgPreloader.width;
                var c = imgPreloader.height;
                if (b > x) {
                    c = c * (x / b);
                    b = x;
                    if (c > y) {
                        b = b * (y / c);
                        c = y
                    }
                } else if (c > y) {
                    b = b * (y / c);
                    c = y;
                    if (b > x) {
                        c = c * (x / b);
                        b = x
                    }
                }
                TB_WIDTH = b + 30;
                TB_HEIGHT = c + 60;
                $("#TB_window").append("<a href='' id='TB_ImageOff' title='Close'><img id='TB_Image' src='" + f + "' width='" + b + "' height='" + c + "' alt='" + d + "'/></a>" + "<div id='TB_caption'>" + d + "<div id='TB_secondLine'>" + TB_imageCount + TB_PrevHTML + TB_NextHTML + "</div></div><div id='TB_closeWindow'><a href='#' id='TB_closeWindowButton' title='Close'>close</a> or Esc Key</div>");
                $("#TB_closeWindowButton").click(tb_remove);
                if (!(TB_PrevHTML === "")) {
                    function goPrev() {
                        if ($(document).unbind("click", goPrev)) {
                            $(document).unbind("click", goPrev)
                        }
                        $("#TB_window").remove();
                        $("body").append("<div id='TB_window'></div>");
                        tb_show(TB_PrevCaption, TB_PrevURL, g);
                        return false
                    }
                    $("#TB_prev").click(goPrev)
                }
                if (!(TB_NextHTML === "")) {
                    function goNext() {
                        $("#TB_window").remove();
                        $("body").append("<div id='TB_window'></div>");
                        tb_show(TB_NextCaption, TB_NextURL, g);
                        return false
                    }
                    $("#TB_next").click(goNext)
                }
                document.onkeydown = function (e) {
                    if (e == null) {
                        keycode = event.keyCode
                    } else {
                        keycode = e.which
                    }
                    if (keycode == 27) {
                        tb_remove()
                    } else if (keycode == 190) {
                        if (!(TB_NextHTML == "")) {
                            document.onkeydown = "";
                            goNext()
                        }
                    } else if (keycode == 188) {
                        if (!(TB_PrevHTML == "")) {
                            document.onkeydown = "";
                            goPrev()
                        }
                    }
                };
                tb_position();
                $("#TB_load").remove();
                $("#TB_ImageOff").click(tb_remove);
                $("#TB_window").css({
                    display: "block"
                })
            };
            imgPreloader.src = f
        } else {
            var l = f.replace(/^[^\?]+\??/, '');
            var m = tb_parseQuery(l);
            TB_WIDTH = (m['width'] * 1) + 30 || 630;
            TB_HEIGHT = (m['height'] * 1) + 40 || 440;
            ajaxContentW = TB_WIDTH - 30;
            ajaxContentH = TB_HEIGHT - 45;
            if (f.indexOf('TB_iframe') != -1) {
                urlNoQuery = f.split('TB_');
                $("#TB_iframeContent").remove();
                if (m['modal'] != "true") {
                    $("#TB_window").append("<div id='TB_title'><div id='TB_ajaxWindowTitle'>" + d + "</div><div id='TB_closeAjaxWindow'><a href='#' id='TB_closeWindowButton' title='Close'>close</a> or Esc Key</div></div><iframe frameborder='0' hspace='0' src='" + urlNoQuery[0] + "' id='TB_iframeContent' name='TB_iframeContent" + Math.round(Math.random() * 1000) + "' onload='tb_showIframe()' style='width:" + (ajaxContentW + 29) + "px;height:" + (ajaxContentH + 17) + "px;' > </iframe>")
                } else {
                    $("#TB_overlay").unbind();
                    $("#TB_window").append("<iframe frameborder='0' hspace='0' src='" + urlNoQuery[0] + "' id='TB_iframeContent' name='TB_iframeContent" + Math.round(Math.random() * 1000) + "' onload='tb_showIframe()' style='width:" + (ajaxContentW + 29) + "px;height:" + (ajaxContentH + 17) + "px;'> </iframe>")
                }
            } else {
                if ($("#TB_window").css("display") != "block") {
                    if (m['modal'] != "true") {
                        $("#TB_window").append("<div id='TB_title'><div id='TB_ajaxWindowTitle'>" + d + "</div><div id='TB_closeAjaxWindow'><a href='#' id='TB_closeWindowButton'>close</a> or Esc Key</div></div><div id='TB_ajaxContent' style='width:" + ajaxContentW + "px;height:" + ajaxContentH + "px'></div>")
                    } else {
                        $("#TB_overlay").unbind();
                        $("#TB_window").append("<div id='TB_ajaxContent' class='TB_modal' style='width:" + ajaxContentW + "px;height:" + ajaxContentH + "px;'></div>")
                    }
                } else {
                    $("#TB_ajaxContent")[0].style.width = ajaxContentW + "px";
                    $("#TB_ajaxContent")[0].style.height = ajaxContentH + "px";
                    $("#TB_ajaxContent")[0].scrollTop = 0;
                    $("#TB_ajaxWindowTitle").html(d)
                }
            }
            $("#TB_closeWindowButton").click(tb_remove);
            if (f.indexOf('TB_inline') != -1) {
                $("#TB_ajaxContent").append($('#' + m['inlineId']).children());
                $("#TB_window").unload(function () {
                    $('#' + m['inlineId']).append($("#TB_ajaxContent").children())
                });
                tb_position();
                $("#TB_load").remove();
                $("#TB_window").css({
                    display: "block"
                })
            } else if (f.indexOf('TB_iframe') != -1) {
                tb_position();
                if ($.browser.safari) {
                    $("#TB_load").remove();
                    $("#TB_window").css({
                        display: "block"
                    })
                }
            } else {
                $("#TB_ajaxContent").load(f += "&random=" + (new Date().getTime()), function () {
                    tb_position();
                    $("#TB_load").remove();
                    tb_init("#TB_ajaxContent a.thickbox");
                    $("#TB_window").css({
                        display: "block"
                    })
                })
            }
        }
        if (!m['modal']) {
            document.onkeyup = function (e) {
                if (e == null) {
                    keycode = event.keyCode
                } else {
                    keycode = e.which
                }
                if (keycode == 27) {
                    tb_remove()
                }
            }
        }
    } catch (e) {}
}
function tb_showIframe() {
    $("#TB_load").remove();
    $("#TB_window").css({
        display: "block"
    })
}
function tb_remove() {
    $("#TB_imageOff").unbind("click");
    $("#TB_closeWindowButton").unbind("click");
    $("#TB_window").fadeOut("fast", function () {
        $('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove()
    });
    $("#TB_load").remove();
    if (typeof document.body.style.maxHeight == "undefined") {
        $("body", "html").css({
            height: "auto",
            width: "auto"
        });
        $("html").css("overflow", "")
    }
    document.onkeydown = "";
    document.onkeyup = "";
    return false
}
function tb_position() {
    $("#TB_window").css({
        marginLeft: '-' + parseInt((TB_WIDTH / 2), 10) + 'px',
        width: TB_WIDTH + 'px'
    });
    if (!(jQuery.browser.msie && jQuery.browser.version < 7)) {
        $("#TB_window").css({
            marginTop: '-' + parseInt((TB_HEIGHT / 2), 10) + 'px'
        })
    }
}
function tb_parseQuery(a) {
    var b = {};
    if (!a) {
        return b
    }
    var c = a.split(/[;&]/);
    for (var i = 0; i < c.length; i++) {
        var d = c[i].split('=');
        if (!d || d.length != 2) {
            continue
        }
        var e = unescape(d[0]);
        var f = unescape(d[1]);
        f = f.replace(/\+/g, ' ');
        b[e] = f
    }
    return b
}
function tb_getPageSize() {
    var a = document.documentElement;
    var w = window.innerWidth || self.innerWidth || (a && a.clientWidth) || document.body.clientWidth;
    var h = window.innerHeight || self.innerHeight || (a && a.clientHeight) || document.body.clientHeight;
    arrayPageSize = [w, h];
    return arrayPageSize
}
function tb_detectMacXFF() {
    var a = navigator.userAgent.toLowerCase();
    if (a.indexOf('mac') != -1 && a.indexOf('firefox') != -1) {
        return true
    }
}