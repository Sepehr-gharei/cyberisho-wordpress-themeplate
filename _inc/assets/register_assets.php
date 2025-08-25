<?php
function register_assets()
{
    /* **************************** start register CSS *****************************/
    wp_register_style('main-style', get_stylesheet_directory_uri() . '/style.css', [], '1.0.0');
    wp_enqueue_style('main-style');
    if (is_page('landing-add')) {
        wp_register_style('lading-add-style', get_stylesheet_directory_uri() . '/assets/css/landing-add.css', [], '1.0.0');
        wp_enqueue_style('lading-add-style');
    }
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
    wp_register_script('main-js', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true);
    wp_enqueue_script('main-js');
    if ( is_front_page()) {
        wp_register_script('client-items-animation', get_template_directory_uri() . '/assets/js/client-items-animation.js', [], '1.0.0', true);
        wp_enqueue_script('client-items-animation');
        wp_register_script('audio-player', get_template_directory_uri() . '/assets/js/audio-player.js', [], '1.0.0', true);
        wp_enqueue_script('audio-player');
        wp_register_script('faq-accordion', get_template_directory_uri() . '/assets/js/faq-accordion.js', [], '1.0.0', true);
        wp_enqueue_script('faq-accordion');
    }
    if (is_page('employment')) {
        wp_register_script('file-uploader', get_template_directory_uri() . '/assets/js/file-uploader.js', [], '1.0.0', true);
        wp_enqueue_script('file-uploader');
    }
    if (is_page('portfolio')) {
        wp_register_script('portfolio-item', get_template_directory_uri() . '/assets/js/portfolio-item.js', [], '1.0.0', true);
        wp_enqueue_script('portfolio-item');
    }
    if (is_page('about-us')) {
        wp_register_script('show-text-page-title', get_template_directory_uri() . '/assets/js/show-text-page-title.js', [], '1.0.0', true);
        wp_enqueue_script('show-text-page-title');
        wp_register_script('collapse', get_template_directory_uri() . '/assets/js/collapse.js', [], '1.0.0', true);
        wp_enqueue_script('collapse');
    }
}
add_action('wp_enqueue_scripts', 'register_assets');
