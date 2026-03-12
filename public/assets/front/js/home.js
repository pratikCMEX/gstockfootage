$(document).ready(function () {
  var base_url = $("#base_url").val();
  var searchTimeout;

  $(document).on("keyup", ".home_search", function () {
    $(".suggetion-search ul").html("");
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
              "<div class='no-suggetion-search'> <p> No Suggetion </p> </div > "
            );
          }
        },
      });
    }, 300);
  });

  document.querySelectorAll(".dropdown-item").forEach(item => {

    item.addEventListener("click", function (e) {
      e.preventDefault();

      const icon = this.querySelector("i").className;
      const text = this.querySelector("span").textContent;

      document.querySelector(".btn-icon").className = icon + " btn-icon";
      document.querySelector(".btn-text").textContent = text;

    });

  });


});
