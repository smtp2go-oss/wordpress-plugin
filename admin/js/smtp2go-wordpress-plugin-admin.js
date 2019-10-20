(function($) {
  "use strict";

  $(function() {
    $(".js-send-test-email-form").submit(function(e) {
      e.preventDefault();
      $.post(
        ajaxurl,
        {
          action: "smtp2go_send_email",
          to_email: $("#smtp2go_to_email").val(),
          to_name: $("#smtp2go_to_name").val()
        },
        function(response) {
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
