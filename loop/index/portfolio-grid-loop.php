<?php
$theme_options = get_option('cyberisho_main_option', []);
$portfolio_options = $theme_options['portfolio'];
$portfolios = $portfolio_options['theme_portfolios'];
$total_items = count($portfolios);

// اگر هیچ نمونه کاری نبود
if ($total_items === 0) {
    echo '<p>نمونه کاری نیست.</p>';
} else {
    // اگر بیش از یا برابر 11 تا باشد، همه را نگه داریم (برای JS استفاده شود)
    // اما اولیه فقط 11 تا (یا 5 در موبایل) نمایش دهیم
    // لیست کامل portfolios را به JS پاس می‌دهیم
    $all_portfolios_json = json_encode($portfolios);

    // کلاس‌های ممکن برای opacity اولیه (رندوم در PHP برای ریلود اولیه)
    $opacity_classes = ['dark-opacity', 'medium-opacity', 'light-opacity'];

    // تعداد ایتم‌های اولیه: بعداً با JS responsive مدیریت می‌شود، اما اینجا فرض 11 برای دسکتاپ
    $initial_count = 11; // اما JS آن را تنظیم می‌کند

    if ($total_items >= $initial_count) {
        $selected_portfolios = array_slice($portfolios, -$initial_count, $initial_count);
    } else {
        $selected_portfolios = [];
        for ($i = 0; $i < $initial_count; $i++) {
            $random_index = rand(0, $total_items - 1);
            $selected_portfolios[] = $portfolios[$random_index];
        }
    }

    // لوپ برای نمایش ایتم‌های اولیه
    echo '<div class="grid-section">';
    foreach ($selected_portfolios as $index => $portfolio) {
        // انتخاب رندوم کلاس opacity برای اولیه
        $random_class = $opacity_classes[array_rand($opacity_classes)];
        if (!empty($portfolio['name']) && !empty($portfolio['url'])) {
            ?>
            <div class="item <?php echo esc_attr($random_class); ?>" data-index="<?php echo $index; ?>">
                <div class="fa-name">
                    <p><?php echo esc_html($portfolio['name']); ?></p>
                </div>
                <div class="space">|</div>
                <div class="en-name">
                    <p><?php echo esc_html($portfolio['url']); ?></p>
                </div>
            </div>
            <?php
        }
    } ?>
    <div class="button">
        <a href="">مشهاهده تمام نمونه کار ها</a>
    </div>
    <?php
    echo '</div>';

    // پاس لیست کامل به JS
    ?>
    <script>
        const allPortfolios = <?php echo $all_portfolios_json; ?>;
        const totalPortfolios = allPortfolios.length;
    </script>
    <?php
}
?>