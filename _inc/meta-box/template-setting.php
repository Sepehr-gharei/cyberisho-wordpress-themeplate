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
        'site-info' => 'اطلاعات سایت',
        'contact' => 'اطلاعات تماس',
        'home' => 'صفحه اصلی',
        'about' => 'صفحه درباره ما',
        'landing' => 'صفحه لندینگ',
        'portfolio' => 'صفحه نمونه کارها'
    ];

    $current_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'site-info';

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
        // Display content based on active tab
        switch ($current_tab) {
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
                theme_settings_site_info_page();
                break;
        }
        ?>
    </div>
    <?php
}

// اطلاعات سایت (خالی)
function theme_settings_site_info_page()
{
    // ذخیره تنظیمات
    if (isset($_POST['submit'])) {
        // بنر فعلی
        update_option('banner_header', sanitize_textarea_field($_POST['banner_header']));
        update_option('banner_content', sanitize_textarea_field($_POST['banner_content']));

        // تعداد پروژه ها
        update_option('project_count', sanitize_textarea_field($_POST['project_count']));
        update_option('project_start_year', sanitize_textarea_field($_POST['project_start_year']));

        // تعداد تیم
        update_option('team_total', sanitize_textarea_field($_POST['team_total']));
        update_option('team_developer', sanitize_textarea_field($_POST['team_developer']));
        update_option('team_graphic', sanitize_textarea_field($_POST['team_graphic']));
        update_option('team_support', sanitize_textarea_field($_POST['team_support']));
        update_option('team_seo', sanitize_textarea_field($_POST['team_seo']));

        ?>
        <div class="updated">
            <p>تنظیمات بنر، پروژه‌ها و تیم ما ذخیره شد.</p>
        </div>
        <?php
    }

    // دریافت مقادیر فعلی
    $banner_header = get_option('banner_header', '');
    $banner_content = get_option('banner_content', '');
    $project_count = get_option('project_count', '');
    $project_start_year = get_option('project_start_year', '');

    $team_total = get_option('team_total', '');
    $team_developer = get_option('team_developer', '');
    $team_graphic = get_option('team_graphic', '');
    $team_support = get_option('team_support', '');
    $team_seo = get_option('team_seo', '');
    ?>
    <div class="tab-content site-information">
        <h2>اطلاعات سایت</h2>

        <!-- فرم بنر شعار -->
        <form method="post" action="">
            <h3>قسمت بنر شعار</h3>
            <table class="form-table">
                <tr>
                    <th><label for="banner_header">هدر بنر</label></th>
                    <td>
                        <textarea name="banner_header" id="banner_header" rows="3" class="large-text"><?php echo esc_textarea($banner_header); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="banner_content">محتوا بنر</label></th>
                    <td>
                        <textarea name="banner_content" id="banner_content" rows="5" class="large-text"><?php echo esc_textarea($banner_content); ?></textarea>
                    </td>
                </tr>
            </table>

            <!-- فرم تعداد پروژه ها -->
            <h3>تعداد پروژه‌ها</h3>
            <table class="form-table">
                <tr>
                    <th><label for="project_count">تعداد پروژه‌ها</label></th>
                    <td>
                        <textarea name="project_count" id="project_count" rows="2" class="large-text"><?php echo esc_textarea($project_count); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="project_start_year">سال شروع پروژه‌ها</label></th>
                    <td>
                        <textarea name="project_start_year" id="project_start_year" rows="2" class="large-text"><?php echo esc_textarea($project_start_year); ?></textarea>
                    </td>
                </tr>
            </table>

            <!-- فرم تعداد تیم -->
            <h3>تیم ما</h3>
            <table class="form-table">
                <tr>
                    <th><label for="team_total">تعداد نفرات تیم</label></th>
                    <td>
                        <textarea name="team_total" id="team_total" rows="2" class="large-text"><?php echo esc_textarea($team_total); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="team_developer">تعداد برنامه‌نویس</label></th>
                    <td>
                        <textarea name="team_developer" id="team_developer" rows="2" class="large-text"><?php echo esc_textarea($team_developer); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="team_graphic">تعداد گرافیست</label></th>
                    <td>
                        <textarea name="team_graphic" id="team_graphic" rows="2" class="large-text"><?php echo esc_textarea($team_graphic); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="team_support">تعداد پشتیبان</label></th>
                    <td>
                        <textarea name="team_support" id="team_support" rows="2" class="large-text"><?php echo esc_textarea($team_support); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="team_seo">تعداد سئوکار</label></th>
                    <td>
                        <textarea name="team_seo" id="team_seo" rows="2" class="large-text"><?php echo esc_textarea($team_seo); ?></textarea>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
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
        // Save FAQs
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
            <h3>سوالات متداوم</h3>
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
                    // Default one empty item
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

// صفحه درباره ما (خالی)
// صفحه درباره ما - به‌روزشده
function theme_settings_about_page()
{
    // ذخیره تنظیمات
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

        <!-- فرم قسمت نمودار -->
        <form method="post" action="">
            <h3>نمودار</h3>
            <table class="form-table">
                <tr>
                    <th><label for="about_chart_title">عملکرد سایبریشو</label></th>
                    <td>
                        <textarea name="about_chart_title" id="about_chart_title" rows="5" class="large-text"><?php echo esc_textarea($chart_title); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="about_chart_years">سال‌های نمودار</label></th>
                    <td>
                        <textarea name="about_chart_years" id="about_chart_years" rows="5" class="large-text"><?php echo esc_textarea($chart_years); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label>عکس نمودار در دسکتاپ</label></th>
                    <td>
                        <input type="text" name="about_chart_desktop_image" id="about_chart_desktop_image" value="<?php echo esc_attr($desktop_image); ?>" class="regular-text">
                        <input type="button" class="button upload-chart-image" value="آپلود تصویر دسکتاپ" data-target="desktop">
                    </td>
                </tr>
                <tr>
                    <th><label>عکس نمودار در موبایل</label></th>
                    <td>
                        <input type="text" name="about_chart_mobile_image" id="about_chart_mobile_image" value="<?php echo esc_attr($mobile_image); ?>" class="regular-text">
                        <input type="button" class="button upload-chart-image" value="آپلود تصویر موبایل" data-target="mobile">
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
                var inputField = $('#' + 'about_chart_' + target + '_image');

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

// صفحه لندینگ (خالی)
function theme_settings_landing_page()
{
    ?>
    <div class="tab-content">
        <h2>صفحه لندینگ</h2>
        <p>این بخش فعلاً خالی است.</p>
    </div>
    <?php
}

// صفحه نمونه کارها
function theme_settings_portfolio_page()
{
    // Save portfolio data
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

    // Load existing portfolios
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
        // Ensure main_image exists in existing portfolios
        foreach ($portfolios as &$portfolio) {
            if (!isset($portfolio['main_image'])) {
                $portfolio['main_image'] = '';
            }
        }
        unset($portfolio); // Unset reference to avoid issues
    }
    ?>
    <div class="tab-content">
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
                            <tr style="width: 100%;">
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
            // بررسی وجود wp.media
            if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
                console.error('wp.media is not loaded');
                return;
            }

            // آپلود تصویر
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

            // افزودن نمونه‌کار جدید
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
                            <tr style="width: 100%;">
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

            // حذف نمونه‌کار
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
    // بارگذاری استایل
    wp_enqueue_style('theme-settings', get_template_directory_uri() . '/_inc/meta-box/css/style.css', [], '1.0');
    // بارگذاری اسکریپت‌های مورد نیاز برای آپلود رسانه
    wp_enqueue_media();
    wp_enqueue_script('jquery');
    wp_enqueue_script('theme-admin-js', get_template_directory_uri() . '/_inc/meta-box/js/admin.js', ['jquery'], null, true);
}

?>