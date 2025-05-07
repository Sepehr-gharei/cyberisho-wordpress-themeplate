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
