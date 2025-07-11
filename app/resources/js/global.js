/**
 * Replaces dangerous characters in provided string with HTML entities.
 * @param str input string.
 * @return string with replaced values.
 */
var replaceTags = function(str) {
    if ($.isNumeric(str)) {
        return str;
    }

    var val = str
        .replace(/[<]+/g, "&lt;")
        .replace(/[>]+/g, "&gt;")
        .replace(/[']+/g, "&#039;");

    return val;
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

// Enables Bootstrap's tooltips.
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
});

// Updates fileselector text input.
$(document).on('change', '.btn-file :file', function() {
    var input = $(this);
    var numFiles = input.get(0).files ? input.get(0).files.length : 1;
    var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

    $('.fileselect').val(label);
});

// Collection maintenance confirmation logic.
$(document).ready(function(e) {
    $(".maintenanceModalInvoker").click(function(e) {
        $("#maintenanceMessage").html($(this).data("message"));

        $("#taskType").attr("value", $(this).data("task"));
    });
});

// Remove confirmation logic - full dialog.
$(document).ready(function(e) {
    $(".removeModalInvoker").click(function(e) {
        $("#removePrefix").html($(this).data("prefix"));

        var val = replaceTags($(this).data("value"));

        $("#removeValue").html(val);
        $("#removeDetail").html($(this).data("detail"));
        $("#removeConfirmString").attr("placeholder", $(this).data("value"));

        $("#removeOperation").attr("value", $(this).data("operation"));
        $("#removeActionId").attr("value", $(this).data("id"));
    });
});

// Remove confirmation logic - simple dialog.
$(document).ready(function(e) {
    $(".removeModalSimpleInvoker").click(function(e) {
        $("#removeSimplePrefix").html($(this).data("prefix"));

        var val = replaceTags($(this).data("value"));

        $("#removeSimpleValue").html(val);
        $("#removeSimpleDetail").html($(this).data("detail"));

        $("#removeSimpleOperation").attr("value", $(this).data("operation"));
        $("#removeSimpleActionId").attr("value", $(this).data("id"));

        // Removes the additional line break if no detail message is provided.
        if ($(this).data("detail") == "") {
            $("#removeSimpleDetailBreak").remove();
        }
    });
});

// Translation unlink confirmation logic.
$(document).ready(function(e) {
    $(".unlinkInvoker").click(function(e) {
        var val = replaceTags($(this).data("value"));

        $("#unlinkValue").html(val);
        $("#unlinkDetail").html($(this).data("detail"));

        $("#unlinkOperation").attr("value", $(this).data("operation"));
        $("#unlinkActionId").attr("value", $(this).data("id"));
    });
});

// Language coloring modal value filler.
$(document).ready(function(e) {
    $(".languageColorModalInvoker").click(function(e) {
        $("#modifyColor").attr("value", $(this).data("value"));

        $("#colorActionId").attr("value", $(this).data("id"));
    });
});

// Language renaming modal value filler.
$(document).ready(function(e) {
    $(".languageRenameModalInvoker").click(function(e) {
        $("#modifyName").attr("value", $(this).data("value"));

        $("#modifyActionId").attr("value", $(this).data("id"));
    });
});
