var dTable;

$(function() {
    dTable = $("#forPurchaseTable")
        .DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            order: [[1, "asc"]],
            buttons: ["copy", "csv", "excel", "pdf", "print"]
        })
        .buttons()
        .container()
        .appendTo("#forPurchaseTable_wrapper .col-md-6:eq(0)");  
});