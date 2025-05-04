<?php
function create_blog_post_type() {
    $labels = array(
        'name'               => _x('وبلاگ', 'نام عمومی نوع پست', 'textdomain'),
        'singular_name'      => _x('بلاگ', 'نام مفرد نوع پست', 'textdomain'),
        'menu_name'          => __('وبلاگ', 'textdomain'),
        'name_admin_bar'     => __('بلاگ', 'textdomain'),
        'add_new'            => __('افزودن بلاگ جدید', 'textdomain'),
        'add_new_item'       => __('افزودن بلاگ جدید', 'textdomain'),
        'new_item'           => __('بلاگ جدید', 'textdomain'),
        'edit_item'          => __('ویرایش بلاگ', 'textdomain'),
        'view_item'          => __('مشاهده بلاگ', 'textdomain'),
        'all_items'          => __('همه وبلاگ', 'textdomain'),
        'search_items'       => __('جستجوی وبلاگ', 'textdomain'),
        'parent_item_colon'  => __('بلاگ مادر:', 'textdomain'),
        'not_found'          => __('هیچ بلاگی یافت نشد.', 'textdomain'),
        'not_found_in_trash' => __('هیچ بلاگی در زباله‌دان یافت نشد.', 'textdomain')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'blog'),
        'capability_type'    => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'         => array('blog_category', 'blog_tag'), // دسته‌بندی و برچسب‌های اختصاصی
        'menu_icon'          => 'dashicons-media-text', // آیکون در منو
    );

    register_post_type('blog', $args);
}
add_action('init', 'create_blog_post_type');
function create_blog_taxonomies() {
    // دسته‌بندی اختصاصی
    register_taxonomy(
        'blog_category', // نام دسته‌بندی
        'blog', // نوع پست مرتبط
        array(
            'label' => __('دسته‌بندی وبلاگ', 'textdomain'),
            'rewrite' => array('slug' => 'blog-category'),
            'hierarchical' => true, // مانند دسته‌بندی‌های معمولی
        )
    );

    // برچسب‌های اختصاصی
    register_taxonomy(
        'blog_tag', // نام برچسب
        'blog', // نوع پست مرتبط
        array(
            'label' => __('برچسب‌های وبلاگ', 'textdomain'),
            'rewrite' => array('slug' => 'blog-tag'),
            'hierarchical' => false, // مانند برچسب‌های معمولی
        )
    );
}
add_action('init', 'create_blog_taxonomies');