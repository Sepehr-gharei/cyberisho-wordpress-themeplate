<div class="all-categories">
    <?php
    // شماره صفحه فعلی
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // کوئری برای گرفتن 9 پست در هر صفحه
    $args = array(
        'posts_per_page' => 9,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $query = new WP_Query($args);

    $counter = 1;

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();

            $categories = get_the_category();
            $category   = !empty($categories) ? $categories[0] : null;

            // تعیین کلاس active فقط برای اولین پست
            $active_class = ($counter === 1) ? 'active-content' : '';
            ?>
            
            <div class="image-container <?php echo esc_attr($active_class); ?>" id="content-<?php echo $counter; ?>">
                <img src="<?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail_url('medium');
                } else {
                    echo get_template_directory_uri() . '/assets/img/default.png';
                }
                ?>" alt="<?php the_title(); ?>" />

                <div class="description">
                    <div class="header">
                        <p><span><?php echo esc_html($category ? $category->name : 'بدون دسته'); ?></span></p>
                    </div>
                    <div class="body">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                    </div>
                    <div class="footer">
                        <div class="item">
                            <p>زمان تقریبی : 
                                <?php
                                $reading_data = calculate_reading_time(get_the_ID());
                                echo $reading_data['reading_time'];
                                ?>
                            </p>
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

    // صفحه‌بندی
    echo '<div class="pagination">';
    echo paginate_links(array(
        'total'   => $query->max_num_pages,
        'current' => $paged,
    ));
    echo '</div>';

    wp_reset_postdata();
    ?>
</div>
