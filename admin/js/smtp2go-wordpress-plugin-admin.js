(function($) {
  "use strict";

  /**
   * All of the code for your admin-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

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
