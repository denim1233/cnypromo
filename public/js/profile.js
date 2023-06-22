$(function() {


     $(document).on("click", "#saveBtn", function(e) {
        // alert('save button;')
    });


    $(document).on("click", "#btnDeactivate", function(e) {
        // alert("Hello World");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-warning",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons
            .fire({
                title: "Deactivate?",
                text: "Are you sure you want to deactivate your account?",
                position: "center",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Deactivate!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            })
            .then(result => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        "Char lang!",
                        "Wala ta ana nga feature diri ʕ•́ᴥ•̀ʔっ♡.",
                        "success"
                    );
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
});
