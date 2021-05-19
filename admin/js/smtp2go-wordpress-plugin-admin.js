(function ($) {
  "use strict";

  $(function () {
    $(".js-stats-tab").click(function (e) {
      $(".js-stats-tab-span.spinner").show();
      $(".js-stats-tab-span.spinner").addClass("is-active");
    });
    $(".js-validation-tab").click(function (e) {
      $(".js-validation-tab-span.spinner").show();
      $(".js-validation-tab-span.spinner").addClass("is-active");
    });    
    $(document).on("click", ".smtp2go_add_remove_row", function () {
      if ($(this).hasClass("j-add-row")) {
        var cloned = $(
          ".smtp2go_custom_headers .smtp2go_custom_headers_table_body tr:last"
        )
          .first()
          .clone();
        cloned.find(".first-remove").removeClass("first-remove");
        cloned.find("input").val("");
        cloned.removeClass("smtp2go-js-hidden");
        cloned.appendTo(
          ".smtp2go_custom_headers .smtp2go_custom_headers_table_body"
        );
      } else {
        var index = $(".smtp2go_add_remove_row.j-remove-row").index(this);
        var row = $(
          ".smtp2go_custom_headers .smtp2go_custom_headers_table_body tr:eq(" +
            index +
            ")"
        );
        row.find("input").val("");
        if (index > 0) {
          $(
            ".smtp2go_custom_headers .smtp2go_custom_headers_table_body tr:eq(" +
              index +
              ")"
          ).remove();
        }
      }
    });

    $(".js-send-test-email-form").submit(function (e) {
      e.preventDefault();
      $(".js-send-test.spinner").addClass("is-active");
      $.post(
        ajaxurl, //from html header
        {
          action: "smtp2go_send_email",
          to_email: $("#smtp2go_to_email").val(),
          to_name: $("#smtp2go_to_name").val(),
        },
        function (response) {
          $(".js-send-test.spinner").removeClass("is-active");
          if (response.success) {
            $(".smtp2go-js-failure").hide();
            $(".smtp2go-js-success").show();
          } else {
            $(".smtp2go-js-failure").html(response.reason).show();
            $(".smtp2go-js-success").hide();
          }
        }
      ).fail(function (jqXHR, textStatus, errorThrown) {
        $(".js-send-test.spinner").removeClass("is-active");
        $(".smtp2go-js-failure").html(jqXHR.responseText).show();
        $(".smtp2go-js-success").hide();
      }),
        "jSON";
      return false;
    });

    // number formatting
    $(".smtp2go-number-format").each(function () {
      $(this).html(Number($(this).text()).toLocaleString());
    });
    $(".j-smtp2go_toggle_apikey_edit").on("click", function () {      
      $(this).toggleClass('active');
      var isActive = $(this).hasClass('active');
      $(this).text(isActive ? 'Hide' : 'Edit');
      $('.smtp2go_obscured_key').toggle();
      $('.smtp2go_text_input[name=smtp2go_api_key_update]').attr('type', isActive ? 'text' : 'hidden');
    });
  });
})(jQuery);
