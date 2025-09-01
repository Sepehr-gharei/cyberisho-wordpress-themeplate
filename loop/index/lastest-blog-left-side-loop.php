<?php
// تنظیمات بهینه برای WP_Query
$args = array(
    'posts_per_page' => 3,
    'post_type' => 'post',
    'post_status' => 'publish',
    'orderby' => 'rand',
    'no_found_rows' => true, // غیرفعال کردن شمارش کل
    'fields' => 'ids', // فقط IDها
    'cache_results' => false, // غیرفعال کردن کش نتایج
    'update_post_meta_cache' => false, // غیرفعال کردن کش متا
    'update_post_term_cache' => false, // غیرفعال کردن کش دسته‌بندی‌ها
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        ?>
        <div class="item">
            <div class="image-wrapper">
                <?php if (has_post_thumbnail()): ?>
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'thumbnail')); ?>" alt="" />
                <?php endif; ?>
            </div>
            <div class="text-field">
                <div class="blog-name">
                    <a  class="excerpt-title" 
                    id="excerpt-<?php echo get_the_ID(); ?>" 
                    data-text="<?php echo esc_attr(get_the_title()); ?>"
                        href="<?php echo esc_url(get_permalink()); ?>"> <?php echo esc_html(get_excerpt_home_page_blog_item_title(get_the_title())); ?></a>
                </div>
                <div class="blog-time">
                    <p>انتشار: <?php echo get_the_date('Y/m/d'); ?></p>
                </div>
                <span>|</span>
                <div class="blog-view">مشاهده: <?php echo do_shortcode('[post_views id="' . $post_id . '"]') ?: '0'; ?></div>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata(); // بازنشانی داده‌های پست
}
?>