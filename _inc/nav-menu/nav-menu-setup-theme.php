
<?Php
function cyberisho_setup_theme_support() {
    // منوهای ناوبری
    register_nav_menus(
        array(
            'right-menu'    => 'منو راست',
            'left-menu'     => 'منو چپ',
            'footer-menu'   => 'منو پانوشت',
        )
    );

    // حمایت از HTML5
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );

    // حمایت‌های دیگر
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'cyberisho_setup_theme_support');






// Custom Walker to output only <a> tags
class Cyberisho_Nav_Walker extends Walker_Nav_Menu {
    // Start of the menu (remove <ul>)
    function start_lvl(&$output, $depth = 0, $args = null) {
        // No output for levels (no nested menus)
    }

    // End of the menu (remove </ul>)
    function end_lvl(&$output, $depth = 0, $args = null) {
        // No output
    }

    // Start of each menu item (remove <li>)
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Build the <a> tag
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';

        // Apply filters for attributes
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        // Build attributes string
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Get the menu item title
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        // Append the <a> tag to the output
        $output .= '<a' . $attributes . '>' . $title . '</a>';
    }

    // End of each menu item (remove </li>)
    function end_el(&$output, $item, $depth = 0, $args = null) {
        // No output
    }
}
?>


<?php
// Custom Walker to output only <li> and <a> tags
class Cyberisho_Footer_Nav_Walker extends Walker_Nav_Menu {
    // Start of the menu (remove <ul>)
    function start_lvl(&$output, $depth = 0, $args = null) {
        // No output for levels (no nested menus)
    }

    // End of the menu (remove </ul>)
    function end_lvl(&$output, $depth = 0, $argsKin = null) {
        // No output
    }

    // Start of each menu item (output <li>)
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Build class attribute for <li>
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        // Start the <li> tag
        $output .= '<li' . $class_names . '>';

        // Build the <a> tag
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';

        // Apply filters for attributes
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        // Build attributes string
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Get the menu item title
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        // Append the <a> tag
        $output .= '<a' . $attributes . '>' . $title . '</a>';
    }

    // End of each menu item (close <li>)
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}
?>