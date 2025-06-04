<?php
$theme_options = get_option('cyberisho_main_option', []);
$portfolio_options = $theme_options['portfolio'];
$portfolios = $portfolio_options['theme_portfolios'];
$portfolios = array_slice($portfolios, 0, 5); // فقط ۵ آیتم اول
$count = count($portfolios); // تعداد آیتم‌های پرتفولیو

// بررسی تعداد و تکرار آرایه بر اساس شرایط
if ($count < 5) {
    $portfolios = array_merge($portfolios, $portfolios, $portfolios, $portfolios, $portfolios); // 5 بار تکرار
} elseif ($count < 10) {
    $portfolios = array_merge($portfolios, $portfolios, $portfolios, $portfolios); // 4 بار تکرار
} elseif ($count < 15) {
    $portfolios = array_merge($portfolios, $portfolios, $portfolios); // 3 بار تکرار
} 

$index = 0; // برای اضافه کردن کلاس active به اولین wrapper
?>

<?php if (!empty($portfolios)): ?>
    <?php foreach ($portfolios as $portfolio):
        if (!empty($portfolio['name'])):
            $desktop_image = !empty($portfolio['desktop_image']) ? esc_url($portfolio['desktop_image']) : '';
            $portfolio_url = !empty($portfolio['url']) ? esc_url($portfolio['url']) : '#'; // استفاده از URL نمونه کار
            $class = ($index === 0) ? 'wrapper active' : 'wrapper'; // اضافه کردن کلاس active به اولین wrapper
            ?>
            <a href="<?php echo $portfolio_url; ?>" id="ticker-item" class="ticker-item"><?php echo esc_html($portfolio['name']); ?></a>
            <?php
            $index++; // افزایش شاخص
        endif;
    endforeach; ?>
<?php else: ?>
    <p>هیچ نمونه کاری یافت نشد.</p>
<?php endif; ?>