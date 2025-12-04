(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
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

  document.addEventListener("DOMContentLoaded", function () {
    const radios = document.querySelectorAll('input[name="payment_method"]');
    const fields = document.querySelectorAll(".method-fields");

    radios.forEach((radio) => {
      radio.addEventListener("change", () => {
        fields.forEach((field) => (field.style.display = "none")); // Hide all
        const selected = document.getElementById("fields-" + radio.value);
        if (selected) selected.style.display = "block"; // Show selected
      });
    });
  });
})(jQuery);


