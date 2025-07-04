jQuery(document).ready(function ($) {
  // Handler for clicking the checkout button
  $(".checkout-button").on("click", function (e) {
    const node = `<i class="fa fa-circle-o-notch fa-spin"></i>`;
    $(this).append(node);
    $(".checkout-button").prop("disabled", true);
    e.preventDefault();
    var priceId = $(this).data("price-id");
    var type = $(this).data("type");
    console.log(priceId);
    $.ajax({
      url: myAjax.ajaxurl,
      method: "POST",
      data: {
        action: "create_checkout_session",
        price_id: priceId,
        type: type,
      },
      success: function (response) {
        if (response.success) {
          window.location.href = response.data.url;
        } else {
          alert("Error: " + response.data);
        }
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  });

  // Function to handle AJAX call after successful payment
  function handleStripeCheckoutSuccess(sessionId) {
    $.ajax({
      url: myAjax.ajaxurl,
      method: "POST",
      data: {
        action: "handle_stripe_checkout_success",
        session_id: sessionId, // Pass the session ID here
      },
      success: function (response) {
        if (response.success) {
          weddingdir_alert(data);
          // Optionally, redirect or perform other actions upon success
        } else {
          alert("Error: " + response.data);
        }
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  }

  var urlParams = new URLSearchParams(window.location.search);
  var sessionId = urlParams.get("session_id");
  if (sessionId) {
    handleStripeCheckoutSuccess(sessionId);
  }
});
