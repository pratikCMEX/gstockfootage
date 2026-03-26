// function addToCart(product_id, btn = null) {
//   $.ajax({
//     url: base_url + "/add-to-cart",
//     type: "POST",
//     headers: {
//       "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//     },
//     data: {
//       product_id: product_id,
//       qty: 1,
//     },
//     beforeSend: function () {
//       if (btn) {
//         $(btn).prop("disabled", true).text("Adding...");
//       }
//     },
//     success: function (res) {
//       if (res.status === true) {
//         let html = cartItemTemplate(res.product);
//         $(".cart-items").prepend(html);
//         let count = parseInt($(".cart-count").text());
//         $(".cart-count").text(Math.max(count + 1, 0));
//         let newCount = $(".cart-items .cart-content").length;
//         updateCartCount(newCount);
//         updateCartTotal(parseFloat(res.product.price), "add");
//         // if (btn) {
//         // alert();
//         // }
//         //
//         toastr.success(res.message);
//       } else {
//         toastr.warning(res.message);
//       }
//     },
//     error: function (xhr) {
//       toastr.error("Something went wrong. Please try again.");
//     },
//     complete: function () {
//       // if (btn) {
//       $(".add_to_cart").prop("disabled", true).text("Added to Cart");
//       // $(".add_to_cart").removeClass("btn-orange");
//       // $(".add_to_cart").addClass("btn-success already-added");
//       // }
//       // $(".add_to_cart").prop("disabled", true).text("Added to Cart");
//     },
//   });
// }
// alert();
function addToCart(product_id, btn = null) {
  console.log(product_id);

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
      console.log(res);

      if (res.status === true) {
        $(".cart-empty").remove();
        let html = cartItemTemplate(res.product);
        $(".cart-items").prepend(html);
        let count = parseInt($(".cart-count").text());
        $(".cart-count").text(Math.max(count + 1, 0));
        let newCount = $(".cart-items .cart-content").length;
        updateCartCount(newCount);
        updateCartTotal(parseFloat(res.product.price), "add");
        toastr.success(res.message);
      } else {
        toastr.warning(res.message);
      }
    },
    error: function (xhr) {
      if (btn) {
        // ✅ Re-enable only the clicked button on error
        $(btn).prop("disabled", false).text("Add");
      }
      toastr.error("Something went wrong. Please try again.");
    },
    complete: function () {
      if (btn) {
        // ✅ Only update the specific button that was clicked
        $(btn)
          .prop("disabled", true)
          .html('<i class="bi bi-cart-check"></i> Added to Cart');
      }
    },
  });
}
function cartItemTemplate(product) {
  let imageUrl = "";

  if (product.type == "image") {
    imageUrl = product.mid_path ? product.file_path : "";
  } else {
    imageUrl = product.thumbnail_path;
  }

  return `
  <div class="cart-content" id="cart-item-${product.id}" data-id="${product.id}"
 data-price="${product.price}">
      <div class="cart-img">
          <img src="${imageUrl}" width="100%" height="100%">
      </div>

      <div class="cart-detail">
          <h6>${product.title}</h6>
          <p>${product.size}</p>

          <div class="cart-price-btn">
              <h5>$${product.price}</h5>
              <button type="button" class="delete_add_to_cart" data-id=${product.id}>
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

$(document).on("click", ".delete_add_to_cart", function () {
  var id = $(this).attr("data-id");
  // alert("HEllo guys");
  $(this).prop("disabled", true);
  removeCartItem(id);
});

function removeCartItem(product_id) {
  console.log(product_id);

  // Select BOTH sidebar and table items
  let items = $("[id='cart-item-" + product_id + "']");

  if (!items.length) {
    console.log("Item not found");
    return;
  }

  let itemPrice = parseFloat(items.first().attr("data-price")) || 0;

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

        // 🔥 Remove sidebar + table row
        items.fadeOut(300, function () {
          $(this).remove();
          $(".delete_add_to_cart").prop("disabled", false);

          /* --------------------------
             SIDEBAR UPDATE
          -------------------------- */
          let remainingItems = $(".cart-items .cart-content").length;
          updateCartCount(remainingItems);

          if (remainingItems === 0) {
            $(".cart-items").html(`
                <div class="cart-empty" style="display: flex; align-items: center; justify-content: center; height: 100%;">
                    <p>Cart is empty</p>
                </div>
            `);
          }

          /* --------------------------
             TABLE UPDATE
          -------------------------- */
          if ($("#cartTable").length) {
            let tableRows = $("#cartTable tbody tr").length;

            if (tableRows === 0) {
              $("#cartTable tbody").html(
                '<tr><td colspan="3" class="text-center">Cart is empty</td></tr>'
              );
            }
          }
        });

        updateCartTotal(itemPrice, "subtract");

        let count = parseInt($(".cart-count").text()) || 0;
        $(".cart-count").text(Math.max(count - 1, 0));

        $(".add_to_cart").prop("disabled", false).text("Add to Cart");
        $(".add_to_cart").addClass("btn-orange");
        $(".add_to_cart").removeClass("btn-success already-added");
      } else {
        toastr.warning(res.message);
      }
    },

    error: function () {
      toastr.error("Something went wrong");
    },
  });
}
function updateCartCount(newCount) {
  let cartCount = $(".cart-count");

  newCount = Math.max(newCount, 0);

  cartCount.text(newCount);

  if (newCount > 0) {
    cartCount.removeClass("d-none");
  } else {
    cartCount.addClass("d-none");
  }
}

function updateCartTotal(amount, type = "add") {
  let totalElement = $(".total_cart_amt");
  let currentTotal = parseFloat(totalElement.text().replace("$", ""));
  if (isNaN(currentTotal)) currentTotal = 0;
  let newTotal;
  if (type === "add") {
    newTotal = currentTotal + amount;
  } else {
    newTotal = currentTotal - amount;
  }
  if (newTotal < 0) newTotal = 0;
  totalElement.text("$" + newTotal.toFixed(2));
}
