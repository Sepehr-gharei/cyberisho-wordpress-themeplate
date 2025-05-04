jQuery(document).ready(function($) {
    $(document).on('click', '#pagination a', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function() {
                // نمایش لودینگ و حذف کلاس animate از المان‌های قبلی
                $('#portfolio-loop').html('<div class="loading">در حال بارگذاری...</div>');
                $('.animated-section').removeClass('animate'); // حذف کلاس برای جلوگیری از تداخل
            },
            success: function(response) {
                // تبدیل پاسخ به DOM قابل پردازش
                var $response = $('<div>').html(response);
                var newContent = $response.find('#portfolio-loop').html();

                if (newContent) {
                    $('#portfolio-loop').html(newContent);
                    // اضافه کردن کلاس animate به تمام المان‌های animated-section
                    $('#portfolio-loop .animated-section').each(function() {
                        $(this).addClass('animate');
                    });
                    // فعال کردن رویداد سفارشی برای دیباگ یا اسکریپت‌های اضافی
                    $(document).trigger('ajaxContentLoaded');
                    console.log('محتوای AJAX بارگذاری شد و animate به animated-section اضافه شد');
                } else {
                    $('#portfolio-loop').html('<div class="error">محتوای جدید یافت نشد.</div>');
                    console.log('المان #portfolio-loop در پاسخ یافت نشد');
                }
            },
            error: function(xhr, status, error) {
                $('#portfolio-loop').html('<div class="error">خطا در بارگذاری داده‌ها: ' + error + '</div>');
                console.log('خطای AJAX: ', xhr, status, error);
            }
        });
    });

    // رویداد سفارشی برای دیباگ یا اسکریپت‌های اضافی
    $(document).on('ajaxContentLoaded', function() {
        console.log('رویداد ajaxContentLoaded فعال شد');
        // اطمینان از اضافه شدن کلاس animate به تمام المان‌های animated-section
        $('#portfolio-loop .animated-section').addClass('animate');
    });
});