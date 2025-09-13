<?php
$theme_options = get_option('cyberisho_main_option', []);
$testimonials_options = $theme_options['testimonials'];
$testimonials = $testimonials_options['testimonials_items'];

// Get up to 8 most recent testimonials
$recent_testimonials = array_slice($testimonials, -8, 8, true);

if (!empty($recent_testimonials)): ?>
    <?php foreach ($recent_testimonials as $testimonial):
        if (!empty($testimonial['customer_name']) && !empty($testimonial['content'])):
            $voice = !empty($testimonial['voice']) ? esc_url($testimonial['voice']) : '';
            $customer_name = esc_html($testimonial['customer_name']);
            $site_name = esc_html($testimonial['site_name']);
            $content = esc_html($testimonial['content']);
            // Combine customer name and site name with a hyphen
            $name_field = $customer_name . ' - ' . ' سایت ' . $site_name;
            ?>

            <div class="swiper-slide">
                <div class="text-content">
                    <p>
                        <?php echo $content; ?>
                    </p>
                </div>
                <div class="name-text">
                    <p><?php echo $name_field; ?></p>
                </div>

                <div class="audio-player">
                    <audio id="audio" src="<?php echo $voice; ?>" type="audio/mpeg" preload="auto"
                        oncontextmenu="return false;"></audio>
                    <div id="progress-bar">
                        <div id="progress"></div>
                    </div>
                    <svg id="play-icon" viewBox="0 0 330 330">
                        <path d="M37.728,328.12c2.266,1.256,4.77,1.88,7.272,1.88c2.763,0,5.522-0.763,7.95-2.28l240-149.999
                          c4.386-2.741,7.05-7.548,7.05-12.72c0-5.172-2.664-9.979-7.05-12.72L52.95,2.28c-4.625-2.891-10.453-3.043-15.222-0.4
                          C32.959,4.524,30,9.547,30,15v300C30,320.453,32.959,325.476,37.728,328.12z" fill="black">
                        </path>
                    </svg>
                    <svg class="pause-svg" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="48" height="48" fill="none"></rect>
                        <path d="M16 12V36" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M32 12V36" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
            </div>

        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>هیچ نظری از مشتریان یافت نشد.</p>
<?php endif; ?>