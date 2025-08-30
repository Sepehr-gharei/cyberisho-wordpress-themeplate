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
    wp_register_script('comment-form-ajax', get_template_directory_uri() . '/assets/js/comment-form-ajax', [], '1.0.0', true);
    wp_enqueue_script('comment-form-ajax');
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

    if (is_front_page()) {
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
