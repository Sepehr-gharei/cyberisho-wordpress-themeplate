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
    wp_register_script('portfolio', get_template_directory_uri() . '/assets/js/portfolio.js', [], '1.0.0', true);
    wp_enqueue_script('portfolio');
    wp_register_script('jquery-toc', get_template_directory_uri() . '/assets/js/jquery-toc.js', [], '1.0.0', true);
    wp_enqueue_script('jquery-toc');
    wp_enqueue_script('like-dislike-script', get_template_directory_uri() . '/assets/js/like-dislike.js', array('jquery'), null, true);
    wp_localize_script('like-dislike-script', 'like_dislike_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('like_dislike_nonce')
    ));
    wp_enqueue_script('post-like-dislike', get_template_directory_uri() . '/assets/js/post-like-dislike.js', array('jquery'), null, true);
    wp_localize_script('post-like-dislike', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));

    wp_register_script('main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true);
    wp_enqueue_script('main');
    
}
add_action('wp_enqueue_scripts', 'register_assets');
function enqueue_panorama_slider_script() {
    wp_enqueue_script(
        'panorama-slider', // نام منحصر به فرد برای این اسکریپت
        'https://panorama-slider.uiinitiative.com/assets/index.d2ce9dca.js', // URL اسکریپت
        array(), // وابستگی‌ها (اگر وجود داشته باشد)
        null, // نسخه (اختیاری)
        true // بارگذاری در footer (بهترین عملکرد)
    );
}
add_action('wp_enqueue_scripts', 'enqueue_panorama_slider_script');

function add_module_type_attribute($tag, $handle, $src) {
    if ('panorama-slider' === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '" crossorigin></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_module_type_attribute', 10, 3);

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
function enqueue_custom_scripts() {
    wp_enqueue_script('portfolio-pagination', get_template_directory_uri() . '/assets/js/portfolio-pagination.js', array('jquery'), null, true);
    wp_localize_script('portfolio-pagination', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}

function cyberisho_enqueue_scripts() {
    // ... سایر اسکریپت‌ها ...

    // تنها در صفحات تکی (single post) که فرم دیدگاه وجود دارد
    if ( is_single() ) {
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

function cyberisho_add_ajax_url_to_form() {
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
add_action('wp_footer', 'cyberisho_add_ajax_url_to_form');

