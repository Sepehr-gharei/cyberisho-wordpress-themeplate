<?php
function register_glossary_post_type() {
    $labels = array(
        'name'                  => _x( 'واژه‌ها', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'واژه', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'واژه‌نامه', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'واژه', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'افزودن واژه جدید', 'textdomain' ),
        'add_new_item'          => __( 'افزودن واژه جدید', 'textdomain' ),
        'new_item'              => __( 'واژه جدید', 'textdomain' ),
        'edit_item'             => __( 'ویرایش واژه', 'textdomain' ),
        'view_item'             => __( 'نمایش واژه', 'textdomain' ),
        'all_items'             => __( 'همه واژه‌ها', 'textdomain' ),
        'search_items'          => __( 'جستجوی واژه‌ها', 'textdomain' ),
        'not_found'             => __( 'واژه‌ای یافت نشد.', 'textdomain' ),
        'not_found_in_trash'    => __( 'واژه‌ای در زباله‌دان یافت نشد.', 'textdomain' ),
        'featured_image'        => __( 'تصویر واژه', 'textdomain' ),
        'set_featured_image'    => __( 'تنظیم تصویر واژه', 'textdomain' ),
        'remove_featured_image' => __( 'حذف تصویر واژه', 'textdomain' ),
        'use_featured_image'    => __( 'استفاده به عنوان تصویر واژه', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'glossary' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'glossary', $args );
}
add_action( 'init', 'register_glossary_post_type' );