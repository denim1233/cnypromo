var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

$(function() {
    $("#mechanicsModal").modal("show");

    console.clear();

    $(document).on("show.bs.modal", ".modal", function() {
        var zIndex = 1040 + 10 * $(".modal:visible").length;
        $(this).css("z-index", zIndex);
        setTimeout(function() {
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", zIndex - 1)
                .addClass("modal-stack");
        }, 0);
    });

    $(document).on("click", ".acceptButton", function(e) {
        $.ajax({
            url: "/cnypromo_dev/public/user/validate/" + this.id,
            method: "POST",
            data: {
                _token: CSRF_TOKEN
            },
            success: function(res) {
                toastr.success(res.msg);
                $("#mechanicsModal").modal("hide");
            },
            error: function(error) {
                toastr.error(error.message);
            }
        });
    });

    $(document).on("click", ".btnWishlist", function(e) {
        // var temp = "";

        $.ajax({
            url: "/cnypromo_dev/public/cart/show/" + this.id,
            method: "GET",
            success: function(data) {
                $("#barcode").val(data.items[0].barcode);

                var formdata = new FormData($("#submitForm")[0]);

                formdata.append("barcode", $("#barcode").val());

                // var idNum = $("#userId").val();
                console.log(formdata);
                console.log($("#submitForm").serialize());
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    }
                });
                $.ajax({
                    url: "/cnypromo_dev/public/wishlist/add",
                    method: "POST",
                    data: formdata,
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {
                            toastr.success(data.success);
                            $(".wishlist_count").text(data.wishCount);
                        } else {
                            toastr.error("Something went wrong");
                        }
                    },
                    error: function(msg) {
                        if (msg.status == 502) {
                            console.log(msg);
                            toastr.error(msg.responseJSON["msg"]);
                        } else {
                            console.log(msg);
                            toastr.error(msg.responseJSON["msg"]);
                        }
                    }
                });
            },
            error: function(msg) {
                if (msg.status == 502) {
                    console.log(msg);
                    toastr.error(msg.responseJSON["msg"]);
                } else {
                    console.log(msg.responseText);
                    toastr.error("Something went wrongssss");
                }
            }
        });
    });

    $(document).off("click", "#btnAddCart").on("click", "#btnAddCart", function(e) {
        e.preventDefault();
        $('#btnAddCart').prop('disabled', true);

        var quantity = parseInt($("#quantity").val());

        if (quantity > 15) {
            toastr.error("Sorry, but maximum quantity is 15 only");
            return;
        }

        if (quantity < 0) {
            toastr.error("Oops, that is not allowed");
            return;
        }

        // if()

        var formdata = new FormData($("#cartForm")[0]);

        formdata.append("barcode", $("#barcodeCart").val());
        formdata.append("userId", $("#userId").val());
        formdata.append("itemPrice", $("#itemPriceCart").val());
        formdata.append("payType", $("#payType").val());

        // var idNum = $("#userId").val();
        console.clear();
        console.log(formdata);


        console.log($("#cartForm").serialize());
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            url: "/cnypromo_dev/public/cart/add",
            method: "POST",
            data: formdata,
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                $('#btnAddCart').prop('disabled', false);
                if (data.success) {
                    toastr.success(data.success);
                    $(".cart_count")
                        .parent()
                        .find("#cartCount")
                        .text(data.cartCount);
                    $(".cart_price").text(data.cartTotalAmount);
                    $("#cartModal").modal("hide");
                    $("#quantity").val("1");
                } else {
                    toastr.error("Something went wrong");
                }
            },
            error: function(msg) {
                if (msg.status == 502) {
                    console.log(msg);
                    toastr.error(msg.responseJSON["msg"]);
                } else {
                    console.log(msg.responseText);
                    toastr.error("Something went wrong");
                }

                      $('#btnAddCart').prop('disabled', false);
            }
        });
    });

    $(document).on("change", "#paymentMode", function() {
        if ($("#paymentMode option:selected").text() == "Salary deduction") {
            $("#itemPriceCart").val(
                $(this)
                    .closest("tr")
                    .children("td:eq(4)")
                    .first()
                    .text()
            );
            $("#payType").val(1);
        } else if ($("#paymentMode option:selected").text() == "Cash payment") {
            $("#itemPriceCart").val(
                $(this)
                    .closest("tr")
                    .children("td:eq(3)")
                    .first()
                    .text()
            );
            $("#payType").val(0);
        }
    });

    $("#cartModal").on("hidden.bs.modal", function() {
        $("select[name=cartModal]").val("Cash payment");
    });

    $(document).on("click", ".btnShowCartModal", function(e) {

        // add checker here for quantity
        // disable btnAddCart button if the quantity is 0


        $.ajax({
            url: "/cnypromo_dev/public/cart/show/" + this.id,
            method: "GET",
            success: function(data) {
                console.log(data.items[0].total_qty);
                if(data.items[0].total_qty === '0'){
                     $('#btnAddCart').prop('disabled', true);
                }else{
                     $('#btnAddCart').prop('disabled', false);
                }

                $("#payType").val(0);
                $("#itemPriceCart").val(data.items[0].cash_price);
                $("#barcodeCart").val(data.items[0].barcode);
                $("#barcodeColumn").html(data.items[0].barcode);
                $("#itemname").text(data.items[0].name);
                $("#nameColumn").html(data.items[0].name);
                $("#descColumn").html(data.items[0].description);
                $("#cashpriceColumn").html(data.items[0].cash_price);
                $("#creditpriceColumn").html(data.items[0].credit_price);
                $("#cartModal").modal("show");
            },
            error: function(msg) {
                if (msg.status == 502) {
                    console.log(msg);
                    toastr.error(msg.responseJSON["msg"]);
                } else {
                    console.log(msg.responseText);
                    toastr.error("Something went wrong");
                }
            }
        });
    });

    //SHOWING ADD TO CART IN THE WISHLIST MODAL
    $(document).on("click", ".addCartWishlist", function() {
        $.ajax({
            url: "/cnypromo_dev/public/cart/show/" + this.id,
            method: "GET",
            success: function(data) {

            

                $("#payType").val(0);
                $("#itemPriceCart").val(data.items[0].cash_price);
                $("#barcodeCart").val(data.items[0].barcode);
                $("#barcodeColumn").html(data.items[0].barcode);
                $("#itemname").text(data.items[0].name);
                $("#nameColumn").html(data.items[0].name);
                $("#descColumn").html(data.items[0].description);
                $("#cashpriceColumn").html(data.items[0].cash_price);
                $("#creditpriceColumn").html(data.items[0].credit_price);
                $("#cartModal").modal("show");
            },
            error: function(msg) {
                if (msg.status == 502) {
                    console.log(msg);
                    toastr.error(msg.responseJSON["msg"]);
                } else {
                    console.log(msg.responseText);
                    toastr.error("Something went wrongssss");
                }
            }
        });
    });

function printData(){
   var divToPrint=document.getElementById("showCartTable");

// divToPrint.deleteCell(0);
// divToPrint.deleteCell(8);

   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();



}

   $(document).on("click", "#btnPrint", function(e) {
        printData();
    });

    //SHOWING CART LIST
    $(document).on("click", "#showModalBtn", function(e) {
        $.ajax({
            url: "/cnypromo_dev/public/cart/getItems",
            method: "GET",
            success: function(data) {
                //GETTING ITEMS FROM CART AND ITEM TABLE
                for (let index = 0; index < data.carts.length; index++) {
                    var temp = "";
                    if (data.carts[index].pay_mode == 0) {
                        temp = "Cash payment";
                    } else if (data.carts[index].pay_mode) {
                        temp = "Salary deduction";
                    }

                    var buttons = "";

                    if (data.carts[index].isConfirmed == 0) {
                        buttons =
                            "</td>" +
                            "<td><div class='form-row'> " +
                            "<div class='form-group'>" +
                            " <button class='btn btn-sm btn-danger' id='btnRemoveCart'>" +
                            "<i class='fa fa-times' aria-hidden='true'></i>" +
                            "</button>" +
                            "</div>" +
                            "</div></td>";
                    } else {
                        // $("#showCartModal").css("display", "none");
                        buttons = "";
                        // $("#btnConfirmCart").css("display", "none");
                        // $("#locationColumn").css("display", "none");
                        // $("#showCartTable").css("display", "none");
                        // $("#orderlink").css("display", "block");
                    }

                    $("#showCartTable tbody").append(
                        "<tr>" +
                            "<td class='w-25' id='itemImages'><img width = 110px height = 110px src='/cnypromo_dev/public/assets/img/" +
                            data.carts[index].itemImage +
                            "' class='img-responsive'></td>" +
                            "<td class='w-25'>" +
                            data.carts[index].barcode +
                            "</td>" +
                            "<td class='w-25'>" +
                            data.carts[index].name +
                            "</td>" +
                            "<td class='w-25'>" +
                            data.carts[index].description +
                            "</td>" +
                            "<td>" +
                            "₱ " +
                            data.carts[index].itemPrice +
                            "</td>" +
                            "<td>" +
                            data.carts[index].quantity +
                            "</td>" +
                            "<td class='w-25' style='font-weight: bold;'>" +
                            "₱ " +
                            data.carts[index].totalAmount +
                            "</td>" +
                            "<td>" +
                            temp +
                            buttons +
                            "</tr>"
                    );
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    //SHOWING WISHLIST
    $(document).on("click", "#wishlistBtn", function(e) {
        $.ajax({
            url: "/cnypromo_dev/public/cart/getWishes",
            method: "GET",
            success: function(data) {
                //GETTING ITEMS FROM CART AND ITEM TABLE
                for (let index = 0; index < data.wishlists.length; index++) {
                    $("#showWishlistTable tbody").append(
                        "<tr>" +
                            "<td class='w-25' id='itemImages'><img src='/cnypromo_dev/public/assets/img/" +
                            data.wishlists[index].itemImage +
                            "' class='img-responsive'></td>" +
                            "<td class='w-25'>" +
                            data.wishlists[index].barcode +
                            "</td>" +
                            "<td class='w-25'>" +
                            data.wishlists[index].name +
                            " " +
                            "</td>" +
                            "<td class='w-25'>" +
                            data.wishlists[index].description +
                            "</td>" +
                            "<td>" +
                            "₱ " +
                            data.wishlists[index].cash_price +
                            "</td>" +
                            "<td>" +
                            "₱ " +
                            data.wishlists[index].credit_price +
                            "</td>" +
                            "<td>" +
                            "<div class='form-group'>" +
                            "<button class='btn btn-sm btn-danger addCartWishlist' id='" +
                            data.wishlists[index].barcode +
                            "'>" +
                            "Add to Cart</button>" +
                            "</div></td>" +
                            "</tr>"
                    );
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    //EMPTY CART MODAL TABLE ON CLOSE
    $(document).on("hidden.bs.modal", "#showCartModal", function(e) {
        $("#showCartTable tbody").empty();
    });

    //EMPTY WISHLIST MODAL TABLE ON CLOSE
    $(document).on("hidden.bs.modal", "#showWishlist", function(e) {
        $("#showWishlistTable tbody").empty();
    });

    $(document).on("hidden.bs.modal", "#cartModal", function(e) {
        $("#quantity").val(1);
    });

    //TABLE FILTER USING SEARCHBAR
    $("#searchBar").on("keyup", function() {
        // Your search term, the value of the input
        var searchTerm = $("#searchBar").val();
        // table rows, array
        var tr = [];

        // Loop through all TD elements
        $("#mainTable")
            .find("td")
            .each(function() {
                var value = $(this).html();
                // if value contains searchterm, add these rows to the array
                if (value.toLowerCase().includes(searchTerm.toLowerCase())) {
                    tr.push($(this).closest("tr"));
                }
            });

        // If search is empty, show all rows
        if (searchTerm == "") {
            $("tr").show();
        } else {
            // Else, hide all rows except those added to the array
            $("tr")
                .not("thead tr")
                .hide();
            tr.forEach(function(el) {
                el.show();
            });
        }
    });

    //VIEWING IMAGES
    $(".image").on("click", function() {
        $(".imagepreview").attr(
            "src",
            $(this)
                .find("img")
                .attr("src")
        );
        $("#imagemodal").modal("show");
    });


    $(document).on("click", ".removeWishlist", function() {
        var id = $(this).attr('id');

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
                text: "Once you remove, you can't undo.",
                position: "center",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                reverseButtons: true
            })
            .then(result => {
                if (result.isConfirmed) {

                    // var id = $("#userId").val();
                    var selectedText = $("#locationSelect")
                        .find("option:selected")
                        .text();

                    $.ajax({
                        url: "/cnypromo_dev/public/wishlist/remove/"+ id,
                        method: "POST",
                        data: {
                            _token: CSRF_TOKEN
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

                            $(".wishlist_count").text(data.wishCount);
                            $('#'+id).remove();

                            swalWithBootstrapButtons.fire(
                                "Confirmed!",
                                data.msg,
                                "success"
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

    //CONFIRM CART
    $(document).on("click", "#btnConfirmCart", function() {
        $('#btnConfirmCart').prop('disabled', true); 
        if ($('#locationSelect').val() === null) {
            toastr.error("Please select pick-up location");
            return;
        }
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
                    var selectedText = $("#locationSelect")
                        .find("option:selected")
                        .text();

                    $.ajax({
                        url: "/cnypromo_dev/public/cart/confirm",
                        method: "POST",
                        data: {
                            _token: CSRF_TOKEN,
                            employeeId: id,
                            location: selectedText
                        },
                        success: function(data) {
                            $('#btnConfirmCart').prop('disabled', false);
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
                            $('#btnConfirmCart').prop('disabled', false);
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

    //DELETE CART ITEM
    $(document).on("click", "#btnRemoveCart", function() {
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
                text: "Do you want to delete this item from your cart?",
                position: "center",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            })
            .then(result => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        "Confirmed!",
                        "Item deleted successfully.",
                        "success"
                    );

                    var barcode = $(this)
                        .closest("tr")
                        .children("td:eq(1)")
                        .first()
                        .text();

                    $.ajax({
                        url: "/cnypromo_dev/public/cart/remove/" + barcode,
                        method: "DELETE",
                        data: {
                            _token: CSRF_TOKEN
                        },
                        success: function(res) {
                            toastr.success(res.deleted);
                            location.reload();
                        },
                        error: function(err) {
                            console.log(err);
                            toastr.error("Something went wrong!");
                        }
                    });
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

    //SHOWING CART MODAL
    $(document).on("click", ".cart", function() {
        $.ajax({
            url: "/cnypromo_dev/public/cart/getItems",
            method: "GET",
            success: function(data) {
                //GETTING ITEMS FROM CART AND ITEM TABLE
                for (let index = 0; index < data.carts.length; index++) {
                    var temp = "";
                    if (data.carts[index].pay_mode == 0) {
                        temp = "Cash payment";
                    } else if (data.carts[index].pay_mode) {
                        temp = "Salary deduction";
                    }

                    var buttons = "";

                    if (data.carts[index].isConfirmed == 0) {
                        buttons =
                            "</td>" +
                            "<td><div class='form-row'> " +
                            "<div class='form-group'>" +
                            " <button class='btn btn-sm btn-danger' id='btnRemoveCart'>" +
                            "<i class='fa fa-times' aria-hidden='true'></i>" +
                            "</button>" +
                            "</div>" +
                            "</div></td>";
                    } else {
                        // $("#showCartModal").css("display", "none");
                        buttons = "";
                        // $("#btnConfirmCart").css("display", "none");
                        // $("#locationColumn").css("display", "none");
                        // $("#showCartTable").css("display", "none");
                        // $("#orderlink").css("display", "block");
                    }

                    $("#showCartTable tbody").append(
                        "<tr>" +
                            "<td class='w-20' id='itemImages'><img style = 'width:110px; height:auto;' src='/cnypromo_dev/public/assets/img/" +
                            data.carts[index].itemImage +
                            "' class='img-responsive'></td>" +
                            "<td class='w-20'>" +
                            data.carts[index].barcode +
                            "</td>" +
                            "<td class='w-25'>" +
                            data.carts[index].name +
                            "</td>" +
                            "<td class='w-25'>" +
                            data.carts[index].description +
                            "</td>" +
                            "<td class='w-25'>" +
                            "₱ " +
                            data.carts[index].itemPrice +
                            "</td>" +
                            "<td >" +
                            data.carts[index].quantity +
                            "</td>" +
                            "<td class='w-25' style='font-weight: bold;'>" +
                            "₱ " +
                            data.carts[index].totalAmount +
                            "</td>" +
                            "<td>" +
                            temp +
                            buttons +
                            "</tr>"
                    );
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
        $("#showCartModal").modal("show");
    });
    $(document).on("click", ".wishlist", function() {
        $.ajax({
            url: "/cnypromo_dev/public/cart/getWishes",
            method: "GET",
            success: function(data) {
                //GETTING ITEMS FROM CART AND ITEM TABLE
                for (let index = 0; index < data.wishlists.length; index++) {
                    $("#showWishlistTable tbody").append(
                        "<tr id = '"+data.wishlists[index].id+"'>" +
                            "<td id='itemImages'><img src='/cnypromo_dev/public/assets/img/" +
                            data.wishlists[index].itemImage +
                            "' class='img-responsive'></td>" +
                            "<td>" +
                            data.wishlists[index].barcode +
                            "</td>" +
                            "<td>" +
                            data.wishlists[index].name +
                            " " +
                            "</td>" +
                            "<td style = 'width:20%'>" +
                            data.wishlists[index].description +
                            "</td>" +
                            "<td>" +
                            "₱ " +
                            data.wishlists[index].cash_price +
                            "</td>" +
                            "<td>" +
                            "₱ " +
                            data.wishlists[index].credit_price +
                            "</td>" +
                            "<td style = 'width:14%;'>" +
                            "<div class='form-group'>" +
                            "<button style = 'width:auto;' class='btn btn-sm btn-danger addCartWishlist' id='" +
                            data.wishlists[index].barcode +
                            "'>" +
                            "Add to Cart</button>" +
                              "&nbsp<button style = 'width:auto;' class='btn btn-sm btn-danger removeWishlist' id='" +
                            data.wishlists[index].id +
                            "'>" +
                            "<i class='fa fa-times' aria-hidden='true'></i></button>" +
                            "</div></td>" +
                            "</tr>"
                    );
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
        $("#showWishlist").modal("show");
    });
});

// updated 2019
const input = document.getElementById("search-input");
const searchBtn = document.getElementById("search-btn");

const expand = () => {
    searchBtn.classList.toggle("close");
    input.classList.toggle("square");
};

searchBtn.addEventListener("click", expand);

//  old version / jquery
//
// function expand() {
//   $(".search").toggleClass("close");
//   $(".input").toggleClass("square");
//   if ($('.search').hasClass('close')) {
//     $('input').focus();
//   } else {
//     $('input').blur();
//   }
// }
// $('button').on('click', expand);
//
