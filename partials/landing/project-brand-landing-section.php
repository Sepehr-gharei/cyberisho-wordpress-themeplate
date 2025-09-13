<section class="project-brand-landing-section">
    <div class="project-brand-landing-container container">
    <?php
// Get projects count and slogan text from post meta
$projects_count = get_post_meta(get_the_ID(), '_landing_projects_count', true);
$slogan_text = get_post_meta(get_the_ID(), '_landing_slogan_text', true);
?>
<aside class="project-text-wrapper">
    <div class="top-text">
        <div class="number">
            <p><?php echo esc_html($projects_count ?: '+4200'); ?></p>
        </div>
        <div class="text">
            <p>پـروژه موفق</p>
        </div>
    </div>
    <div class="bott-text">
        <p><?php echo esc_html($slogan_text ?: 'جـای شـــــــــــما خالیسـت...'); ?></p>
    </div>
</aside>
        <aside class="brand-wrapper">
            <div class="slider-swiper">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php
                        $theme_options = get_option('cyberisho_main_option', []);
                        $site_info_options = $theme_options['site-info'];
                        $brand_images = $site_info_options['brand_images'] ?? [];

                        // مسیر عکس پیش‌فرض (میتونی آدرس دلخواه بزاری)
                        $default_image = get_template_directory_uri() . '/assets/images/default.png';

                        // فقط آرایه‌ی تصاویر معتبر رو بگیریم
                        $valid_images = [];
                        if (!empty($brand_images) && is_array($brand_images)) {
                            foreach ($brand_images as $brand) {
                                if (!empty($brand['image'])) {
                                    $valid_images[] = esc_url($brand['image']);
                                }
                            }
                        }

                        // اگر هیچ تصویری نبود → همه پیش‌فرض
                        if (empty($valid_images)) {
                            $valid_images = array_fill(0, 15, $default_image);
                        }

                        // حالا دقیقاً 15 تا می‌سازیم
                        $slides = [];
                        for ($i = 0; $i < 15; $i++) {
                            $slides[] = $valid_images[$i % count($valid_images)];
                        }

                        // خروجی
                        foreach ($slides as $img): ?>
                            <div class="swiper-slide">
                                <img src="<?php echo $img; ?>" alt="Brand Image" />
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>