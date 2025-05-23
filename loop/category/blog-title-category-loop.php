<?php
// دریافت دسته‌بندی فعال از URL
$queried_object = get_queried_object();
$current_category_slug = !empty($queried_object) && is_category() ? $queried_object->slug : '';

// تنظیمات لوپ
$args = array(
    'posts_per_page' => 10,
    'post_type' => 'post',
    'post_status' => 'publish'
);
$query = new WP_Query($args);

if ($query->have_posts()):
    $item_count = 1;
    $displayed_categories = array(); // آرایه برای نگهداری دسته‌بندی‌های چاپ‌شده

    while ($query->have_posts()):
        $query->the_post();

        // دریافت دسته‌بندی‌های پست
        $categories = get_the_category();

        if (!empty($categories)):
            foreach ($categories as $category):
                // بررسی تکراری بودن دسته‌بندی
                if (!in_array($category->term_id, $displayed_categories)) {
                    // بررسی آیا این دسته‌بندی با slug دسته‌بندی فعال مطابقت دارد
                    $is_active = ($category->slug === $current_category_slug) ? 'active' : '';
                    ?>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                        <div class="item <?php echo esc_attr($is_active); ?>" id="item-<?php echo $item_count; ?>">
                            <?php echo esc_html($category->name); ?>
                        </div>
                    </a>
                    <?php
                    // افزودن دسته‌بندی به لیست چاپ‌شده‌ها
                    $displayed_categories[] = $category->term_id;

                    $item_count++;
                }
            endforeach;
        endif;
    endwhile;

    wp_reset_postdata();
else:
    echo '<p>پستی یافت نشد.</p>';
endif;
?>