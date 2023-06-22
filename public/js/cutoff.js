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
                        value.totalAmount,
                        value.updated_at
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
                            dtable.row.add(['','', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>','']).draw();
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
                            dtable.row.add(['','', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>','']).draw();
                            dtable.row.add(['','', '', '', '', '', '','<b>Grand Total</b>','<b>'+grandTotal+'</b>','']).draw();

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


    function customized_excel ( xlsx ) {

        var dateFrom = $('#rpt_dateFrom').val();
        var dateTo = $('#rpt_dateTo').val();
        var location = $('#pickLocationSelectCutOff').val();

    
        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        var numrows = 5;
        var clR = $('row', sheet);
        var ctr = 1;
                    //update Row
                    clR.each(function () {
                        var attr = $(this).attr('r');
                        var ind = parseInt(attr);
                        ind = ind + numrows;
                        $(this).attr("r", ind);
                    });
    
                    // Create row before data
                    $('row c ', sheet).each(function () {
                        var attr = $(this).attr('r');
                        var pre = attr.substring(0, 1);
                        var ind = parseInt(attr.substring(1, attr.length));
                        ind = ind + numrows;
                        $(this).attr("r", pre + ind);
                    });
    
                    function Addrow(index, data) {
                        var msg = '<row r="' + index + '">'
                        for (var i = 0; i < data.length; i++) {
                            var key = data[i].key;
                            var value = data[i].value;
                            msg += '<c t="inlineStr" r="' + key + index + '">';
                            msg += '<is>';
                            msg += '<t>' + value + '</t>';
                            msg += '</is>';
                            msg += '</c>';
                        }
                        msg += '</row>';
                        return msg;
                    }
    
                    var r1 = Addrow(1, [{ key: 'A', value: 'Citihardware | Chinese New Year 2022' }]);
                    var r2 = Addrow(2, [{ key: 'A', value: 'Cut-off Order Report' }]);
                    var r3 = Addrow(3, [{ key: 'A', value:  dateFrom + ' 03:00:00 - '+dateTo + ' 23:59:59'}]);
                    var r4 = Addrow(4, [{ key: 'A', value: location }]);
    
                    sheet.childNodes[0].childNodes[1].innerHTML = r1+ r2  + r3 + r4 + sheet.childNodes[0].childNodes[1].innerHTML;
    
                    function _createNode(doc, nodeName, opts) {
                        var tempNode = doc.createElement(nodeName);
    
                        if (opts) {
                            if (opts.attr) {
                                $(tempNode).attr(opts.attr);
                            }
    
                            if (opts.children) {
                                $.each(opts.children, function (key, value) {
                                    tempNode.appendChild(value);
                                });
                            }
    
                            if (opts.text !== null && opts.text !== undefined) {
                                tempNode.appendChild(doc.createTextNode(opts.text));
                            }
                        }
    
                        return tempNode;
                    }
    
                    var mergeCells = $('mergeCells', sheet);
                    mergeCells[0].appendChild(_createNode(sheet, 'mergeCell', {
                        attr: {
                            ref: 'A1:F1'
                        }
                    }));
    
                    var mergeCells2 = $('mergeCells', sheet);
    
                    mergeCells2[0].appendChild(_createNode(sheet, 'mergeCell', {
                        attr: {
                            ref: 'A2:F2'
                        }
                    }));
    
    
                    var mergeCells3 = $('mergeCells', sheet);
    
                    mergeCells3[0].appendChild(_createNode(sheet, 'mergeCell', {
                        attr: {
                            ref: 'A3:F3'
                        }
                    }));
    
    
                    var mergeCells4 = $('mergeCells', sheet);

                    mergeCells4[0].appendChild(_createNode(sheet, 'mergeCell', {
                        attr: {
                            ref: 'A4:F4'
                        }
                    }));

                    

    
                    mergeCells.attr('count', mergeCells.attr('count') + 1);
                    mergeCells2.attr('count', mergeCells.attr('count') + 1);
                    mergeCells3.attr('count', mergeCells.attr('count') + 1);
                    mergeCells4.attr('count', mergeCells.attr('count') + 1);

    
                    // $('row c[r^="A1"]', sheet).attr('s', '51');
                    // $('row c[r^="D2"]', sheet).attr('s', '55');
                    // $('row c[r^="A2"]', sheet).attr( 's', '52' );
                    // $('row c[r^="E2"]', sheet).attr( 's', '52');
                    // $('row c[r^="A3"]', sheet).attr( 's', '52' );
                    // $('row c[r^="E3"]', sheet).attr( 's', '52' );
                    // $('row c[r^="B2"]', sheet).attr('s', ['55']);
                    // $('row c[r^="B3"]', sheet).attr('s', ['55']);
                }


    dTable = $("#itemOrderTable")
        .DataTable({
            responsive: true,
            "ordering": false,
            lengthChange: false,
            pageLength: 25,
            autoWidth: false,
            // order: [[1, "asc"]],
            buttons: [

            // {
            //     extend: 'csv',
            //     title: 'CitiHardware | Chinese New Year 2022 ',
            //     messageTop: 'Cut-off Orders Report',
            //     message: function() {
            //         return  $("#rpt_dateFrom").val() +' 3:00:00 - '+ $("#rpt_dateTo").val() + ' 23:59:59\n'+ $('#pickLocationSelectCutOff').val();
            //     }
            // },

            {
                extend: 'excelHtml5',
                title: '',
                customize: customized_excel
            },

            // {
            //     extend: 'pdf',
            //     title: 'CitiHardware | Chinese New Year 2022 \nCut-off Orders Report',
            //     alignment: "left",
            // },
        
            {
                extend: 'print',
                title: function() {
                    return  'CitiHardware | Chinese New Year 2022<br> Cut-off Orders Report<br>';
                },
                messageTop: function() {
                    return  'Another title';
                },
                message: function() {
                    return  $("#rpt_dateFrom").val() +' 3:00:00 - '+ $("#rpt_dateTo").val() + ' 23:59:59<br>'+$('#pickLocationSelectCutOff').val();
                },
            
                // customize: function(win) {
                //   $(win.document.body).append('<html elements here>'); //after the table
                //   $(win.document.body).prepend('<html elements here>'); //before the table
                // }
            },
        
        
        
        ],
           
            
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

        window.location.href =
            "/cnypromo_dev/public/reports/printstub/" + picklocation;
    });

    $(document).on("click", "#checkoutStubBtn", function(e) {
        var picklocation = $("#pickLocationSelect option:selected").text();

        window.location.href =
            "/cnypromo_dev/public/reports/printcheckout/" + picklocation;

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
                        grandTotal = parseFloat(grandTotal) + parseFloat(startTotalAmount);
                        subTotal = parseFloat(subTotal) + parseFloat(startTotalAmount);

                          if(ctr === dtRows){
                            // console.log(startTotalAmount);
                            dtable.row.add(['', '', '', '', '', '','<b>Subtotal</b>','<b>'+subTotal+'</b>']).draw();
                            dtable.row.add(['', '', '', '', '', '','<b>Grand Total</b>','<b>'+grandTotal+'</b>']).draw();

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
});
