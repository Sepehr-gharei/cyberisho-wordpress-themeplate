<?php
// تنظیمات لوپ
$args = array(
    'posts_per_page' => 10,
    'post_type' => 'post',
    'post_status' => 'publish'
);
$query = new WP_Query($args);

if ($query->have_posts()):
    $is_first = true;
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
                    ?>
                    <div class="item <?php echo $is_first ? 'active' : ''; ?>" id="item-<?php echo $item_count; ?>">
                        <?php echo esc_html($category->name); ?>
                    </div>
                    <?php
                    // افزودن دسته‌بندی به لیست چاپ‌شده‌ها
                    $displayed_categories[] = $category->term_id;

                    $is_first = false;
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