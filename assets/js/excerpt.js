jQuery(document).ready(function($) {
    // تابع برای دریافت متن کوتاه‌شده
    function getExcerpt(text, elementId) {
        // بررسی عرض صفحه
        var isMobile = window.innerWidth < 768;

        // ارسال درخواست AJAX
        $.ajax({
            url: excerptAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_excerpt',
                text: text,
                is_mobile: isMobile,
                _ajax_nonce: excerptAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // نمایش متن کوتاه‌شده در المان مورد نظر
                    $('#' + elementId).text(response.data.excerpt);
                } else {
                    console.error('Error in AJAX response:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    // فراخوانی تابع برای تمام المان‌های مورد نظر
    $('.excerpt-title').each(function() {
        var text = $(this).data('text') || '';
        var elementId = $(this).attr('id');
        if (text && elementId) {
            getExcerpt(text, elementId);
        }
    });

    // بروزرسانی در صورت تغییر اندازه صفحه
    $(window).resize(function() {
        $('.excerpt-title').each(function() {
            var text = $(this).data('text') || '';
            var elementId = $(this).attr('id');
            if (text && elementId) {
                getExcerpt(text, elementId);
            }
        });
    });
});