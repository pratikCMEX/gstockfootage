$(document).ready(function () {
  var base_url = $("#base_url").val();
  var searchTimeout;

  $(document).on("keyup", ".home_search", function () {
    var value = $(this).val().toLowerCase();

    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(function () {
      $.ajax({
        url: base_url + "/home_search",
        type: "GET",
        data: {
          search: value,
        },

        success: function (res) {
          let html = "";

          if (res.length > 0 && value != "") {
            res.forEach(function (keyword) {
              html += `<li>
                                    <a href="#">${keyword}</a>
                                </li>`;
            });

            $(".suggetion-search ul").html(html);
            $(".suggetion-search").addClass("show");
          } else {
            $(".suggetion-search ul").html(
              "<li><a href='javascript:void(0)'>No results found</li></a>  </li>"
            );
          }
        },
      });
    }, 500);
  });
});
