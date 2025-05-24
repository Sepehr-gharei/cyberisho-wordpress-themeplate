jQuery(document).ready(function($) {
    // Single Image Upload
    $(document).on('click', '.field-upload-img:not(.multiple)', function(e) {
        e.preventDefault();
        var button = $(this);
        var inputId = button.data('input-id') || button.closest('.cyberisho-field').find('input').attr('name');
        var input = $('input[name="' + inputId + '"]');
        var imgContainer = button.closest('.flex').find('.field-img-container');
        var deleteLink = button.closest('.flex').find('.field-delete-img');

        var frame = wp.media({
            title: 'انتخاب تصویر',
            button: { text: 'استفاده از تصویر' },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            input.val(attachment.url);
            imgContainer.html('<img src="' + attachment.url + '" alt="" style="max-width: 100px; max-height: 100px;" />');
            deleteLink.removeClass('hidden');
        });

        frame.open();
    });

    // Delete Single Image
    $(document).on('click', '.field-delete-img:not([data-id])', function(e) {
        e.preventDefault();
        var button = $(this);
        var inputId = button.data('input-id') || button.closest('.cyberisho-field').find('input').attr('name');
        var input = $('input[name="' + inputId + '"]');
        var imgContainer = button.closest('.flex').find('.field-img-container');

        input.val('');
        imgContainer.html('');
        button.addClass('hidden');
    });

    // Multiple Image Upload
    $(document).on('click', '.field-upload-img.multiple', function(e) {
        e.preventDefault();
        var button = $(this);
        var inputId = button.data('input-id') || button.closest('.cyberisho-field').find('input').attr('name');
        var input = $('input[name="' + inputId + '"]');
        var imgContainer = button.closest('.flex').find('.field-img-container');

        var frame = wp.media({
            title: 'انتخاب تصاویر',
            button: { text: 'استفاده از تصاویر' },
            multiple: true
        });

        frame.on('select', function() {
            var attachments = frame.state().get('selection').toJSON();
            var ids = attachments.map(function(attachment) {
                return attachment.id;
            });
            input.val(ids.join(','));
            imgContainer.html('');
            attachments.forEach(function(attachment) {
                imgContainer.append('<div class="field-img-item" data-id="' + attachment.id + '"><img src="' + attachment.url + '" alt="" style="max-width: 100px; max-height: 100px;" /><a href="#" class="field-delete-img" data-id="' + attachment.id + '">حذف</a></div>');
            });
        });

        frame.open();
    });

    // Delete Image from Gallery
    $(document).on('click', '.field-delete-img[data-id]', function(e) {
        e.preventDefault();
        var button = $(this);
        var imgItem = button.closest('.field-img-item');
        var inputId = button.closest('.field-multiple-image-uploader').find('.field-upload-img').data('input-id') || button.closest('.cyberisho-field').find('input').attr('name');
        var input = $('input[name="' + inputId + '"]');
        var idToRemove = button.data('id');
        var ids = input.val().split(',').filter(function(id) {
            return id !== idToRemove.toString();
        });

        input.val(ids.join(','));
        imgItem.remove();
    });

    // Add Repeater Row for All Sections
    $(document).on('click', '.add-repeater-row', function(e) {
        e.preventDefault();
        var button = $(this);
        var repeater = button.closest('.field-repeater');
        var repeaterId = repeater.attr('id');
        var settings = button.data('settings');
        if (typeof settings === 'string') {
            settings = JSON.parse(settings);
        }
        var count = repeater.find('.repeater-table').length;

        var html = '<div id="' + repeaterId + '[' + count + ']" class="repeater-table w100">' +
                   '<div class="repeater-table-entry">' +
                   '<button type="button" class="button delete-repeater-row">حذف</button>';

        $.each(settings, function(key, setting) {
            var parts = key.match(/\[([^\]]*)\]/g);
            var default_id = parts[parts.length - 1].replace(/[\[\]]/g, '');
            var fieldId = repeaterId + '[' + count + '][' + default_id + ']';
            var title = setting.title;
            var type = setting.type;

            if (type === 'text') {
                html += '<div id="' + fieldId + '" class="cyberisho-field field-text">' +
                        '<label for="' + fieldId + '">' + title + '</label>' +
                        '<input type="text" value="" name="' + fieldId + '" />' +
                        '</div>';
            } else if (type === 'textarea') {
                html += '<div id="' + fieldId + '" class="cyberisho-field field-textarea">' +
                        '<label for="' + fieldId + '">' + title + '</label>' +
                        '<textarea name="' + fieldId + '" rows="4" cols="50"></textarea>' +
                        '</div>';
            } else if (type === 'image-uploader') {
                html += '<div id="' + fieldId + '" class="cyberisho-field field-image-uploader">' +
                        '<label for="' + fieldId + '">' + title + '</label>' +
                        '<div class="flex align-items-center">' +
                        '<button type="button" class="button field-upload-img" data-input-id="' + fieldId + '">انتخاب تصویر</button>' +
                        '<input value="" type="text" class="field-img-url" name="' + fieldId + '" readonly />' +
                        '<div class="field-img-container"></div>' +
                        '<a class="field-delete-img hidden" href="#" data-input-id="' + fieldId + '">حذف تصویر</a>' +
                        '</div></div>';
            } else if (type === 'select') {
                html += '<div id="' + fieldId + '" class="cyberisho-field field-select">' +
                        '<label for="' + fieldId + '">' + title + '</label>' +
                        '<select class="cyberisho-select select-single" name="' + fieldId + '">';
                $.each(setting.content, function(val, label) {
                    html += '<option value="' + val + '">' + label + '</option>';
                });
                html += '</select></div>';
            }
        });

        html += '</div></div>';
        button.before(html);
    });

    // Delete Repeater Row
    $(document).on('click', '.delete-repeater-row', function(e) {
        e.preventDefault();
        var button = $(this);
        var repeaterTable = button.closest('.repeater-table');
        repeaterTable.remove();
    });

    // Color Picker
    $('.color-picker').wpColorPicker();

    // Select2 Initialization
    $('.select-multiple').select2({
        placeholder: 'انتخاب کنید',
        allowClear: true
    });
});