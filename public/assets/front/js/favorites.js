var base_url = $("#base_url").val();

$(document).on("click", ".addFavorite", function (e) {
  e.preventDefault(); // Prevent parent anchor tag from navigating
  var id = $(this).data("product-id");
  var type = $(this).data("type");
  var button = $(this);

  // console.log("Adding to favorites:", { product_id: id, product_type: type });

  $.ajax({
    url: base_url + "/add_favorite",
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    data: {
      product_id: id,
      product_type: type,
    },
    success: function (response) {
      // console.log(response);
      if (response.success) {
        toastr.success(response.message);

        // Update wishlist count in header

        var icon = button.find("i");
        var currentCount = parseInt($(".wishlist-count").text());
        if (response.action === "removed") {
          icon.removeClass("bi-heart-fill").addClass("bi-heart");
          if (button.text().trim() !== "") {
            // change text
            button
              .contents()
              .filter(function () {
                return this.nodeType === 3;
              })
              .remove();

            button.append(" Save");
          }
          var newCount = currentCount - 1;
          $(".wishlist-count").text(newCount);
          // Hide if 0
          if (newCount <= 0) {
            $(".wishlist-count").hide();
          }
          // $(".wishlist-count").text(currentCount - 1);
          // button.removeClass('favorited');
          // button.find('svg').removeClass('text-danger').addClass('text-muted');
          // Decrease count
          // $('.wishlist-count').text(currentCount - 1);
        } else if (response.action === "added") {
          icon.removeClass("bi-heart").addClass("bi-heart-fill");
          if (button.text().trim() !== "") {
            button
              .contents()
              .filter(function () {
                return this.nodeType === 3;
              })
              .remove();

            button.append(" Saved");
          }

          var newCount = currentCount + 1;
          $(".wishlist-count").text(newCount);
          // Always show when adding
          $(".wishlist-count").show();
          // $(".wishlist-count").text(currentCount + 1);
          // button.addClass('favorited');
          // button.find('svg').removeClass('text-muted').addClass('text-danger');
          // Increase count
          // $('.wishlist-count').text(currentCount + 1);
        }
      } else {
        toastr.error(response.message);
      }
    },
  });
});

$(document).on("click", ".removeFavorite", function () {
  var id = $(this).data("id");
  var button = $(this);

  $.ajax({
    url: base_url + "/remove_favorites",
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    data: {
      id: id,
    },
    success: function (response) {
      // console.log(response);
      if (response.success) {
        toastr.success(response.message);

        // Update wishlist count in header
        // var currentCount = parseInt($(".wishlist-count").text());
        // $(".wishlist-count").text(currentCount - 1);
         var currentCount = parseInt($(".wishlist-count").text() || 0);
        var newCount = currentCount - 1;
        $(".wishlist-count").text(newCount);

        //  Hide count if 0
        if (newCount <= 0) {
          $(".wishlist-count").hide();
        }

        button.closest(".wishlist-item").fadeOut(200, function () {
          $(this).remove();

          if ($(".wishlist-item").length === 0) {
            $(".row.row-gap-4").html(`
              <div class="col-12 mt-4">
                <div class="empty-wishlist text-center">
                  <h4>Your Wishlist is Empty</h4>
                  <p>You haven't added any items to your wishlist yet. Browse products and add your favorites here.</p>
                  <a href="/" class="btn btn-orange mt-2">Browse Products</a>
                </div>
              </div>
            `);
          }
        });
        // Update button appearance based on action
      } else {
        toastr.error(response.message);
      }
    },
  });
});
