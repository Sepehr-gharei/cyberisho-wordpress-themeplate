<!--************************* start webdesing text field section *************************-->
<div class="webdesing-text-field-section webdesing-text-field-section-background-gray">
    <div class="container">
        <div class="what-is-webdesign wrapper animated-section">
            <?php
            /*
            Template Name: Landing Page
            */
            get_header();
            ?>

            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    // دریافت داده‌های متاباکس
                    $about_text = get_post_meta(get_the_ID(), '_landing_about_text', true);
                    $content_text = get_post_meta(get_the_ID(), '_landing_content_text', true);
                    $containers = get_post_meta(get_the_ID(), '_landing_containers', true);
                    $containers_data = !empty($containers) ? json_decode($containers, true) : array();

                endwhile;
            endif;
            ?>
            <?php
            ?>
            <h3><?php echo esc_html($about_text); ?></h3>
            <p>
                <?php echo esc_html($content_text); ?>
            </p>
        </div>
        <?php
        if (!empty($containers_data)): ?>
            <section class="landing-containers">
                <?php foreach ($containers_data as $index => $container): ?>
                    <div class="specifications-of-webdesign facilities-of-webdesig wrapper animated-section">
                        <?php if (!empty($container['header'])): ?>
                            <h4><?php echo esc_html($container['header']); ?></h4>
                        <?php endif; ?>

                        <?php if (!empty($container['items'])): ?>
                            <div class="container-items">
                                <?php foreach ($container['items'] as $item): ?>
                                    <?php if ($item['type'] === 'content'): ?>
                                        <div class="item-content">
                                            <p><?php echo esc_html($item['value']); ?></p>
                                        </div>
                                    <?php else: ?>
                                        <div class="item-list">
                                            <ul>
                                                <li><?php echo esc_html($item['value']); ?></li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php endif;
        ?>
    </div>
</div>
<!--************************* end webdesing text field section *************************-->