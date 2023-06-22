var btnUploadlike = $("#upload_page_like"),
    btnOuterlike = $(".button_outer_like");

var btnUploadshare = $("#upload_post_like"),
    btnOutershare = $(".button_outer_share");

btnUploadlike.on("change", function(e) {
    var ext = btnUploadlike
        .val()
        .split(".")
        .pop()
        .toLowerCase();
    if ($.inArray(ext, ["gif", "png", "jpg", "jpeg"]) == -1) {
        $(".error_msg_like").text("Not an Image...");
    } else {
        $(".error_msg_like").text("");
        btnOuterlike.addClass("file_uploading_like");
        setTimeout(function() {
            btnOuterlike.addClass("file_uploaded_like");
        }, 3000);
        var uploadedFilelike = URL.createObjectURL(e.target.files[0]);
        setTimeout(function() {
            $("#uploaded_view_like")
                .append('<img src="' + uploadedFilelike + '" />')
                .addClass("show");
        }, 3500);
    }
});

btnUploadshare.on("change", function(e) {
    var ext = btnUploadshare
        .val()
        .split(".")
        .pop()
        .toLowerCase();
    if ($.inArray(ext, ["gif", "png", "jpg", "jpeg"]) == -1) {
        $(".error_msg_share").text("Not an Image...");
    } else {
        $(".error_msg_share").text("");
        btnOutershare.addClass("file_uploading_share");
        setTimeout(function() {
            btnOutershare.addClass("file_uploaded_share");
        }, 3000);
        var uploadedFileshare = URL.createObjectURL(e.target.files[0]);
        setTimeout(function() {
            $("#uploaded_view_share")
                .append('<img src="' + uploadedFileshare + '" />')
                .addClass("show");
        }, 3500);
    }
});

$(".file_remove_like").on("click", function(e) {
    $("#uploaded_view_like").removeClass("show");
    $("#uploaded_view_like")
        .find("img")
        .remove();
    btnOuterlike.removeClass("file_uploading_like");
    btnOuterlike.removeClass("file_uploaded_like");
});

$(".file_remove_share").on("click", function(e) {
    $("#uploaded_view_share").removeClass("show");
    $("#uploaded_view_share")
        .find("img")
        .remove();
    btnOutershare.removeClass("file_uploading_share");
    btnOutershare.removeClass("file_uploaded_share");
});

