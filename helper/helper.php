<?php 
add_theme_support( 'post-thumbnails' );
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



function calculate_reading_time($post_id) {
    // دریافت محتوای مقدمه
    $intro = get_post_meta($post_id, '_blog_intro', true);
    $intro = is_string($intro) ? $intro : ''; // اطمینان از رشته بودن
    $intro_clean = strip_tags($intro); // حذف تگ‌های HTML
    $intro_word_count = str_word_count($intro_clean, 0, 'آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی'); // پشتیبانی از حروف فارسی
    error_log('Intro Word Count: ' . $intro_word_count); // لاگ برای عیب‌یابی

    // دریافت محتوای بخش‌ها
    $sections = get_post_meta($post_id, '_blog_sections', true);
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
function add_video_and_track_views() {
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
        add_filter('the_content', function($content) use ($random_video, $view_count) {
            $video_html = '<video controls><source src="' . esc_url($random_video) . '" type="video/mp4">مرورگر شما از ویدئو پشتیبانی نمی‌کند.</video>';
            $views_html = '<p>تعداد بازدید: ' . $view_count . '</p>';
            return $content . $video_html . $views_html;
        });
    }
}
add_action('wp', 'add_video_and_track_views');

// شورت‌کد برای نمایش تعداد بازدید در صورت نیاز
function display_post_views() {
    global $post;
    $view_count = get_post_meta($post->ID, 'post_views_count', true);
    return $view_count ? $view_count : 0;
}
add_shortcode('post_views', 'display_post_views');





// در فایل functions.php قالب وردپرس

// ایجاد جدول برای ذخیره آی‌پی‌ها هنگام فعال‌سازی قالب
function create_like_dislike_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'like_dislike_ips';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        post_id bigint(20) NOT NULL,
        user_ip varchar(100) NOT NULL,
        action varchar(10) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_like_dislike_table');

// مدیریت درخواست AJAX برای لایک و دیسلایک
add_action('wp_ajax_handle_like_dislike', 'handle_like_dislike');
add_action('wp_ajax_nopriv_handle_like_dislike', 'handle_like_dislike');

function handle_like_dislike() {
    global $wpdb;
    $post_id = intval($_POST['post_id']);
    $action = sanitize_text_field($_POST['action_type']);
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $table_name = $wpdb->prefix . 'like_dislike_ips';

    // بررسی اینکه آیا کاربر قبلاً رای داده است
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE post_id = %d AND user_ip = %s",
        $post_id, $user_ip
    ));

    if ($existing > 0) {
        wp_send_json_error('شما قبلاً رای داده‌اید.');
    }

    // ثبت رای
    $wpdb->insert(
        $table_name,
        array(
            'post_id' => $post_id,
            'user_ip' => $user_ip,
            'action' => $action
        ),
        array('%d', '%s', '%s')
    );

    // به‌روزرسانی تعداد لایک‌ها یا دیسلایک‌ها
    $meta_key = $action == 'like' ? 'post_likes' : 'post_dislikes';
    $current_count = get_post_meta($post_id, $meta_key, true);
    $current_count = $current_count ? intval($current_count) + 1 : 1;
    update_post_meta($post_id, $meta_key, $current_count);

    wp_send_json_success(array(
        'count' => $current_count,
        'action' => $action
    ));
}

// افزودن کد جاوااسکریپت و HTML به قالب
function add_like_dislike_scripts() {
    wp_enqueue_script('like-dislike', get_template_directory_uri() . '/js/like-dislike.js', array('jquery'), '1.0', true);
    wp_localize_script('like-dislike', 'likeDislikeAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('like_dislike_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'add_like_dislike_scripts');

// نمایش دکمه‌ها در محتوا
// افزودن متا فیلدها برای ذخیره تعداد لایک و دیسلایک
function blog_add_like_dislike_meta() {
    $posts = get_posts(array('post_type' => 'blog', 'numberposts' => -1));
    foreach ($posts as $post) {
        if (!metadata_exists('post', $post->ID, '_likes')) {
            update_post_meta($post->ID, '_likes', 0);
        }
        if (!metadata_exists('post', $post->ID, '_dislikes')) {
            update_post_meta($post->ID, '_dislikes', 0);
        }
    }
}
add_action('init', 'blog_add_like_dislike_meta');

// ثبت اسکریپت‌های Ajax و جاوااسکریپت
function blog_enqueue_scripts() {
    wp_enqueue_script('blog-like-dislike', get_template_directory_uri() . '/js/like-dislike.js', array('jquery'), '1.0', true);
    wp_localize_script('blog-like-dislike', 'blog_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('blog_like_dislike_nonce')
    ));
    wp_enqueue_style('blog-like-dislike-style', get_template_directory_uri() . '/css/like-dislike.css');
}
add_action('wp_enqueue_scripts', 'blog_enqueue_scripts');

// مدیریت درخواست‌های Ajax برای لایک و دیسلایک
function blog_handle_like_dislike() {
    check_ajax_referer('blog_like_dislike_nonce', 'nonce');

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $action_type = isset($_POST['action_type']) ? sanitize_text_field($_POST['action_type']) : '';

    if (!$post_id || !in_array($action_type, ['like', 'dislike'])) {
        wp_send_json_error('Invalid request');
    }

    // بررسی کوکی
    $cookie_name = 'blog_voted_' . $post_id;
    if (isset($_COOKIE[$cookie_name])) {
        wp_send_json_error('You have already voted');
    }

    // به‌روزرسانی متا فیلد
    if ($action_type === 'like') {
        $likes = get_post_meta($post_id, '_likes', true);
        update_post_meta($post_id, '_likes', intval($likes) + 1);
    } elseif ($action_type === 'dislike') {
        $dislikes = get_post_meta($post_id, '_dislikes', true);
        update_post_meta($post_id, '_dislikes', intval($dislikes) + 1);
    }

    // تنظیم کوکی برای جلوگیری از رای‌دهی مجدد
    setcookie($cookie_name, 'voted', time() + (365 * 24 * 60 * 60), '/'); // کوکی برای یک سال

    // ارسال پاسخ
    $response = array(
        'likes' => get_post_meta($post_id, '_likes', true),
        'dislikes' => get_post_meta($post_id, '_dislikes', true)
    );
    wp_send_json_success($response);
}
add_action('wp_ajax_blog_like_dislike', 'blog_handle_like_dislike');
add_action('wp_ajax_nopriv_blog_like_dislike', 'blog_handle_like_dislike');

// نمایش دکمه‌های لایک و دیسلایک
function blog_display_like_dislike_buttons($content) {
    if (get_post_type() === 'blog' && is_singular('blog')) {
        $post_id = get_the_ID();
        $likes = get_post_meta($post_id, '_likes', true) ?: 0;
        $dislikes = get_post_meta($post_id, '_dislikes', true) ?: 0;
        $cookie_name = 'blog_voted_' . $post_id;
        $voted = isset($_COOKIE[$cookie_name]) ? true : false;

        $buttons = '<div class="blog-like-dislike">';
        $buttons .= '<button class="like-button ' . ($voted ? 'disabled' : '') . '" data-post-id="' . $post_id . '" data-action="like" ' . ($voted ? 'disabled' : '') . '>لایک (' . $likes . ')</button>';
        $buttons .= '<button class="dislike-button ' . ($voted ? 'disabled' : '') . '" data-post-id="' . $post_id . '" data-action="dislike" ' . ($voted ? 'disabled' : '') . '>دیسلایک (' . $dislikes . ')</button>';
        $buttons .= '</div>';

        $content .= $buttons;
    }
    return $content;
}
add_filter('the_content', 'blog_display_like_dislike_buttons');

function get_excerpt_article_title($content, $char_limit = 38) {
    // حذف تگ‌های HTML و whitespace اضافی
    $clean_content = strip_tags($content);
    $clean_content = preg_replace('/\s+/', ' ', $clean_content);
    $clean_content = trim($clean_content);

    // شمارش تعداد حروف (فاصله‌ها در نظر گرفته نمی‌شن)
    $char_count = mb_strlen(preg_replace('/\s/u', '', $clean_content), 'UTF-8');

    // گرفتن ۳۸ حرف اول به صورت UTF-8
    $shortened = mb_substr($clean_content, 0, $char_limit, 'UTF-8');

    return $shortened;
}