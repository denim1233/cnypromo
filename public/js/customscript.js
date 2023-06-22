var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
var dTable;
// var itemId;

$(function() {
    dTable = $("#itemTable")
        .DataTable({
            responsive: true,
            lengthChange: false,
            pageLength: 25,
            autoWidth: false,
            order: [[0, "desc"]],
            buttons: ["copy", "csv", "excel", "pdf", "print"]
        })
        .buttons()
        .container()
        .appendTo("#itemTable_wrapper .col-md-6:eq(0)");
});

function getSelected() {
    var selectedIds = dTable.columns().checkboxes.selected()[0];
    console.log(selectedIds);

    selectedIds.forEach(function(selectedId) {
        alert(selectedId);
    });
}

//? THIS IS USED TO SAVE/UPDATE
//?DATA TO THE DATABASE WHEN CLICKING SAVE BUTTON

$("#saveBtn").on("click", function(e) {
    e.preventDefault();
    inputValidation();

    var formdata = new FormData($("#item_Form")[0]);
    console.log(formdata.get);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        // url: "/admin/addItem",
        url: "/cnypromo_dev/public/admin/addItem",
        type: "POST",
        data: formdata,
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function(res) {
            modalClear();
            toastr.success(res.success);
            $("#itemAddModal").modal("hide");
            $("#itemTable").load(window.location + " #itemTable");
        },
        error: function(e) {
            console.log(e.status);
            if (e.status == 422) {
                toastr.error("Incomplete field inputs");
            } else {
                toastr.error("Something went wrong.");
            }
        }
    });
});

$("#updateBtn").on("click", function(e) {
    e.preventDefault();
    //GETTING THE ID
    var itemId = $("#itemId").val();
    //GETTING FORM DATA
    var editForm = new FormData($("#edit_Form")[0]);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        // url: "/admin/updateItems/" + itemId,
        url: "/cnypromo_dev/public/admin/updateItems/" + itemId,
        type: "POST",
        data: editForm,
        contentType: false,
        cache: false,
        processData: false,
        success: function(res) {
            modalEditClear();
            toastr.success(res.success);
            $("#itemTable").load(window.location + " #itemTable");
            $("#itemEditModal").modal("hide");
        },
        error: function(e) {
            console.log(e);
            toastr.error("Something went wrong.");
        }
    });
});

//ON MODAL CLOSE
$("#itemAddModal").on("hidden.bs.modal", function() {
    modalClear();
});

//FORM INPUT VALIDATION
function inputValidation() {
    if ($("#barcode").val() == "") {
        toastr.error("Barcode field is required");
        return;
    }
    if ($("#item_name").val() == "") {
        toastr.error("Item name field is required");
        return;
    }
    if ($("#description").val() == "") {
        toastr.error("Description field is required");
        return;
    }
    if ($("#stocks").val() == "") {
        toastr.error("Stocks available field is required");
        return;
    }
    if ($("#cash_price").val() == "") {
        toastr.error("Cash field is required");
        return;
    }
    if ($("#credit_price").val() == "") {
        toastr.error("Credit field is required");
        return;
    }
}

function modalClear() {
    $("#barcode").val("");
    $("#item_name").val("");
    $("#description").val("");
    $("#quantity").val("");
    $("#cash_price").val(0);
    $("#credit_price").val(0);
}
function modalEditClear() {
    $("#item_barcode").val("");
    $("#item_item_name").val("");
    $("#item_description").val("");
    $("#edit_quantity").val("");
    $("#item_cash_price").val(0);
    $("#item_credit_price").val(0);
}
//CLICKING ON EDITING PRODUCT
$(document).on("click", "#editBtn", function() {
    //GETTING ID
    $("#itemId").val(
        $(this)
            .closest("tr")
            .children("td:eq(0)")
            .first()
            .text()
    );

    //APPENDING VALUES TO THE INPUTS
    $("#edit_barcode").val(
        $(this)
            .closest("tr")
            .children("td:eq(1)")
            .first()
            .text()
    );
    $("#edit_item_name").val(
        $(this)
            .closest("tr")
            .children("td:eq(2)")
            .first()
            .text()
    );
    $("#edit_description").val(
        $(this)
            .closest("tr")
            .children("td:eq(3)")
            .first()
            .text()
    );
    $("#edit_quantity").val(
        $(this)
            .closest("tr")
            .children("td:eq(5)")
            .first()
            .text()
    );
    $("#edit_cash_price").val(
        $(this)
            .closest("tr")
            .children("td:eq(6)")
            .first()
            .text()
    );
    $("#edit_credit_price").val(
        $(this)
            .closest("tr")
            .children("td:eq(7)")
            .first()
            .text()
    );
});

$(document).on("click", "#promptDel", function() {
    var id = $(this)
        .closest("tr")
        .children("td:eq(0)")
        .first()
        .text();
    $("#itemId").val(id);
});

$(document).on("click", "#deleteBtn", function() {
    //GETTING ID
    var id = $("#itemId").val();
    // alert(id);
    // return;
    $.ajax({
        // url: "/admin/deleteItems/" + id,
        url: "/cnypromo_dev/public/admin/deleteItems/" + id,
        method: "DELETE",
        data: {
            _token: CSRF_TOKEN
        },
        success: function(res) {
            toastr.success(res.deleted);
            $("#deleteModal").modal("hide");
            $("#itemTable").load(window.location + " #itemTable");
        },
        error: function(err) {
            console.log(err);
            toastr.error("Something went wrong!");
        }
    });
});

$(document).on("click", "#csvUploadBtn", function(e) {
    e.preventDefault();

    console.log($("#importForm")[0]);

    var formdata = new FormData($("#importForm")[0]);
    console.log(formdata.get);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: "/cnypromo_dev/public/admin/uploadCSV",
        type: "POST",
        data: formdata,
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function(res) {
            toastr.success(res.success);
        },
        error: function(error) {
            console.log(error.status);
            toastr.error("Something went wrong.");
        }
    });
});

//GETTING SELECTED ROWS OF TABLE

//IMAGE PREVIEWING
function previewFile(input) {
    var file = $("input[type=file]").get(0).files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            $("#previewImg").attr("src", reader.result);
        };
        reader.readAsDataURL(file);
    }
}
