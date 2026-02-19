function addToCart(product_id, btn = null) {
  $.ajax({
    url: base_url + "/add-to-cart",
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
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
        let html = cartItemTemplate(res.product);
        $(".cart-items").prepend(html);
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

function cartItemTemplate(product) {
  return `
  <div class="cart-content" id="cart-item-${product.id}">
      <div class="cart-img">
          <img src="${product.image}" width="100%" height="100%">
      </div>

      <div class="cart-detail">
          <h6>${product.title}</h6>
          <p>${product.size}</p>

          <div class="cart-price-btn">
              <h5>$${product.price}</h5>
              <button type="button" class="delete_add_to_cart" data-id=${product.id}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                      viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round">
                      <path d="M3 6h18"></path>
                      <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                      <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      <line x1="10" x2="10" y1="11" y2="17"></line>
                      <line x1="14" x2="14" y1="11" y2="17"></line>
                  </svg>
              </button>
          </div>
      </div>
  </div>
  `;
}

function removeCartItem(product_id) {
  $.ajax({
    url: base_url + "/remove-from-cart",
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    data: { product_id: product_id },

    success: function (res) {
      if (res.status === true) {
        toastr.success(res.message);
        $("#cart-item-" + product_id).fadeOut(300, function () {
          $(this).remove();
        });
        let count = parseInt($(".cart-count").text());
        $(".cart-count").text(Math.max(count - 1, 0));
      } else {
        toastr.warning(res.message);
      }
    },

    error: function () {
      toastr.error("Something went wrong");
    },
  });
}
