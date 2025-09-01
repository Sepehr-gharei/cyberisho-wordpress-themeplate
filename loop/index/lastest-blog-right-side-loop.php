<?php
// دریافت آخرین پست با get_posts
$args = array(
    'posts_per_page' => 1, // فقط یک پست
    'post_status' => 'publish', // فقط پست‌های منتشرشده
    'no_found_rows' => true, // غیرفعال کردن شمارش کل برای سرعت بیشتر
    'fields' => 'ids', // فقط ID پست را بگیر برای کاهش بار
);

$post_ids = get_posts($args);

// بررسی وجود پست و نمایش آن
if (!empty($post_ids)) {
    $post_id = $post_ids[0]; // فقط اولین ID پست
    ?>
    <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="item">
        <div class="image-section">
            <?php if (has_post_thumbnail($post_id)): ?>
                <img src="<?php echo get_the_post_thumbnail_url($post_id, 'thumbnail'); ?>" alt="" />
            <?php endif; ?>
        </div>
        <div class="time-view-wrapper">
            <p>انتشار: <?php echo get_the_date('Y/m/d', $post_id); ?></p>
            <p>مشاهده:
                <?php echo do_shortcode('[post_views id="' . $post_id . '"]') ? do_shortcode('[post_views id="' . $post_id . '"]') : '0'; ?>
            </p>
        </div>
        <div class="text-field">
            <p><?php echo get_the_title($post_id); ?></p>
        </div>
    </a>
    <?php
}
?>