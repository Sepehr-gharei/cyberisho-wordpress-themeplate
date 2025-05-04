<?php
function create_portfolio_post_type() {
    $labels = array(
        'name'               => _x('نمونه کار ها', 'نام عمومی نوع پست', 'textdomain'),
        'singular_name'      => _x('نمونه کار', 'نام مفرد نوع پست', 'textdomain'),
        'menu_name'          => __('نمونه کار ها', 'textdomain'),
        'name_admin_bar'     => __('نمونه کار', 'textdomain'),
        'add_new'            => __('افزودن نمونه کار جدید', 'textdomain'),
        'add_new_item'       => __('افزودن نمونه کار جدید', 'textdomain'),
        'new_item'           => __('نمونه کار جدید', 'textdomain'),
        'edit_item'          => __('ویرایش نمونه کار', 'textdomain'),
        'view_item'          => __('مشاهده نمونه کار', 'textdomain'),
        'all_items'          => __('همه نمونه کار ها', 'textdomain'),
        'search_items'       => __('جستجوی نمونه کار ها', 'textdomain'),
        'parent_item_colon'  => __('نمونه کار مادر:', 'textdomain'),
        'not_found'          => __('هیچ نمونه کاری یافت نشد.', 'textdomain'),
        'not_found_in_trash' => __('هیچ نمونه کاری در زباله‌دان یافت نشد.', 'textdomain')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'portfolio'),
        'capability_type'    => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'         => array('portfolio_category', 'portfolio_tag'), // دسته‌بندی و برچسب‌های اختصاصی
        'menu_icon' => 'dashicons-portfolio',
    );

    register_post_type('portfolio', $args);
}
add_action('init', 'create_portfolio_post_type');
function create_portfolio_taxonomies() {
    // دسته‌بندی اختصاصی
    register_taxonomy(
        'portfolio_category', // نام دسته‌بندی
        'portfolio', // نوع پست مرتبط
        array(
            'label' => __('دسته‌بندی نمونه کار ها', 'textdomain'),
            'rewrite' => array('slug' => 'portfolio-category'),
            'hierarchical' => true, // مانند دسته‌بندی‌های معمولی
        )
    );

    // برچسب‌های اختصاصی
    register_taxonomy(
        'portfolio_tag', // نام برچسب
        'portfolio', // نوع پست مرتبط
        array(
            'label' => __('برچسب‌های نمونه کار ها', 'textdomain'),
            'rewrite' => array('slug' => 'portfolio-tag'),
            'hierarchical' => false, // مانند برچسب‌های معمولی
        )
    );
}
add_action('init', 'create_portfolio_taxonomies');