<?php
include_once("_inc/assets/register_assets.php");
include_once("_inc/taxonimies/blog_taxonomy.php");
include_once("_inc/taxonimies/portfolio_taxonomy.php");
include_once("_inc/meta-box/portfolio-meta-box.php");
include_once("helper/helper.php");
function custom_post_type_pagination($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('portfolio')) {
        $query->set('posts_per_page', 1); // تعداد پست‌ها در هر صفحه
    }
   
   
}
add_action('pre_get_posts', 'custom_post_type_pagination');
