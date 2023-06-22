var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
/******************************************
 * My Login
 *
 * Bootstrap 4 Login Page
 *
 * @author          Muhamad Nauval Azhar
 * @uri 			https://nauval.in
 * @copyright       Copyright (c) 2018 Muhamad Nauval Azhar
 * @license         My Login is licensed under the MIT license.
 * @github          https://github.com/nauvalazhar/my-login
 * @version         1.2.0
 *
 * Help me to keep this project alive
 * https://www.buymeacoffee.com/mhdnauvalazhar
 *
 ******************************************/

("use strict");

$(function() {
    $("input").attr("autocomplete", "off");
    // author badge :)
    var author =
        '<div style="position: fixed;bottom: 0;right: 20px;background-color: #fff;box-shadow: 0 4px 8px rgba(0,0,0,.05);border-radius: 3px 3px 0 0;font-size: 12px;padding: 5px 10px;">By <a href="#">Lloyd Gene Alcantara</a> &nbsp;&bull;&nbsp;</div>';
    $("body").append(author);

    $("input[type='password'][data-eye]").each(function(i) {
        var $this = $(this),
            id = "eye-password-" + i,
            el = $("#" + id);

        $this.wrap(
            $("<div/>", {
                style: "position:relative",
                id: id
            })
        );

        $this.css({
            paddingRight: 60
        });
        $this.after(
            $("<div/>", {
                html: "Show",
                class: "btn btn-primary btn-sm showBtn",
                id: "passeye-toggle-" + i
            }).css({
                position: "absolute",
                right: 10,
                top: $this.outerHeight() / 2 - 12,
                padding: "2px 7px",
                fontSize: 12,
                cursor: "pointer"
            })
        );

        $this.after(
            $("<input/>", {
                type: "hidden",
                id: "passeye-" + i
            })
        );

        var invalid_feedback = $this
            .parent()
            .parent()
            .find(".invalid-feedback");

        if (invalid_feedback.length) {
            $this.after(invalid_feedback.clone());
        }

        $this.on("keyup paste", function() {
            $("#passeye-" + i).val($(this).val());
        });
        $("#passeye-toggle-" + i).on("click", function() {
            if ($this.hasClass("show")) {
                $this.attr("type", "password");
                $this.removeClass("show");
                $(this).removeClass("btn-outline-primary");
            } else {
                $this.attr("type", "text");
                $this.val($("#passeye-" + i).val());
                $this.addClass("show");
                $(this).addClass("btn-outline-primary");
            }
        });
    });

    $(".my-login-validation").on("submit", function() {
        var form = $(this);
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.addClass("was-validated");
    });

    // $("#btnLogin").on("click", function() {
    $(document).on("click", "#btnLogin", function() {
        var username = $("#idnum").val();
        console.log(CSRF_TOKEN);

        $.ajax({
            url: "/auth/check",
            type: "POST",
            data: {
                _token: CSRF_TOKEN,
                username: username
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    $(document).on("click", "#btnRegister", function(e) {
        e.preventDefault();

        var regForm = new FormData($("#registerForm")[0]);

        console.log(regForm);
        console.log($("#registerForm").serialize());

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            url: "checknew",
            type: "POST",
            data: regForm,
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                toastr.success(data.nice);
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
});
