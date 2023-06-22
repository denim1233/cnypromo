var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

$(function() {
    dTable = $("#validateTable")
        .DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            order: [[0, "asc"]],
            buttons: ["copy", "csv", "excel", "pdf", "print"]
        })
        .buttons()
        .container()
        .appendTo("#validateTable_wrapper .col-md-6:eq(0)");

    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch("state", $(this).prop("checked"));
    });

    //FOR VIEWING IMAGES
    $(document).on("click", "#viewValidateBtn", function() {
        $("#employee_ID").val(
            $(this)
                .closest("tr")
                .find("td:eq(1)")
                .text()
        );
        $("#validationModal").modal("show");
    });

    //FOR DELETING VALIDATION
    $(document).on("click", "#removeValidated", function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-warning",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons
            .fire({
                title: "Are you sure?",
                text: "Once your cart is confirmed, you can't unchange it.",
                position: "center",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, it's final!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            })
            .then(result => {
                if (result.isConfirmed) {
                    var id = $("#userId").val();

                    $.ajax({
                        url: "/cnypromo_dev/public/cart/confirm",
                        method: "POST",
                        data: {
                            _token: CSRF_TOKEN,
                            employeeId: id
                        },
                        success: function(data) {
                            if (data.error) {
                                swalWithBootstrapButtons.fire(
                                    "Confirmation error!",
                                    data.error,
                                    "error"
                                );
                                return;
                            }
                            swalWithBootstrapButtons.fire(
                                "Confirmed!",
                                data.msg,
                                "success"
                            );
                            $("#showCartTable").modal("hide");
                            $("#showCartTable").load(
                                window.location + " #showCartTable"
                            );
                        },
                        error: function(data) {
                            console.log(data);
                            swalWithBootstrapButtons.fire(
                                "Error",
                                "Something went wrong :(",
                                "error"
                            );
                        }
                    });

                    $("td:nth-child(8),th:nth-child(8)").hide();
                    // $("#showCartModal").modal("hide");
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        "Cancelled",
                        "Action cancelled :)",
                        "error"
                    );
                }
            });
    });

    //VIEWING IMAGES
    $("#validateTable").on("click", ".image", function() {
        // $(".image").on("click", function() {
        $(".imagepreview").attr(
            "src",
            $(this)
                .find("img")
                .attr("src")
        );
        $("#imagemodal").modal("show");
    });

    //VALIDATION
    $(document).on("click", "#valBtn", function(e) {
        var idnum = $("#employee_ID").val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            url: "/cnypromo_dev/public/user/validate",
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                userId: idnum
            },
            cache: false,
            success: function(res) {
                $("#validateTable").load(window.location + " #validateTable");
                toastr.success(res.msg);
                $("#validationModal").modal("hide");
            },
            error: function(e) {
                console.log(e);
                toastr.error("Something went wrong.");
            }
        });
    });
});
