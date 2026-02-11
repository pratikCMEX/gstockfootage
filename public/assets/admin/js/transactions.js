$(document).on("click", ".delete_transaction", function () {
    var id = $(this).data("id");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // alert();
            $("#delete_transaction_form" + id).submit();
        }
    });
});

$(document).on("click", ".copy-ref", function () {
    // let ref = $(this).data("ref");

    // navigator.clipboard
    //     .writeText(ref)
    //     .then(() => {
    //         alert("Reference ID copied: " + ref);
    //     })
    //     .catch(() => {
    //         alert("Copy failed");
    //     });

    let ref = $(this).data("ref");

    let tempInput = document.createElement("input");
    tempInput.value = ref;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    // alert("Reference ID copied: " + ref);
    toastr.success("Wallet Address copied");
});
