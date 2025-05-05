<?php
function my_custom_portfolio_metabox()
{
    global $post;

    // دریافت اطلاعات برگه فعلی
    if ($post) {
        $page_slug = $post->post_name; // Slug برگه
        // بررسی اینکه آیا برگه مورد نظر است (مثلاً Slug برگه 'about' باشد)
        if ($page_slug === 'portfolio') {
            add_meta_box(
                'my_metabox_id', // ID متاباکس
                'متن درباره نمونه کار ها', // عنوان متاباکس
                'my_portfolio_metabox_callback', // تابع نمایش محتوا
                'page', // نوع پست (اینجا برگه)
                'normal', // موقعیت
                'high' // اولویت
            );
        }
    }
}
add_action('add_meta_boxes', 'my_custom_portfolio_metabox');

// تابع نمایش محتوای متاباکس
function my_portfolio_metabox_callback($post)
{
    // دریافت مقدار ذخیره‌شده (اگر وجود داشته باشد)
    $portfolip_text_field = get_post_meta($post->ID, '_portfolip_text_field', true);

    // افزودن nonce برای امنیت
    wp_nonce_field('my_metabox_nonce', 'my_nonce');

    // فیلد متاباکس
    ?>
    <label for="portfolip_text_field">مقدار متن درباره نمونه کار ها:</label>
    <textarea id="portfolip_text_field" name="portfolip_text_field"
        style="width: 100%;"><?php echo esc_attr($portfolip_text_field); ?></textarea>
    <?php
}

// ذخیره داده‌های متاباکس
function save_my_portfolio_metabox($post_id)
{
    // بررسی nonce برای امنیت
    if (!isset($_POST['my_nonce']) || !wp_verify_nonce($_POST['my_nonce'], 'my_metabox_nonce')) {
        return;
    }

    // بررسی دسترسی کاربر
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // ذخیره مقدار فیلد
    if (isset($_POST['portfolip_text_field'])) {
        update_post_meta($post_id, '_portfolip_text_field', sanitize_text_field($_POST['portfolip_text_field']));
    }
}
add_action('save_post', 'save_my_portfolio_metabox');




