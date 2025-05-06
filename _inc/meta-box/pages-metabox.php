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
function add_page_header_meta_box() {
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
function render_page_header_meta_box($post) {
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
function save_page_header_meta_box_data($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['page_header_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['page_header_meta_box_nonce'], 'save_page_header_meta_box_data')) {
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
function my_custom_aboutus_metaboxes() {
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
function aboutus_video_metabox_callback($post) {
    $video_url = get_post_meta($post->ID, '_aboutus_video_url', true);
    wp_nonce_field('aboutus_metabox_nonce', 'aboutus_nonce');
    ?>
    <label for="aboutus_video_url">آدرس ویدیو:</label>
    <input type="text" id="aboutus_video_url" name="aboutus_video_url" value="<?php echo esc_url($video_url); ?>" style="width: 100%; margin-bottom: 10px;">
    <input type="button" id="upload_video_button" class="button" value="انتخاب ویدیو از رسانه">
    <script>
        jQuery(document).ready(function($){
            $('#upload_video_button').click(function() {
                var frame = wp.media({
                    title: 'انتخاب ویدیو',
                    library: { type: 'video' },
                    multiple: false
                });
                
                frame.on('select', function() {
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
function aboutus_video_thumbnail_metabox_callback($post) {
    $thumbnail_id = get_post_meta($post->ID, '_aboutus_video_thumbnail_id', true);
    $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
    wp_nonce_field('aboutus_metabox_nonce', 'aboutus_nonce');
    ?>
    <label for="aboutus_video_thumbnail">تصویر تامبنیل:</label>
    <input type="hidden" id="aboutus_video_thumbnail_id" name="aboutus_video_thumbnail_id" value="<?php echo esc_attr($thumbnail_id); ?>">
    <input type="text" id="aboutus_video_thumbnail_url" name="aboutus_video_thumbnail_url" value="<?php echo esc_url($thumbnail_url); ?>" style="width: 100%; margin-bottom: 10px;">
    <input type="button" id="upload_thumbnail_button" class="button" value="انتخاب تصویر از رسانه">
    <div id="thumbnail_preview" style="margin-top: 10px;">
        <?php if ($thumbnail_url) : ?>
            <img src="<?php echo esc_url($thumbnail_url); ?>" style="max-width: 200px; height: auto;">
        <?php endif; ?>
    </div>
    <script>
        jQuery(document).ready(function($){
            $('#upload_thumbnail_button').click(function() {
                var frame = wp.media({
                    title: 'انتخاب تصویر تامبنیل',
                    library: { type: 'image' },
                    multiple: false
                });
                
                frame.on('select', function() {
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
function save_aboutus_metaboxes($post_id) {
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