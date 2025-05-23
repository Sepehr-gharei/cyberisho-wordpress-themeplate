<div class="all-categories">

    <?php
    // دریافت دسته‌بندی فعال از URL
    $queried_object = get_queried_object();
    $current_category_slug = !empty($queried_object) && is_category() ? $queried_object->slug : '';

    $categories = get_categories(array(
        'hide_empty' => true,
    ));

    $counter = 1;

    foreach ($categories as $category) {
        $args = array(
            'posts_per_page' => 1,
            'category__in' => array($category->term_id),
        );

        $query = new WP_Query($args);

        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();

                // تعیین کلاس active-content بر اساس تطابق slug دسته‌بندی
                $active_class = ($category->slug === $current_category_slug) ? 'active-content' : '';
                ?>

                <div class="image-container <?php echo esc_attr($active_class); ?>" id="content-<?php echo $counter; ?>">
                    <img src="<?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail_url('medium');
                    } else {
                        echo get_template_directory_uri() . '/assets/img/default.png'; // تصویر پیش‌فرض
                    }
                    ?>" alt="<?php the_title(); ?>" />

                    <div class="description">
                        <div class="header">
                            <p><span><a
                                        href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><?php echo esc_html($category->name); ?></a></span>
                            </p>
                        </div>
                        <div class="body">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                        </div>
                        <div class="footer">
                            <div class="item">
                                <p>زمان تقریبی : <?php
                                $reading_data = calculate_reading_time(get_the_ID());
                                echo $reading_data['reading_time']; ?> </p>
                            </div>
                            <div class="item">
                                <p>انتشار : <?php echo get_the_date(); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $counter++;
            endwhile;
        endif;

        wp_reset_postdata();
    }
    ?>
</div>