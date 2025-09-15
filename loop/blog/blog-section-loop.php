<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 9, // تعداد پست در هر صفحه
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
                                $terms = get_the_terms(get_the_ID(), 'category');
                                if (!empty($terms) && !is_wp_error($terms)) {
                                    echo esc_html($terms[0]->name);
                                }
                                ?>
                            </p>
                        </div>
                        <div class="body">
                            <h4>
                                <?php
                                $title = get_the_title();
                                $limit = 32; // تعداد حروف مجاز
                                if (mb_strlen($title, 'UTF-8') > $limit) {
                                    echo mb_substr($title, 0, $limit, 'UTF-8') . '...';
                                } else {
                                    echo $title;
                                }
                                ?>
                            </h4>

                        </div>
                        <div class="footer">
                            <div class="item">انتشار: <?php echo get_the_date('Y/m/d'); ?></div>
                            <div class="item">زمان تقریبی مطالعه:
                                <?php
                                $reading_data = calculate_reading_time(get_the_ID());
                                echo $reading_data['reading_time'];
                                ?> دقیقه
                            </div>
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
        $big = 999999999; // برای فرمت لینک‌ها
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $loop->max_num_pages,
            'prev_text' => __('
                <svg width="218pt" height="146pt" viewBox="0 0 218 146" xmlns="http://www.w3.org/2000/svg">
                    <g id="#000000ff">
                        <path fill="var(--normal-text-color)" d="M 30.79 30.75 ... Z"></path>
                    </g>
                </svg>
            '),
            'next_text' => __('
                <svg width="218pt" height="146pt" viewBox="0 0 218 146" xmlns="http://www.w3.org/2000/svg">
                    <g id="#000000ff">
                        <path fill="var(--normal-text-color)" d="M 30.79 30.75 ... Z"></path>
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