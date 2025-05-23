<?php
if (have_posts()):
    while (have_posts()):
        the_post();
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
                            <h4><?php echo get_excerpt_blog_item_title(get_the_title()) ?> </h4>
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
else:
endif;
