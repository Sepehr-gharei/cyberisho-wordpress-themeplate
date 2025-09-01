<?php
add_theme_support('post-thumbnails');
function custom_post_type_pagination($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('portfolio')) {
        $query->set('posts_per_page', 1); // تعداد پست‌ها در هر صفحه
    }

    if (!is_admin() && $query->is_main_query() && is_post_type_archive('blog')) {
        $query->set('posts_per_page', 1); // تعداد پست‌ها در هر صفحه
    }


}
add_action('pre_get_posts', 'custom_post_type_pagination');
function calculate_reading_time($post_id)
{
    // دریافت محتوای مقدمه
    $intro = get_post_meta($post_id, '_post_intro', true);
    $intro = is_string($intro) ? $intro : ''; // اطمینان از رشته بودن
    $intro_clean = strip_tags($intro); // حذف تگ‌های HTML
    $intro_word_count = str_word_count($intro_clean, 0, 'آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی'); // پشتیبانی از حروف فارسی
    error_log('Intro Word Count: ' . $intro_word_count); // لاگ برای عیب‌یابی

    // دریافت محتوای بخش‌ها
    $sections = get_post_meta($post_id, '_post_sections', true);
    $sections_word_count = 0;

    if (is_array($sections) && !empty($sections)) {
        foreach ($sections as $index => $section) {
            // شمارش کلمات هدر
            $header_content = isset($section['header_content']) && is_string($section['header_content']) ? $section['header_content'] : '';
            $header_clean = strip_tags($header_content);
            $header_word_count = str_word_count($header_clean, 0, 'آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی');
            $sections_word_count += $header_word_count;
            error_log('Section ' . $index . ' Header Word Count: ' . $header_word_count); // لاگ برای عیب‌یابی

            // شمارش کلمات پاراگراف‌ها
            $paragraphs = isset($section['paragraphs']) && is_array($section['paragraphs']) ? $section['paragraphs'] : [];
            foreach ($paragraphs as $p_index => $paragraph) {
                $paragraph = is_string($paragraph) ? $paragraph : '';
                $paragraph_clean = strip_tags($paragraph);
                $paragraph_word_count = str_word_count($paragraph_clean, 0, 'آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی');
                $sections_word_count += $paragraph_word_count;
                error_log('Section ' . $index . ' Paragraph ' . $p_index . ' Word Count: ' . $paragraph_word_count); // لاگ برای عیب‌یابی
            }
        }
    }
    error_log('Sections Total Word Count: ' . $sections_word_count); // لاگ برای عیب‌یابی

    // مجموع کلمات
    $total_word_count = $intro_word_count + $sections_word_count;
    error_log('Total Word Count: ' . $total_word_count); // لاگ برای عیب‌یابی

    // محاسبه زمان مطالعه (فرض: 180 کلمه در دقیقه برای فارسی)
    $reading_speed = 180; // سرعت مطالعه برای فارسی
    $reading_time = $total_word_count > 0 ? ceil($total_word_count / $reading_speed) : 1; // حداقل 1 دقیقه
    error_log('Reading Time: ' . $reading_time . ' minutes'); // لاگ برای عیب‌یابی

    return [
        'word_count' => $total_word_count,
        'reading_time' => $reading_time
    ];
}


// تابع برای افزودن ویدئو و شمارش بازدید در صفحه single
function add_video_and_track_views()
{
    // فقط در صفحات single پست اجرا شود
    if (is_single()) {
        global $post;

        // شمارش بازدیدها
        $view_count = get_post_meta($post->ID, 'post_views_count', true);
        $view_count = ($view_count) ? intval($view_count) + 1 : 1;
        update_post_meta($post->ID, 'post_views_count', $view_count);

        // لیست ویدئوها (می‌توانید URL ویدئوها را اینجا اضافه کنید)
        $videos = array(
            'https://example.com/video1.mp4',
            'https://example.com/video2.mp4',
            'https://example.com/video3.mp4',
            // ویدئوهای بیشتر را اینجا اضافه کنید
        );

        // انتخاب رندوم یک ویدئو
        $random_video = $videos[array_rand($videos)];

        // افزودن ویدئو و تعداد بازدید به محتوا
        add_filter('the_content', function ($content) use ($random_video, $view_count) {
            $video_html = '<video controls><source src="' . esc_url($random_video) . '" type="video/mp4">مرورگر شما از ویدئو پشتیبانی نمی‌کند.</video>';
            $views_html = '<p>تعداد بازدید: ' . $view_count . '</p>';
            return $content . $video_html . $views_html;
        });
    }
}
add_action('wp', 'add_video_and_track_views');

// شورت‌کد برای نمایش تعداد بازدید در صورت نیاز
function display_post_views()
{
    global $post;
    $view_count = get_post_meta($post->ID, 'post_views_count', true);
    return $view_count ? $view_count : 0;
}
add_shortcode('post_views', 'display_post_views');

function add_like_dislike_fields()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Add like_count and dislike_count to wp_postmeta if they don't exist
    $sql = "ALTER TABLE $wpdb->postmeta 
            ADD IF NOT EXISTS like_count INT DEFAULT 0,
            ADD IF NOT EXISTS dislike_count INT DEFAULT 0";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'add_like_dislike_fields');

// AJAX handler for like/dislike
function handle_like_dislike()
{
    if (!isset($_POST['post_id']) || !isset($_POST['action_type'])) {
        wp_send_json_error('Invalid request');
    }

    $post_id = intval($_POST['post_id']);
    $action_type = sanitize_text_field($_POST['action_type']);
    $cookie_name = 'voted_' . $post_id;

    // Check if user has already voted
    if (isset($_COOKIE[$cookie_name])) {
        wp_send_json_error('You have already voted');
    }

    // Update the appropriate counter
    if ($action_type === 'like') {
        $meta_key = 'like_count';
    } elseif ($action_type === 'dislike') {
        $meta_key = 'dislike_count';
    } else {
        wp_send_json_error('Invalid action');
    }

    $current_count = (int) get_post_meta($post_id, $meta_key, true);
    $new_count = $current_count + 1;

    update_post_meta($post_id, $meta_key, $new_count);

    // Set cookie to prevent multiple votes (expires in 30 days)
    setcookie($cookie_name, $action_type, time() + (30 * 24 * 60 * 60), '/');

    wp_send_json_success([
        'like_count' => (int) get_post_meta($post_id, 'like_count', true),
        'dislike_count' => (int) get_post_meta($post_id, 'dislike_count', true)
    ]);
}
add_action('wp_ajax_handle_like_dislike', 'handle_like_dislike');
add_action('wp_ajax_nopriv_handle_like_dislike', 'handle_like_dislike');

// Enqueue JavaScript
function enqueue_like_dislike_scripts()
{
    wp_enqueue_script('like-dislike-script', get_template_directory_uri() . '/js/like-dislike.js', ['jquery'], '1.0', true);
    wp_localize_script('like-dislike-script', 'likeDislikeAjax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('like_dislike_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_like_dislike_scripts');
function get_excerpt_article_title($text)
{
    if (!is_string($text)) {
        return '';
    }

    // گرفتن 34 حرف اول متن ورودی به صورت ایمن
    $excerpt = mb_substr($text, 0, 34, 'UTF-8');

    // اضافه کردن "..." در صورتی که متن بیشتر از 34 حرف باشد
    if (mb_strlen($text, 'UTF-8') > 34) {
        $excerpt .= '…'; // یا '...' بسته به سبک مورد نظر
    }

    return $excerpt;
}


function get_excerpt_blog_item_title($text)
{
    if (!is_string($text)) {
        return '';
    }

    // گرفتن 34 حرف اول متن ورودی به صورت ایمن
    $excerpt = mb_substr($text, 0, 32, 'UTF-8');

    // اضافه کردن "..." در صورتی که متن بیشتر از 34 حرف باشد
    if (mb_strlen($text, 'UTF-8') > 32) {
        $excerpt .= '…'; // یا '...' بسته به سبک مورد نظر
    }

    return $excerpt;
}
function get_excerpt_home_page_blog_item_title($text, $is_mobile = false)
{
    if (!is_string($text)) {
        return '';
    }

    // تعیین تعداد کاراکترها بر اساس عرض صفحه
    $length = $is_mobile ? 24 : 38;

    // گرفتن تعداد مشخصی از کاراکترهای اول متن به صورت ایمن
    $excerpt = mb_substr($text, 0, $length, 'UTF-8');

    // اضافه کردن "..." در صورتی که متن طولانی‌تر از حد مشخص شده باشد
    if (mb_strlen($text, 'UTF-8') > $length) {
        $excerpt .= '…';
    }

    return $excerpt;
}

// اکشن برای مدیریت درخواست AJAX
add_action('wp_ajax_get_excerpt', 'handle_get_excerpt_ajax');
add_action('wp_ajax_nopriv_get_excerpt', 'handle_get_excerpt_ajax');

function handle_get_excerpt_ajax() {
    // بررسی وجود متن و is_mobile در درخواست
    $text = isset($_POST['text']) ? sanitize_text_field($_POST['text']) : '';
    $is_mobile = isset($_POST['is_mobile']) && $_POST['is_mobile'] === 'true' ? true : false;

    // دریافت متن کوتاه‌شده
    $excerpt = get_excerpt_home_page_blog_item_title($text, $is_mobile);

    // ارسال پاسخ به صورت JSON
    wp_send_json_success(['excerpt' => $excerpt]);
}

// ثبت اسکریپت جاوااسکریپت و ارسال URL AJAX به آن
add_action('wp_enqueue_scripts', 'enqueue_excerpt_script');
function enqueue_excerpt_script() {
    wp_enqueue_script('excerpt-script', get_template_directory_uri() . '/assets/js/excerpt.js', ['jquery'], null, true);
    wp_localize_script('excerpt-script', 'excerptAjax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('excerpt_nonce')
    ]);
}

function custom_breadcrumb() {
    // Initial settings
    $home_icon = '<svg><use href="#house-icon"></use></svg>';
    $arrow_icon = '<div class="arrow-icon"><svg><use href="#double-arrow-icon"></use></svg></div>';

    echo '<div class="col-12 breadcrumb"><div class="d-flex">';

    // Home page icon
    echo '<li class="home-page"><a href="' . esc_url(home_url('/')) . '">' . $home_icon . '</a></li>';

    // If not on the front page
    if (!is_front_page()) {
        echo $arrow_icon;

        // If on a single post or page
        if (is_singular()) {
            echo '<li class="breadcrumb-page"><a href="' . esc_url(get_the_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
        }

        // If on a category page
        if (is_category()) {
            $category = get_queried_object();
            echo '<li class="breadcrumb-page"><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
        }

        // If on an archive page (including custom post type archives)
        if (is_archive()) {
            if (is_category()) {
                // Skip category archives (already handled above)
            } else {
                $queried_object = get_queried_object();
                $post_type = get_post_type();

                if ($post_type && $post_type !== 'post') {
                    // For custom post type archives (like glossary)
                    $post_type_object = get_post_type_object($post_type);
                    $archive_title = $post_type_object->labels->name; // e.g., "واژه‌ها"
                    $archive_link = get_post_type_archive_link($post_type);
                    echo '<li class="breadcrumb-page"><a href="' . esc_url($archive_link) . '">' . esc_html($archive_title) . '</a></li>';
                } else {
                    // For other archives (e.g., date, author)
                    $archive_title = wp_strip_all_tags(get_the_archive_title()); // Remove HTML and prefixes
                    echo '<li class="breadcrumb-page"><a href="#">' . esc_html($archive_title) . '</a></li>';
                }
            }
        }

        // If on a search page
        if (is_search()) {
            echo '<li class="breadcrumb-page"><a href="#">' . esc_html__('Search', 'textdomain') . '</a></li>';
        }
    }

    echo '</div></div>';
}