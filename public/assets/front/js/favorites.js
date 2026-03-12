var base_url = $("#base_url").val();

$(document).on('click', '.addFavorite', function (e) {
    e.preventDefault(); // Prevent parent anchor tag from navigating
    var id = $(this).data('product-id');
    var type = $(this).data('type');
    var button = $(this);

    console.log('Adding to favorites:', { product_id: id, product_type: type });

    $.ajax({
        url: base_url + "/add_favorite",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        data: {

            product_id: id,
            product_type: type
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);

                // Update button appearance based on action
                if (response.action === 'removed') {
                    button.removeClass('favorited');

                    button.find('svg').removeClass('text-danger').addClass('text-muted');
                } else if (response.action === 'added') {
                    button.addClass('favorited');

                    button.find('svg').removeClass('text-muted').addClass('text-danger');
                }
            } else {
                toastr.error(response.message);
            }
        }
    });
});

$(document).on('click', '.removeFavorite', function () {

    var id = $(this).data('id');
    var button = $(this);

    $.ajax({
        url: base_url + "/remove_favorites",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        data: {
            id: id,
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                toastr.success(response.message);

                 button.closest('.wishlist-item').fadeOut(200, function () {
    $(this).remove();
});
                // Update button appearance based on action

            } else {
                toastr.error(response.message);
            }
        }
    });

})
