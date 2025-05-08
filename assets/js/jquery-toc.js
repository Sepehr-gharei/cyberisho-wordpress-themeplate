$(document).ready(function () {
    $('#content').empty(); // پاک کردن محتوای قبلی

    let counter = 0;

    // لیست عباراتی که نمی‌خواهیم در TOC ظاهر شوند
    const excludedPhrases = [
        "سایبریشو",
        "حقیقتـــاً نه اولینیـــم نه بهتریـــن!",
        "برای یک انتخـــــــــاب درست"
    ];

    $('h1, h2, h3').each(function () {
        let $header = $(this);
        let text = $header.text().trim();

        // بررسی اینکه آیا این عنوان باید حذف شود
        for (let phrase of excludedPhrases) {
            if (text === phrase.trim()) {
                return; // ادامه نده (این عنوان را نادیده بگیر)
            }
        }

        // اگر بعد از trim خالی بود، نادیده بگیر
        if (text.length === 0) return;

        // اگر id ندارد، یکی اختصاص بده
        if (!$header.attr('id')) {
            $header.attr('id', 'toc-header-' + (counter));
        }

        // اضافه کردن آیتم به toc
        $('#content').append(
            '<div class="item">' +
                '<a href="#' + $header.attr('id') + '">' + text + '</a>' +
            '</div>'
        );

        counter++;
    });

    // اسکرول آرام وقتی روی لینک کلیک کردیم
    $('#content a').on('click', function (e) {
        e.preventDefault();

        const hash = this.hash;
        const target = $(hash);

        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 800); // 800 میلی‌ثانیه = نیم ثانیه
        }
    });
});