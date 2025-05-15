<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'paged' => $paged,
);

$loop = new WP_Query($args);

if ($loop->have_posts()):
    while ($loop->have_posts()):
        $loop->the_post();
        ?>
        <section class="col-12 col-md-6 col-lg-4">
            <div class="wrapper">
                <a href="<?php the_permalink(); ?>">
                    <div class="image-section">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                        <?php else: ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/blog-item-2.png'; ?>"
                                alt="تصویر پیش فرض" />
                        <?php endif; ?>
                    </div>
                    <div class="text-field">
                        <div class="header">
                            <p>
                                <?php
                                // فرض کنید taxonomy ما 'blog_category_tax' است
                                $terms = get_the_terms(get_the_ID(), 'category');

                                if (!empty($terms) && !is_wp_error($terms)) {
                                    // فقط اولین دسته را نمایش بده
                                    echo esc_html($terms[0]->name);
                                }
                                ?>
                            </p>
                        </div>
                        <div class="body">
                            <h4><?php the_title(); ?></h4>
                        </div>
                        <div class="footer">
                            <div class="item">انتشار: <?php echo get_the_date('Y/m/d'); ?></div>
                            <div class="item">زمان تقریبی مطالعه: <?php
                            $reading_data = calculate_reading_time(get_the_ID());
                            echo $reading_data['reading_time'] ?> دقیقه</div>
                        </div>
                    </div>
                </a>
            </div>
        </section>
        <?php
    endwhile;
    ?>

    <!-- شروع Pagination -->
    <div class="pagination-wrapper pagination reverse">
        <?php
        $big = 999999999; // نیاز برای فرمت لینک‌ها
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $loop->max_num_pages,
            'prev_text' => __('
            <svg width="218pt" height="146pt" viewBox="0 0 218 146" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <g id="#000000ff">
                    <path fill="var(--normal-text-color)" opacity="1.00" d="M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z"></path>
                </g>
            </svg>
        '),
            'next_text' => __('
            <svg width="218pt" height="146pt" viewBox="0 0 218 146" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <g id="#000000ff">
                    <path fill="var(--normal-text-color)" opacity="1.00" d="M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z"></path>
                </g>
            </svg>
        '),
        ));
        ?>
    </div>
    <!-- پایان Pagination -->
    <?php
    wp_reset_postdata();
else:
    echo '<p>هیچ پستی یافت نشد.</p>';
endif;
?>