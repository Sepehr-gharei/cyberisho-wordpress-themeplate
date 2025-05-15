function showCustomAlertRed(message) {
  const alertBox = document.getElementById("customAlertRed");
  const alertMessage = document.getElementById("alertMessageRed");

  // تنظیم پیام
  alertMessage.textContent = message;

  // نمایش alert
  alertBox.classList.remove("hidden");

  // پنهان کردن alert پس از 3 ثانیه
  setTimeout(() => {
    alertBox.classList.add("hidden");
  }, 3000); // 3000 میلی‌ثانیه = 3 ثانیه
}

jQuery(document).ready(function ($) {
  $(".post-like-button, .post-dislike-button").on("click", function (e) {
    e.preventDefault();

    var $button = $(this);
    var postId = $button.data("post-id");
    var actionType = $button.data("action");

    // Check if user has already voted
    if (document.cookie.indexOf("voted_" + postId) !== -1) {
   
      showCustomAlertRed("شما قبلاً رأی داده‌اید!");

      return;
    }

    $.ajax({
      url: likeDislikeAjax.ajax_url,
      type: "POST",
      data: {
        action: "handle_like_dislike",
        post_id: postId,
        action_type: actionType,
        nonce: likeDislikeAjax.nonce,
      },
      success: function (response) {
        if (response.success) {
          // Update counters
          $button
            .closest(".like-dislike-section")
            .find(".like-counter")
            .text(response.data.like_count);
          $button
            .closest(".like-dislike-section")
            .find(".dislike-wrapper .like-counter")
            .text(response.data.dislike_count);

          // Disable buttons
          $button.prop("disabled", true);
          $button
            .siblings(".post-like-button, .post-dislike-button")
            .prop("disabled", true);
        } else {
          alert(response.data);
        }
      },
      error: function () {
      showCustomAlertRed("خطایی رخ داد. لطفاً دوباره امتحان کنید.");

      },
    });
  });

  // Initialize counters on page load
  $(".like-dislike-section").each(function () {
    var postId = $(this).find(".post-like-button").data("post-id");
    $.ajax({
      url: likeDislikeAjax.ajax_url,
      type: "POST",
      data: {
        action: "handle_like_dislike",
        post_id: postId,
        action_type: "get_counts",
        nonce: likeDislikeAjax.nonce,
      },
      success: function (response) {
        if (response.success) {
          $(this).find(".like-counter").text(response.data.like_count);
          $(this)
            .find(".dislike-wrapper .like-counter")
            .text(response.data.dislike_count);
        }
      },
    });
  });
});
