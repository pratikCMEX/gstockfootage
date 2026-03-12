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
          _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (res) {
          console.log(res);
          // $(".search_result").html(res);
        },
      });
    }, 500);
  });
});
