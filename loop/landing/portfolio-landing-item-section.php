<?php
// دریافت تنظیمات اصلی قالب
$theme_options = get_option('cyberisho_main_option', []);
$portfolios = !empty($theme_options['portfolio']['theme_portfolios']) ? $theme_options['portfolio']['theme_portfolios'] : [];

// اگر نمونه‌کارها خالی باشند، یک آرایه پیش‌فرض ایجاد می‌کنیم
if (empty($portfolios) || !is_array($portfolios)) {
    $portfolios = [
        [
            'name' => 'نمونه کار پیش‌فرض',
            'main_image' => 'https://via.placeholder.com/400'
        ]
    ];
}

// تعداد نمونه‌کارها
$count = count($portfolios);

// اگر تعداد کمتر از 8 باشد، آیتم‌ها را تکرار می‌کنیم
$repeated_portfolios = [];
for ($i = 0; $i < max(8, $count); $i++) {
    $index = $i % $count; // استفاده از مدولو برای تکرار آیتم‌ها
    $repeated_portfolios[] = $portfolios[$index];
}
?>

    <?php foreach ($repeated_portfolios as $portfolio) : 
        $name = !empty($portfolio['name']) ? esc_html($portfolio['name']) : 'بدون عنوان';
        $main_image = !empty($portfolio['main_image']) ? esc_url($portfolio['main_image']) : 'https://via.placeholder.com/400';
    ?>
        <div class="swiper-slide">
            <img src="<?php echo $main_image; ?>" alt="<?php echo $name; ?>" />
            <div class="slide-content">
                <p><?php echo $name; ?></p>
            </div>
        </div>
    <?php endforeach; ?>