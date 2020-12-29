"use strict";
jQuery(document).ready(function() {

    $(".summernote").summernote({
        height:150,
        minHeight: null,
        maxHeight: null,
        focus: !1,
        codeviewFilter: true,
        codeviewIframeFilter: true
    });
    $(".inline-editor").summernote({
        airMode: !0
    })
}), window.edit = function() {
    $(".click2edit").summernote()
}, window.save = function() {
    $(".click2edit").summernote("destroy")
};
