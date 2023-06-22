var dTable;
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");





$(function() {



    $( "#btnGenerateCutOff" ).click(function() {

        console.log('test data' );

        let location = $("#pickLocationSelectCutOff option:selected").text();

        $.ajax({
            url: "/cnypromo_dev/public/reports/generate-cut-off",
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                location: location,
                dateFrom:  $('#rpt_dateFrom').val() ,
                dateTo:    $('#rpt_dateTo').val() ,
            },
            cache: false,
            success: function(data) {
                var dtable = $("#itemOrderTable").DataTable();
                dtable.clear().draw();

                $.each(data, function(index, value) {
                    dtable.row.add([
                        value.branch_name,
                        value.emp_id,
                        value.emp_name,
                        value.order_no,
                        value.barcode,
                        value.name + " " + value.description,
                        value.itemPrice,
                        value.quantity,
                        value.totalAmount
                    ]);
                });
                dtable.draw();


                      var total = 0;
                    var currentPage = dtable.page();
                    var tempName = '';
                    var startName= '';
                    var ctr = 1;
                    var grandTotal = 0;
                    var startTotalAmount = 0;
                    var subTotal = 0;
                        var rowAdded = 0;

                    let dtRows = dtable.data().length;



                   var data = dtable.rows().data();
                     data.each(function (value, index) {
                               startName = value[2];
                        startTotalAmount =  parseFloat(value[8]);
                
                        // console.log(this.cells[0].innerHTML);
                            

                        if(index != 0){

                            if(tempName != startName){
                            dtable.row.add(['','', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                            subTotal = 0;

                            var tempIndex;


                             tempIndex = index + rowAdded;



                            var index = tempIndex,
                                rowCount = dtable.data().length-1,
                                insertedRow = dtable.row(rowCount).data(),
                                tempRow;

                            for (var i=rowCount;i>index;i--) {
                                tempRow = dtable.row(i-1).data();
                                dtable.row(i).data(tempRow);
                                dtable.row(i-1).data(insertedRow);
                            }     

                            dtable.row(index).data(insertedRow);
                            dtable.page(currentPage).draw(false);

                                rowAdded = rowAdded + 1;  

                            }
                        


                        }
                          tempName = startName;

                        grandTotal = parseFloat(grandTotal) + parseFloat(startTotalAmount);
                        subTotal = parseFloat(subTotal) + parseFloat(startTotalAmount);

                          if(ctr === dtRows){
                            dtable.row.add(['','', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                            dtable.row.add(['','', '', '', '', '', '','<b>Grand Total</b>','<b>'+grandTotal+'</b>']).draw();

                          }

                          ctr++;

                     });

                if (dtable != null) {
                    $("#claimStubBtn").prop("disabled", false);
                }
            },
            error: function(error) {
                toastr.error("Something went wrong!");
            }
        });

    });


    if (window.location.href.indexOf("itemorder") > -1) {
    var checkExist = setInterval(function() {
   if ($('#pickLocationSelect').length) {
       $("#pickLocationSelect").change();
          clearInterval(checkExist);
   }
}, 500); 
    }

    if (window.location.href.indexOf("employee-cart") > -1) {

var checkExist2 = setInterval(function() {
    if ($('#pickLocationSelectEmployeeCart').length) {
        $("#pickLocationSelectEmployeeCart").change();
           clearInterval(checkExist2);
    }
 }, 500); 
    }

    dTable = $("#itemOrderTable")
        .DataTable({
            responsive: true,
            "ordering": false,
            lengthChange: false,
            pageLength: 25,
            autoWidth: false,
            // order: [[1, "asc"]],
            buttons: ["copy", "csv", "excel", "pdf", "print"],
        })
        .buttons()
        .container()
        .appendTo("#itemOrderTable_wrapper .col-md-6:eq(0)");

    $(document).on("change", "#pickLocationSelect", function() {
        var location = $("#pickLocationSelect option:selected").text();

        $.ajax({
            url: "/cnypromo_dev/public/reports/selectlocation",
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                location: location
            },
            cache: false,
            success: function(data) {
                var dtable = $("#itemOrderTable").DataTable();
                dtable.clear().draw();

                $.each(data, function(index, value) {
                    dtable.row.add([
                        value.branch_name,
                        value.emp_id,
                        value.emp_name,
                        value.order_no,
                        value.barcode,
                        value.name + " " + value.description,
                        value.itemPrice,
                        value.quantity,
                        value.totalAmount
                    ]);
                });
                dtable.draw();


                      var total = 0;
                    var currentPage = dtable.page();
                    var tempName = '';
                    var startName= '';
                    var ctr = 1;
                    var grandTotal = 0;
                    var startTotalAmount = 0;
                    var subTotal = 0;
                        var rowAdded = 0;

                    let dtRows = dtable.data().length;



                   var data = dtable.rows().data();
                     data.each(function (value, index) {
                               startName = value[2];
                        startTotalAmount =  parseFloat(value[8]);
                
                        // console.log(this.cells[0].innerHTML);
                            

                        if(index != 0){

                            if(tempName != startName){
                            dtable.row.add(['','', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                            subTotal = 0;

                            var tempIndex;


                             tempIndex = index + rowAdded;



                            var index = tempIndex,
                                rowCount = dtable.data().length-1,
                                insertedRow = dtable.row(rowCount).data(),
                                tempRow;

                            for (var i=rowCount;i>index;i--) {
                                tempRow = dtable.row(i-1).data();
                                dtable.row(i).data(tempRow);
                                dtable.row(i-1).data(insertedRow);
                            }     

                            dtable.row(index).data(insertedRow);
                            dtable.page(currentPage).draw(false);

                                rowAdded = rowAdded + 1;  

                            }
                        


                        }
                          tempName = startName;

                        grandTotal = parseFloat(grandTotal) + parseFloat(startTotalAmount);
                        subTotal = parseFloat(subTotal) + parseFloat(startTotalAmount);

                          if(ctr === dtRows){
                            dtable.row.add(['','', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                            dtable.row.add(['','', '', '', '', '', '','<b>Grand Total</b>','<b>'+grandTotal+'</b>']).draw();

                          }

                          ctr++;

                     });

                if (dtable != null) {
                    $("#claimStubBtn").prop("disabled", false);
                }
            },
            error: function(error) {
                toastr.error("Something went wrong!");
            }
        });
    });

    $(document).on("click", "#claimStubBtn", function(e) {
        var picklocation = $("#pickLocationSelect option:selected").text();

        // window.navigate("/cnypromo_dev/public/reports/itemorder");
        window.location.href =
            "/cnypromo_dev/public/reports/printstub/" + picklocation;

        // $.ajax({
        //     url: "/cnypromo_dev/public/reports/printclaimstub",
        //     method: "POST",
        //     data: {
        //         _token: CSRF_TOKEN,
        //         picklocation: picklocation
        //     },
        //     cache: false,
        //     success: function(res) {},
        //     error: function() {
        //         toastr.error("Something went wrong!");
        //     }
        // });
    });

    $(document).on("click", "#checkoutStubBtn", function(e) {
        var picklocation = $("#pickLocationSelect option:selected").text();

        window.location.href =
            "/cnypromo_dev/public/reports/printcheckout/" + picklocation;

        // $.ajax({
        //     url: "/cnypromo_dev/public/reports/printcheckout/" + picklocation,
        //     method: "GET",
        //     data: {
        //         _token: CSRF_TOKEN,
        //         picklocation: picklocation
        //     },
        //     cache: false,
        //     error: function() {
        //         toastr.error("Something went wrong!");
        //     }
        // });
    });


    $(document).on("change", "#pickLocationSelectEmployeeCart", function() {
        var location = $("#pickLocationSelectEmployeeCart option:selected").text();

        $.ajax({
            url: "/cnypromo_dev/public/reports/selectlocationEmloyeeCart",
            method: "POST",
            data: {
                _token: CSRF_TOKEN,
                location: location
            },
            cache: false,
            success: function(data) {
                var dtable = $("#itemOrderTable").DataTable();
                dtable.clear().draw();

                // if (table.rows().count() === 0) {
                //     $("#claimStubBtn").css("display", "none");
                // } else {
                //     $("#claimStubBtn").css("display", "block");
                // }

                $.each(data, function(index, value) {
                    dtable.row.add([
                        value.emp_id,
                        value.emp_name,
                        value.order_no,
                        value.barcode,
                        value.name + " " + value.description,
                        value.itemPrice,
                        value.quantity,
                        value.totalAmount
                    ]);
                });
                dtable.draw();


                // dtable.row.add();

//                 var data = {
//   emp_name: dataSecondary.Stats1
//   test: dataSecondary.Stats2 
//   columnName3: dataSecondary.Stats3
// }


                // rowTest = [
                //         'test',
                //         'test',
                //         'test',
                //         'test',d
                //         0.00,
                //         0,
                //         0.00
                //     ];

                // dtable.Rows.InsertAt(rowTest, 3);

               

                //     insertedRow = dtable.row(10).data();
                    // tempRow = dtable.row(2).data();
                    // dTable.row(3).data(tempRow);
                  //   dtable.row(3).data();


                      var total = 0;
                    var currentPage = dtable.page();
                    var tempName = '';
                    var startName= '';
                    var ctr = 1;
                    var grandTotal = 0;
                    var startTotalAmount = 0;
                    var subTotal = 0;
                        var rowAdded = 0;

                    let dtRows = dtable.data().length;



                   var data = dtable.rows().data();
                     data.each(function (value, index) {
                               startName = value[1];
                        startTotalAmount =  parseFloat(value[7]);
                
                        // console.log(this.cells[0].innerHTML);
                            

                        if(index != 0){

                            if(tempName != startName){
                            dtable.row.add(['', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                            subTotal = 0;

                            var tempIndex;


                             tempIndex = index + rowAdded;



                            var index = tempIndex,
                                rowCount = dtable.data().length-1,
                                insertedRow = dtable.row(rowCount).data(),
                                tempRow;

                            for (var i=rowCount;i>index;i--) {
                                tempRow = dtable.row(i-1).data();
                                dtable.row(i).data(tempRow);
                                dtable.row(i-1).data(insertedRow);
                            }     

                            dtable.row(index).data(insertedRow);
                            dtable.page(currentPage).draw(false);

                                rowAdded = rowAdded + 1;  

                            }
                        


                        }


                      
                          tempName = startName;

                            // console.log(ctr);
                        grandTotal = parseFloat(grandTotal) + parseFloat(startTotalAmount);
                        subTotal = parseFloat(subTotal) + parseFloat(startTotalAmount);

                            // console.log(dtable.data().length);
                            // console.log(ctr);
                            // console.log(dtRows);

                          if(ctr === dtRows){
                            // console.log(startTotalAmount);
                            dtable.row.add(['', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                            dtable.row.add(['', '', '', '', '', '','<b>Grand Total</b>','<b>'+grandTotal+'</b>']).draw();

                          }

                          ctr++;





                     });









                  // var total = 0;
                  //   var currentPage = dtable.page();
                  //   var tempName = '';
                  //   var startName= '';
                  //   var ctr = 1;
                  //   var grandTotal = 0;
                  //   var startTotalAmount = 0;
                  //   var subTotal = 0;

                  //   let dtRows = dtable.data().length;




                  //   $("#itemOrderTable tbody tr").each(function(index) {

                  //       startName = this.cells[1].innerHTML;
                  //       startTotalAmount =  parseFloat(this.cells[7].innerHTML)
                
                  //       // console.log(this.cells[0].innerHTML);

                  //       console.log(startTotalAmount);
                  //       console.log(this.cells[0].innerHTML);


                  //       if(index != 0){
                            
                  //           if(tempName != startName){

                  //           dtable.row.add(['', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                  //           subTotal = 0;

                  //           var index = index,
                  //               rowCount = dtable.data().length-1,
                  //               insertedRow = dtable.row(rowCount).data(),
                  //               tempRow;

                  //           for (var i=rowCount;i>index;i--) {
                  //               tempRow = dtable.row(i-1).data();
                  //               dtable.row(i).data(tempRow);
                  //               dtable.row(i-1).data(insertedRow);
                  //           }     

                  //           dtable.row(index).data(insertedRow);
                  //           dtable.page(currentPage).draw(false);


                  //           }
                        

                                

                  //       }


                      
                  //         tempName = startName;

                  //           // console.log(ctr);
                  //       grandTotal = parseFloat(grandTotal) + parseFloat(startTotalAmount);
                  //       subTotal = parseFloat(subTotal) + parseFloat(startTotalAmount);

                  //           // console.log(dtable.data().length);
                  //           // console.log(ctr);
                  //           // console.log(dtRows);

                  //         if(ctr === dtRows){
                  //           // console.log(startTotalAmount);
                  //           dtable.row.add(['', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                  //           dtable.row.add(['', '', '', '', '', '','<b>Grand Total</b>','<b>'+grandTotal+'</b>']).draw();

                  //         }

                  //         ctr++;

                  //   });


          


                if (dtable != null) {
                    $("#claimStubBtn").prop("disabled", false);
                }
            },
            error: function(error) {
                toastr.error("Something went wrong!");
            }
        });
    });
});
