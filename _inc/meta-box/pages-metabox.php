<?php
/*
function my_custom_portfolio_metabox()
{
    global $post;

    if ($post) {
        $page_slug = $post->post_name;
        if ($page_slug === 'portfolio') {
            add_meta_box(
                'my_metabox_id', 
                'متن درباره نمونه کار ها', 
                'my_portfolio_metabox_callback', 
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action('add_meta_boxes', 'my_custom_portfolio_metabox');

function my_portfolio_metabox_callback($post)
{
    $portfolip_text_field = get_post_meta($post->ID, '_portfolip_text_field', true);

    wp_nonce_field('my_metabox_nonce', 'my_nonce');

    ?>
    <label for="portfolip_text_field">مقدار متن درباره نمونه کار ها:</label>
    <textarea id="portfolip_text_field" name="portfolip_text_field"
        style="width: 100%;"><?php echo esc_attr($portfolip_text_field); ?></textarea>
    <?php
}

function save_my_portfolio_metabox($post_id)
{
    if (!isset($_POST['my_nonce']) || !wp_verify_nonce($_POST['my_nonce'], 'my_metabox_nonce')) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    if (isset($_POST['portfolip_text_field'])) {
        update_post_meta($post_id, '_portfolip_text_field', sanitize_text_field($_POST['portfolip_text_field']));
    }
}
add_action('save_post', 'save_my_portfolio_metabox');
*/


function remove_editor_from_pages() {
    // فقط برای برگه‌ها
    if (isset($_GET['post']) && get_post_type($_GET['post']) === 'page' || isset($_GET['post_type']) && $_GET['post_type'] === 'page') {
        // حذف ویرایشگر پیش‌فرض
        remove_post_type_support('page', 'editor');
    }
}
add_action('admin_init', 'remove_editor_from_pages');

//***************** افزودن متا باکس متن هدر برگه ها**********************
//***************** افزودن متا باکس متن هدر برگه ها**********************
function add_page_header_meta_box()
{
    add_meta_box(
        'page_header_meta_box',         // Unique ID
        'متن هدر برگه',                 // Title
        'render_page_header_meta_box',  // Callback function
        'page',                         // Apply to 'page' post type
        'normal',                       // Context
        'high'                          // Priority
    );
}
add_action('add_meta_boxes', 'add_page_header_meta_box');

// رندر فیلدها در متا باکس
function render_page_header_meta_box($post)
{
    // Retrieve current value from database
    $header_text = get_post_meta($post->ID, '_page_header_text_key', true);

    // Security field (nonce)
    wp_nonce_field('save_page_header_meta_box_data', 'page_header_meta_box_nonce');

    // Textarea Field
    echo '<label for="page-header-text">متن هدر:</label><br>';
    echo '<textarea id="page-header-text" name="page_header_text" rows="5" cols="80" style="width:100%;">';
    echo esc_textarea($header_text);
    echo '</textarea>';
}

// ذخیره داده‌ها
function save_page_header_meta_box_data($post_id)
{
    // Check if nonce is valid
    if (
        !isset($_POST['page_header_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['page_header_meta_box_nonce'], 'save_page_header_meta_box_data')
    ) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save or delete data
    if (isset($_POST['page_header_text'])) {
        $sanitized_text = sanitize_textarea_field($_POST['page_header_text']);
        update_post_meta($post_id, '_page_header_text_key', $sanitized_text);
    } else {
        delete_post_meta($post_id, '_page_header_text_key');
    }
}
add_action('save_post', 'save_page_header_meta_box_data');


//***************** افزودن متا باکس ویدیو وعکس ویدیو درباره ما **********************
//***************** افزودن متا باکس ویدیو وعکس ویدیو درباره ما **********************
function my_custom_aboutus_metaboxes()
{
    global $post;

    if ($post) {
        $page_slug = $post->post_name;
        if ($page_slug === 'about-us') {
            // متاباکس اول برای ویدیو
            add_meta_box(
                'aboutus_video_metabox',
                'ویدیو درباره ما',
                'aboutus_video_metabox_callback',
                'page',
                'normal',
                'high'
            );

            // متاباکس دوم برای تامبنیل ویدیو
            add_meta_box(
                'aboutus_video_thumbnail_metabox',
                'عکس تامبنیل ویدیو درباره ما',
                'aboutus_video_thumbnail_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action('add_meta_boxes', 'my_custom_aboutus_metaboxes');

// کالبک متاباکس ویدیو
function aboutus_video_metabox_callback($post)
{
    $video_url = get_post_meta($post->ID, '_aboutus_video_url', true);
    wp_nonce_field('aboutus_metabox_nonce', 'aboutus_nonce');
    ?>
    <label for="aboutus_video_url">آدرس ویدیو:</label>
    <input type="text" id="aboutus_video_url" name="aboutus_video_url" value="<?php echo esc_url($video_url); ?>"
        style="width: 100%; margin-bottom: 10px;">
    <input type="button" id="upload_video_button" class="button" value="انتخاب ویدیو از رسانه">
    <script>
        jQuery(document).ready(function ($) {
            $('#upload_video_button').click(function () {
                var frame = wp.media({
                    title: 'انتخاب ویدیو',
                    library: { type: 'video' },
                    multiple: false
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#aboutus_video_url').val(attachment.url);
                });

                frame.open();
            });
        });
    </script>
    <?php
}

// کالبک متاباکس تامبنیل ویدیو
function aboutus_video_thumbnail_metabox_callback($post)
{
    $thumbnail_id = get_post_meta($post->ID, '_aboutus_video_thumbnail_id', true);
    $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
    wp_nonce_field('aboutus_metabox_nonce', 'aboutus_nonce');
    ?>
    <label for="aboutus_video_thumbnail">تصویر تامبنیل:</label>
    <input type="hidden" id="aboutus_video_thumbnail_id" name="aboutus_video_thumbnail_id"
        value="<?php echo esc_attr($thumbnail_id); ?>">
    <input type="text" id="aboutus_video_thumbnail_url" name="aboutus_video_thumbnail_url"
        value="<?php echo esc_url($thumbnail_url); ?>" style="width: 100%; margin-bottom: 10px;">
    <input type="button" id="upload_thumbnail_button" class="button" value="انتخاب تصویر از رسانه">
    <div id="thumbnail_preview" style="margin-top: 10px;">
        <?php if ($thumbnail_url): ?>
            <img src="<?php echo esc_url($thumbnail_url); ?>" style="max-width: 200px; height: auto;">
        <?php endif; ?>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('#upload_thumbnail_button').click(function () {
                var frame = wp.media({
                    title: 'انتخاب تصویر تامبنیل',
                    library: { type: 'image' },
                    multiple: false
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#aboutus_video_thumbnail_id').val(attachment.id);
                    $('#aboutus_video_thumbnail_url').val(attachment.url);
                    $('#thumbnail_preview').html('<img src="' + attachment.url + '" style="max-width: 200px; height: auto;">');
                });

                frame.open();
            });
        });
    </script>
    <?php
}

// تابع ذخیره سازی داده‌های متاباکس
function save_aboutus_metaboxes($post_id)
{
    if (!isset($_POST['aboutus_nonce']) || !wp_verify_nonce($_POST['aboutus_nonce'], 'aboutus_metabox_nonce')) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // ذخیره ویدیو
    if (isset($_POST['aboutus_video_url'])) {
        update_post_meta($post_id, '_aboutus_video_url', esc_url_raw($_POST['aboutus_video_url']));
    }

    // ذخیره تامبنیل
    if (isset($_POST['aboutus_video_thumbnail_id'])) {
        update_post_meta($post_id, '_aboutus_video_thumbnail_id', absint($_POST['aboutus_video_thumbnail_id']));
    }
}
add_action('save_post', 'save_aboutus_metaboxes');


function my_custom_aboutus_metabox()
{
    global $post;

    if ($post && isset($post->post_name)) {
        $page_slug = $post->post_name;
        if ($page_slug === 'about-us') {
            add_meta_box(
                'my_aboutus_metabox_id',
                'اطلاعات درباره ما',
                'my_aboutus_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action('add_meta_boxes', 'my_custom_aboutus_metabox');

// === 2. تابع Callback متا باکس ===
if (!function_exists('my_aboutus_metabox_callback')) {
    function my_aboutus_metabox_callback($post)
    {
        // گرفتن داده‌های ذخیره شده قبلی
        $sections = get_post_meta($post->ID, '_aboutus_info_sections', true);

        wp_nonce_field('my_aboutus_metabox_nonce', 'my_aboutus_nonce');

        ?>
        <div id="aboutus-sections-container">
            <?php
            // اگر داده وجود داشت، نمایش بده
            if (!empty($sections) && is_array($sections)):
                foreach ($sections as $index => $section):
                    ?>
                    <div class="aboutus-section">
                        <label>عنوان:</label>
                        <textarea name="aboutus_sections[<?php echo esc_attr($index); ?>][title]"
                            style="width:100%;"><?php echo esc_textarea($section['title'] ?? ''); ?></textarea>

                        <label>محتوا:</label>
                        <textarea name="aboutus_sections[<?php echo esc_attr($index); ?>][content]"
                            style="width:100%; height:100px;"><?php echo esc_textarea($section['content'] ?? ''); ?></textarea>

                        <button type="button" class="remove-section button">حذف</button>
                        <hr>
                    </div>
                    <?php
                endforeach;
            else:
                // در غیر اینصورت فقط یک فیلد نمایش بده
                ?>
                <div class="aboutus-section">
                    <label>عنوان:</label>
                    <textarea name="aboutus_sections[0][title]" style="width:100%;"></textarea>

                    <label>محتوا:</label>
                    <textarea name="aboutus_sections[0][content]" style="width:100%; height:100px;"></textarea>

                    <button type="button" class="remove-section button">حذف</button>
                    <hr>
                </div>
                <?php
            endif;
            ?>
        </div>

        <button type="button" id="add-section" class="button button-primary">افزودن بخش</button>

        <style>
            .aboutus-section {
                position: relative;
                margin-bottom: 20px;
            }

            .remove-section {
                color: red;
                float: left;
                margin-top: -25px;
            }
        </style>

        <script>
            jQuery(document).ready(function ($) {
                let maxSections = 4;
                let sectionCount = $('.aboutus-section').length;

                $('#add-section').on('click', function () {
                    if (sectionCount >= maxSections) {
                        alert('حداکثر 4 بخش مجاز است.');
                        return;
                    }
                    const newSection = `
                        <div class="aboutus-section">
                            <label>عنوان:</label>
                            <textarea name="aboutus_sections[${sectionCount}][title]" style="width:100%;"></textarea>

                            <label>محتوا:</label>
                            <textarea name="aboutus_sections[${sectionCount}][content]" style="width:100%; height:100px;"></textarea>

                            <button type="button" class="remove-section button">حذف</button>
                            <hr>
                        </div>
                    `;
                    $('#aboutus-sections-container').append(newSection);
                    sectionCount++;
                });

                $(document).on('click', '.remove-section', function () {
                    if (confirm('آیا مطمئن هستید؟')) {
                        $(this).closest('.aboutus-section').remove();
                        sectionCount--;
                    }
                });
            });
        </script>
        <?php
    }
}

// === 3. ذخیره داده‌ها ===
function save_my_aboutus_metabox($post_id)
{
    if (!isset($_POST['my_aboutus_nonce']) || !wp_verify_nonce($_POST['my_aboutus_nonce'], 'my_aboutus_metabox_nonce')) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    if (isset($_POST['aboutus_sections'])) {
        $sections = array_map(function ($section) {
            return [
                'title' => sanitize_textarea_field($section['title']),
                'content' => sanitize_textarea_field($section['content']),
            ];
        }, $_POST['aboutus_sections']);

        update_post_meta($post_id, '_aboutus_info_sections', $sections);
    } else {
        delete_post_meta($post_id, '_aboutus_info_sections');
    }
}
add_action('save_post', 'save_my_aboutus_metabox');


// Add Meta Box for Contact Page Only
function my_custom_contact_location_metabox()
{
    global $post;

    if ($post && $post->post_name === 'contact') {
        add_meta_box(
            'my_location_metabox_id',
            'لوکیشن ها',
            'my_contact_location_metabox_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'my_custom_contact_location_metabox');

// Metabox HTML Output
function my_contact_location_metabox_callback($post)
{
    // Retrieve saved values
    $location_neshan_address = get_post_meta($post->ID, '_location_neshan_address', true);
    $location_balad_address = get_post_meta($post->ID, '_location_balad_address', true);
    $location_waze_address = get_post_meta($post->ID, '_location_waze_address', true);
    $location_map_address = get_post_meta($post->ID, '_location_map_address', true);
    $location_brt_address = get_post_meta($post->ID, '_location_brt_address', true);
    $location_metro_address = get_post_meta($post->ID, '_location_metro_address', true);
    $location_image_address = get_post_meta($post->ID, '_location_image_address', true);

    // Security Nonce
    wp_nonce_field('my_location_metabox_nonce', 'my_location_nonce');

    ?>
    <table class="form-table">
        <tr>
            <th><label for="location_neshan_address">نشان</label></th>
            <td><input type="text" name="location_neshan_address" id="location_neshan_address"
                    value="<?php echo esc_attr($location_neshan_address); ?>" style="width:100%;" /></td>
        </tr>
        <tr>
            <th><label for="location_balad_address">بلد</label></th>
            <td><textarea name="location_balad_address" id="location_balad_address" rows="2"
                    style="width:100%;"><?php echo esc_textarea($location_balad_address); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="location_waze_address">Waze</label></th>
            <td><textarea name="location_waze_address" id="location_waze_address" rows="2"
                    style="width:100%;"><?php echo esc_textarea($location_waze_address); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="location_map_address">Map Embed Code</label></th>
            <td><textarea name="location_map_address" id="location_map_address" rows="4"
                    style="width:100%;"><?php echo esc_textarea($location_map_address); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="location_brt_address">نزدیک ترین brt</label></th>
            <td><textarea name="location_brt_address" id="location_brt_address" rows="4"
                    style="width:100%;"><?php echo esc_textarea($location_brt_address); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="location_metro_address">نزدیک ترین metro</label></th>
            <td><textarea name="location_metro_address" id="location_metro_address" rows="4"
                    style="width:100%;"><?php echo esc_textarea($location_metro_address); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="location_image_address">عکس مپ لوکیشن</label></th>
            <td>
                <input type="text" name="location_image_address" id="location_image_address"
                    value="<?php echo esc_url($location_image_address); ?>" style="width:80%;" />
                <button type="button" class="upload_image_button button">انتخاب تصویر</button>
                <p class="description">آدرس URL عکس را وارد کنید یا از طریق دکمه بالا آپلود کنید.</p>
                <?php if (!empty($location_image_address)): ?>
                    <div style="margin-top: 10px;"><img src="<?php echo esc_url($location_image_address); ?>" alt=""
                            style="max-width: 200px; height:auto;" /></div>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <script>
        jQuery(document).ready(function ($) {
            $('.upload_image_button').on('click', function () {
                var $input = $(this).prev('input');
                var custom_uploader = wp.media({
                    title: 'انتخاب عکس',
                    button: { text: 'انتخاب' },
                    multiple: false
                }).on('select', function () {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    $input.val(attachment.url);
                }).open();
            });
        });
    </script>
    <?php
}

// Save Meta Box Data
function save_my_contact_location_metabox($post_id)
{
    // Check nonce
    if (!isset($_POST['my_location_nonce']) || !wp_verify_nonce($_POST['my_location_nonce'], 'my_location_metabox_nonce')) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Save fields
    if (isset($_POST['location_neshan_address'])) {
        update_post_meta($post_id, '_location_neshan_address', sanitize_text_field($_POST['location_neshan_address']));
    }

    if (isset($_POST['location_balad_address'])) {
        update_post_meta($post_id, '_location_balad_address', sanitize_textarea_field($_POST['location_balad_address']));
    }

    if (isset($_POST['location_waze_address'])) {
        update_post_meta($post_id, '_location_waze_address', sanitize_textarea_field($_POST['location_waze_address']));
    }

    if (isset($_POST['location_map_address'])) {
        update_post_meta($post_id, '_location_map_address', sanitize_textarea_field($_POST['location_map_address']));
    }






    if (isset($_POST['location_metro_address'])) {
        update_post_meta($post_id, '_location_metro_address', sanitize_textarea_field($_POST['location_metro_address']));
    }


    if (isset($_POST['location_brt_address'])) {
        update_post_meta($post_id, '_location_brt_address', sanitize_textarea_field($_POST['location_brt_address']));
    }





    if (isset($_POST['location_image_address'])) {
        update_post_meta($post_id, '_location_image_address', esc_url_raw($_POST['location_image_address']));
    }
}
add_action('save_post', 'save_my_contact_location_metabox');



// Add meta boxes for 'landing' page template
function my_custom_landing_metaboxes()
{
    global $post;

    if ($post && $post->post_type === 'page') {
        $page_slug = $post->post_name;
        if ($page_slug === 'landing') {

            // Meta box for video upload via Media Library
            add_meta_box(
                'my_landing_video_metabox',
                'ویدیو صفحه لندینگ',
                'my_landing_video_metabox_callback',
                'page',
                'normal',
                'high'
            );

            // Meta box for thumbnail image upload
            add_meta_box(
                'my_landing_thumbnail_metabox',
                'عکس تامبنیل صفحه لندینگ',
                'my_landing_thumbnail_metabox_callback',
                'page',
                'normal',
                'high'
            );

            // Meta box for 4 text containers
            add_meta_box(
                'my_landing_containers_metabox',
                'چهار کانتینر متنی',
                'my_landing_containers_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action('add_meta_boxes', 'my_custom_landing_metaboxes');


// Callback for Video Upload Metabox
function my_landing_video_metabox_callback($post)
{
    $video_id = get_post_meta($post->ID, '_landing_video_attachment_id', true);
    $video_url = $video_id ? wp_get_attachment_url($video_id) : '';

    wp_nonce_field('my_landing_video_nonce', 'landing_video_nonce');
    ?>
    <div class="video-preview">
        <?php if ($video_url): ?>
            <video controls style="max-width:100%; margin-top:10px;">
                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
            </video>
        <?php endif; ?>
    </div>

    <input type="hidden" name="landing_video_attachment_id" id="landing_video_attachment_id" value="<?php echo esc_attr($video_id); ?>" />

    <button type="button" class="button button-secondary" id="upload_video_button">
        <?php echo $video_id ? 'تغییر ویدیو' : 'انتخاب ویدیو'; ?>
    </button>

    <?php if ($video_id): ?>
        <button type="button" class="button button-secondary" id="remove_video_button" style="margin-top: 10px; color: red;">
            حذف ویدیو
        </button>
    <?php endif; ?>

    <script>
        jQuery(document).ready(function ($) {
            var mediaUploader;

            $('#upload_video_button').on('click', function (e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'انتخاب ویدیو',
                    button: {
                        text: 'استفاده از این ویدیو'
                    },
                    multiple: false,
                    library: {
                        type: 'video'
                    }
                });

                mediaUploader.on('select', function () {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#landing_video_attachment_id').val(attachment.id);

                    var videoHtml = '<video controls style="max-width:100%; margin-top:10px;"><source src="' + attachment.url + '" type="video/mp4"></video>';
                    $('.video-preview').html(videoHtml);
                    $('#remove_video_button').show();
                });

                mediaUploader.open();
            });

            $('#remove_video_button').on('click', function (e) {
                e.preventDefault();
                $('#landing_video_attachment_id').val('');
                $('.video-preview').html('');
                $(this).hide();
            });
        });
    </script>
    <?php
}


// Callback for Thumbnail Image Upload Metabox
function my_landing_thumbnail_metabox_callback($post)
{
    $thumbnail_id = get_post_meta($post->ID, '_landing_thumbnail_attachment_id', true);
    $thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'medium') : '';

    wp_nonce_field('my_landing_thumbnail_nonce', 'landing_thumbnail_nonce');
    ?>
    <div class="thumbnail-preview">
        <?php if ($thumbnail_url): ?>
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="Thumbnail Preview" style="max-width: 100%; margin-top: 10px; border-radius: 8px;" />
        <?php endif; ?>
    </div>

    <input type="hidden" name="landing_thumbnail_attachment_id" id="landing_thumbnail_attachment_id" value="<?php echo esc_attr($thumbnail_id); ?>" />

    <button type="button" class="button button-secondary" id="upload_thumbnail_button">
        <?php echo $thumbnail_id ? 'تغییر تصویر' : 'انتخاب تامبنیل'; ?>
    </button>

    <?php if ($thumbnail_id): ?>
        <button type="button" class="button button-secondary" id="remove_thumbnail_button" style="margin-top: 10px; color: red;">
            حذف تصویر
        </button>
    <?php endif; ?>

    <script>
        jQuery(document).ready(function ($) {
            var mediaUploader;

            $('#upload_thumbnail_button').on('click', function (e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'انتخاب تصویر',
                    button: {
                        text: 'استفاده از این تصویر'
                    },
                    multiple: false,
                    library: {
                        type: 'image'
                    }
                });

                mediaUploader.on('select', function () {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#landing_thumbnail_attachment_id').val(attachment.id);

                    var imageUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

                    $('.thumbnail-preview').html('<img src="' + imageUrl + '" style="max-width:100%; margin-top:10px; border-radius:8px;" />');
                    $('#remove_thumbnail_button').show();
                });

                mediaUploader.open();
            });

            $('#remove_thumbnail_button').on('click', function (e) {
                e.preventDefault();
                $('#landing_thumbnail_attachment_id').val('');
                $('.thumbnail-preview').html('');
                $(this).hide();
            });
        });
    </script>
    <?php
}


// Callback for 4 Text Containers Metabox
function my_landing_containers_metabox_callback($post)
{
    $container_1 = get_post_meta($post->ID, '_landing_container_1', true);
    $container_2 = get_post_meta($post->ID, '_landing_container_2', true);
    $container_3 = get_post_meta($post->ID, '_landing_container_3', true);
    $container_4 = get_post_meta($post->ID, '_landing_container_4', true);

    wp_nonce_field('my_landing_containers_nonce', 'landing_containers_nonce');
    ?>
    <div style="display:flex; flex-direction:column; gap:15px;">
        <div>
            <label for="landing_container_1">کانتینر 1:</label>
            <textarea name="landing_container_1" id="landing_container_1" rows="3" style="width:100%;"><?php echo esc_textarea($container_1); ?></textarea>
        </div>

        <div>
            <label for="landing_container_2">کانتینر 2:</label>
            <textarea name="landing_container_2" id="landing_container_2" rows="3" style="width:100%;"><?php echo esc_textarea($container_2); ?></textarea>
        </div>

        <div>
            <label for="landing_container_3">کانتینر 3:</label>
            <textarea name="landing_container_3" id="landing_container_3" rows="3" style="width:100%;"><?php echo esc_textarea($container_3); ?></textarea>
        </div>

        <div>
            <label for="landing_container_4">کانتینر 4:</label>
            <textarea name="landing_container_4" id="landing_container_4" rows="3" style="width:100%;"><?php echo esc_textarea($container_4); ?></textarea>
        </div>
    </div>
    <?php
}


// Save Metabox Data
function save_my_landing_metaboxes($post_id) {
    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check Nonces
    if (
        (isset($_POST['landing_video_nonce']) && !wp_verify_nonce($_POST['landing_video_nonce'], 'my_landing_video_nonce')) ||
        (isset($_POST['landing_thumbnail_nonce']) && !wp_verify_nonce($_POST['landing_thumbnail_nonce'], 'my_landing_thumbnail_nonce')) ||
        (isset($_POST['landing_containers_nonce']) && !wp_verify_nonce($_POST['landing_containers_nonce'], 'my_landing_containers_nonce'))
    ) {
        return;
    }

    // Check user capability
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Save Video Attachment ID
    if (isset($_POST['landing_video_attachment_id'])) {
        update_post_meta($post_id, '_landing_video_attachment_id', intval($_POST['landing_video_attachment_id']));
    } else {
        delete_post_meta($post_id, '_landing_video_attachment_id');
    }

    // Save Thumbnail Attachment ID
    if (isset($_POST['landing_thumbnail_attachment_id'])) {
        update_post_meta($post_id, '_landing_thumbnail_attachment_id', intval($_POST['landing_thumbnail_attachment_id']));
    } else {
        delete_post_meta($post_id, '_landing_thumbnail_attachment_id');
    }

    // Save Text Containers with character count validation
    $containers = [
        'landing_container_1',
        'landing_container_2',
        'landing_container_3',
        'landing_container_4'
    ];

    $has_error = false;
    
    foreach ($containers as $container) {
        if (isset($_POST[$container])) {
            $text = sanitize_textarea_field($_POST[$container]);
            $char_count = mb_strlen($text, 'UTF-8');
            
            if ($char_count > 42) {
                $has_error = true;
                set_transient('landing_container_error_' . $container, 
                    sprintf('متن وارد شده در کانتینر %s باید حداکثر 42 کاراکتر باشد (تعداد کاراکترهای وارد شده: %d).', 
                    str_replace('landing_container_', '', $container), 
                    $char_count), 
                45);
            } else {
                update_post_meta($post_id, '_' . $container, $text);
            }
        }
    }
    
    if ($has_error) {
        set_transient('landing_containers_validation_error', 'برخی فیلدها ذخیره نشدند. لطفا خطاهای مربوط به تعداد کاراکترها را بررسی کنید.', 45);
    }
}
add_action('save_post', 'save_my_landing_metaboxes');

// Display admin notices for container errors
function display_landing_container_errors() {
    // Display general validation error
    if ($error = get_transient('landing_containers_validation_error')) {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php echo esc_html($error); ?></p>
        </div>
        <?php
        delete_transient('landing_containers_validation_error');
    }
    
    // Display individual container errors
    for ($i = 1; $i <= 4; $i++) {
        $container_key = 'landing_container_' . $i;
        if ($error = get_transient('landing_container_error_' . $container_key)) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html($error); ?></p>
            </div>
            <?php
            delete_transient('landing_container_error_' . $container_key);
        }
    }
}
add_action('admin_notices', 'display_landing_container_errors');

// Add character counter to textareas
function add_container_character_counter() {
    global $post;
    
    if ($post && $post->post_type === 'page' && $post->post_name === 'landing') {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Add character counter for each container
            for (var i = 1; i <= 4; i++) {
                var textarea = $('#landing_container_' + i);
                var counter = $('<div class="character-counter" style="text-align: left; font-size: 12px; color: #666; margin-top: 5px;"></div>');
                textarea.after(counter);
                
                // Update counter on input
                textarea.on('input', function() {
                    var text = $(this).val();
                    var charCount = text.length;
                    var counter = $(this).next('.character-counter');
                    
                    counter.text('تعداد کاراکترها: ' + charCount + ' (حداکثر 42 کاراکتر مجاز است)');
                    
                    if (charCount > 42) {
                        counter.css('color', 'red');
                    } else {
                        counter.css('color', 'green');
                    }
                });
                
                // Trigger input event to update counter initially
                textarea.trigger('input');
            }
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'add_container_character_counter');



function my_landing_page_metabox() {
    global $post;

    if ($post) {
        $page_slug = $post->post_name;
        if ($page_slug === 'landing') {
            add_meta_box(
                'landing_page_metabox',
                'محتوا صفحه لندینگ',
                'landing_page_metabox_callback',
                'page',
                'normal',
                'high'
            );
        }
    }
}
add_action('add_meta_boxes', 'my_landing_page_metabox');
function landing_page_metabox_callback($post) {
    wp_nonce_field('landing_metabox_nonce', 'landing_nonce');

    // دریافت مقادیر ذخیره شده
    $about_text = get_post_meta($post->ID, '_landing_about_text', true);
    $content_text = get_post_meta($post->ID, '_landing_content_text', true);
    $containers = get_post_meta($post->ID, '_landing_containers', true);
    $containers_data = !empty($containers) ? json_decode($containers, true) : array();

    ?>
    <div class="landing-metabox-container">
        <!-- فیلدهای اصلی -->
        <div class="landing-field-group">
            <h4>درباره صفحه طراحی سایت</h4>
            <textarea name="landing_about_text" style="width: 100%; height: 100px;"><?php echo esc_textarea($about_text); ?></textarea>
        </div>

        <div class="landing-field-group">
            <h4>محتوا</h4>
            <textarea name="landing_content_text" style="width: 100%; height: 100px;"><?php echo esc_textarea($content_text); ?></textarea>
        </div>

        <!-- کانتینرها -->
        <div class="landing-containers-wrapper">
            <h3>محتوای داخل این صفحه</h3>
            <button type="button" class="button add-container-btn">اضافه کردن کانتینر جدید</button>
            
            <div class="landing-containers">
                <?php if (!empty($containers_data)): ?>
                    <?php foreach ($containers_data as $index => $container): ?>
                        <div class="landing-container" data-index="<?php echo $index; ?>">
                            <div class="container-header">
                                <h4>کانتینر <?php echo $index + 1; ?></h4>
                                <button type="button" class="button remove-container-btn">حذف کانتینر</button>
                            </div>
                            
                            <div class="container-fields">
                                <!-- هدر کانتینر -->
                                <div class="landing-field-group">
                                    <h4>هدر (H4)</h4>
                                    <input type="text" name="landing_containers[<?php echo $index; ?>][header]" 
                                           value="<?php echo esc_attr($container['header'] ?? ''); ?>" style="width: 100%;">
                                </div>
                                
                                <!-- آیتم‌ها (محتوا و لیست به ترتیب زمانی) -->
                                <?php if (!empty($container['items'])): ?>
                                    <?php foreach ($container['items'] as $item_index => $item): ?>
                                        <div class="content-group" data-type="<?php echo esc_attr($item['type']); ?>">
                                            <label><?php echo $item['type'] === 'content' ? 'محتوا' : 'لیست محتوا'; ?> <?php echo $item_index + 1; ?></label>
                                            <textarea name="landing_containers[<?php echo $index; ?>][items][<?php echo $item_index; ?>][value]" 
                                                      style="width: 100%; height: <?php echo $item['type'] === 'content' ? '100px' : '60px'; ?>;">
                                                      <?php echo esc_textarea($item['value']); ?>
                                            </textarea>
                                            <input type="hidden" name="landing_containers[<?php echo $index; ?>][items][<?php echo $item_index; ?>][type]" 
                                                   value="<?php echo esc_attr($item['type']); ?>">
                                            <button type="button" class="button remove-content-btn">حذف آیتم</button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                
                                <!-- دکمه‌های افزودن -->
                                <div class="container-actions">
                                    <button type="button" class="button add-content-btn">اضافه کردن محتوا</button>
                                    <button type="button" class="button add-list-content-btn">اضافه کردن لیست محتوا</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // افزودن کانتینر جدید
        $('.add-container-btn').on('click', function() {
            var containerIndex = $('.landing-container').length;
            var newContainer = `
                <div class="landing-container" data-index="${containerIndex}">
                    <div class="container-header">
                        <h4>کانتینر ${containerIndex + 1}</h4>
                        <button type="button" class="button remove-container-btn">حذف کانتینر</button>
                    </div>
                    
                    <div class="container-fields">
                        <div class="landing-field-group">
                            <h4>هدر (H4)</h4>
                            <input type="text" name="landing_containers[${containerIndex}][header]" style="width: 100%;">
                        </div>
                        
                        <div class="container-actions">
                            <button type="button" class="button add-content-btn">اضافه کردن محتوا</button>
                            <button type="button" class="button add-list-content-btn">اضافه کردن لیست محتوا</button>
                        </div>
                    </div>
                </div>
            `;
            
            $('.landing-containers').append(newContainer);
        });
        
        // افزودن محتوای جدید
        $(document).on('click', '.add-content-btn', function() {
            var container = $(this).closest('.landing-container');
            var containerIndex = container.data('index');
            var itemCount = container.find('.content-group').length;
            
            var newContent = `
                <div class="content-group" data-type="content">
                    <label>محتوا ${itemCount + 1}</label>
                    <textarea name="landing_containers[${containerIndex}][items][${itemCount}][value]" style="width: 100%; height: 100px;"></textarea>
                    <input type="hidden" name="landing_containers[${containerIndex}][items][${itemCount}][type]" value="content">
                    <button type="button" class="button remove-content-btn">حذف آیتم</button>
                </div>
            `;
            
            container.find('.container-actions').before(newContent);
        });
        
        // افزودن لیست محتوای جدید
        $(document).on('click', '.add-list-content-btn', function() {
            var container = $(this).closest('.landing-container');
            var containerIndex = container.data('index');
            var itemCount = container.find('.content-group').length;
            
            var newListContent = `
                <div class="content-group" data-type="list">
                    <label>لیست محتوا ${itemCount + 1}</label>
                    <textarea name="landing_containers[${containerIndex}][items][${itemCount}][value]" style="width: 100%; height: 60px;"></textarea>
                    <input type="hidden" name="landing_containers[${containerIndex}][items][${itemCount}][type]" value="list">
                    <button type="button" class="button remove-content-btn">حذف آیتم</button>
                </div>
            `;
            
            container.find('.container-actions').before(newListContent);
        });
        
        // حذف کانتینر
        $(document).on('click', '.remove-container-btn', function() {
            if (confirm('آیا از حذف این کانتینر مطمئن هستید؟')) {
                $(this).closest('.landing-container').remove();
                updateContainerIndexes();
            }
        });
        
        // حذف آیتم
        $(document).on('click', '.remove-content-btn', function() {
            if (confirm('آیا از حذف این آیتم مطمئن هستید؟')) {
                var contentGroup = $(this).closest('.content-group');
                var container = contentGroup.closest('.landing-container');
                contentGroup.remove();
                updateItemIndexes(container);
            }
        });
        
        // به‌روزرسانی اندیس‌های کانتینرها
        function updateContainerIndexes() {
            $('.landing-container').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('.container-header h4').text(`کانتینر ${index + 1}`);
                
                $(this).find('[name^="landing_containers"]').each(function() {
                    var name = $(this).attr('name');
                    name = name.replace(/landing_containers\[\d+\]/, `landing_containers[${index}]`);
                    $(this).attr('name', name);
                });
            });
        }
        
        // به‌روزرسانی اندیس‌های آیتم‌ها
        function updateItemIndexes(container) {
            container.find('.content-group').each(function(index) {
                var type = $(this).data('type');
                var label = type === 'content' ? 'محتوا' : 'لیست محتوا';
                $(this).find('label').text(`${label} ${index + 1}`);
                
                $(this).find('textarea').attr('name', `landing_containers[${container.data('index')}][items][${index}][value]`);
                $(this).find('input[type="hidden"]').attr('name', `landing_containers[${container.data('index')}][items][${index}][type]`);
            });
        }
    });
    </script>

    <style>
    .landing-metabox-container {
        padding: 15px;
    }
    .landing-field-group {
        margin-bottom: 20px;
    }
    .landing-containers-wrapper {
        margin-top: 30px;
        border-top: 1px solid #ddd;
        padding-top: 20px;
    }
    .landing-container {
        background: #f9f9f9;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .container-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .container-header h4 {
        margin: 0 15px 0 0;
        flex: 1;
        min-width: 100%;
    }
    .container-fields {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .content-group {
        background: #fff;
        padding: 10px;
        border: 1px solid #eee;
        border-radius: 3px;
    }
    .content-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .content-group button {
        margin-top: 5px;
    }
    .container-actions {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #ccc;
    }
    </style>
    <?php
}

function save_landing_page_metabox($post_id) {
    if (!isset($_POST['landing_nonce']) || !wp_verify_nonce($_POST['landing_nonce'], 'landing_metabox_nonce')) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // ذخیره فیلدهای اصلی
    if (isset($_POST['landing_about_text'])) {
        update_post_meta(
            $post_id,
            '_landing_about_text',
            sanitize_textarea_field(wp_unslash($_POST['landing_about_text']))
        );
    }

    if (isset($_POST['landing_content_text'])) {
        update_post_meta(
            $post_id,
            '_landing_content_text',
            sanitize_textarea_field(wp_unslash($_POST['landing_content_text']))
        );
    }

    // ذخیره کانتینرها
    if (isset($_POST['landing_containers'])) {
        $containers = $_POST['landing_containers'];
        $clean_containers = array();

        foreach ($containers as $container) {
            $clean_container = array(
                'header' => sanitize_text_field(wp_unslash($container['header'] ?? '')),
                'items' => array()
            );

            // ذخیره آیتم‌ها (محتوا و لیست)
            if (!empty($container['items'])) {
                foreach ($container['items'] as $item) {
                    $clean_item = array(
                        'type' => sanitize_text_field(wp_unslash($item['type'])),
                        'value' => sanitize_textarea_field(wp_unslash($item['value']))
                    );
                    if (!empty(trim($clean_item['value'])) && in_array($clean_item['type'], ['content', 'list'])) {
                        $clean_container['items'][] = $clean_item;
                    }
                }
            }

            $clean_containers[] = $clean_container;
        }

        update_post_meta(
            $post_id,
            '_landing_containers',
            wp_json_encode($clean_containers, JSON_UNESCAPED_UNICODE)
        );
    } else {
        delete_post_meta($post_id, '_landing_containers');
    }
}
add_action('save_post', 'save_landing_page_metabox');