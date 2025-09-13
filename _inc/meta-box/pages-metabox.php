<?php

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



// افزودن متاباکس برای صفحه درباره ما
function my_custom_aboutus_metaboxes()
{
    global $post;

    if ($post && $post->post_name === 'about-us') {
        // متاباکس برای کانتینر اطلاعات بیشتر
        add_meta_box(
            'aboutus_info_image_metabox',
            'عکس کانتینر اطلاعات بیشتر',
            'aboutus_info_image_metabox_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'my_custom_aboutus_metaboxes');

// کالبک متاباکس عکس کانتینر اطلاعات بیشتر
function aboutus_info_image_metabox_callback($post)
{
    $image_id = get_post_meta($post->ID, '_aboutus_info_image_id', true);
    $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
    wp_nonce_field('aboutus_metabox_nonce', 'aboutus_nonce');
    ?>
    <label for="aboutus_info_image">عکس کانتینر اطلاعات بیشتر:</label>
    <input type="hidden" id="aboutus_info_image_id" name="aboutus_info_image_id" value="<?php echo esc_attr($image_id); ?>">
    <input type="text" id="aboutus_info_image_url" name="aboutus_info_image_url" value="<?php echo esc_url($image_url); ?>"
        style="width: 100%; margin-bottom: 10px;" readonly>
    <input type="button" id="upload_info_image_button" class="button" value="انتخاب تصویر از رسانه">
    <input type="button" id="remove_info_image_button" class="button" value="حذف تصویر"
        style="<?php echo $image_id ? '' : 'display:none;'; ?> margin-bottom: 10px;">
    <div id="info_image_preview" style="margin-top: 10px;">
        <?php if ($image_url): ?>
            <img src="<?php echo esc_url($image_url); ?>" style="max-width: 200px; height: auto;">
        <?php endif; ?>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('#upload_info_image_button').click(function () {
                var frame = wp.media({
                    title: 'انتخاب عکس کانتینر اطلاعات بیشتر',
                    library: { type: 'image' },
                    multiple: false
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#aboutus_info_image_id').val(attachment.id);
                    $('#aboutus_info_image_url').val(attachment.url);
                    $('#info_image_preview').html('<img src="' + attachment.url + '" style="max-width: 200px; height: auto;">');
                    $('#remove_info_image_button').show();
                });

                frame.open();
            });

            $('#remove_info_image_button').click(function () {
                $('#aboutus_info_image_id').val('');
                $('#aboutus_info_image_url').val('');
                $('#info_image_preview').html('');
                $(this).hide();
            });
        });
    </script>
    <?php
}

// تابع ذخیره‌سازی داده‌های متاباکس
function save_aboutus_metaboxes($post_id)
{
    if (!isset($_POST['aboutus_nonce']) || !wp_verify_nonce($_POST['aboutus_nonce'], 'aboutus_metabox_nonce')) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // ذخیره عکس کانتینر اطلاعات بیشتر
    if (isset($_POST['aboutus_info_image_id']) && !empty($_POST['aboutus_info_image_id'])) {
        update_post_meta($post_id, '_aboutus_info_image_id', absint($_POST['aboutus_info_image_id']));
    } else {
        delete_post_meta($post_id, '_aboutus_info_image_id');
    }
}
add_action('save_post', 'save_aboutus_metaboxes');

// افزودن متاباکس اطلاعات درباره ما
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

// کالبک متاباکس اطلاعات درباره ما
if (!function_exists('my_aboutus_metabox_callback')) {
    function my_aboutus_metabox_callback($post)
    {
        $sections = get_post_meta($post->ID, '_aboutus_info_sections', true);
        wp_nonce_field('my_aboutus_metabox_nonce', 'my_aboutus_nonce');
        ?>
        <div id="aboutus-sections-container">
            <?php
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

// ذخیره داده‌های متاباکس اطلاعات درباره ما
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

// افزودن متاباکس برای صفحه تماس
function my_custom_contact_location_metabox()
{
    global $post;

    if ($post && $post->post_name === 'contact') {
        add_meta_box(
            'my_location_metabox_id',
            'لوکیشن‌ها',
            'my_contact_location_metabox_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'my_custom_contact_location_metabox');

// کالبک متاباکس لوکیشن‌ها
function my_contact_location_metabox_callback($post)
{
    $location_neshan_address = get_post_meta($post->ID, '_location_neshan_address', true);
    $location_balad_address = get_post_meta($post->ID, '_location_balad_address', true);
    $location_waze_address = get_post_meta($post->ID, '_location_waze_address', true);
    $location_map_address = get_post_meta($post->ID, '_location_map_address', true);
    $location_brt_address = get_post_meta($post->ID, '_location_brt_address', true);
    $location_metro_address = get_post_meta($post->ID, '_location_metro_address', true);
    $location_image_address = get_post_meta($post->ID, '_location_image_address', true);

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
            <th><label for="location_brt_address">نزدیک‌ترین BRT</label></th>
            <td><textarea name="location_brt_address" id="location_brt_address" rows="4"
                    style="width:100%;"><?php echo esc_textarea($location_brt_address); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="location_metro_address">نزدیک‌ترین مترو</label></th>
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

// ذخیره داده‌های متاباکس لوکیشن
function save_my_contact_location_metabox($post_id)
{
    if (!isset($_POST['my_location_nonce']) || !wp_verify_nonce($_POST['my_location_nonce'], 'my_location_metabox_nonce')) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

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

    if (isset($_POST['location_brt_address'])) {
        update_post_meta($post_id, '_location_brt_address', sanitize_textarea_field($_POST['location_brt_address']));
    }

    if (isset($_POST['location_metro_address'])) {
        update_post_meta($post_id, '_location_metro_address', sanitize_textarea_field($_POST['location_metro_address']));
    }

    if (isset($_POST['location_image_address'])) {
        update_post_meta($post_id, '_location_image_address', esc_url_raw($_POST['location_image_address']));
    }
}
add_action('save_post', 'save_my_contact_location_metabox');


// بارگذاری رسانه‌نگار وردپرس برای آپلود فایل‌های صوتی
function enqueue_media_uploader()
{
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');

// افزودن متاباکس‌ها برای صفحه Landing
function my_custom_landing_metaboxes()
{
    global $post;
    if ($post && $post->post_type === 'page' && $post->post_name === 'landing') {
        // متاباکس برای گردونه
        add_meta_box(
            'landing_carousel_metabox',
            'گردونه',
            'landing_carousel_metabox_callback',
            'page',
            'normal',
            'high'
        );
        // متاباکس برای اسلایدر برندها
        add_meta_box(
            'landing_brands_slider_metabox',
            'قسمت اسلاید عکس برندها',
            'landing_brands_slider_metabox_callback',
            'page',
            'normal',
            'high'
        );
        // متاباکس برای چرا سایبریشو
        add_meta_box(
            'landing_why_cyberisho_metabox',
            'چرا طراحی سایت با سایبریشو',
            'landing_why_cyberisho_metabox_callback',
            'page',
            'normal',
            'high'
        );
        // متاباکس برای نمونه کارها
        add_meta_box(
            'landing_portfolio_metabox',
            'قسمت نمونه کارهای ما',
            'landing_portfolio_metabox_callback',
            'page',
            'normal',
            'high'
        );
        // متاباکس برای فرآیند و مراحل اجرا
        add_meta_box(
            'landing_process_steps_metabox',
            'فرآیند و مراحل اجرا',
            'landing_process_steps_metabox_callback',
            'page',
            'normal',
            'high'
        );
        // متاباکس برای پلن‌های قیمتی
        add_meta_box(
            'landing_pricing_plans_metabox',
            'پلن‌های قیمتی',
            'landing_pricing_plans_metabox_callback',
            'page',
            'normal',
            'high'
        );
        // متاباکس برای سوالات متداول
        add_meta_box(
            'landing_faq_metabox',
            'سوالات متداول',
            'landing_faq_metabox_callback',
            'page',
            'normal',
            'high'
        );
        // متاباکس برای اطلاعات محتوایی
        add_meta_box(
            'landing_content_info_metabox',
            'اطلاعاتی محتوایی',
            'landing_content_info_metabox_callback',
            'page',
            'normal',
            'high'
        );
        // متاباکس برای متن شعار آخر صفحه
        add_meta_box(
            'landing_slogan_footer_metabox',
            'متن شعار آخر صفحه',
            'landing_slogan_footer_metabox_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'my_custom_landing_metaboxes');

// کالبک برای متاباکس گردونه
function landing_carousel_metabox_callback($post)
{
    wp_nonce_field('landing_carousel_nonce', 'landing_carousel_nonce');
    $carousel_items = get_post_meta($post->ID, '_landing_carousel_items', true);
    $carousel_items_data = !empty($carousel_items) ? json_decode($carousel_items, true) : array_fill(0, 5, ['text' => '', 'audio_url' => '']);
    ?>
    <div class="landing-carousel-wrapper">
        <div class="landing-field-group">
            <h4>آیتم‌های گردونه</h4>
            <?php for ($i = 0; $i < 5; $i++): ?>
                <div class="carousel-item-group" data-index="<?php echo $i; ?>">
                    <div class="cyberisho-field">
                        <label>متن آیتم <?php echo $i + 1; ?></label>
                        <textarea name="carousel_items[<?php echo $i; ?>][text]"
                            style="width:100%; height:80px;"><?php echo esc_textarea($carousel_items_data[$i]['text'] ?? ''); ?></textarea>
                    </div>
                    <div class="cyberisho-field">
                        <label>ویس مربوط به آیتم <?php echo $i + 1; ?></label>
                        <div class="flex align-items-center">
                            <button type="button" class="button field-upload-audio"
                                data-input-id="carousel_items[<?php echo $i; ?>][audio_url]">انتخاب ویس</button>
                            <input value="<?php echo esc_url($carousel_items_data[$i]['audio_url'] ?? ''); ?>" type="text"
                                class="field-audio-url" name="carousel_items[<?php echo $i; ?>][audio_url]" readonly />
                            <div class="field-audio-container">
                                <?php if (!empty($carousel_items_data[$i]['audio_url'])): ?>
                                    <audio controls>
                                        <source src="<?php echo esc_url($carousel_items_data[$i]['audio_url']); ?>"
                                            type="audio/mpeg">
                                    </audio>
                                <?php endif; ?>
                            </div>
                            <a class="field-delete-audio <?php echo !empty($carousel_items_data[$i]['audio_url']) ? '' : 'hidden'; ?>"
                                href="#" data-input-id="carousel_items[<?php echo $i; ?>][audio_url]">حذف ویس</a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('.field-upload-audio').on('click', function (e) {
                e.preventDefault();
                var button = $(this);
                var inputId = button.data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = button.siblings('.field-audio-container');
                var deleteLink = button.siblings('.field-delete-audio');

                var frame = wp.media({
                    title: 'انتخاب فایل صوتی',
                    button: { text: 'انتخاب' },
                    multiple: false,
                    library: { type: 'audio' }
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    inputField.val(attachment.url);
                    audioContainer.html('<audio controls><source src="' + attachment.url + '" type="' + attachment.mime + '"></audio>');
                    deleteLink.removeClass('hidden');
                });

                frame.open();
            });

            $('.field-delete-audio').on('click', function (e) {
                e.preventDefault();
                var inputId = $(this).data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = $(this).siblings('.field-audio-container');
                inputField.val('');
                audioContainer.empty();
                $(this).addClass('hidden');
            });
        });
    </script>
    <style>
        .landing-carousel-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-carousel-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .carousel-item-group {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
    </style>
    <?php
}

// کالبک برای متاباکس اسلایدر برندها
function landing_brands_slider_metabox_callback($post)
{
    wp_nonce_field('landing_brands_slider_nonce', 'landing_brands_slider_nonce');
    $projects_count = get_post_meta($post->ID, '_landing_projects_count', true);
    $slogan_text = get_post_meta($post->ID, '_landing_slogan_text', true);
    ?>
    <div class="landing-brands-slider-wrapper">
        <div class="landing-field-group">
            <label for="projects_count">تعداد پروژه‌ها</label>
            <input type="text" name="projects_count" id="projects_count" value="<?php echo esc_attr($projects_count); ?>"
                style="width:100%;" />
        </div>
        <div class="landing-field-group">
            <label for="slogan_text">متن شعار کنار عکس برندها</label>
            <textarea name="slogan_text" id="slogan_text"
                style="width:100%; height:80px;"><?php echo esc_textarea($slogan_text); ?></textarea>
        </div>
    </div>
    <style>
        .landing-brands-slider-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-brands-slider-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
    <?php
}

// کالبک برای متاباکس چرا سایبریشو
function landing_why_cyberisho_metabox_callback($post)
{
    wp_nonce_field('landing_why_cyberisho_nonce', 'landing_why_cyberisho_nonce');
    $why_audio_url = get_post_meta($post->ID, '_landing_why_audio_url', true);
    $why_items = get_post_meta($post->ID, '_landing_why_items', true);
    $why_items_data = !empty($why_items) ? json_decode($why_items, true) : array();
    ?>
    <div class="landing-why-cyberisho-wrapper">
        <!-- Audio Upload -->
        <div class="landing-field-group">
            <label for="why_audio_url">ویس مربوط به چرا طراحی سایت با سایبریشو</label>
            <div class="flex align-items-center">
                <button type="button" class="button field-upload-audio" data-input-id="why_audio_url">انتخاب ویس</button>
                <input value="<?php echo esc_url($why_audio_url); ?>" type="text" class="field-audio-url"
                    name="why_audio_url" readonly />
                <div class="field-audio-container">
                    <?php if ($why_audio_url): ?>
                        <audio controls>
                            <source src="<?php echo esc_url($why_audio_url); ?>" type="audio/mpeg">
                        </audio>
                    <?php endif; ?>
                </div>
                <a class="field-delete-audio <?php echo $why_audio_url ? '' : 'hidden'; ?>" href="#"
                    data-input-id="why_audio_url">حذف ویس</a>
            </div>
        </div>
        <!-- Why Items -->
        <div class="landing-field-group">
            <h4>آیتم‌های چرا طراحی سایت با سایبریشو</h4>
            <button type="button" class="button add-why-item-btn">افزودن آیتم جدید</button>
            <div class="why-items-container">
                <?php
                if (!empty($why_items_data)):
                    foreach ($why_items_data as $index => $item):
                        ?>
                        <div class="why-item-group" data-index="<?php echo $index; ?>">
                            <div class="cyberisho-field">
                                <label>متن SVG آیتم <?php echo $index + 1; ?></label>
                                <textarea name="why_items[<?php echo $index; ?>][svg]"
                                    style="width:100%; height:80px;"><?php echo esc_textarea($item['svg'] ?? ''); ?></textarea>
                            </div>
                            <div class="cyberisho-field">
                                <label>تایتل آیتم <?php echo $index + 1; ?></label>
                                <input type="text" name="why_items[<?php echo $index; ?>][title]"
                                    value="<?php echo esc_attr($item['title'] ?? ''); ?>" style="width:100%;" />
                            </div>
                            <div class="cyberisho-field">
                                <label>متن آیتم <?php echo $index + 1; ?></label>
                                <textarea name="why_items[<?php echo $index; ?>][text]"
                                    style="width:100%; height:80px;"><?php echo esc_textarea($item['text'] ?? ''); ?></textarea>
                            </div>
                            <button type="button" class="button remove-why-item-btn" style="color: red; margin-top: 10px;">حذف
                                آیتم</button>
                        </div>
                        <?php
                    endforeach;
                else:
                    for ($i = 0; $i < 4; $i++):
                        ?>
                        <div class="why-item-group" data-index="<?php echo $i; ?>">
                            <div class="cyberisho-field">
                                <label>متن SVG آیتم <?php echo $i + 1; ?></label>
                                <textarea name="why_items[<?php echo $i; ?>][svg]" style="width:100%; height:80px;"></textarea>
                            </div>
                            <div class="cyberisho-field">
                                <label>تایتل آیتم <?php echo $i + 1; ?></label>
                                <input type="text" name="why_items[<?php echo $i; ?>][title]" value="" style="width:100%;" />
                            </div>
                            <div class="cyberisho-field">
                                <label>متن آیتم <?php echo $i + 1; ?></label>
                                <textarea name="why_items[<?php echo $i; ?>][text]" style="width:100%; height:80px;"></textarea>
                            </div>
                            <button type="button" class="button remove-why-item-btn" style="color: red; margin-top: 10px;">حذف
                                آیتم</button>
                        </div>
                        <?php
                    endfor;
                endif;
                ?>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            var maxItems = 10; // Maximum 10 items, minimum 4
            var itemCount = $('.why-item-group').length;
            $('.add-why-item-btn').on('click', function () {
                if (itemCount >= maxItems) {
                    alert('حداکثر 10 آیتم مجاز است.');
                    return;
                }
                var newItem = `
                    <div class="why-item-group" data-index="${itemCount}">
                        <div class="cyberisho-field">
                            <label>متن SVG آیتم ${itemCount + 1}</label>
                            <textarea name="why_items[${itemCount}][svg]" style="width:100%; height:80px;"></textarea>
                        </div>
                        <div class="cyberisho-field">
                            <label>تایتل آیتم ${itemCount + 1}</label>
                            <input type="text" name="why_items[${itemCount}][title]" style="width:100%;" />
                        </div>
                        <div class="cyberisho-field">
                            <label>متن آیتم ${itemCount + 1}</label>
                            <textarea name="why_items[${itemCount}][text]" style="width:100%; height:80px;"></textarea>
                        </div>
                        <button type="button" class="button remove-why-item-btn" style="color: red; margin-top: 10px;">حذف آیتم</button>
                    </div>
                `;
                $('.why-items-container').append(newItem);
                itemCount++;
            });
            $(document).on('click', '.remove-why-item-btn', function () {
                if (itemCount <= 4) {
                    alert('حداقل 4 آیتم باید وجود داشته باشد.');
                    return;
                }
                if (confirm('آیا از حذف این آیتم مطمئن هستید؟')) {
                    $(this).closest('.why-item-group').remove();
                    itemCount--;
                    updateWhyItemIndexes();
                }
            });
            function updateWhyItemIndexes() {
                $('.why-item-group').each(function (index) {
                    $(this).attr('data-index', index);
                    $(this).find('label').each(function () {
                        var text = $(this).text().replace(/\d+$/, index + 1);
                        $(this).text(text);
                    });
                    $(this).find('[name^="why_items"]').each(function () {
                        var name = $(this).attr('name').replace(/why_items\[\d+\]/, `why_items[${index}]`);
                        $(this).attr('name', name);
                    });
                });
            }
            // مدیریت آپلود ویس برای چرا سایبریشو
            $('.field-upload-audio').on('click', function (e) {
                e.preventDefault();
                var button = $(this);
                var inputId = button.data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = button.siblings('.field-audio-container');
                var deleteLink = button.siblings('.field-delete-audio');

                var frame = wp.media({
                    title: 'انتخاب فایل صوتی',
                    button: { text: 'انتخاب' },
                    multiple: false,
                    library: { type: 'audio' }
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    inputField.val(attachment.url);
                    audioContainer.html('<audio controls><source src="' + attachment.url + '" type="' + attachment.mime + '"></audio>');
                    deleteLink.removeClass('hidden');
                });

                frame.open();
            });

            $('.field-delete-audio').on('click', function (e) {
                e.preventDefault();
                var inputId = $(this).data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = $(this).siblings('.field-audio-container');
                inputField.val('');
                audioContainer.empty();
                $(this).addClass('hidden');
            });
        });
    </script>
    <style>
        .landing-why-cyberisho-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-why-cyberisho-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .why-item-group {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .why-items-container {
            margin-top: 20px;
        }
    </style>
    <?php
}

// کالبک برای متاباکس نمونه کارها
function landing_portfolio_metabox_callback($post)
{
    wp_nonce_field('landing_portfolio_nonce', 'landing_portfolio_nonce');
    $portfolio_audio_url = get_post_meta($post->ID, '_landing_portfolio_audio_url', true);
    ?>
    <div class="landing-portfolio-wrapper">
        <div class="landing-field-group">
            <label for="portfolio_audio_url">ویس مربوط به نمونه کارهای ما</label>
            <div class="flex align-items-center">
                <button type="button" class="button field-upload-audio" data-input-id="portfolio_audio_url">انتخاب
                    ویس</button>
                <input value="<?php echo esc_url($portfolio_audio_url); ?>" type="text" class="field-audio-url"
                    name="portfolio_audio_url" readonly />
                <div class="field-audio-container">
                    <?php if ($portfolio_audio_url): ?>
                        <audio controls>
                            <source src="<?php echo esc_url($portfolio_audio_url); ?>" type="audio/mpeg">
                        </audio>
                    <?php endif; ?>
                </div>
                <a class="field-delete-audio <?php echo $portfolio_audio_url ? '' : 'hidden'; ?>" href="#"
                    data-input-id="portfolio_audio_url">حذف ویس</a>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('.field-upload-audio').on('click', function (e) {
                e.preventDefault();
                var button = $(this);
                var inputId = button.data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = button.siblings('.field-audio-container');
                var deleteLink = button.siblings('.field-delete-audio');

                var frame = wp.media({
                    title: 'انتخاب فایل صوتی',
                    button: { text: 'انتخاب' },
                    multiple: false,
                    library: { type: 'audio' }
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    inputField.val(attachment.url);
                    audioContainer.html('<audio controls><source src="' + attachment.url + '" type="' + attachment.mime + '"></audio>');
                    deleteLink.removeClass('hidden');
                });

                frame.open();
            });

            $('.field-delete-audio').on('click', function (e) {
                e.preventDefault();
                var inputId = $(this).data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = $(this).siblings('.field-audio-container');
                inputField.val('');
                audioContainer.empty();
                $(this).addClass('hidden');
            });
        });
    </script>
    <style>
        .landing-portfolio-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-portfolio-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
    <?php
}

// کالبک برای متاباکس فرآیند و مراحل اجرا
function landing_process_steps_metabox_callback($post)
{
    wp_nonce_field('landing_process_steps_nonce', 'landing_process_steps_nonce');
    $process_audio_url = get_post_meta($post->ID, '_landing_process_audio_url', true);
    $process_steps = get_post_meta($post->ID, '_landing_process_steps', true);
    $process_steps_data = !empty($process_steps) ? json_decode($process_steps, true) : array_fill(0, 4, '');
    ?>
    <div class="landing-process-steps-wrapper">
        <div class="landing-field-group">
            <label for="process_audio_url">ویس مربوط به فرآیند و مراحل اجرا</label>
            <div class="flex align-items-center">
                <button type="button" class="button field-upload-audio" data-input-id="process_audio_url">انتخاب
                    ویس</button>
                <input value="<?php echo esc_url($process_audio_url); ?>" type="text" class="field-audio-url"
                    name="process_audio_url" readonly />
                <div class="field-audio-container">
                    <?php if ($process_audio_url): ?>
                        <audio controls>
                            <source src="<?php echo esc_url($process_audio_url); ?>" type="audio/mpeg">
                        </audio>
                    <?php endif; ?>
                </div>
                <a class="field-delete-audio <?php echo $process_audio_url ? '' : 'hidden'; ?>" href="#"
                    data-input-id="process_audio_url">حذف ویس</a>
            </div>
        </div>
        <div class="landing-field-group">
            <h4>مراحل اجرا</h4>
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="process-step-group">
                    <label for="process_step_<?php echo $i; ?>">مرحله اجرا <?php echo $i + 1; ?></label>
                    <textarea name="process_steps[<?php echo $i; ?>]" id="process_step_<?php echo $i; ?>"
                        style="width:100%; height:80px;"><?php echo esc_textarea($process_steps_data[$i] ?? ''); ?></textarea>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('.field-upload-audio').on('click', function (e) {
                e.preventDefault();
                var button = $(this);
                var inputId = button.data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = button.siblings('.field-audio-container');
                var deleteLink = button.siblings('.field-delete-audio');

                var frame = wp.media({
                    title: 'انتخاب فایل صوتی',
                    button: { text: 'انتخاب' },
                    multiple: false,
                    library: { type: 'audio' }
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    inputField.val(attachment.url);
                    audioContainer.html('<audio controls><source src="' + attachment.url + '" type="' + attachment.mime + '"></audio>');
                    deleteLink.removeClass('hidden');
                });

                frame.open();
            });

            $('.field-delete-audio').on('click', function (e) {
                e.preventDefault();
                var inputId = $(this).data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = $(this).siblings('.field-audio-container');
                inputField.val('');
                audioContainer.empty();
                $(this).addClass('hidden');
            });
        });
    </script>
    <style>
        .landing-process-steps-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-process-steps-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .process-step-group {
            margin-bottom: 15px;
        }
    </style>
    <?php
}

// کالبک برای متاباکس پلن‌های قیمتی
function landing_pricing_plans_metabox_callback($post)
{
    wp_nonce_field('landing_pricing_plans_nonce', 'landing_pricing_plans_nonce');
    $pricing_audio_url = get_post_meta($post->ID, '_landing_pricing_audio_url', true);
    $pricing_plans = get_post_meta($post->ID, '_landing_pricing_plans', true);
    $pricing_plans_data = !empty($pricing_plans) ? json_decode($pricing_plans, true) : array_fill(0, 3, ['title' => '', 'features' => array_fill(0, 4, ''), 'footer' => '']);
    ?>
    <div class="landing-pricing-plans-wrapper">
        <!-- Audio Upload -->
        <div class="landing-field-group">
            <label for="pricing_audio_url">ویس مربوط به پلن‌های قیمتی ما</label>
            <div class="flex align-items-center">
                <button type="button" class="button field-upload-audio" data-input-id="pricing_audio_url">انتخاب
                    ویس</button>
                <input value="<?php echo esc_url($pricing_audio_url); ?>" type="text" class="field-audio-url"
                    name="pricing_audio_url" readonly />
                <div class="field-audio-container">
                    <?php if ($pricing_audio_url): ?>
                        <audio controls>
                            <source src="<?php echo esc_url($pricing_audio_url); ?>" type="audio/mpeg">
                        </audio>
                    <?php endif; ?>
                </div>
                <a class="field-delete-audio <?php echo $pricing_audio_url ? '' : 'hidden'; ?>" href="#"
                    data-input-id="pricing_audio_url">حذف ویس</a>
            </div>
        </div>
        <!-- Pricing Plans -->
        <div class="landing-field-group">
            <h4>پلن‌های قیمتی</h4>
            <?php for ($i = 0; $i < 3; $i++): ?>
                <div class="pricing-plan-group" data-index="<?php echo $i; ?>">
                    <h5>پلن قیمتی <?php echo $i + 1; ?></h5>
                    <div class="cyberisho-field">
                        <label>تایتل پلن قیمتی <?php echo $i + 1; ?></label>
                        <input type="text" name="pricing_plans[<?php echo $i; ?>][title]"
                            value="<?php echo esc_attr($pricing_plans_data[$i]['title'] ?? ''); ?>" style="width:100%;" />
                    </div>
                    <div class="cyberisho-field">
                        <label>امکانات پلن <?php echo $i + 1; ?></label>
                        <button type="button" class="button add-feature-btn" data-plan-index="<?php echo $i; ?>">افزودن خصوصیت
                            جدید</button>
                        <div class="features-container" data-plan-index="<?php echo $i; ?>">
                            <?php
                            $features = $pricing_plans_data[$i]['features'] ?? array_fill(0, 4, '');
                            foreach ($features as $index => $feature):
                                ?>
                                <div class="feature-group" data-index="<?php echo $index; ?>">
                                    <label>خصوصیت <?php echo $index + 1; ?></label>
                                    <textarea name="pricing_plans[<?php echo $i; ?>][features][<?php echo $index; ?>]"
                                        style="width:100%; height:60px;"><?php echo esc_textarea($feature); ?></textarea>
                                    <button type="button" class="button remove-feature-btn"
                                        style="color: red; margin-top: 10px;">حذف خصوصیت</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="cyberisho-field">
                        <label>متن فوتر پلن <?php echo $i + 1; ?></label>
                        <textarea name="pricing_plans[<?php echo $i; ?>][footer]"
                            style="width:100%; height:80px;"><?php echo esc_textarea($pricing_plans_data[$i]['footer'] ?? ''); ?></textarea>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('.add-feature-btn').on('click', function () {
                var planIndex = $(this).data('plan-index');
                var container = $(this).siblings('.features-container[data-plan-index="' + planIndex + '"]');
                var featureCount = container.find('.feature-group').length;
                var newFeature = `
                    <div class="feature-group" data-index="${featureCount}">
                        <label>خصوصیت ${featureCount + 1}</label>
                        <textarea name="pricing_plans[${planIndex}][features][${featureCount}]" style="width:100%; height:60px;"></textarea>
                        <button type="button" class="button remove-feature-btn" style="color: red; margin-top: 10px;">حذف خصوصیت</button>
                    </div>
                `;
                container.append(newFeature);
                updateFeatureIndexes(container, planIndex);
            });
            $(document).on('click', '.remove-feature-btn', function () {
                var container = $(this).closest('.features-container');
                var planIndex = container.data('plan-index');
                var featureCount = container.find('.feature-group').length;
                if (featureCount <= 4) {
                    alert('حداقل 4 خصوصیت باید وجود داشته باشد.');
                    return;
                }
                if (confirm('آیا از حذف این خصوصیت مطمئن هستید؟')) {
                    $(this).closest('.feature-group').remove();
                    updateFeatureIndexes(container, planIndex);
                }
            });
            function updateFeatureIndexes(container, planIndex) {
                container.find('.feature-group').each(function (index) {
                    $(this).attr('data-index', index);
                    $(this).find('label').text(`خصوصیت ${index + 1}`);
                    $(this).find('textarea').attr('name', `pricing_plans[${planIndex}][features][${index}]`);
                });
            }
            // مدیریت آپلود ویس برای پلن‌های قیمتی
            $('.field-upload-audio').on('click', function (e) {
                e.preventDefault();
                var button = $(this);
                var inputId = button.data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = button.siblings('.field-audio-container');
                var deleteLink = button.siblings('.field-delete-audio');

                var frame = wp.media({
                    title: 'انتخاب فایل صوتی',
                    button: { text: 'انتخاب' },
                    multiple: false,
                    library: { type: 'audio' }
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    inputField.val(attachment.url);
                    audioContainer.html('<audio controls><source src="' + attachment.url + '" type="' + attachment.mime + '"></audio>');
                    deleteLink.removeClass('hidden');
                });

                frame.open();
            });

            $('.field-delete-audio').on('click', function (e) {
                e.preventDefault();
                var inputId = $(this).data('input-id');
                var inputField = $('input[name="' + inputId + '"]');
                var audioContainer = $(this).siblings('.field-audio-container');
                inputField.val('');
                audioContainer.empty();
                $(this).addClass('hidden');
            });
        });
    </script>
    <style>
        .landing-pricing-plans-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-pricing-plans-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .pricing-plan-group {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .pricing-plan-group h5 {
            margin: 0 0 15px;
        }

        .features-container {
            margin-top: 15px;
        }

        .feature-group {
            margin-bottom: 15px;
        }
    </style>
    <?php
}

// کالبک برای متاباکس سوالات متداول
function landing_faq_metabox_callback($post)
{
    wp_nonce_field('landing_faq_nonce', 'landing_faq_nonce');
    $faq_items = get_post_meta($post->ID, '_landing_faq_items', true);
    $faq_items_data = !empty($faq_items) ? json_decode($faq_items, true) : array();
    ?>
    <div class="landing-faq-wrapper">
        <div class="landing-field-group">
            <h4>سوالات متداول</h4>
            <button type="button" class="button add-faq-item-btn">افزودن سوال جدید</button>
            <div class="faq-items-container">
                <?php
                if (!empty($faq_items_data)):
                    foreach ($faq_items_data as $index => $item):
                        ?>
                        <div class="faq-item-group" data-index="<?php echo $index; ?>">
                            <div class="cyberisho-field">
                                <label>تایتل سوال <?php echo $index + 1; ?></label>
                                <input type="text" name="faq_items[<?php echo $index; ?>][title]"
                                    value="<?php echo esc_attr($item['title'] ?? ''); ?>" style="width:100%;" />
                            </div>
                            <div class="cyberisho-field">
                                <label>محتوای سوال <?php echo $index + 1; ?></label>
                                <textarea name="faq_items[<?php echo $index; ?>][content]"
                                    style="width:100%; height:80px;"><?php echo esc_textarea($item['content'] ?? ''); ?></textarea>
                            </div>
                            <button type="button" class="button remove-faq-item-btn" style="color: red; margin-top: 10px;">حذف
                                سوال</button>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            var maxFaqItems = 20; // Maximum 20 FAQ items
            var faqItemCount = $('.faq-item-group').length;
            $('.add-faq-item-btn').on('click', function () {
                if (faqItemCount >= maxFaqItems) {
                    alert('حداکثر 20 سوال مجاز است.');
                    return;
                }
                var newFaqItem = `
                    <div class="faq-item-group" data-index="${faqItemCount}">
                        <div class="cyberisho-field">
                            <label>تایتل سوال ${faqItemCount + 1}</label>
                            <input type="text" name="faq_items[${faqItemCount}][title]" style="width:100%;" />
                        </div>
                        <div class="cyberisho-field">
                            <label>محتوای سوال ${faqItemCount + 1}</label>
                            <textarea name="faq_items[${faqItemCount}][content]" style="width:100%; height:80px;"></textarea>
                        </div>
                        <button type="button" class="button remove-faq-item-btn" style="color: red; margin-top: 10px;">حذف سوال</button>
                    </div>
                `;
                $('.faq-items-container').append(newFaqItem);
                faqItemCount++;
            });
            $(document).on('click', '.remove-faq-item-btn', function () {
                if (confirm('آیا از حذف این سوال مطمئن هستید؟')) {
                    $(this).closest('.faq-item-group').remove();
                    updateFaqItemIndexes();
                }
            });
            function updateFaqItemIndexes() {
                $('.faq-item-group').each(function (index) {
                    $(this).attr('data-index', index);
                    $(this).find('label').each(function () {
                        var text = $(this).text().replace(/\d+$/, index + 1);
                        $(this).text(text);
                    });
                    $(this).find('[name^="faq_items"]').each(function () {
                        var name = $(this).attr('name').replace(/faq_items\[\d+\]/, `faq_items[${index}]`);
                        $(this).attr('name', name);
                    });
                });
                faqItemCount = $('.faq-item-group').length;
            }
        });
    </script>
    <style>
        .landing-faq-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-faq-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .faq-item-group {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .faq-items-container {
            margin-top: 20px;
        }
    </style>
    <?php
}

// کالبک برای متاباکس اطلاعات محتوایی
function landing_content_info_metabox_callback($post)
{
    wp_nonce_field('landing_content_info_nonce', 'landing_content_info_nonce');
    $content_info = get_post_meta($post->ID, '_landing_content_info', true);
    $settings = array(
        'textarea_name' => 'content_info',
        'media_buttons' => false,
        'textarea_rows' => 15,
        'teeny' => false,
        'tinymce' => array(
            'valid_elements' => 'p,h2,h3,h4,h5,li,ul,strong,b,em,i'
        ),
        'quicktags' => array(
            'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,p,h2,h3,h4,h5'
        )
    );
    ?>
    <div class="landing-content-info-wrapper">
        <div class="landing-field-group">
            <label>اطلاعاتی محتوایی</label>
            <?php wp_editor($content_info, 'content_info', $settings); ?>
        </div>
    </div>
    <style>
        .landing-content-info-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-content-info-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
    <?php
}

// کالبک برای متاباکس متن شعار آخر صفحه
function landing_slogan_footer_metabox_callback($post)
{
    wp_nonce_field('landing_slogan_footer_nonce', 'landing_slogan_footer_nonce');
    $slogan_footer_title = get_post_meta($post->ID, '_landing_slogan_footer_title', true);
    $slogan_footer_content = get_post_meta($post->ID, '_landing_slogan_footer_content', true);
    $settings = array(
        'textarea_name' => 'slogan_footer_content',
        'media_buttons' => false,
        'textarea_rows' => 10,
        'teeny' => false,
        'tinymce' => array(
            'valid_elements' => 'p,h2,h3,h4,h5,li,ul,strong,b,em,i'
        ),
        'quicktags' => array(
            'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,p,h2,h3,h4,h5'
        )
    );
    ?>
    <div class="landing-slogan-footer-wrapper">
        <div class="landing-field-group">
            <label for="slogan_footer_title">تایتل</label>
            <input type="text" name="slogan_footer_title" id="slogan_footer_title"
                value="<?php echo esc_attr($slogan_footer_title); ?>" style="width:100%;" />
        </div>
        <div class="landing-field-group">
            <label>محتوا</label>
            <?php wp_editor($slogan_footer_content, 'slogan_footer_content', $settings); ?>
        </div>
    </div>
    <style>
        .landing-slogan-footer-wrapper .landing-field-group {
            margin-bottom: 20px;
        }

        .landing-slogan-footer-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
    <?php
}

// ذخیره داده‌های متاباکس‌ها
function save_my_landing_metaboxes($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // بررسی نانس‌ها
    if (
        (isset($_POST['landing_carousel_nonce']) && !wp_verify_nonce($_POST['landing_carousel_nonce'], 'landing_carousel_nonce')) ||
        (isset($_POST['landing_brands_slider_nonce']) && !wp_verify_nonce($_POST['landing_brands_slider_nonce'], 'landing_brands_slider_nonce')) ||
        (isset($_POST['landing_why_cyberisho_nonce']) && !wp_verify_nonce($_POST['landing_why_cyberisho_nonce'], 'landing_why_cyberisho_nonce')) ||
        (isset($_POST['landing_portfolio_nonce']) && !wp_verify_nonce($_POST['landing_portfolio_nonce'], 'landing_portfolio_nonce')) ||
        (isset($_POST['landing_process_steps_nonce']) && !wp_verify_nonce($_POST['landing_process_steps_nonce'], 'landing_process_steps_nonce')) ||
        (isset($_POST['landing_pricing_plans_nonce']) && !wp_verify_nonce($_POST['landing_pricing_plans_nonce'], 'landing_pricing_plans_nonce')) ||
        (isset($_POST['landing_faq_nonce']) && !wp_verify_nonce($_POST['landing_faq_nonce'], 'landing_faq_nonce')) ||
        (isset($_POST['landing_content_info_nonce']) && !wp_verify_nonce($_POST['landing_content_info_nonce'], 'landing_content_info_nonce')) ||
        (isset($_POST['landing_slogan_footer_nonce']) && !wp_verify_nonce($_POST['landing_slogan_footer_nonce'], 'landing_slogan_footer_nonce'))
    ) {
        return;
    }
    // بررسی مجوز کاربر
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }
    // ذخیره گردونه
    if (isset($_POST['carousel_items']) && is_array($_POST['carousel_items'])) {
        $carousel_items = array_map(function ($item) {
            $text = isset($item['text']) ? sanitize_textarea_field($item['text']) : '';
            $audio_url = isset($item['audio_url']) ? esc_url_raw($item['audio_url']) : '';
            // اعتبارسنجی URL
            if (!empty($audio_url) && filter_var($audio_url, FILTER_VALIDATE_URL)) {
                return [
                    'text' => $text,
                    'audio_url' => $audio_url
                ];
            }
            return [
                'text' => $text,
                'audio_url' => ''
            ];
        }, $_POST['carousel_items']);
        update_post_meta($post_id, '_landing_carousel_items', wp_json_encode($carousel_items, JSON_UNESCAPED_UNICODE));
    } else {
        // به جای حذف، آرایه پیش‌فرض ذخیره شود
        update_post_meta($post_id, '_landing_carousel_items', wp_json_encode(array_fill(0, 5, ['text' => '', 'audio_url' => '']), JSON_UNESCAPED_UNICODE));
    }
    // ذخیره اسلایدر برندها
    if (isset($_POST['projects_count'])) {
        update_post_meta($post_id, '_landing_projects_count', sanitize_text_field($_POST['projects_count']));
    } else {
        delete_post_meta($post_id, '_landing_projects_count');
    }
    if (isset($_POST['slogan_text'])) {
        update_post_meta($post_id, '_landing_slogan_text', sanitize_textarea_field($_POST['slogan_text']));
    } else {
        delete_post_meta($post_id, '_landing_slogan_text');
    }
    // ذخیره چرا سایبریشو
    if (isset($_POST['why_audio_url'])) {
        $why_audio_url = esc_url_raw($_POST['why_audio_url']);
        if (filter_var($why_audio_url, FILTER_VALIDATE_URL)) {
            update_post_meta($post_id, '_landing_why_audio_url', $why_audio_url);
        } else {
            delete_post_meta($post_id, '_landing_why_audio_url');
        }
    } else {
        delete_post_meta($post_id, '_landing_why_audio_url');
    }
    if (isset($_POST['why_items'])) {
        $why_items = array_map(function ($item) {
            return [
                'svg' => $item['svg'] ?? '',
                'title' => sanitize_text_field($item['title'] ?? ''),
                'text' => sanitize_textarea_field($item['text'] ?? '')
            ];
        }, $_POST['why_items']);
        update_post_meta($post_id, '_landing_why_items', wp_json_encode($why_items, JSON_UNESCAPED_UNICODE));
    } else {
        delete_post_meta($post_id, '_landing_why_items');
    }
    // ذخیره نمونه کارها
    if (isset($_POST['portfolio_audio_url'])) {
        $portfolio_audio_url = esc_url_raw($_POST['portfolio_audio_url']);
        if (filter_var($portfolio_audio_url, FILTER_VALIDATE_URL)) {
            update_post_meta($post_id, '_landing_portfolio_audio_url', $portfolio_audio_url);
        } else {
            delete_post_meta($post_id, '_landing_portfolio_audio_url');
        }
    } else {
        delete_post_meta($post_id, '_landing_portfolio_audio_url');
    }
    // ذخیره فرآیند و مراحل اجرا
    if (isset($_POST['process_audio_url'])) {
        $process_audio_url = esc_url_raw($_POST['process_audio_url']);
        if (filter_var($process_audio_url, FILTER_VALIDATE_URL)) {
            update_post_meta($post_id, '_landing_process_audio_url', $process_audio_url);
        } else {
            delete_post_meta($post_id, '_landing_process_audio_url');
        }
    } else {
        delete_post_meta($post_id, '_landing_process_audio_url');
    }
    if (isset($_POST['process_steps'])) {
        $process_steps = array_map('sanitize_textarea_field', $_POST['process_steps']);
        update_post_meta($post_id, '_landing_process_steps', wp_json_encode($process_steps, JSON_UNESCAPED_UNICODE));
    } else {
        delete_post_meta($post_id, '_landing_process_steps');
    }
    // ذخیره پلن‌های قیمتی
    if (isset($_POST['pricing_audio_url'])) {
        $pricing_audio_url = esc_url_raw($_POST['pricing_audio_url']);
        if (filter_var($pricing_audio_url, FILTER_VALIDATE_URL)) {
            update_post_meta($post_id, '_landing_pricing_audio_url', $pricing_audio_url);
        } else {
            delete_post_meta($post_id, '_landing_pricing_audio_url');
        }
    } else {
        delete_post_meta($post_id, '_landing_pricing_audio_url');
    }
    if (isset($_POST['pricing_plans'])) {
        $pricing_plans = array_map(function ($plan) {
            $features = array_map('sanitize_textarea_field', $plan['features'] ?? array_fill(0, 4, ''));
            return [
                'title' => sanitize_text_field($plan['title'] ?? ''),
                'features' => array_slice($features, 0, 20), // محدود به 20 خصوصیت برای ایمنی
                'footer' => sanitize_textarea_field($plan['footer'] ?? '')
            ];
        }, $_POST['pricing_plans']);
        update_post_meta($post_id, '_landing_pricing_plans', wp_json_encode($pricing_plans, JSON_UNESCAPED_UNICODE));
    } else {
        delete_post_meta($post_id, '_landing_pricing_plans');
    }
    // ذخیره سوالات متداول
    if (isset($_POST['faq_items'])) {
        $faq_items = array_map(function ($item) {
            return [
                'title' => sanitize_text_field($item['title'] ?? ''),
                'content' => sanitize_textarea_field($item['content'] ?? '')
            ];
        }, $_POST['faq_items']);
        update_post_meta($post_id, '_landing_faq_items', wp_json_encode($faq_items, JSON_UNESCAPED_UNICODE));
    } else {
        delete_post_meta($post_id, '_landing_faq_items');
    }
    // ذخیره اطلاعات محتوایی
    if (isset($_POST['content_info'])) {
        $allowed_tags = wp_kses_allowed_html('post');
        $allowed_tags = array_intersect_key($allowed_tags, array_flip(['p', 'h2', 'h3', 'h4', 'h5', 'li', 'ul', 'strong', 'b', 'em', 'i']));
        update_post_meta($post_id, '_landing_content_info', wp_kses($_POST['content_info'], $allowed_tags));
    } else {
        delete_post_meta($post_id, '_landing_content_info');
    }
    // ذخیره متن شعار آخر صفحه
    if (isset($_POST['slogan_footer_title'])) {
        update_post_meta($post_id, '_landing_slogan_footer_title', sanitize_text_field($_POST['slogan_footer_title']));
    } else {
        delete_post_meta($post_id, '_landing_slogan_footer_title');
    }
    if (isset($_POST['slogan_footer_content'])) {
        $allowed_tags = wp_kses_allowed_html('post');
        $allowed_tags = array_intersect_key($allowed_tags, array_flip(['p', 'h2', 'h3', 'h4', 'h5', 'li', 'ul', 'strong', 'b', 'em', 'i']));
        update_post_meta($post_id, '_landing_slogan_footer_content', wp_kses($_POST['slogan_footer_content'], $allowed_tags));
    } else {
        delete_post_meta($post_id, '_landing_slogan_footer_content');
    }
}
add_action('save_post', 'save_my_landing_metaboxes');

// نمایش پیام‌های خطا برای URLهای نامعتبر
add_action('admin_notices', function () {
    if (isset($_POST['carousel_items']) && is_array($_POST['carousel_items'])) {
        foreach ($_POST['carousel_items'] as $index => $item) {
            if (!empty($item['audio_url']) && !filter_var($item['audio_url'], FILTER_VALIDATE_URL)) {
                echo '<div class="error"><p>خطا: آدرس فایل صوتی آیتم ' . ($index + 1) . ' نامعتبر است.</p></div>';
            }
        }
    }
    if (isset($_POST['why_audio_url']) && !empty($_POST['why_audio_url']) && !filter_var($_POST['why_audio_url'], FILTER_VALIDATE_URL)) {
        echo '<div class="error"><p>خطا: آدرس فایل صوتی بخش "چرا سایبریشو" نامعتبر است.</p></div>';
    }
    if (isset($_POST['portfolio_audio_url']) && !empty($_POST['portfolio_audio_url']) && !filter_var($_POST['portfolio_audio_url'], FILTER_VALIDATE_URL)) {
        echo '<div class="error"><p>خطا: آدرس فایل صوتی بخش "نمونه کارها" نامعتبر است.</p></div>';
    }
    if (isset($_POST['process_audio_url']) && !empty($_POST['process_audio_url']) && !filter_var($_POST['process_audio_url'], FILTER_VALIDATE_URL)) {
        echo '<div class="error"><p>خطا: آدرس فایل صوتی بخش "فرآیند و مراحل اجرا" نامعتبر است.</p></div>';
    }
    if (isset($_POST['pricing_audio_url']) && !empty($_POST['pricing_audio_url']) && !filter_var($_POST['pricing_audio_url'], FILTER_VALIDATE_URL)) {
        echo '<div class="error"><p>خطا: آدرس فایل صوتی بخش "پلن‌های قیمتی" نامعتبر است.</p></div>';
    }
});

function allow_svg_tags($tags)
{
    $tags['svg'] = array(
        'class' => true,
        'width' => true,
        'height' => true,
        'viewbox' => true,
        'xmlns' => true,
        'fill' => true,
    );
    $tags['path'] = array(
        'fill' => true,
        'opacity' => true,
        'd' => true,
    );
    return $tags;
}
add_filter('wp_kses_allowed_html', 'allow_svg_tags', 10, 2);
function my_employment_page_metabox()
{
    global $post;

    if ($post && $post->post_name === 'employment') {
        // متاباکس برای ردیف‌های شغلی
        add_meta_box(
            'employment_positions_metabox',
            'ردیف‌های شغلی',
            'employment_positions_metabox_callback',
            'page',
            'normal',
            'high'
        );

        // متاباکس برای شرایط عمومی
        add_meta_box(
            'employment_general_conditions_metabox',
            'شرایط عمومی',
            'employment_general_conditions_metabox_callback',
            'page',
            'normal',
            'high'
        );

        // متاباکس برای شرایط‌ها (تا 8 کانتینر)
        add_meta_box(
            'employment_conditions_metabox',
            'شرایط‌ها',
            'employment_conditions_metabox_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'my_employment_page_metabox');

// کالبک متاباکس ردیف‌های شغلی
function employment_positions_metabox_callback($post)
{
    wp_nonce_field('employment_positions_nonce', 'employment_positions_nonce');
    $positions = get_post_meta($post->ID, '_employment_positions', true);
    $positions_data = !empty($positions) ? json_decode($positions, true) : array_fill(0, 5, '');

    ?>
    <div class="employment-positions-wrapper">
        <p>لطفاً اطلاعات مربوط به هر ردیف شغلی را وارد کنید:</p>
        <?php for ($i = 0; $i < 5; $i++): ?>
            <div class="position-group">
                <label for="employment_position_<?php echo $i; ?>">ردیف شغلی <?php echo $i + 1; ?></label>
                <textarea name="employment_positions[<?php echo $i; ?>]" id="employment_position_<?php echo $i; ?>"
                    style="width:100%; height:80px;"><?php echo esc_textarea($positions_data[$i] ?? ''); ?></textarea>
            </div>
        <?php endfor; ?>
    </div>
    <style>
        .employment-positions-wrapper .position-group {
            margin-bottom: 15px;
        }

        .employment-positions-wrapper label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
    <?php
}

// کالبک متاباکس شرایط عمومی
function employment_general_conditions_metabox_callback($post)
{
    wp_nonce_field('employment_general_conditions_nonce', 'employment_general_conditions_nonce');
    $general_conditions = get_post_meta($post->ID, '_employment_general_conditions', true);
    ?>
    <div class="employment-field-group">
        <label for="employment_general_conditions">تایتل شرایط عمومی</label>
        <textarea name="employment_general_conditions" id="employment_general_conditions"
            style="width:100%; height:100px;"><?php echo esc_textarea($general_conditions); ?></textarea>
    </div>
    <?php
}

// کالبک متاباکس شرایط‌ها
function employment_conditions_metabox_callback($post)
{
    wp_nonce_field('employment_conditions_nonce', 'employment_conditions_nonce');
    $conditions = get_post_meta($post->ID, '_employment_conditions', true);
    $conditions_data = !empty($conditions) ? json_decode($conditions, true) : array();

    ?>
    <div class="employment-conditions-wrapper">
        <button type="button" class="button button-primary add-condition-btn">افزودن شرط جدید</button>
        <div class="employment-conditions-container">
            <?php if (!empty($conditions_data)): ?>
                <?php foreach ($conditions_data as $index => $condition): ?>
                    <div class="condition-group" data-index="<?php echo $index; ?>">
                        <h4>شرط <?php echo $index + 1; ?></h4>
                        <textarea name="employment_conditions[<?php echo $index; ?>]"
                            style="width:100%; height:100px;"><?php echo esc_textarea($condition); ?></textarea>
                        <button type="button" class="button remove-condition-btn" style="color: red; margin-top: 10px;">حذف
                            شرط</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            var maxConditions = 8;
            var conditionCount = $('.condition-group').length;

            // افزودن شرط جدید
            $('.add-condition-btn').on('click', function () {
                if (conditionCount >= maxConditions) {
                    alert('حداکثر ۸ شرط مجاز است.');
                    return;
                }

                var newCondition = `
                    <div class="condition-group" data-index="${conditionCount}">
                        <h4>شرط ${conditionCount + 1}</h4>
                        <textarea name="employment_conditions[${conditionCount}]" style="width:100%; height:100px;"></textarea>
                        <button type="button" class="button remove-condition-btn" style="color: red; margin-top: 10px;">حذف شرط</button>
                    </div>
                `;
                $('.employment-conditions-container').append(newCondition);
                conditionCount++;
            });

            // حذف شرط
            $(document).on('click', '.remove-condition-btn', function () {
                if (confirm('آیا از حذف این شرط مطمئن هستید؟')) {
                    $(this).closest('.condition-group').remove();
                    conditionCount--;
                    updateConditionIndexes();
                }
            });

            // به‌روزرسانی اندیس‌های شرط‌ها
            function updateConditionIndexes() {
                $('.employment-conditions-container .condition-group').each(function (index) {
                    $(this).attr('data-index', index);
                    $(this).find('h4').text(`شرط ${index + 1}`);
                    $(this).find('textarea').attr('name', `employment_conditions[${index}]`);
                });
            }
        });
    </script>

    <style>
        .employment-conditions-wrapper {
            margin-top: 20px;
        }

        .condition-group {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .condition-group h4 {
            margin: 0 0 10px;
        }

        .employment-field-group {
            margin-bottom: 20px;
        }

        .employment-field-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
    <?php
}

// ذخیره داده‌های متاباکس‌ها
function save_employment_page_metabox($post_id)
{
    // بررسی نانس‌ها
    if (
        (isset($_POST['employment_positions_nonce']) && !wp_verify_nonce($_POST['employment_positions_nonce'], 'employment_positions_nonce')) ||
        (isset($_POST['employment_general_conditions_nonce']) && !wp_verify_nonce($_POST['employment_general_conditions_nonce'], 'employment_general_conditions_nonce')) ||
        (isset($_POST['employment_conditions_nonce']) && !wp_verify_nonce($_POST['employment_conditions_nonce'], 'employment_conditions_nonce'))
    ) {
        return;
    }

    // بررسی مجوز کاربر
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // ذخیره ردیف‌های شغلی
    if (isset($_POST['employment_positions'])) {
        $positions = array_map('sanitize_textarea_field', wp_unslash($_POST['employment_positions']));
        update_post_meta(
            $post_id,
            '_employment_positions',
            wp_json_encode($positions, JSON_UNESCAPED_UNICODE)
        );
    } else {
        delete_post_meta($post_id, '_employment_positions');
    }

    // ذخیره شرایط عمومی
    if (isset($_POST['employment_general_conditions'])) {
        update_post_meta(
            $post_id,
            '_employment_general_conditions',
            sanitize_textarea_field(wp_unslash($_POST['employment_general_conditions']))
        );
    } else {
        delete_post_meta($post_id, '_employment_general_conditions');
    }

    // ذخیره شرایط‌ها
    if (isset($_POST['employment_conditions'])) {
        $conditions = array_map('sanitize_textarea_field', wp_unslash($_POST['employment_conditions']));
        $conditions = array_slice($conditions, 0, 8); // محدود کردن به 8 شرط
        update_post_meta(
            $post_id,
            '_employment_conditions',
            wp_json_encode($conditions, JSON_UNESCAPED_UNICODE)
        );
    } else {
        delete_post_meta($post_id, '_employment_conditions');
    }
}
add_action('save_post', 'save_employment_page_metabox');