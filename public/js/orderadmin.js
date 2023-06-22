var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

$(function() {

    $(document).on("change", "#pickLocationSelect", function() {
        var location = $("#pickLocationSelect option:selected").text();
    
        $.ajax({
            url: "/cnypromo_dev/public/admin/filter-order",
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                location: location
            },
            cache: false,
            success: function(data) {
                var dtable = $("#orderadminTable").DataTable();
                dtable.clear().draw();
    
                $.each(data, function(index, value) {
                    dtable.row.add([
                        value.id,
                        value.order_no,
                        value.branch_name,
                        value.userId,
                        value.emp_name,
                        value.barcode,
                        value.name,
                        value.description,
                        value.cash_price,
                        value.loan_price,
                        value.quantity,
                        value.totalAmount,
                        value.pay_mode_desc,
                        value.updated_at
                    ]);
                });
                dtable.draw();
    
                if (dtable != null) {
                    $("#claimStubBtn").prop("disabled", false);
                }
            },
            error: function(error) {
                toastr.error("Something went wrong!");
            }
        });
    });

    

    dTable = $("#orderadminTable")
        .DataTable({
            responsive: true,
            lengthChange: false,
            pageLength: 25,
            autoWidth: false,
            order: [[0, "asc"]],
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })
        .buttons()
        .container()
        .appendTo("#orderadminTable_wrapper .col-md-6:eq(0)");

    $(document).on("click", "#showProc", function(e) {
        // var table = $("#orderadminTable").DataTable();

        $("#itemId").val(
            $(this)
                .closest("tr")
                .find("td:eq(0)")
                .text()
        );
        $("#employeeId").val(
            $(this)
                .closest("tr")
                .find("td:eq(2)")
                .text()
        );
    });

    $(document).on("click", "#showRec", function(e) {
        $("#itemId").val(
            $(this)
                .closest("tr")
                .find("td:eq(0)")
                .text()
        );
        $("#employeeId").val(
            $(this)
                .closest("tr")
                .find("td:eq(2)")
                .text()
        );
    });

    $(document).on("click", "#processBtn", function(e) {
        // var id = $("#employeeId").val();
        // var orderId = $("#itemId").val();
        var id = $("#itemId").val();


        $.ajax({
            url: "/cnypromo_dev/public/order/process/" + id,
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            cache: false,
            success: function(data) {
                if (data.error) {
                    toastr.error(data.error);
                } else if (data.msg) {
                    $("#processModal").modal("hide");
                    $("#orderadminTable").load(
                        window.location + " #orderadminTable"
                    );
                    location.reload();
                    toastr.success(data.msg);
                }
            },
            error: function() {}
        });
    });
    $(document).on("click", "#receiveBtn", function(e) {
        // var id = $("#employeeId").val();
        var id = $("#itemId").val();

        $.ajax({
            url: "/cnypromo_dev/public/order/receive/" + id,
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            cache: false,
            success: function(data) {
                if (data.error) {
                    toastr.error(data.error);
                } else if (data.msg) {
                    $("#receieveModal").modal("hide");
                    $("#orderadminTable").load(
                        window.location + " #orderadminTable"
                    );
                    toastr.success(data.msg);
                }
            },
            error: function() {}
        });
    });
});
