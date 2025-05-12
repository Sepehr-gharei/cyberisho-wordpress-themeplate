<?php 

function handle_ajax_comment_submission() {
    check_ajax_referer('custom_ajax_comment_nonce', 'security');

    $post_id = intval($_POST['post_id']);
    $author  = sanitize_text_field($_POST['author']);
    $email   = sanitize_email($_POST['email']);
    $content = sanitize_textarea_field($_POST['comment']);

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
        'comment_parent'       => 0,
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