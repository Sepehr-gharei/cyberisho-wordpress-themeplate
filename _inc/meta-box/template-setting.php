<?php
// Adding custom theme settings menu
add_action('admin_menu', 'custom_theme_settings_menu');

if (!function_exists('custom_theme_settings_menu')) {
    function custom_theme_settings_menu()
    {
        add_menu_page(
            'تنظیمات قالب',
            'تنظیمات قالب',
            'manage_options',
            'theme-settings',
            'theme_settings_page',
            'dashicons-admin-generic',
            30
        );
    }
}

// Main theme settings page with tabs
function theme_settings_page()
{
    $tabs = [
        'footer-content' => 'محتواهای پاورچین', // تب جدید
        'site-info' => 'اطلاعات سایت',
        'contact' => 'اطلاعات تماس',
        'home' => 'صفحه اصلی',
        'about' => 'صفحه درباره ما',
        'landing' => 'صفحه لندینگ',
        'portfolio' => 'صفحه نمونه کارها'
    ];

    $current_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'footer-content';

    ?>
    <div class="wrap">
        <h1>تنظیمات قالب</h1>
        <h2 class="nav-tab-wrapper">
            <?php foreach ($tabs as $tab_slug => $tab_name): ?>
                <a href="?page=theme-settings&tab=<?php echo esc_attr($tab_slug); ?>"
                    class="nav-tab <?php echo $current_tab === $tab_slug ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html($tab_name); ?>
                </a>
            <?php endforeach; ?>
        </h2>

        <?php
        switch ($current_tab) {
            case 'footer-content':
                theme_settings_footer_content_page();
                break;
            case 'site-info':
                theme_settings_site_info_page();
                break;
            case 'contact':
                theme_settings_contact_page();
                break;
            case 'home':
                theme_settings_home_page();
                break;
            case 'about':
                theme_settings_about_page();
                break;
            case 'landing':
                theme_settings_landing_page();
                break;
            case 'portfolio':
                theme_settings_portfolio_page();
                break;
            default:
                theme_settings_footer_content_page();
                break;
        }
        ?>
    </div>
    <?php
}

// محتوای پاورچین (جدید)
function theme_settings_footer_content_page()
{
    if (isset($_POST['submit'])) {
        update_option('footer_text', sanitize_textarea_field($_POST['footer_text']));
        update_option('footer_icon_1_image', esc_url_raw($_POST['footer_icon_1_image']));
        update_option('footer_icon_2_image', esc_url_raw($_POST['footer_icon_2_image']));
        update_option('footer_icon_1_url', sanitize_textarea_field($_POST['footer_icon_1_url']));
        update_option('footer_icon_2_url', sanitize_textarea_field($_POST['footer_icon_2_url']));
        ?>
        <div class="updated">
            <p>تنظیمات محتوای پاورچین ذخیره شد.</p>
        </div>
        <?php
    }

    $footer_text = get_option('footer_text', '');
    $footer_icon_1_image = get_option('footer_icon_1_image', '');
    $footer_icon_2_image = get_option('footer_icon_2_image', '');
    $footer_icon_1_url = get_option('footer_icon_1_url', '');
    $footer_icon_2_url = get_option('footer_icon_2_url', '');
    ?>
    <div class="tab-content footer-content">
        <h2>محتواهای پاورچین</h2>

        <form method="post" action="">
            <h3>متن پاورچین</h3>
            <table class="form-table">
                <tr>
                    <th><label for="footer_text">متن پاورچین</label></th>
                    <td>
                        <textarea name="footer_text" id="footer_text" rows="5"
                            class="large-text"><?php echo esc_textarea($footer_text); ?></textarea>
                    </td>
                </tr>
            </table>

            <h3>عکس نمادهای سایت</h3>
            <table class="form-table">
                <tr>
                    <th><label>عکس نماد اول</label></th>
                    <td>
                        <input type="text" name="footer_icon_1_image" id="footer_icon_1_image"
                            value="<?php echo esc_attr($footer_icon_1_image); ?>" class="regular-text">
                        <input type="button" class="button upload-icon-image" value="آپلود تصویر"
                            data-target="icon_1">
                        <div class="image-preview icon-1-image-preview">
                            <?php if (!empty($footer_icon_1_image)): ?>
                                <img src="<?php echo esc_url($footer_icon_1_image); ?>" style="max-width: 200px;">
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><label>عکس نماد دوم</label></th>
                    <td>
                        <input type="text" name="footer_icon_2_image" id="footer_icon_2_image"
                            value="<?php echo esc_attr($footer_icon_2_image); ?>" class="regular-text">
                        <input type="button" class="button upload-icon-image" value="آپلود تصویر"
                            data-target="icon_2">
                        <div class="image-preview icon-2-image-preview">
                            <?php if (!empty($footer_icon_2_image)): ?>
                                <img src="<?php echo esc_url($footer_icon_2_image); ?>" style="max-width: 200px;">
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><label for="footer_icon_1_url">URL نماد اول</label></th>
                    <td>
                        <textarea name="footer_icon_1_url" id="footer_icon_1_url" rows="3"
                            class="large-text"><?php echo esc_textarea($footer_icon_1_url); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="footer_icon_2_url">URL نماد دوم</label></th>
                    <td>
                        <textarea name="footer_icon_2_url" id="footer_icon_2_url" rows="3"
                            class="large-text"><?php echo esc_textarea($footer_icon_2_url); ?></textarea>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
                console.error('wp.media is not loaded');
                return;
            }

            $(document).on('click', '.upload-icon-image', function (e) {
                e.preventDefault();
                var button = $(this);
                var target = button.data('target');
                var inputField = $('#footer_' + target + '_image');
                var previewField = $('.icon-' + target.replace('_', '-') + '-image-preview');

                var frame = wp.media({
                    title: 'انتخاب تصویر',
                    button: { text: 'استفاده از تصویر' },
                    multiple: false
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    inputField.val(attachment.url);
                    previewField.html('<img src="' + attachment.url + '" style="max-width: 200px;">');
                });

                frame.open();
            });
        });
    </script>
    <?php
}

// اطلاعات سایت
function theme_settings_site_info_page()
{
    if (isset($_POST['submit'])) {
        update_option('banner_header', sanitize_textarea_field($_POST['banner_header']));
        update_option('banner_content', sanitize_textarea_field($_POST['banner_content']));
        update_option('project_count', sanitize_textarea_field($_POST['project_count']));
        update_option('project_start_year', sanitize_textarea_field($_POST['project_start_year']));
        update_option('team_total', sanitize_textarea_field($_POST['team_total']));
        update_option('team_developer', sanitize_textarea_field($_POST['team_developer']));
        update_option('team_graphic', sanitize_textarea_field($_POST['team_graphic']));
        update_option('team_support', sanitize_textarea_field($_POST['team_support']));
        update_option('team_seo', sanitize_textarea_field($_POST['team_seo']));
        for ($i = 1; $i <= 4; $i++) {
            update_option('home_feature_' . $i, sanitize_textarea_field($_POST['home_feature_' . $i]));
        }
        // Save brand images
        $brand_images = [];
        if (isset($_POST['brand_image'])) {
            foreach ($_POST['brand_image'] as $index => $image) {
                $brand_images[$index] = esc_url_raw($image);
            }
        }
        update_option('brand_images', $brand_images);
        ?>
        <div class="updated">
            <p>تنظیمات بنر، پروژه‌ها، تیم ما، ویژگی‌های سایت و برندها ذخیره شد.</p>
        </div>
        <?php
    }

    $banner_header = get_option('banner_header', '');
    $banner_content = get_option('banner_content', '');
    $project_count = get_option('project_count', '');
    $project_start_year = get_option('project_start_year', '');
    $team_total = get_option('team_total', '');
    $team_developer = get_option('team_developer', '');
    $team_graphic = get_option('team_graphic', '');
    $team_support = get_option('team_support', '');
    $team_seo = get_option('team_seo', '');
    $features = [];
    for ($i = 1; $i <= 4; $i++) {
        $features[$i] = get_option('home_feature_' . $i, '');
    }
    $brand_images = get_option('brand_images', ['']); // Initialize with one empty brand image
    ?>
    <div class="tab-content site-information">
        <h2>اطلاعات سایت</h2>
        <form method="post" action="">
            <h3>قسمت بنر شعار</h3>
            <table class="form-table">
                <tr>
                    <th><label for="banner_header">هدر بنر</label></th>
                    <td>
                        <textarea name="banner_header" id="banner_header" rows="3"
                            class="large-text"><?php echo esc_textarea($banner_header); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="banner_content">محتوا بنر</label></th>
                    <td>
                        <textarea name="banner_content" id="banner_content" rows="5"
                            class="large-text"><?php echo esc_textarea($banner_content); ?></textarea>
                    </td>
                </tr>
            </table>
            <h3>تعداد پروژه‌ها</h3>
            <table class="form-table">
                <tr>
                    <th><label for="project_count">تعداد پروژه‌ها</label></th>
                    <td>
                        <textarea name="project_count" id="project_count" rows="2"
                            class="large-text"><?php echo esc_textarea($project_count); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="project_start_year">سال شروع پروژه‌ها</label></th>
                    <td>
                        <textarea name="project_start_year" id="project_start_year" rows="2"
                            class="large-text"><?php echo esc_textarea($project_start_year); ?></textarea>
                    </td>
                </tr>
            </table>
            <h3>تیم ما</h3>
            <table class="form-table">
                <tr>
                    <th><label for="team_total">تعداد نفرات تیم</label></th>
                    <td>
                        <textarea name="team_total" id="team_total" rows="2"
                            class="large-text"><?php echo esc_textarea($team_total); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="team_developer">تعداد برنامه‌نویس</label></th>
                    <td>
                        <textarea name="team_developer" id="team_developer" rows="2"
                            class="large-text"><?php echo esc_textarea($team_developer); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="team_graphic">تعداد گرافیست</label></th>
                    <td>
                        <textarea name="team_graphic" id="team_graphic" rows="2"
                            class="large-text"><?php echo esc_textarea($team_graphic); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="team_support">تعداد پشتیبان</label></th>
                    <td>
                        <textarea name="team_support" id="team_support" rows="2"
                            class="large-text"><?php echo esc_textarea($team_support); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="team_seo">تعداد سئوکار</label></th>
                    <td>
                        <textarea name="team_seo" id="team_seo" rows="2"
                            class="large-text"><?php echo esc_textarea($team_seo); ?></textarea>
                    </td>
                </tr>
            </table>
            <h3>چهار ویژگی سایت</h3>
            <table class="form-table">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <tr>
                        <th><label for="home_feature_<?php echo $i; ?>">ویژگی <?php echo $i; ?></label></th>
                        <td>
                            <textarea name="home_feature_<?php echo $i; ?>" id="home_feature_<?php echo $i; ?>" rows="3"
                                class="large-text"><?php echo esc_textarea($features[$i]); ?></textarea>
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
            <h3>برندها</h3>
            <div id="brand-images-container" class="brand-images-container" >
                <?php foreach ($brand_images as $index => $image): ?>
                    <div class="brand-image-item" data-index="<?php echo $index; ?>">
                        <h4>عکس برند <?php echo $index + 1; ?>
                            <?php if (count($brand_images) > 1): ?>
                                <button type="button" class="button remove-brand-image">حذف</button>
                            <?php endif; ?>
                        </h4>
                        <table class="form-table">
                            <tr>
                                <th><label>عکس برند</label></th>
                                <td>
                                    <input type="text" name="brand_image[<?php echo $index; ?>]" 
                                        class="brand-image-url" value="<?php echo esc_attr($image); ?>" class="regular-text">
                                    <input type="button" class="button upload-brand-image" value="آپلود تصویر" 
                                        data-target="brand_<?php echo $index; ?>">
                                    <div class="image-preview brand-image-preview-<?php echo $index; ?>">
                                        <?php if (!empty($image)): ?>
                                            <img src="<?php echo esc_url($image); ?>" style="max-width: 200px;">
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            <p>
                <button type="button" class="button button-primary add-brand-image">افزودن عکس برند جدید</button>
            </p>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
                console.error('wp.media is not loaded');
                return;
            }

            $(document).on('click', '.upload-brand-image', function (e) {
                e.preventDefault();
                var button = $(this);
                var target = button.data('target');
                var container = button.closest('.brand-image-item');
                var image_url_field = container.find('.brand-image-url');
                var image_preview = container.find('.image-preview');
                
                var frame = wp.media({
                    title: 'انتخاب تصویر',
                    button: { text: 'استفاده از تصویر' },
                    multiple: false
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    image_url_field.val(attachment.url);
                    image_preview.html('<img src="' + attachment.url + '" style="max-width: 200px;">');
                });

                frame.open();
            });

            $('.add-brand-image').on('click', function () {
                var container = $('#brand-images-container');
                var index = container.find('.brand-image-item').length;
                var template = `
                    <div class="brand-image-item" data-index="${index}">
                        <h4>عکس برند ${index + 1}
                            <button type="button" class="button remove-brand-image">حذف</button>
                        </h4>
                        <table class="form-table">
                            <tr>
                                <th><label>عکس برند</label></th>
                                <td>
                                    <input type="text" name="brand_image[${index}]" class="brand-image-url" class="regular-text">
                                    <input type="button" class="button upload-brand-image" value="آپلود تصویر" data-target="brand_${index}">
                                    <div class="image-preview brand-image-preview-${index}"></div>
                                </td>
                            </tr>
                        </table>
                    </div>`;
                container.append(template);
            });

            $(document).on('click', '.remove-brand-image', function () {
                if ($('.brand-image-item').length > 1) {
                    $(this).closest('.brand-image-item').remove();
                    $('.brand-image-item').each(function (i) {
                        $(this).attr('data-index', i);
                        $(this).find('h4').text('عکس برند ' + (i + 1));
                        $(this).find('input, button').each(function () {
                            var name = $(this).attr('name');
                            var dataTarget = $(this).attr('data-target');
                            if (name) {
                                $(this).attr('name', name.replace(/brand_image\[\d+\]/, 'brand_image[' + i + ']'));
                            }
                            if (dataTarget) {
                                $(this).attr('data-target', 'brand_' + i);
                            }
                        });
                        $(this).find('.image-preview').attr('class', 'image-preview brand-image-preview-' + i);
                    });
                }
            });
        });
    </script>
    <?php
}
// اطلاعات تماس
function theme_settings_contact_page()
{
    if (isset($_POST['submit'])) {
        update_option('contact_hotline', sanitize_text_field($_POST['contact_hotline']));
        update_option('contact_emergency', sanitize_text_field($_POST['contact_emergency']));
        update_option('contact_email', sanitize_email($_POST['contact_email']));
        update_option('social_whatsapp', sanitize_text_field($_POST['social_whatsapp']));
        update_option('social_instagram', sanitize_text_field($_POST['social_instagram']));
        update_option('social_telegram', sanitize_text_field($_POST['social_telegram']));
        update_option('contact_location', sanitize_text_field($_POST['contact_location']));
        ?>
        <div class="updated">
            <p>تنظیمات ذخیره شد.</p>
        </div>
        <?php
    }
    ?>
    <div class="tab-content">
        <h2>اطلاعات تماس</h2>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th><label for="contact_hotline">خط ویژه</label></th>
                    <td><input type="text" name="contact_hotline" id="contact_hotline"
                            value="<?php echo esc_attr(get_option('contact_hotline')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="contact_emergency">تماس ضروری</label></th>
                    <td><input type="text" name="contact_emergency" id="contact_emergency"
                            value="<?php echo esc_attr(get_option('contact_emergency')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="contact_email">ایمیل</label></th>
                    <td><input type="email" name="contact_email" id="contact_email"
                            value="<?php echo esc_attr(get_option('contact_email')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="social_whatsapp">واتساپ</label></th>
                    <td><input type="text" name="social_whatsapp" id="social_whatsapp"
                            value="<?php echo esc_attr(get_option('social_whatsapp')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="social_instagram">اینستاگرام</label></th>
                    <td><input type="text" name="social_instagram" id="social_instagram"
                            value="<?php echo esc_attr(get_option('social_instagram')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="social_telegram">تلگرام</label></th>
                    <td><input type="text" name="social_telegram" id="social_telegram"
                            value="<?php echo esc_attr(get_option('social_telegram')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="contact_location">لوکیشن</label></th>
                    <td><input type="text" name="contact_location" id="contact_location"
                            value="<?php echo esc_attr(get_option('contact_location')); ?>" class="regular-text"></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// صفحه اصلی
function theme_settings_home_page()
{
    if (isset($_POST['submit'])) {
        update_option('home_meeting_title', sanitize_text_field($_POST['home_meeting_title']));
        update_option('home_meeting_content', sanitize_textarea_field($_POST['home_meeting_content']));
        update_option('home_service_1_title', sanitize_text_field($_POST['home_service_1_title']));
        update_option('home_service_1_content', sanitize_textarea_field($_POST['home_service_1_content']));
        update_option('home_service_2_title', sanitize_text_field($_POST['home_service_2_title']));
        update_option('home_service_2_content', sanitize_textarea_field($_POST['home_service_2_content']));
        for ($i = 1; $i <= 4; $i++) {
            update_option('home_cyberwhy_' . $i, sanitize_text_field($_POST['home_cyberwhy_' . $i]));
        }
        $faq_data = [];
        if (isset($_POST['home_faq_title_0'])) {
            for ($i = 0; isset($_POST['home_faq_title_' . $i]); $i++) {
                $faq_data[] = [
                    'title' => sanitize_text_field($_POST['home_faq_title_' . $i]),
                    'content' => sanitize_textarea_field($_POST['home_faq_content_' . $i]),
                ];
            }
        }
        update_option('home_faq_items', $faq_data);
        ?>
        <div class="updated">
            <p>تنظیمات ذخیره شد.</p>
        </div>
        <?php
    }
    ?>
    <div class="tab-content main-page">
        <h2>صفحه اصلی</h2>
        <form method="post" action="">
            <h3>متن ملاقات</h3>
            <table class="form-table">
                <tr>
                    <th><label for="home_meeting_title">عنوان</label></th>
                    <td><input type="text" name="home_meeting_title" id="home_meeting_title"
                            value="<?php echo esc_attr(get_option('home_meeting_title')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="home_meeting_content">محتوا</label></th>
                    <td><textarea name="home_meeting_content" id="home_meeting_content" rows="5"
                            class="large-text"><?php echo esc_textarea(get_option('home_meeting_content')); ?></textarea>
                    </td>
                </tr>
            </table>
            <h3>خدمات ما</h3>
            <h4>خدمت اول</h4>
            <table class="form-table">
                <tr>
                    <th><label for="home_service_1_title">عنوان</label></th>
                    <td><input type="text" name="home_service_1_title" id="home_service_1_title"
                            value="<?php echo esc_attr(get_option('home_service_1_title')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="home_service_1_content">محتوا</label></th>
                    <td><textarea name="home_service_1_content" id="home_service_1_content" rows="5"
                            class="large-text"><?php echo esc_textarea(get_option('home_service_1_content')); ?></textarea>
                    </td>
                </tr>
            </table>
            <h4>خدمت دوم</h4>
            <table class="form-table">
                <tr>
                    <th><label for="home_service_2_title">عنوان</label></th>
                    <td><input type="text" name="home_service_2_title" id="home_service_2_title"
                            value="<?php echo esc_attr(get_option('home_service_2_title')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="home_service_2_content">محتوا</label></th>
                    <td><textarea name="home_service_2_content" id="home_service_2_content" rows="5"
                            class="large-text"><?php echo esc_textarea(get_option('home_service_2_content')); ?></textarea>
                    </td>
                </tr>
            </table>
            <h3>چرا سایبری شو را انتخاب کنیم؟</h3>
            <table class="form-table">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <tr>
                        <th><label for="home_cyberwhy_<?php echo $i; ?>">عنوان آیتم <?php echo $i; ?></label></th>
                        <td>
                            <input type="text" name="home_cyberwhy_<?php echo $i; ?>" id="home_cyberwhy_<?php echo $i; ?>"
                                value="<?php echo esc_attr(get_option('home_cyberwhy_' . $i)); ?>" class="regular-text">
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
            <h3>سوالات متداول</h3>
            <div id="faq-container">
                <?php
                $faqs = get_option('home_faq_items', []);
                if (!empty($faqs)) {
                    foreach ($faqs as $index => $faq) {
                        ?>
                        <div class="faq-item" data-index="<?php echo $index; ?>">
                            <h4>سوال <?php echo $index + 1; ?>
                                <button type="button" class="button remove-faq">حذف</button>
                            </h4>
                            <table class="form-table">
                                <tr>
                                    <th><label for="home_faq_title_<?php echo $index; ?>">عنوان سوال</label></th>
                                    <td>
                                        <input type="text" name="home_faq_title_<?php echo $index; ?>"
                                            value="<?php echo esc_attr($faq['title']); ?>" class="regular-text">
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="home_faq_content_<?php echo $index; ?>">متن پاسخ</label></th>
                                    <td>
                                        <textarea name="home_faq_content_<?php echo $index; ?>" rows="5"
                                            class="large-text"><?php echo esc_textarea($faq['content']); ?></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="faq-item" data-index="0">
                        <h4>سوال 1
                            <button type="button" class="button remove-faq">حذف</button>
                        </h4>
                        <table class="form-table">
                            <tr>
                                <th><label for="home_faq_title_0">عنوان سوال</label></th>
                                <td>
                                    <input type="text" name="home_faq_title_0" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th><label for="home_faq_content_0">متن پاسخ</label></th>
                                <td>
                                    <textarea name="home_faq_content_0" rows="5" class="large-text"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
            <p>
                <button type="button" class="button button-primary add-faq">افزودن سوال جدید</button>
            </p>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// صفحه درباره ما
function theme_settings_about_page()
{
    if (isset($_POST['submit'])) {
        update_option('about_chart_title', sanitize_textarea_field($_POST['about_chart_title']));
        update_option('about_chart_years', sanitize_textarea_field($_POST['about_chart_years']));
        update_option('about_chart_desktop_image', esc_url_raw($_POST['about_chart_desktop_image']));
        update_option('about_chart_mobile_image', esc_url_raw($_POST['about_chart_mobile_image']));
        ?>
        <div class="updated">
            <p>تنظیمات نمودار در صفحه درباره ما ذخیره شد.</p>
        </div>
        <?php
    }

    $chart_title = get_option('about_chart_title', '');
    $chart_years = get_option('about_chart_years', '');
    $desktop_image = get_option('about_chart_desktop_image', '');
    $mobile_image = get_option('about_chart_mobile_image', '');
    ?>
    <div class="tab-content about-page">
        <h2>صفحه درباره ما</h2>
        <form method="post" action="">
            <h3>نمودار</h3>
            <table class="form-table">
                <tr>
                    <th><label for="about_chart_title">عملکرد سایبریشو</label></th>
                    <td>
                        <textarea name="about_chart_title" id="about_chart_title" rows="5"
                            class="large-text"><?php echo esc_textarea($chart_title); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="about_chart_years">سال‌های نمودار</label></th>
                    <td>
                        <textarea name="about_chart_years" id="about_chart_years" rows="5"
                            class="large-text"><?php echo esc_textarea($chart_years); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label>عکس نمودار در دسکتاپ</label></th>
                    <td>
                        <input type="text" name="about_chart_desktop_image" id="about_chart_desktop_image"
                            value="<?php echo esc_attr($desktop_image); ?>" class="regular-text">
                        <input type="button" class="button upload-chart-image" value="آپلود تصویر دسکتاپ"
                            data-target="desktop">
                    </td>
                </tr>
                <tr>
                    <th><label>عکس نمودار در موبایل</label></th>
                    <td>
                        <input type="text" name="about_chart_mobile_image" id="about_chart_mobile_image"
                            value="<?php echo esc_attr($mobile_image); ?>" class="regular-text">
                        <input type="button" class="button upload-chart-image" value="آپلود تصویر موبایل"
                            data-target="mobile">
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('click', '.upload-chart-image', function (e) {
                e.preventDefault();
                var button = $(this);
                var target = button.data('target');
                var inputField = $('#about_chart_' + target + '_image');

                var frame = wp.media({
                    title: 'انتخاب تصویر',
                    button: { text: 'استفاده از تصویر' },
                    multiple: false
                });

                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    inputField.val(attachment.url);
                });

                frame.open();
            });
        });
    </script>
    <?php
}

// صفحه لندینگ
function theme_settings_landing_page()
{
    if (isset($_POST['submit'])) {
        update_option('landing_initial_header', sanitize_textarea_field($_POST['landing_initial_header']));
        update_option('landing_initial_content', sanitize_textarea_field($_POST['landing_initial_content']));
        update_option('landing_footer_header', sanitize_textarea_field($_POST['landing_footer_header']));
        update_option('landing_footer_content', sanitize_textarea_field($_POST['landing_footer_content']));
        update_option('landing_pricing_header', sanitize_textarea_field($_POST['landing_pricing_header']));
        $pricing_rows = [];
        if (isset($_POST['pricing_row'])) {
            foreach ($_POST['pricing_row'] as $index => $row) {
                $pricing_rows[$index] = [
                    'description' => sanitize_textarea_field($row['description']),
                    'duration' => sanitize_textarea_field($row['duration']),
                    'price' => sanitize_textarea_field($row['price']),
                ];
            }
        }
        update_option('landing_pricing_rows', $pricing_rows);
        update_option('landing_pricing_footer', sanitize_textarea_field($_POST['landing_pricing_footer']));
        $site_types = [];
        if (isset($_POST['site_type'])) {
            foreach ($_POST['site_type'] as $index => $site) {
                $site_types[$index] = [
                    'image' => esc_url_raw($site['image']),
                    'content_header' => sanitize_textarea_field($site['content_header']),
                    'content' => sanitize_textarea_field($site['content']),
                    'feature_header' => sanitize_textarea_field($site['feature_header']),
                    'feature_1' => sanitize_textarea_field($site['feature_1']),
                    'feature_2' => sanitize_textarea_field($site['feature_2']),
                    'feature_3' => sanitize_textarea_field($site['feature_3']),
                ];
            }
        }
        update_option('landing_site_types', $site_types);
        $faq_data = [];
        if (isset($_POST['landing_page_faq_title_0'])) {
            for ($i = 0; isset($_POST['landing_page_faq_title_' . $i]); $i++) {
                $faq_data[] = [
                    'title' => sanitize_text_field($_POST['landing_page_faq_title_' . $i]),
                    'content' => sanitize_textarea_field($_POST['landing_page_faq_content_' . $i]),
                ];
            }
        }
        update_option('landing_page_faqs', $faq_data);
        ?>
        <div class="updated">
            <p>تنظیمات صفحه لندینگ ذخیره شد.</p>
        </div>
        <?php
    }

    $initial_header = get_option('landing_initial_header', '');
    $initial_content = get_option('landing_initial_content', '');
    $footer_header = get_option('landing_footer_header', '');
    $footer_content = get_option('landing_footer_content', '');
    $pricing_header = get_option('landing_pricing_header', '');
    $pricing_rows = get_option('landing_pricing_rows', []);
    $pricing_footer = get_option('landing_pricing_footer', '');
    $site_types = get_option('landing_site_types', []);
    $faqs = get_option('landing_page_faqs', []);

    if (empty($site_types)) {
        $site_types[] = [
            'image' => '',
            'content_header' => '',
            'content' => '',
            'feature_header' => '',
            'feature_1' => '',
            'feature_2' => '',
            'feature_3' => ''
        ];
    }

    if (empty($pricing_rows)) {
        $pricing_rows[] = [
            'description' => '',
            'duration' => '',
            'price' => ''
        ];
    }

    if (empty($faqs)) {
        $faqs[] = [
            'title' => '',
            'content' => ''
        ];
    }
    ?>
    <div class="tab-content landing-page">
        <h2>صفحه لندینگ</h2>
        <form method="post" action="">
            <h3>هدر و محتوای اولیه</h3>
            <table class="form-table">
                <tr>
                    <th><label for="landing_initial_header">هدر اولیه</label></th>
                    <td>
                        <textarea name="landing_initial_header" id="landing_initial_header" rows="3" class="large-text"><?php echo esc_textarea($initial_header); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="landing_initial_content">محتوای اولیه</label></th>
                    <td>
                        <textarea name="landing_initial_content" id="landing_initial_content" rows="5" class="large-text"><?php echo esc_textarea($initial_content); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="landing_footer_header">هدر پاورقی</label></th>
                    <td>
                        <textarea name="landing_footer_header" id="landing_footer_header" rows="3" class="large-text"><?php echo esc_textarea($footer_header); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="landing_footer_content">محتوای پاورقی</label></th>
                    <td>
                        <textarea name="landing_footer_content" id="landing_footer_content" rows="5" class="large-text"><?php echo esc_textarea($footer_content); ?></textarea>
                    </td>
                </tr>
            </table>
            <h3>انواع سایت</h3>
            <div id="site-types-container">
                <?php foreach ($site_types as $index => $site): ?>
                    <div class="site-type-item" data-index="<?php echo $index; ?>">
                        <h4>نوع سایت <?php echo $index + 1; ?>
                            <button type="button" class="button remove-site-type">حذف</button>
                        </h4>
                        <table class="form-table">
                            <tr class="image-section">
                                <th><label>عکس این قسمت</label></th>
                                <td>
                                    <input type="hidden" name="site_type[<?php echo $index; ?>][image]" 
                                        class="site-image-url" value="<?php echo esc_attr($site['image']); ?>">
                                    <input type="button" class="button upload-image-button" value="آپلود تصویر" data-target="site">
                                    <div class="image-preview site-image-preview">
                                        <?php if (!empty($site['image'])): ?>
                                            <img src="<?php echo esc_url($site['image']); ?>" style="max-width: 200px;">
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_content_header_<?php echo $index; ?>">هدر محتوا</label></th>
                                <td>
                                    <textarea name="site_type[<?php echo $index; ?>][content_header]" 
                                        id="site_type_content_header_<?php echo $index; ?>" rows="3" 
                                        class="large-text"><?php echo esc_textarea($site['content_header']); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_content_<?php echo $index; ?>">محتوا</label></th>
                                <td>
                                    <textarea name="site_type[<?php echo $index; ?>][content]" 
                                        id="site_type_content_<?php echo $index; ?>" rows="5" 
                                        class="large-text"><?php echo esc_textarea($site['content']); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_feature_header_<?php echo $index; ?>">هدر ویژگی</label></th>
                                <td>
                                    <textarea name="site_type[<?php echo $index; ?>][feature_header]" 
                                        id="site_type_feature_header_<?php echo $index; ?>" rows="3" 
                                        class="large-text"><?php echo esc_textarea($site['feature_header']); ?></textarea>
                                </td>
                            </tr>
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                <tr>
                                    <th><label for="site_type_feature_<?php echo $i; ?>_<?php echo $index; ?>">ویژگی <?php echo $i; ?></label></th>
                                    <td>
                                        <textarea name="site_type[<?php echo $index; ?>][feature_<?php echo $i; ?>]" 
                                            id="site_type_feature_<?php echo $i; ?>_<?php echo $index; ?>" rows="3" 
                                            class="large-text"><?php echo esc_textarea($site['feature_' . $i]); ?></textarea>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            <p>
                <button type="button" class="button button-primary add-site-type">افزودن نوع سایت جدید</button>
            </p>
            <h3>قیمت و تعرفه‌های طراحی سایت</h3>
            <table class="form-table">
                <tr>
                    <th><label for="landing_pricing_header">محتوای هدر</label></th>
                    <td>
                        <textarea name="landing_pricing_header" id="landing_pricing_header" rows="3" class="large-text"><?php echo esc_textarea($pricing_header); ?></textarea>
                    </td>
                </tr>
            </table>
            <h4>جدول</h4>
            <div id="pricing-rows-container">
                <?php foreach ($pricing_rows as $index => $row): ?>
                    <div class="pricing-row-item" data-index="<?php echo $index; ?>">
                        <h5>سطر <?php echo $index + 1; ?>
                            <button type="button" class="button remove-pricing-row">حذف</button>
                        </h5>
                        <table class="form-table">
                            <tr>
                                <th><label for="pricing_row_description_<?php echo $index; ?>">شرح خدمات</label></th>
                                <td>
                                    <textarea name="pricing_row[<?php echo $index; ?>][description]" 
                                        id="pricing_row_description_<?php echo $index; ?>" rows="3" 
                                        class="large-text"><?php echo esc_textarea($row['description']); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="pricing_row_duration_<?php echo $index; ?>">مدت زمان</label></th>
                                <td>
                                    <textarea name="pricing_row[<?php echo $index; ?>][duration]" 
                                        id="pricing_row_duration_<?php echo $index; ?>" rows="3" 
                                        class="large-text"><?php echo esc_textarea($row['duration']); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="pricing_row_price_<?php echo $index; ?>">قیمت</label></th>
                                <td>
                                    <textarea name="pricing_row[<?php echo $index; ?>][price]" 
                                        id="pricing_row_price_<?php echo $index; ?>" rows="3" 
                                        class="large-text"><?php echo esc_textarea($row['price']); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            <p>
                <button type="button" class="button button-primary add-pricing-row">افزودن سطر جدید</button>
            </p>
            <table class="form-table">
                <tr>
                    <th><label for="landing_pricing_footer">محتوای فوتر</label></th>
                    <td>
                        <textarea name="landing_pricing_footer" id="landing_pricing_footer" rows="5" class="large-text"><?php echo esc_textarea($pricing_footer); ?></textarea>
                    </td>
                </tr>
            </table>
            <h3>سوالات متداول</h3>
            <div id="landing-faq-container">
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="faq-item" data-index="<?php echo $index; ?>">
                        <h4>سوال <?php echo $index + 1; ?>
                            <button type="button" class="button remove-landing-faq">حذف</button>
                        </h4>
                        <table class="form-table">
                            <tr>
                                <th><label for="landing_page_faq_title_<?php echo $index; ?>">عنوان سوال</label></th>
                                <td>
                                    <input type="text" name="landing_page_faq_title_<?php echo $index; ?>" 
                                        id="landing_page_faq_title_<?php echo $index; ?>" 
                                        value="<?php echo esc_attr($faq['title']); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th><label for="landing_page_faq_content_<?php echo $index; ?>">متن پاسخ</label></th>
                                <td>
                                    <textarea name="landing_page_faq_content_<?php echo $index; ?>" 
                                        id="landing_page_faq_content_<?php echo $index; ?>" rows="5" 
                                        class="large-text"><?php echo esc_textarea($faq['content']); ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            <p>
                <button type="button" class="button button-primary add-landing-faq">افزودن سوال جدید</button>
            </p>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
                console.error('wp.media is not loaded');
                return;
            }
            $(document).on('click', '.upload-image-button', function (e) {
                e.preventDefault();
                var button = $(this);
                var target = button.data('target');
                var container = button.closest('.site-type-item');
                var image_url_field = container.find('.' + target + '-image-url');
                var image_preview = container.find('.' + target + '-image-preview');
                var frame = wp.media({
                    title: 'انتخاب تصویر',
                    button: { text: 'استفاده از تصویر' },
                    multiple: false
                });
                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    image_url_field.val(attachment.url);
                    image_preview.html('<img src="' + attachment.url + '" style="max-width: 200px;">');
                });
                frame.open();
            });
            $('.add-site-type').on('click', function () {
                var container = $('#site-types-container');
                var index = container.find('.site-type-item').length;
                var template = `
                    <div class="site-type-item" data-index="${index}">
                        <h4>نوع سایت ${index + 1}
                            <button type="button" class="button remove-site-type">حذف</button>
                        </h4>
                        <table class="form-table">
                            <tr class="image-section">
                                <th><label>عکس این قسمت</label></th>
                                <td>
                                    <input type="hidden" name="site_type[${index}][image]" class="site-image-url">
                                    <input type="button" class="button upload-image-button" value="آپلود تصویر" data-target="site">
                                    <div class="image-preview site-image-preview"></div>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_content_header_${index}">هدر محتوا</label></th>
                                <td>
                                    <textarea name="site_type[${index}][content_header]" id="site_type_content_header_${index}" rows="3" class="large-text"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_content_${index}">محتوا</label></th>
                                <td>
                                    <textarea name="site_type[${index}][content]" id="site_type_content_${index}" rows="5" class="large-text"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_feature_header_${index}">هدر ویژگی</label></th>
                                <td>
                                    <textarea name="site_type[${index}][feature_header]" id="site_type_feature_header_${index}" rows="3" class="large-text"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_feature_1_${index}">ویژگی 1</label></th>
                                <td>
                                    <textarea name="site_type[${index}][feature_1]" id="site_type_feature_1_${index}" rows="3" class="large-text"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_feature_2_${index}">ویژگی 2</label></th>
                                <td>
                                    <textarea name="site_type[${index}][feature_2]" id="site_type_feature_2_${index}" rows="3" class="large-text"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="site_type_feature_3_${index}">ویژگی 3</label></th>
                                <td>
                                    <textarea name="site_type[${index}][feature_3]" id="site_type_feature_3_${index}" rows="3" class="large-text"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>`;
                container.append(template);
            });
            $(document).on('click', '.remove-site-type', function () {
                if ($('.site-type-item').length > 1) {
                    $(this).closest('.site-type-item').remove();
                    $('.site-type-item').each(function (i) {
                        $(this).attr('data-index', i);
                        $(this).find('h4').text('نوع سایت ' + (i + 1));
                        $(this).find('input, textarea, button').each(function () {
                            var name = $(this).attr('name');
                            var id = $(this).attr('id');
                            if (name) {
                                $(this).attr('name', name.replace(/site_type\[\d+\]/, 'site_type[' + i + ']'));
                            }
                            if (id) {
                                $(this).attr('id', id.replace(/site_type_([a-z_]+)_(\d+)/, 'site_type_$1_' + i));
                            }
                        });
                    });
                }
            });
            $('.add-pricing-row').on('click', function () {
                var container = $('#pricing-rows-container');
                var index = container.find('.pricing-row-item').length;
                var template = `
                    <div class="pricing-row-item" data-index="${index}">
                        <h5>سطر ${index + 1}
                            <button type="button" class="button remove-pricing-row">حذف</button>
                        </h5>
                        <table class="form-table">
                            <tr>
                                <th><label for="pricing_row_description_${index}">شرح خدمات</label></th>
                                <td>
                                    <textarea name="pricing_row[${index}][description]" id="pricing_row_description_${index}" rows="3" class="large-text"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="pricing_row_duration_${index}">مدت زمان</label></th>
                                <td>
                                    <textarea name="pricing_row[${index}][duration]" id="pricing_row_duration_${index}" rows="3" class="large-text"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="pricing_row_price_${index}">قیمت</label></th>
                                <td>
                                    <textarea name="pricing_row[${index}][price]" id="pricing_row_price_${index}" rows="3" class="large-text"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>`;
                container.append(template);
            });
            $(document).on('click', '.remove-pricing-row', function () {
                if ($('.pricing-row-item').length > 1) {
                    $(this).closest('.pricing-row-item').remove();
                    $('.pricing-row-item').each(function (i) {
                        $(this).attr('data-index', i);
                        $(this).find('h5').text('سطر ' + (i + 1));
                        $(this).find('textarea').each(function () {
                            var name = $(this).attr('name');
                            var id = $(this).attr('id');
                            if (name) {
                                $(this).attr('name', name.replace(/pricing_row\[\d+\]/, 'pricing_row[' + i + ']'));
                            }
                            if (id) {
                                $(this).attr('id', id.replace(/pricing_row_([a-z_]+)_(\d+)/, 'pricing_row_$1_' + i));
                            }
                        });
                    });
                }
            });
            $('.add-landing-faq').on('click', function () {
                var container = $('#landing-faq-container');
                var index = container.find('.faq-item').length;
                var template = `
                    <div class="faq-item" data-index="${index}">
                        <h4>سوال ${index + 1}
                            <button type="button" class="button remove-landing-faq">حذف</button>
                        </h4>
                        <table class="form-table">
                            <tr>
                                <th><label for="landing_page_faq_title_${index}">عنوان سوال</label></th>
                                <td>
                                    <input type="text" name="landing_page_faq_title_${index}" id="landing_page_faq_title_${index}" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th><label for="landing_page_faq_content_${index}">متن پاسخ</label></th>
                                <td>
                                    <textarea name="landing_page_faq_content_${index}" id="landing_page_faq_content_${index}" rows="5" class="large-text"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>`;
                container.append(template);
            });
            $(document).on('click', '.remove-landing-faq', function () {
                if ($('#landing-faq-container .faq-item').length > 1) {
                    $(this).closest('.faq-item').remove();
                    $('#landing-faq-container .faq-item').each(function (i) {
                        $(this).attr('data-index', i);
                        $(this).find('h4').text('سوال ' + (i + 1));
                        $(this).find('input, textarea').each(function () {
                            var name = $(this).attr('name');
                            var id = $(this).attr('id');
                            if (name) {
                                $(this).attr('name', name.replace(/landing_page_faq_(title|content)_\d+/, 'landing_page_faq_$1_' + i));
                            }
                            if (id) {
                                $(this).attr('id', id.replace(/landing_page_faq_(title|content)_\d+/, 'landing_page_faq_$1_' + i));
                            }
                        });
                    });
                }
            });
        });
    </script>
    <?php
}

// صفحه نمونه کارها
function theme_settings_portfolio_page()
{
    if (isset($_POST['submit'])) {
        $portfolios = [];
        if (isset($_POST['portfolio'])) {
            foreach ($_POST['portfolio'] as $index => $portfolio) {
                $portfolios[$index] = [
                    'name' => sanitize_text_field($portfolio['name']),
                    'type' => sanitize_text_field($portfolio['type']),
                    'duration' => sanitize_text_field($portfolio['duration']),
                    'location' => sanitize_text_field($portfolio['location']),
                    'url' => esc_url_raw($portfolio['url']),
                    'main_image' => esc_url_raw($portfolio['main_image'] ?? ''),
                    'desktop_image' => esc_url_raw($portfolio['desktop_image']),
                    'mobile_image' => esc_url_raw($portfolio['mobile_image']),
                ];
            }
        }
        update_option('theme_portfolios', $portfolios);
        ?>
        <div class="updated">
            <p>نمونه کارها ذخیره شد.</p>
        </div>
        <?php
    }

    $portfolios = get_option('theme_portfolios', []);
    if (empty($portfolios)) {
        $portfolios[] = [
            'name' => '',
            'type' => '',
            'duration' => '',
            'location' => '',
            'url' => '',
            'main_image' => '',
            'desktop_image' => '',
            'mobile_image' => ''
        ];
    } else {
        foreach ($portfolios as &$portfolio) {
            if (!isset($portfolio['main_image'])) {
                $portfolio['main_image'] = '';
            }
        }
        unset($portfolio);
    }
    ?>
    <div class="tab-content landing-page">
        <h2>صفحه نمونه کارها</h2>
        <form method="post" action="">
            <div id="portfolio-container">
                <?php foreach ($portfolios as $index => $portfolio): ?>
                    <div class="portfolio-item" data-index="<?php echo $index; ?>">
                        <h3>نمونه کار <?php echo $index + 1; ?>
                            <button type="button" class="button remove-portfolio">حذف</button>
                        </h3>
                        <table class="form-table">
                            <tr>
                                <th><label>نام نمونه کار</label></th>
                                <td><input type="text" name="portfolio[<?php echo $index; ?>][name]"
                                        value="<?php echo esc_attr($portfolio['name']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label>نوع سایت</label></th>
                                <td><input type="text" name="portfolio[<?php echo $index; ?>][type]"
                                        value="<?php echo esc_attr($portfolio['type']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label>مدت زمان انجام</label></th>
                                <td><input type="text" name="portfolio[<?php echo $index; ?>][duration]"
                                        value="<?php echo esc_attr($portfolio['duration']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label>موقعیت</label></th>
                                <td><input type="text" name="portfolio[<?php echo $index; ?>][location]"
                                        value="<?php echo esc_attr($portfolio['location']); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label>URL سایت</label></th>
                                <td><input type="url" name="portfolio[<?php echo $index; ?>][url]"
                                        value="<?php echo esc_attr($portfolio['url']); ?>" class="regular-text"></td>
                            </tr>
                            <tr class="image-section">
                                <th><label>عکس اصلی</label></th>
                                <td>
                                    <input type="hidden" name="portfolio[<?php echo $index; ?>][main_image]"
                                        class="main-image-url" value="<?php echo esc_attr($portfolio['main_image'] ?? ''); ?>">
                                    <input type="button" class="button upload-image-button" value="آپلود تصویر"
                                        data-target="main">
                                    <div class="image-preview main-image-preview">
                                        <?php if (!empty($portfolio['main_image'])): ?>
                                            <img src="<?php echo esc_url($portfolio['main_image']); ?>" style="max-width: 200px;">
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="image-section">
                                <th><label>عکس دسکتاپ</label></th>
                                <td>
                                    <input type="hidden" name="portfolio[<?php echo $index; ?>][desktop_image]"
                                        class="desktop-image-url" value="<?php echo esc_attr($portfolio['desktop_image']); ?>">
                                    <input type="button" class="button upload-image-button" value="آپلود تصویر"
                                        data-target="desktop">
                                    <div class="image-preview desktop-image-preview">
                                        <?php if ($portfolio['desktop_image']): ?>
                                            <img src="<?php echo esc_url($portfolio['desktop_image']); ?>"
                                                style="max-width: 200px;">
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="image-section">
                                <th><label>عکس موبایل</label></th>
                                <td>
                                    <input type="hidden" name="portfolio[<?php echo $index; ?>][mobile_image]"
                                        class="mobile-image-url" value="<?php echo esc_attr($portfolio['mobile_image']); ?>">
                                    <input type="button" class="button upload-image-button" value="آپلود تصویر"
                                        data-target="mobile">
                                    <div class="image-preview mobile-image-preview">
                                        <?php if ($portfolio['mobile_image']): ?>
                                            <img src="<?php echo esc_url($portfolio['mobile_image']); ?>" style="max-width: 200px;">
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            <p>
                <button type="button" class="button add-portfolio">افزودن نمونه کار جدید</button>
            </p>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
                console.error('wp.media is not loaded');
                return;
            }
            $(document).on('click', '.upload-image-button', function (e) {
                e.preventDefault();
                var button = $(this);
                var target = button.data('target');
                var container = button.closest('.portfolio-item');
                var image_url_field = container.find('.' + target + '-image-url');
                var image_preview = container.find('.' + target + '-image-preview');
                var frame = wp.media({
                    title: 'انتخاب تصویر',
                    button: { text: 'استفاده از تصویر' },
                    multiple: false
                });
                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    image_url_field.val(attachment.url);
                    image_preview.html('<img src="' + attachment.url + '" style="max-width: 200px;">');
                });
                frame.open();
            });
            $('.add-portfolio').on('click', function () {
                var container = $('#portfolio-container');
                var index = container.find('.portfolio-item').length;
                var template = `
                    <div class="portfolio-item" data-index="${index}">
                        <h3>نمونه کار ${index + 1}
                            <button type="button" class="button remove-portfolio">حذف</button>
                        </h3>
                        <table class="form-table">
                            <tr>
                                <th><label>نام نمونه کار</label></th>
                                <td><input type="text" name="portfolio[${index}][name]" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label>نوع سایت</label></th>
                                <td><input type="text" name="portfolio[${index}][type]" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label>مدت زمان انجام</label></th>
                                <td><input type="text" name="portfolio[${index}][duration]" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label>موقعیت</label></th>
                                <td><input type="text" name="portfolio[${index}][location]" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label>URL سایت</label></th>
                                <td><input type="url" name="portfolio[${index}][url]" class="regular-text"></td>
                            </tr>
                            <tr class="image-section">
                                <th><label>عکس اصلی</label></th>
                                <td>
                                    <input type="hidden" name="portfolio[${index}][main_image]" class="main-image-url">
                                    <input type="button" class="button upload-image-button" value="آپلود تصویر" data-target="main">
                                    <div class="image-preview main-image-preview"></div>
                                </td>
                            </tr>
                            <tr class="image-section">
                                <th><label>عکس دسکتاپ</label></th>
                                <td>
                                    <input type="hidden" name="portfolio[${index}][desktop_image]" class="desktop-image-url">
                                    <input type="button" class="button upload-image-button" value="آپلود تصویر" data-target="desktop">
                                    <div class="image-preview desktop-image-preview"></div>
                                </td>
                            </tr>
                            <tr class="image-section">
                                <th><label>عکس موبایل</label></th>
                                <td>
                                    <input type="hidden" name="portfolio[${index}][mobile_image]" class="mobile-image-url">
                                    <input type="button" class="button upload-image-button" value="آپلود تصویر" data-target="mobile">
                                    <div class="image-preview mobile-image-preview"></div>
                                </td>
                            </tr>
                        </table>
                    </div>`;
                container.append(template);
            });
            $(document).on('click', '.remove-portfolio', function () {
                if ($('.portfolio-item').length > 1) {
                    $(this).closest('.portfolio-item').remove();
                    $('.portfolio-item').each(function (i) {
                        $(this).attr('data-index', i);
                        $(this).find('h3').text('نمونه کار ' + (i + 1));
                        $(this).find('input, button').each(function () {
                            var name = $(this).attr('name');
                            if (name) {
                                $(this).attr('name', name.replace(/portfolio\[\d+\]/, 'portfolio[' + i + ']'));
                            }
                        });
                    });
                }
            });
        });
    </script>
    <?php
}

// بارگذاری استایل‌ها و اسکریپت‌ها
add_action('admin_enqueue_scripts', 'theme_settings_enqueue_scripts');

function theme_settings_enqueue_scripts($hook)
{
    if ($hook !== 'toplevel_page_theme-settings') {
        return;
    }
    wp_enqueue_style('theme-settings', get_template_directory_uri() . '/_inc/meta-box/css/style.css', [], '1.0');
    wp_enqueue_media();
    wp_enqueue_script('jquery');
    wp_enqueue_script('theme-admin-js', get_template_directory_uri() . '/_inc/meta-box/js/admin.js', ['jquery'], null, true);
}
?>