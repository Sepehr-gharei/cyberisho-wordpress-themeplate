<?php
$theme_options = get_option('cyberisho_main_option', []);
$portfolio_options = $theme_options['portfolio'];
$portfolios = $portfolio_options['theme_portfolios'];
$portfolios = array_slice($portfolios, 0, 5); // فقط ۵ آیتم اول
$index = 0; // برای اضافه کردن کلاس active به اولین wrapper
?>

<?php if (!empty($portfolios)): ?>
    <?php foreach ($portfolios as $portfolio):
        if (!empty($portfolio['name'])):
            $desktop_image = !empty($portfolio['desktop_image']) ? esc_url($portfolio['desktop_image']) : '';
            $class = ($index === 0) ? 'wrapper active' : 'wrapper'; // اضافه کردن کلاس active به اولین wrapper
            ?>
            <a href="#" class="ticker-item"><?php echo esc_html($portfolio['name']); ?></a>
            <?php
            $index++; // افزایش شاخص
        endif;
    endforeach; ?>
<?php else: ?>
    <p>هیچ نمونه کاری یافت نشد.</p>
<?php endif; ?>