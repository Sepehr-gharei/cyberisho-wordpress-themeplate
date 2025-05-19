<?php 

function handle_ajax_comment_submission() {
    check_ajax_referer('custom_ajax_comment_nonce', 'security');

    $post_id = intval($_POST['post_id']);
    $author  = sanitize_text_field($_POST['author']);
    $email   = sanitize_email($_POST['email']);
    $content = sanitize_textarea_field($_POST['comment']);
    $comment_parent = isset($_POST['comment_parent']) ? intval($_POST['comment_parent']) : 0;

    if (!is_numeric($post_id) || !get_post($post_id)) {
        wp_send_json_error('پست معتبر نیست.');
    }

    if (empty($content)) {
        wp_send_json_error('محتوای دیدگاه نمی‌تواند خالی باشد.');
    }

    // تنظیمات دیدگاه
    $comment_data = array(
        'comment_post_ID'      => $post_id,
        'comment_author'       => $author,
        'comment_author_email' => $email,
        'comment_content'      => $content,
        'comment_type'         => '',
        'comment_parent'       => $comment_parent, // مقدار جدید
        'user_id'              => 0,
        'comment_approved'     => 1, // یا 0 برای نیاز به تأیید مدیر
    );

    $comment_id = wp_insert_comment($comment_data);

    if ($comment_id) {
        wp_send_json_success([
            'message' => 'نظر شما با موفقیت ثبت شد.',
            'comment_id' => $comment_id,
            'permalink' => get_permalink($post_id)
        ]);
    } else {
        wp_send_json_error('خطا در ثبت دیدگاه.');
    }
}
add_action('wp_ajax_custom_ajax_comment', 'handle_ajax_comment_submission');
add_action('wp_ajax_nopriv_custom_ajax_comment', 'handle_ajax_comment_submission');


function ajax_comment_pagination() {
    check_ajax_referer('comment_pagination_nonce', 'security');

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    if ($post_id <= 0 || $page <= 0) {
        wp_send_json_error('پارامترهای نامعتبر: post_id یا page نامعتبر است.');
    }

    $comments_per_page = get_option('comments_per_page', 10);
    $total_comments = get_comments_number($post_id);
    $total_pages = ceil($total_comments / $comments_per_page);

    $args = [
        'post_id' => $post_id,
        'status' => 'approve',
        'number' => $comments_per_page,
        'paged' => $page,
        'callback' => 'cy_theme_comment',
        'style' => 'ul',
    ];

    ob_start();
    $comments = get_comments([
        'post_id' => $post_id,
        'status' => 'approve',
        'number' => $comments_per_page,
        'paged' => $page,
    ]);
    
    wp_list_comments($args, $comments);
    $comments_html = ob_get_clean();

    // Generate pagination links
    ob_start();
    $big = 999999999;
    echo paginate_links(array(
        'base' => add_query_arg('cpage', '%#%'),
        'format' => '',
        'current' => $page,
        'total' => $total_pages,
        'prev_text' => __('<svg width="218pt" height="146pt" viewBox="0 0 218 146" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <g id="#000000ff">
            <path fill="var(--normal-text-color)" opacity="1.00" d="M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z"></path>
          </g>
        </svg>'),
        'next_text' => __('<svg width="218pt" height="146pt" viewBox="0 0 218 146" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <g id="#000000ff">
            <path fill="var(--normal-text-color)" opacity="1.00" d="M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z"></path>
          </g>
        </svg>'),
    ));
    $pagination_html = ob_get_clean();

    wp_send_json_success([
        'comments_html' => $comments_html,
        'pagination_html' => $pagination_html,
        'current_page' => $page,
        'total_pages' => $total_pages,
    ]);
}
add_action('wp_ajax_comment_pagination', 'ajax_comment_pagination');
add_action('wp_ajax_nopriv_comment_pagination', 'ajax_comment_pagination');



