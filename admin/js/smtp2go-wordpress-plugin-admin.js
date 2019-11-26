(function($) {
  "use strict";

  $(function() {

    $(".js-stats-tab").click(function(e) {

      console.log($(".js-stats-tab-span.spinner"));

      $(".js-stats-tab-span.spinner").show();
      $(".js-stats-tab-span.spinner").addClass("is-active");

      console.log($(".js-stats-tab-span.spinner"));
    });

    $(".js-send-test-email-form").submit(function(e) {
      e.preventDefault();
      $(".js-send-test.spinner").addClass("is-active");
      $.post(
        ajaxurl,//from html header
        {
          action: "smtp2go_send_email",
          to_email: $("#smtp2go_to_email").val(),
          to_name: $("#smtp2go_to_name").val()
        },
        function(response) {
          $(".js-send-test.spinner").removeClass("is-active");
          if (response.success) {
            $(".smtp2go-js-failure").hide();
            $(".smtp2go-js-success").show();
          } else {
            $(".smtp2go-js-failure")
              .html(response.reason)
              .show();
            $(".smtp2go-js-success").hide();
          }
        }
      ),
        "jSON";
      return false;
    });
  });
})(jQuery);
