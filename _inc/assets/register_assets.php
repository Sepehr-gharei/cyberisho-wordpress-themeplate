<?php
function register_assets()
{
    /* **************************** start register CSS *****************************/
    wp_register_style('main-style', get_stylesheet_directory_uri() . '/style.css', [], '1.0.0');
    wp_enqueue_style('main-style');
    /* **************************** end register CSS *****************************/
    /* **************************** start register JS *****************************/
    wp_deregister_script('jquery');
    wp_register_script(
        'jquery',
        'https://code.jquery.com/jquery-3.7.1.min.js',
        array(),
        '3.7.1',
        true
    );
    wp_enqueue_script('jquery');
    wp_register_script('video-wrapper', get_template_directory_uri() . '/assets/js/video-wrapper.js', [], '1.0.0', true);
    wp_enqueue_script('video-wrapper');
    wp_register_script('load-animate', get_template_directory_uri() . '/assets/js/load-animate.js', [], '1.0.0', true);
    wp_enqueue_script('load-animate');
    if (is_single() or is_page('landing')) {
        wp_register_script('jquery-toc', get_template_directory_uri() . '/assets/js/jquery-toc.js', [], '1.0.0', true);
        wp_enqueue_script('jquery-toc');
    }
    if (is_single()) {
        wp_enqueue_script('like-dislike-script', get_template_directory_uri() . '/assets/js/like-dislike.js', array('jquery'), null, true);
        wp_localize_script('like-dislike-script', 'like_dislike_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('like_dislike_nonce')
        ));
        wp_enqueue_script('post-like-dislike', get_template_directory_uri() . '/assets/js/post-like-dislike.js', array('jquery'), null, true);
        wp_localize_script('post-like-dislike', 'ajax_object', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }
    wp_register_script('main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true);
    wp_enqueue_script('main');
    wp_register_script('meeting-form', get_template_directory_uri() . '/assets/js/meeting-form.js', [], '1.0.0', true);
    wp_enqueue_script('meeting-form');
    function cyberisho_enqueue_scripts()
    {
        // ... سایر اسکریپت‌ها ...

        // تنها در صفحات تکی (single post) که فرم دیدگاه وجود دارد
        if (is_single()) {
            wp_enqueue_script(
                'custom-comment-ajax',
                get_template_directory_uri() . '/assets/js/comment-form-ajax.js',
                [],
                filemtime(get_template_directory() . '/assets/js/comment-form-ajax.js'),
                true
            );
        }
    }
    add_action('wp_enqueue_scripts', 'cyberisho_enqueue_scripts');

function cyberisho_add_ajax_url_to_form()
{
    ?>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("custom-comment-form");
            if (form) {
                form.setAttribute("data-ajax-url", "<?php echo admin_url('admin-ajax.php'); ?>");
            }
        });
    </script>
    <?php
}
add_action('wp_enqueue_scripts', 'register_assets');
