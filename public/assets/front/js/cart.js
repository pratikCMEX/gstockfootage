function addToCart(product_id, btn = null) {
  $.ajax({
    url: "{{ route('add.to.cart') }}",
    type: "POST",
    data: {
      product_id: product_id,
      qty: 1,
    },
    beforeSend: function () {
      if (btn) {
        $(btn).prop("disabled", true).text("Adding...");
      }
    },
    success: function (res) {
      if (res.status === true) {
        toastr.success(res.message);
      } else {
        toastr.warning(res.message);
      }
    },
    error: function (xhr) {
      toastr.error("Something went wrong. Please try again.");
    },
    complete: function () {
      if (btn) {
        $(btn).prop("disabled", false).text("Add to Cart");
      }
    },
  });
}
