<?php
// افزودن متا باکس‌ها
function custom_portfolio_metaboxes() {
    add_meta_box(
        'portfolio_details',
        'جزئیات پروژه',
        'render_portfolio_details_metabox',
        'portfolio',
        'normal',
        'high'
    );

    add_meta_box(
        'portfolio_images',
        'عکس‌های پروژه',
        'render_portfolio_images_metabox',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'custom_portfolio_metaboxes');

// متا باکس اول: جزئیات پروژه
function render_portfolio_details_metabox($post) {
    wp_nonce_field(basename(__FILE__), 'portfolio_details_nonce');

    $site_type = get_post_meta($post->ID, '_site_type', true);
    $duration = get_post_meta($post->ID, '_duration', true);
    $position = get_post_meta($post->ID, '_position', true);
    $url = get_post_meta($post->ID, '_project_url', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="site_type">نوع سایت</label></th>
            <td><input type="text" name="site_type" id="site_type" value="<?php echo esc_attr($site_type); ?>" class="widefat"></td>
        </tr>
        <tr>
            <th><label for="duration">مدت زمان انجام</label></th>
            <td><input type="text" name="duration" id="duration" value="<?php echo esc_attr($duration); ?>" class="widefat"></td>
        </tr>
        <tr>
            <th><label for="position">موقعیت</label></th>
            <td><input type="text" name="position" id="position" value="<?php echo esc_attr($position); ?>" class="widefat"></td>
        </tr>
        <tr>
            <th><label for="project_url">URL سایت</label></th>
            <td><input type="text" name="project_url" id="project_url" value="<?php echo esc_url($url); ?>" class="widefat"></td>
        </tr>
    </table>
    <?php
}

// متا باکس دوم: عکس‌های پروژه
function render_portfolio_images_metabox($post) {
    wp_nonce_field(basename(__FILE__), 'portfolio_images_nonce');

    $thumbnail_image_id = get_post_meta($post->ID, '_thumbnail_image_id', true);
    $thumbnail_title = get_post_meta($post->ID, '_thumbnail_title', true);

    $large_image_id = get_post_meta($post->ID, '_large_image_id', true);
    $large_title = get_post_meta($post->ID, '_large_title', true);
    ?>
    <table class="form-table">
        <!-- عکس کوچک -->
        <tr>
            <th>عکس کوچک</th>
            <td>
                <div class="image-preview-wrap">
                    <?php if ($thumbnail_image_id) : ?>
                        <?php echo wp_get_attachment_image($thumbnail_image_id, 'thumbnail'); ?>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="thumbnail_image_id" id="thumbnail_image_id" value="<?php echo esc_attr($thumbnail_image_id); ?>">
                <button type="button" class="upload_image_button button">انتخاب/تغییر عکس کوچک</button>
                <button type="button" class="remove_image_button button">حذف</button>
                <br><br>
                <input type="text" name="thumbnail_title" placeholder="عنوان عکس کوچک" value="<?php echo esc_attr($thumbnail_title); ?>" class="widefat">
            </td>
        </tr>

        <!-- عکس بزرگ -->
        <tr>
            <th>عکس بزرگ</th>
            <td>
                <div class="image-preview-wrap">
                    <?php if ($large_image_id) : ?>
                        <?php echo wp_get_attachment_image($large_image_id, 'full'); ?>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="large_image_id" id="large_image_id" value="<?php echo esc_attr($large_image_id); ?>">
                <button type="button" class="upload_image_button button">انتخاب/تغییر عکس بزرگ</button>
                <button type="button" class="remove_image_button button">حذف</button>
                <br><br>
                <input type="text" name="large_title" placeholder="عنوان عکس بزرگ" value="<?php echo esc_attr($large_title); ?>" class="widefat">
            </td>
        </tr>
    </table>

    <style>
        .image-preview-wrap img {
            max-width: 200px;
            height: auto;
        }
    </style>

    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;

            $('.upload_image_button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var inputField = button.prev();
                var previewWrap = button.parent().find('.image-preview-wrap');

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'انتخاب تصویر',
                    button: { text: 'انتخاب تصویر' },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    inputField.val(attachment.id);
                    previewWrap.html('<img src="' + attachment.url + '">');
                });

                mediaUploader.open();
            });

            $('.remove_image_button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                button.parent().find('.image-preview-wrap').html('');
                button.prev().val('');
                button.prev().prev().val('');
            });
        });
    </script>
    <?php
}

// ذخیره داده‌ها
function save_portfolio_metabox_data($post_id) {

    // Verify nonce
    if (!isset($_POST['portfolio_details_nonce']) || !wp_verify_nonce($_POST['portfolio_details_nonce'], basename(__FILE__))) {
        return;
    }
    if (!isset($_POST['portfolio_images_nonce']) || !wp_verify_nonce($_POST['portfolio_images_nonce'], basename(__FILE__))) {
        return;
    }

    // Auto-save fix
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) return;

    // Save details fields
    $fields = ['project_name', 'site_type', 'duration', 'position', 'project_url'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }

    // Save image fields
    $image_fields = ['thumbnail_image_id', 'thumbnail_title', 'large_image_id', 'large_title'];
    foreach ($image_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, intval($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_portfolio_metabox_data');