jQuery(document).ready(function ($) {
    $('#contact-form-id').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        // Clear honeypot field
        form.find('input[name="family"]').val('');
        var formData = form.serialize();
        var nonce = ajax_object.nonce;

        // Remove previous messages
        form.find('.success-message, .error-message').remove();

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'insert_contact_form_data',
                form_data: formData,
                nonce: nonce,
            },
            success: function (response) {
                console.log('Contact Form Response:', response);
                if (response.success) {
                    form.find('input[type="submit"]').hide();
                    form.append('<p class="success-message">درخواست شما با موفقیت ارسال شد!</p>');
                    form[0].reset();
                } else {
                    form.append('<p class="error-message">' + (response.data || 'خطای ناشناخته') + '</p>');
                }
            },
            error: function (error) {
                console.log('Contact Form Error:', error);
                form.append('<p class="error-message">خطا در ارسال درخواست: ' + (error.responseText || 'خطای ناشناخته') + '</p>');
            }
        });
    });

    $('#meeting-form-id').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        // Clear honeypot field
        form.find('input[name="family"]').val('');
        var formData = form.serialize();
        var nonce = ajax_object.nonce;

        // Remove previous messages
        form.find('.success-message, .error-message').remove();

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'insert_meeting_form_data',
                form_data: formData,
                nonce: nonce,
            },
            success: function (response) {
                console.log('Meeting Form Response:', response);
                if (response.success) {
                    form.find('input[type="submit"]').hide();
                    form.append('<p class="success-message">درخواست شما با موفقیت ارسال شد!</p>');
                    form[0].reset();
                } else {
                    form.append('<p class="error-message">' + (response.data || 'خطای ناشناخته') + '</p>');
                }
            },
            error: function (error) {
                console.log('Meeting Form Error:', error);
                form.append('<p class="error-message">خطا در ارسال درخواست: ' + (error.responseText || 'خطای ناشناخته') + '</p>');
            }
        });
    });
    $('#inperson-meeting-form-id').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        // Clear honeypot field
        form.find('input[name="family"]').val('');
        var formData = form.serialize();
        var nonce = ajax_object.nonce;

        // Remove previous messages
        form.find('.success-message, .error-message').remove();

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'insert_inperson_meeting_form_data',
                form_data: formData,
                nonce: nonce,
            },
            success: function (response) {
                console.log('In-Person Meeting Form Response:', response);
                if (response.success) {
                    form.find('input[type="submit"]').hide();
                    form.append('<p class="success-message">درخواست شما با موفقیت ارسال شد!</p>');
                    form[0].reset();
                } else {
                    form.append('<p class="error-message">' + (response.data || 'خطای ناشناخته') + '</p>');
                }
            },
            error: function (error) {
                console.log('In-Person Meeting Form Error:', error);
                form.append('<p class="error-message">خطا در ارسال درخواست: ' + (error.responseText || 'خطای ناشناخته') + '</p>');
            }
        });
    });
});