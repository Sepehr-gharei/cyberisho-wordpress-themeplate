<?php


function comment_handle_like_dislike()
{
    check_ajax_referer('like_dislike_nonce', 'security');

    $comment_id = intval($_POST['comment_id']);
    $action = sanitize_text_field($_POST['action_type']);

    // Check if the voted_comments cookie exists and decode it
    $voted_comments = isset($_COOKIE['voted_comments']) ? json_decode(stripslashes($_COOKIE['voted_comments']), true) : array();

    // Ensure $voted_comments is an array
    if (!is_array($voted_comments)) {
        $voted_comments = array();
    }

    // Check if the user has already voted on this comment
    if (in_array($comment_id, $voted_comments)) {
        wp_send_json_error('شما قبلاً به این کامنت رای داده‌اید.');
    }

    if ($action === 'like' || $action === 'dislike') {
        $meta_key = ($action === 'like') ? 'like_count' : 'dislike_count';
        $current_count = get_comment_meta($comment_id, $meta_key, true);

        if (!$current_count) {
            $current_count = 0;
        }

        $new_count = $current_count + 1;
        update_comment_meta($comment_id, $meta_key, $new_count);

        // Add the comment ID to the voted_comments array
        $voted_comments[] = $comment_id;

        // Set the cookie with the updated voted_comments array (expires in 30 days)
        setcookie('voted_comments', json_encode($voted_comments), time() + (30 * 24 * 60 * 60), '/');

        wp_send_json_success(array(
            'count' => $new_count
        ));
    }

    wp_send_json_error('عملیات نامعتبر.');
}
add_action('wp_ajax_like_dislike', 'comment_handle_like_dislike');
add_action('wp_ajax_nopriv_like_dislike', 'comment_handle_like_dislike');
function display_like_dislike_buttons($comment_id)
{
    $like_count = get_comment_meta($comment_id, 'like_count', true);
    $dislike_count = get_comment_meta($comment_id, 'dislike_count', true);

    $like_count = ($like_count) ? $like_count : 0;
    $dislike_count = ($dislike_count) ? $dislike_count : 0;
    ?>

    <div class="like-dislike-section comment-like-dislike-section">
        <div class="dislike-wrapper">
            <button class="dislike-button" data-comment-id="<?php echo esc_attr($comment_id) ?>">
                <div class="icon">
                    <?php echo esc_attr($dislike_count) ?>
                    <svg width="178pt" height="172pt" viewBox="0 0 178 172" version="1.1"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="#000000ff">
                            <path fill="var(--normal-text-color)" opacity="1.00"
                                d=" M 99.07 7.06 C 104.04 2.37 111.46 0.45 118.09 2.14 C 126.50 4.03 133.33 12.27 132.77 21.02 C 132.56 31.03 127.82 40.25 126.20 49.98 C 126.13 49.37 126.06 48.77 125.98 48.16 C 124.69 52.84 122.68 57.27 120.69 61.68 C 133.45 61.72 146.21 61.63 158.96 61.72 C 170.25 62.12 178.87 74.31 175.88 85.12 C 171.75 99.73 166.95 114.15 162.72 128.73 C 160.47 135.11 159.37 141.93 156.05 147.90 C 149.22 161.15 134.94 170.05 120.03 170.39 C 85.68 170.38 51.32 170.39 16.97 170.39 C 11.15 170.26 5.20 166.68 3.06 161.14 C 1.20 157.37 1.63 153.07 1.63 149.01 C 1.64 125.01 1.64 101.00 1.63 77.00 C 1.84 73.62 2.72 69.69 5.77 67.74 C 5.99 67.26 6.43 66.30 6.65 65.83 C 9.39 63.79 12.47 61.89 15.98 61.74 C 25.99 61.45 36.04 62.02 46.04 61.49 C 59.75 56.41 71.42 46.88 80.91 35.91 C 85.38 30.58 89.27 24.75 92.34 18.50 C 94.49 14.64 95.86 10.24 99.07 7.06 M 109.72 13.68 C 106.45 15.05 105.16 18.52 103.73 21.47 C 93.42 43.52 75.10 62.01 52.51 71.36 C 52.62 100.68 52.53 130.00 52.56 159.33 C 74.61 159.20 96.67 159.44 118.72 159.20 C 131.89 158.92 144.43 149.71 148.14 137.01 C 153.61 118.95 159.24 100.94 164.63 82.87 C 166.33 77.60 161.32 72.38 156.08 72.82 C 141.04 72.71 126.00 72.85 110.96 72.76 C 108.67 73.02 106.29 71.48 106.02 69.11 C 105.24 65.99 106.96 63.12 108.46 60.54 C 113.68 50.54 117.06 39.71 119.96 28.85 C 120.75 25.61 122.04 22.29 121.30 18.90 C 119.63 14.54 114.17 11.17 109.72 13.68 M 13.68 75.50 C 12.05 81.22 13.51 87.22 13.06 93.05 C 12.25 107.04 13.75 121.03 12.88 135.02 C 13.50 141.36 12.63 147.71 12.87 154.06 C 12.87 156.75 15.28 159.18 17.97 159.20 C 25.74 159.47 33.52 159.21 41.29 159.30 C 41.32 130.45 41.38 101.60 41.27 72.75 C 34.19 72.83 27.12 72.76 20.05 72.78 C 17.74 72.83 14.76 73.09 13.68 75.50 Z">
                            </path>
                        </g>
                    </svg>

                </div>
            </button>
        </div>
        <div class="like-wrapper">
            <button class="like-button" data-comment-id="<?php echo esc_attr($comment_id) ?>">
                <div class="icon">
                    <?php echo esc_attr($like_count) ?>
                    <svg width="178pt" height="172pt" viewBox="0 0 178 172" version="1.1"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="#000000ff">
                            <path fill="var(--normal-text-color)" opacity="1.00"
                                d=" M 99.07 7.06 C 104.04 2.37 111.46 0.45 118.09 2.14 C 126.50 4.03 133.33 12.27 132.77 21.02 C 132.56 31.03 127.82 40.25 126.20 49.98 C 126.13 49.37 126.06 48.77 125.98 48.16 C 124.69 52.84 122.68 57.27 120.69 61.68 C 133.45 61.72 146.21 61.63 158.96 61.72 C 170.25 62.12 178.87 74.31 175.88 85.12 C 171.75 99.73 166.95 114.15 162.72 128.73 C 160.47 135.11 159.37 141.93 156.05 147.90 C 149.22 161.15 134.94 170.05 120.03 170.39 C 85.68 170.38 51.32 170.39 16.97 170.39 C 11.15 170.26 5.20 166.68 3.06 161.14 C 1.20 157.37 1.63 153.07 1.63 149.01 C 1.64 125.01 1.64 101.00 1.63 77.00 C 1.84 73.62 2.72 69.69 5.77 67.74 C 5.99 67.26 6.43 66.30 6.65 65.83 C 9.39 63.79 12.47 61.89 15.98 61.74 C 25.99 61.45 36.04 62.02 46.04 61.49 C 59.75 56.41 71.42 46.88 80.91 35.91 C 85.38 30.58 89.27 24.75 92.34 18.50 C 94.49 14.64 95.86 10.24 99.07 7.06 M 109.72 13.68 C 106.45 15.05 105.16 18.52 103.73 21.47 C 93.42 43.52 75.10 62.01 52.51 71.36 C 52.62 100.68 52.53 130.00 52.56 159.33 C 74.61 159.20 96.67 159.44 118.72 159.20 C 131.89 158.92 144.43 149.71 148.14 137.01 C 153.61 118.95 159.24 100.94 164.63 82.87 C 166.33 77.60 161.32 72.38 156.08 72.82 C 141.04 72.71 126.00 72.85 110.96 72.76 C 108.67 73.02 106.29 71.48 106.02 69.11 C 105.24 65.99 106.96 63.12 108.46 60.54 C 113.68 50.54 117.06 39.71 119.96 28.85 C 120.75 25.61 122.04 22.29 121.30 18.90 C 119.63 14.54 114.17 11.17 109.72 13.68 M 13.68 75.50 C 12.05 81.22 13.51 87.22 13.06 93.05 C 12.25 107.04 13.75 121.03 12.88 135.02 C 13.50 141.36 12.63 147.71 12.87 154.06 C 12.87 156.75 15.28 159.18 17.97 159.20 C 25.74 159.47 33.52 159.21 41.29 159.30 C 41.32 130.45 41.38 101.60 41.27 72.75 C 34.19 72.83 27.12 72.76 20.05 72.78 C 17.74 72.83 14.76 73.09 13.68 75.50 Z">
                            </path>
                        </g>
                    </svg>
                </div>
            </button>
        </div>
    </div>

    <?php
}


function cy_theme_comment($comment, $args, $depth)
{
    ?>
    <li id="comment-<?php echo $comment->comment_ID ?>" <?php comment_class(); ?>>
        <div class="comment-item <?php
        $email = get_comment_author_email();
        $user = get_user_by('email', $email);

        if ($user && in_array('administrator', (array) $user->roles)) {
            // کاربر نقش ادمین دارد
            echo 'admin-comment';
        }
        ?> 
        " id="comment-id-<?php echo $comment->comment_ID ?>">
            <div class="user-comment-details">
                <div class="profile-image">
                    <?php
                    if ($user && in_array('administrator', (array) $user->roles)) {
                        echo '<svg>
                          <use href="#favicon-logo-icon"></use>
                        </svg>';
                    } else {
                        echo get_avatar($comment->comment_author_email, 90, '', $comment->comment_author);
                    }
                    ?>
                </div>
                <div class="user-detail">
                    <p class="user-name"><?php echo $comment->comment_author; ?></p>
                    <div class="date-of-comment">
                        <span><?php echo get_comment_date('Y/m/d'); ?></span> در
                        <span><?php echo get_comment_date('H/i'); ?></span>
                    </div>
                </div>
                <div class="answer">
                    <a href="#comment-form" data-comment-id="<?php echo $comment->comment_ID; ?>">
                        پاسخ
                    </a>
                </div>
                <div class="like-dislike-container">
                    <?php display_like_dislike_buttons($comment->comment_ID); ?>
                </div>
            </div>
            <div class="user-comment-text">
                <p><?php echo $comment->comment_content; ?></p>
            </div>
        </div>
    </li>
    <?php
}