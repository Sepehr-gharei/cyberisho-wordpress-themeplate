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
    wp_register_script('main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true);
    wp_enqueue_script('main');
    wp_register_script('video-wrapper', get_template_directory_uri() . '/assets/js/video-wrapper.js', [], '1.0.0', true);
    wp_enqueue_script('video-wrapper');
    wp_register_script('load-animate', get_template_directory_uri() . '/assets/js/load-animate.js', [], '1.0.0', true);
    wp_enqueue_script('load-animate');
    wp_register_script('portfolio', get_template_directory_uri() . '/assets/js/portfolio.js', [], '1.0.0', true);
    wp_enqueue_script('portfolio');
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