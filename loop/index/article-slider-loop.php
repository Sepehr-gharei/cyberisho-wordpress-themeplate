<?php

$args = array(
    'post_type' => 'blog',
    'posts_per_page' => 10,
);

$loop = new WP_Query($args);

if ($loop->have_posts()):
    while ($loop->have_posts()):
        $loop->the_post();
        ?>
        <div class="swiper-slide">
            <a href="" <?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('post-thumbnail', array('class' => 'slide-image')); ?>
                <?php else: ?>
                    <img class="slide-image" src="<?php echo get_template_directory_uri() . '/assets/img/blog-item-2.png'; ?>"
                        alt="تصویر پیش فرض" />
                <?php endif; ?>
                <div class="text-field">
                    <div class="text">
                        <p>
                            <?php echo get_excerpt_article_title(get_the_title()) ?>

                        </p>
                    </div>
                    <div class="more-information">
                        <small><?php echo get_the_date('Y/m/d'); ?></small><small>مشاهده
                            <?php echo do_shortcode('[post_views]'); ?></small>
                    </div>
                </div>
            </a>
        </div>





        <?php
    endwhile;
    wp_reset_postdata();
else:
    echo '<p>هیچ پستی یافت نشد.</p>';
endif;
?>