jQuery(document).ready(function($) {
    $('.like-button, .dislike-button').on('click', function(e) {
        e.preventDefault();
        var $button = $(this);

        // دیباگ: بررسی وضعیت دکمه
        console.log('Button clicked:', $button.hasClass('disabled'), $button.prop('disabled'));

        // بررسی وضعیت دکمه (غیرفعال یا خیر)
        if ($button.hasClass('disabled') || $button.prop('disabled')) {
            return;
        }

        var post_id = $button.data('post-id');
        var action_type = $button.data('action');
        var $likeCounter = $button.closest('.like-dislike-section').find('.like-wrapper .like-counter');
        var $dislikeCounter = $button.closest('.like-dislike-section').find('.dislike-wrapper .like-counter');

        $.ajax({
            url: blog_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'blog_like_dislike',
                post_id: post_id,
                action_type: action_type,
                nonce: blog_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // نمایش الرت بر اساس نوع اقدام
                    if (action_type === 'like') {
                        alert('شما با موفقیت لایک کردید!');
                    } else if (action_type === 'dislike') {
                        alert('شما با موفقیت دیسلایک کردید!');
                    }

                    // به‌روزرسانی تعداد لایک‌ها و دیسلایک‌ها
                    $likeCounter.text(response.data.likes);
                    $dislikeCounter.text(response.data.dislikes);

                    // غیرفعال کردن دکمه‌ها
                    $('.like-button[data-post-id="' + post_id + '"]').addClass('disabled').prop('disabled', true);
                    $('.dislike-button[data-post-id="' + post_id + '"]').addClass('disabled').prop('disabled', true);

                    // پررنگ کردن آیکون‌ها
                    $('.like-button[data-post-id="' + post_id + '"] .icon').css('opacity', '1');
                    $('.dislike-button[data-post-id="' + post_id + '"] .icon').css('opacity', '1');
                } else {
                    alert(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.log('Ajax Error:', status, error); // برای دیباگ
                alert('خطایی رخ داد. لطفاً دوباره تلاش کنید.');
            }
        });
    });
});
