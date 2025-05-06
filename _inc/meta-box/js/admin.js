// admin.js
jQuery(document).ready(function ($) {
    // دکمه افزودن سوال جدید
    $('.add-faq').on('click', function () {
        var faqIndex = $('.faq-item').length;
        var template = `
            <div class="faq-item" data-index="${faqIndex}">
                <h4>سوال ${faqIndex + 1} 
                    <button type="button" class="button remove-faq">حذف</button>
                </h4>
                <table class="form-table">
                    <tr>
                        <th><label>عنوان سوال</label></th>
                        <td>
                            <input type="text" name="home_faq_title_${faqIndex}" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th><label>متن پاسخ</label></th>
                        <td>
                            <textarea name="home_faq_content_${faqIndex}" rows="5" class="large-text"></textarea>
                        </td>
                    </tr>
                </table>
            </div>`;
        $('#faq-container').append(template);
    });

    // حذف سوال
    $(document).on('click', '.remove-faq', function () {
        if ($('.faq-item').length > 1) {
            $(this).closest('.faq-item').remove();
        }
    });
});