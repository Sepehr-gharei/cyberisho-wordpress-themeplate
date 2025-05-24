<?php

class Admin_Helper {

    public function cyberisho_Text($id, $title, $content, $width) {
        $field = "<div id='$id' class='cyberisho-field $width field-text'>"
            . "<label for='$id'>$title</label>"
            . "<input type='text' value='". (!empty($content) ? esc_attr($content) : '') ."' name='$id' />"
        . "</div>";

        return $field;
    }

    public function cyberisho_Textarea($id, $title, $content, $width) {
        $escaped_content = !empty($content) ? esc_attr($content) : '';
        $br_content = nl2br($escaped_content);
        $field = "<div id='$id' class='cyberisho-field $width field-textarea'>"
            . "<label for='$id'>$title</label>"
            . "<textarea name='$id' rows='4' cols='50'>". (!empty($content) ? esc_attr($content) : '') ."</textarea>"
        . "</div>";

        return $field;
    }

    public function cyberisho_URL($id, $title, $content, $width) {
        $field = "<div id='$id' class='cyberisho-field $width field-url'>"
            . "<label for='$id'>$title</label>"
            . "<input type='text' value='". (!empty($content) ? esc_attr($content) : '') ."' name='$id' />"
        . "</div>";

        return $field;
    }

    public function cyberisho_Image_Uploader($id, $title, $content, $width) {
        $field = "<div id='$id' class='cyberisho-field $width field-image-uploader'>"
            . "<label for='$id'>$title</label>"
            . "<div class='flex align-items-center'>"
                . "<button class='button field-upload-img' id='chooseLogo'>انتخاب تصویر</button>"
                . "<input value='". (!empty($content) ? esc_url($content) : '') ."' type='text' class='field-img-url' name='$id' />"
                . "<div class='field-img-container'>". (!empty($content) ? '<img src="'. esc_url($content) .'" alt="'. $id . '">' : '') ."</div>"
                . "<a class='field-delete-img". (empty($content) ? ' hidden' : '') ."' href='#'>حذف تصویر</a>"
            . "</div>"
        . "</div>";

        return $field;
    }

    public function cyberisho_Multiple_Image_Uploader($id, $title, $content, $width) {
        $content = explode(',', $content);
        $field = "<div id='$id' class='cyberisho-field $width field-multiple-image-uploader'>"
            . "<label for='$id'>$title</label>"
            . "<div class='flex align-items-center flex-wrap'>"
                . "<button class='button field-upload-img' id='chooseLogo'>انتخاب تصاویر</button>"
                . "<input value='". (!empty($content) ? implode(',', $content) : '') ."' type='text' class='field-img-ids' name='$id' />"
                . "<div class='field-img-container'>";
                if (!empty($content) && is_array($content)) {
                    foreach ($content as $image_id) {
                        $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                        if ($image_url) {
                            $field .= "<div class='field-img-item' data-id='$image_id'><img src='$image_url' alt=''></div>";
                        }
                    }
                }
                $field .= "</div>"
            . "</div>"
        . "</div>";
    
        return $field;
    }

    public function cyberisho_Checkbox($id, $title, $content, $width) {
        $field = "<div id='$id' class='cyberisho-field $width field-checkbox'>"
            . "<label for='$id'>$title</label>"
            . "<div>"
                . "<input type='checkbox' name='$id' ". ($content == true ? ' checked' : '') ." >"
                . "<span class='btn-toggle'></span>"
            . "</div>"
        . "</div>";

        return $field;
    }

    public function cyberisho_Select($id, $title, $content, $selected, $width) {
        $field = '';
        $field .= "<div id='$id' class='cyberisho-field $width field-select'>"
            . "<label for='$id'>$title</label>"
            . "<select class='cyberisho-select select-single' name='$id'>";
                foreach($content as $id => $value) {
                    $field .= "<option ". ($selected == $id ? ' selected' : '') ." value='$id'>$value</option>";
                }
            $field .= "</select>"
        . "</div>";

        return $field;
    }

    public function cyberisho_Select2($id, $select_id, $title, $content, $selected, $width) {
        $field = '';
        $field .= "<div id='$id' class='cyberisho-field $width field-select2'>"
            . "<label for='$id'>$title</label>"
            . "<select class='cyberisho-select select-multiple' name='$select_id' multiple='multiple'>";
                foreach($content as $id => $value) {
                    $field .= "<option ". (!empty($selected) && in_array($id, $selected) ? ' selected' : '') ." value='$id'>$value</option>";
                }
            $field .= "</select>"
        . "</div>";

        return $field;
    }

    public function cyberisho_Color($id, $title, $content, $width) {
        $field = "<div id='$id' class='cyberisho-field $width field-color'>"
            . "<label for='$id'>$title</label>"
            . "<input type='text' class='color-picker' data-alpha-color-type='hex' data-alpha-enabled='true' value='". (!empty($content) ? esc_attr($content) : '#000') ."' name='$id' />"
        . "</div>";

        return $field;
    }

    public function cyberisho_Editor($id, $title, $content, $width) {
        $settings = array(
            'textarea_name' => $id,
            'wpautop' => false,
            'textarea_rows' => 15,
            'media_buttons' => false,
            'drag_drop_upload' => false,
            'editor_height' => 200,
            'tinymce' => array('plugins' => 'fullscreen,wordpress,wplink,textcolor'),
        );
    
        $content = html_entity_decode($content);
        $content = stripslashes($content);
        return wp_editor($content, $id, $settings);
    }

    public function cyberisho_Repeater($id, $title, $section, $btn, $settings, $default, $width) {
        $field = '';
        $theme_options = get_option('cyberisho_main_option', []);
        
        // Encode settings as JSON for the data-settings attribute
        $json_settings = json_encode($settings, JSON_UNESCAPED_UNICODE);
        
        $field .= "<div id='$id' class='cyberisho-field field-repeater'>"
            . "<label for='$id'>$title</label>"
            . "<div class='main-repeater flex flex-wrap'>";
        
        $get_option = (!empty($theme_options[$section]) ? $theme_options[$section] : '');
        if (!empty($get_option[$id])) {
            $i = -1;
            foreach ($get_option[$id] as $repeater) {
                $i++;
                $field .= "<div id='". $id . "[" . $i . "]' class='repeater-table $width'>"
                    . "<div class='repeater-table-entry'>"
                    . "<button class='delete-repeater-row'>حذف</button>";
                foreach ($settings as $key => $setting) {
                    $parts = explode('[', $key);
                    $lastPart = end($parts);
                    $default_id = rtrim($lastPart, ']');
                    $type = $setting['type'];
                    $title = $setting['title'];
                    $key = $id . '[' . $i . '][' . $default_id . ']';
                    $w = '';
                    $default = (!empty($get_option[$id][$i][$default_id]) ? $get_option[$id][$i][$default_id] : '');
                    switch ($type) {
                        case 'text':
                            $field .= $this->cyberisho_Text($key, $title, $default, $w);
                            break;
                        case 'textarea':
                            $field .= $this->cyberisho_Textarea($key, $title, $default, $w);
                            break;
                        case 'image-uploader':
                            $field .= $this->cyberisho_Image_Uploader($key, $title, $default, $w);
                            break;
                        case 'select':
                            $field .= $this->cyberisho_Select($key, $title, $setting['content'], $default, $w);
                            break;
                    }
                }
                $field .= "</div>"
                    . "</div>";
            }
        } else {
            $field .= "<div id='". $id . "[0]' class='repeater-table $width'>"
                . "<div class='repeater-table-entry'>";
                foreach ($settings as $key => $setting) {
                    $parts = explode('[', $key);
                    $lastPart = end($parts);
                    $default_id = rtrim($lastPart, ']');
                    $type = $setting['type'];
                    $title = $setting['title'];
                    $field_id = $id . '[0][' . $default_id . ']';
                    $w = '';
                    $default = (!empty($get_option[$id][0][$default_id]) ? $get_option[$id][0][$default_id] : '');
                    switch ($type) {
                        case 'text':
                            $field .= $this->cyberisho_Text($field_id, $title, $default, $w);
                            break;
                        case 'textarea':
                            $field .= $this->cyberisho_Textarea($field_id, $title, $default, $w);
                            break;
                        case 'image-uploader':
                            $field .= $this->cyberisho_Image_Uploader($field_id, $title, $default, $w);
                            break;
                        case 'select':
                            $field .= $this->cyberisho_Select($field_id, $title, $setting['content'], $default, $w);
                            break;
                    }
                }
                $field .= "</div>"
                    . "</div>";
        }
        
        // Add the data-settings attribute to the button
        $field .= "<button class='button w100 button-primary add-repeater-row' data-settings='" . esc_attr($json_settings) . "'>$btn</button>"
            . "</div>"
        . "</div>";

        return $field;
    }

    public function cyberisho_Heading($id, $title) {
        $field = "<h3 id='$id' class='cyberisho-field w100 field-heading'>$title</h3>";

        return $field;
    }


    public function cyberisho_Get_Post_Type($post_type) {
        // Initialize an empty array to store post IDs and titles
        $posts = [];

        // Validate the post_type parameter
        if (empty($post_type) || !is_string($post_type)) {
            return $posts; // Return empty array if post_type is invalid
        }

        // Fetch published posts of the specified post type
        $get_posts = get_posts(array(
            'post_type'   => $post_type,
            'numberposts' => -1, // Retrieve all posts
            'post_status' => 'publish',
        ));

        // Check if posts were found
        if (!empty($get_posts)) {
            foreach ($get_posts as $post) {
                $posts[$post->ID] = $post->post_title;
            }
        }

        return $posts;
    }
}

class Main_Settings extends Admin_Helper {

    protected function All_Settings() {
        $settings = [
            'footer-content' => [
                'menu' => 'محتواهای پاورچین',
                'lable' => 'تنظیمات محتوای پاورچین',
                'settings' => [
                    'footer_text' => [
                        'type' => 'textarea',
                        'title' => 'متن پاورچین',
                        'w' => 'w100',
                    ],
                    'footer_icon_1_image' => [
                        'type' => 'image-uploader',
                        'title' => 'عکس نماد اول',
                        'w' => 'w50',
                    ],
                    'footer_icon_2_image' => [
                        'type' => 'image-uploader',
                        'title' => 'عکس نماد دوم',
                        'w' => 'w50',
                    ],
                    'footer_icon_1_url' => [
                        'type' => 'url',
                        'title' => 'URL نماد اول',
                        'w' => 'w50',
                    ],
                    'footer_icon_2_url' => [
                        'type' => 'url',
                        'title' => 'URL نماد دوم',
                        'w' => 'w50',
                    ],
                ],
            ],
            'site-info' => [
                'menu' => 'اطلاعات سایت',
                'lable' => 'تنظیمات اطلاعات سایت',
                'settings' => [
                    'banner_header' => [
                        'type' => 'textarea',
                        'title' => 'هدر بنر',
                        'w' => 'w100',
                    ],
                    'banner_content' => [
                        'type' => 'textarea',
                        'title' => 'محتوا بنر',
                        'w' => 'w100',
                    ],
                    'project_count' => [
                        'type' => 'text',
                        'title' => 'تعداد پروژه‌ها',
                        'w' => 'w50',
                    ],
                    'project_start_year' => [
                        'type' => 'text',
                        'title' => 'سال شروع پروژه‌ها',
                        'w' => 'w50',
                    ],
                    'team_total' => [
                        'type' => 'text',
                        'title' => 'تعداد نفرات تیم',
                        'w' => 'w50',
                    ],
                    'team_item_1' => [
                        'type' => 'text',
                        'title' => 'ایتم نفرات اول',
                        'w' => 'w50',
                    ],
                    'team_item_2' => [
                        'type' => 'text',
                        'title' => 'ایتم نفرات دوم',
                        'w' => 'w50',
                    ],
                    'team_item_3' => [
                        'type' => 'text',
                        'title' => 'ایتم نفرات سوم',
                        'w' => 'w50',
                    ],
                    'team_item_4' => [
                        'type' => 'text',
                        'title' => 'ایتم نفرات چهارم',
                        'w' => 'w50',
                    ],
                    'home_feature_1' => [
                        'type' => 'textarea',
                        'title' => 'ویژگی 1',
                        'w' => 'w25',
                    ],
                    'home_feature_2' => [
                        'type' => 'textarea',
                        'title' => 'ویژگی 2',
                        'w' => 'w25',
                    ],
                    'home_feature_3' => [
                        'type' => 'textarea',
                        'title' => 'ویژگی 3',
                        'w' => 'w25',
                    ],
                    'home_feature_4' => [
                        'type' => 'textarea',
                        'title' => 'ویژگی 4',
                        'w' => 'w25',
                    ],
                    'brand_images' => [
                        'type' => 'repeater',
                        'title' => 'عکس‌های برند',
                        'section' => 'site-info',
                        'btn' => 'افزودن عکس برند جدید',
                        'w' => 'w100',
                        'settings' => [
                            'brand_images[0][image]' => [
                                'type' => 'image-uploader',
                                'title' => 'عکس برند',
                            ],
                        ],
                    ],
                    'above_brands_text' => [
                        'type' => 'heading',
                        'title' => 'متن بالای عنوان',
                        'w' => 'w100',
                    ],
                    'above_brands_header' => [
                        'type' => 'textarea',
                        'title' => 'هدر متن',
                        'w' => 'w100',
                    ],
                    'above_brands_content_1' => [
                        'type' => 'textarea',
                        'title' => 'محتوای اول متن',
                        'w' => 'w50',
                    ],
                    'above_brands_content_2' => [
                        'type' => 'textarea',
                        'title' => 'محتوای دوم متن',
                        'w' => 'w50',
                    ],
                    'below_brands_text' => [
                        'type' => 'heading',
                        'title' => 'متن پایین برندها',
                        'w' => 'w100',
                    ],
                    'below_brands_content' => [
                        'type' => 'textarea',
                        'title' => 'محتوای متن',
                        'w' => 'w100',
                    ],
                ],
            ],
            'contact' => [
                'menu' => 'اطلاعات تماس',
                'lable' => 'تنظیمات اطلاعات تماس',
                'settings' => [
                    'contact_hotline' => [
                        'type' => 'text',
                        'title' => 'خط ویژه',
                        'w' => 'w50',
                    ],
                    'contact_emergency' => [
                        'type' => 'text',
                        'title' => 'تماس ضروری',
                        'w' => 'w50',
                    ],
                    'contact_email' => [
                        'type' => 'text',
                        'title' => 'ایمیل',
                        'w' => 'w50',
                    ],
                    'social_whatsapp' => [
                        'type' => 'url',
                        'title' => 'واتساپ',
                        'w' => 'w50',
                    ],
                    'social_instagram' => [
                        'type' => 'url',
                        'title' => 'اینستاگرام',
                        'w' => 'w50',
                    ],
                    'social_telegram' => [
                        'type' => 'url',
                        'title' => 'تلگرام',
                        'w' => 'w50',
                    ],
                    'social_linkedin' => [
                        'type' => 'url',
                        'title' => 'لینکدین',
                        'w' => 'w50',
                    ],
                    'social_twitter' => [
                        'type' => 'url',
                        'title' => 'توییتر',
                        'w' => 'w50',
                    ],
                    'contact_location' => [
                        'type' => 'text',
                        'title' => 'لوکیشن',
                        'w' => 'w50',
                    ],
                ],
            ],
            'home' => [
                'menu' => 'صفحه اصلی',
                'lable' => 'تنظیمات صفحه اصلی',
                'settings' => [
                    'home_meeting_title' => [
                        'type' => 'text',
                        'title' => 'عنوان ملاقات',
                        'w' => 'w50',
                    ],
                    'home_meeting_content' => [
                        'type' => 'textarea',
                        'title' => 'محتوای ملاقات',
                        'w' => 'w50',
                    ],
                    'home_about_text' => [
                        'type' => 'textarea',
                        'title' => 'متن درباره ما',
                        'w' => 'w100',
                    ],
                    'home_service_1_title' => [
                        'type' => 'text',
                        'title' => 'عنوان خدمت اول',
                        'w' => 'w50',
                    ],
                    'home_service_1_content' => [
                        'type' => 'textarea',
                        'title' => 'محتوای خدمت اول',
                        'w' => 'w50',
                    ],
                    'home_service_2_title' => [
                        'type' => 'text',
                        'title' => 'عنوان خدمت دوم',
                        'w' => 'w50',
                    ],
                    'home_service_2_content' => [
                        'type' => 'textarea',
                        'title' => 'محتوای خدمت دوم',
                        'w' => 'w50',
                    ],
                    'home_cyberwhy_1' => [
                        'type' => 'text',
                        'title' => 'چرا سایبری شو 1',
                        'w' => 'w25',
                    ],
                    'home_cyberwhy_2' => [
                        'type' => 'text',
                        'title' => 'چرا سایبری شو 2',
                        'w' => 'w25',
                    ],
                    'home_cyberwhy_3' => [
                        'type' => 'text',
                        'title' => 'چرا سایبری شو 3',
                        'w' => 'w25',
                    ],
                    'home_cyberwhy_4' => [
                        'type' => 'text',
                        'title' => 'چرا سایبری شو 4',
                        'w' => 'w25',
                    ],
                    'home_faq_items' => [
                        'type' => 'repeater',
                        'title' => 'سوالات متداول',
                        'section' => 'home',
                        'btn' => 'افزودن سوال جدید',
                        'w' => 'w100',
                        'settings' => [
                            'home_faq_items[0][title]' => [
                                'type' => 'text',
                                'title' => 'عنوان سوال',
                            ],
                            'home_faq_items[0][content]' => [
                                'type' => 'textarea',
                                'title' => 'متن پاسخ',
                            ],
                        ],
                    ],
                ],
            ],
            'about' => [
                'menu' => 'صفحه درباره ما',
                'lable' => 'تنظیمات صفحه درباره ما',
                'settings' => [
                    'about_chart_title' => [
                        'type' => 'textarea',
                        'title' => 'عملکرد سایبریشو',
                        'w' => 'w100',
                    ],
                    'about_chart_header' => [
                        'type' => 'textarea',
                        'title' => 'درباره نمودار هدر',
                        'w' => 'w100',
                    ],
                    'about_chart_footer' => [
                        'type' => 'textarea',
                        'title' => 'درباره نمودار فوتر',
                        'w' => 'w100',
                    ],
                    'about_chart_items' => [
                        'type' => 'repeater',
                        'title' => 'آیتم‌های نمودار',
                        'section' => 'about',
                        'btn' => 'افزودن آیتم نمودار جدید',
                        'w' => 'w100',
                        'settings' => [
                            'about_chart_items[0][year]' => [
                                'type' => 'text',
                                'title' => 'سال نمودار',
                            ],
                            'about_chart_items[0][projects]' => [
                                'type' => 'text',
                                'title' => 'تعداد پروژه‌ها',
                            ],
                        ],
                    ],
                ],
            ],
            'landing' => [
                'menu' => 'صفحه لندینگ',
                'lable' => 'تنظیمات صفحه لندینگ',
                'settings' => [
                    'landing_initial_header' => [
                        'type' => 'text',
                        'title' => 'هدر اولیه قبل از انواع سایت ها',
                        'w' => 'w50',
                    ],
                    'heading_landing_initial_content-2' => [
                        'type' => 'heading',
                        'title' => 'محتوای اولیه قبل از انواع سایت ها',
                    ],
                    'landing_initial_content' => [
                        'type' => 'editor',
                        'title' => 'محتوای اولیه',
                        'w' => 'w50',
                    ],
                    'landing_footer_header' => [
                        'type' => 'text',
                        'title' => 'هدر پاورقی بعد از انواع سایت ها',
                        'w' => 'w50',
                    ],
                    'heading_landing_footer_content' => [
                        'type' => 'heading',
                        'title' => 'محتوای پاورقی بعد از انواع سایت ها',
                    ],
                    'landing_footer_content' => [
                        'type' => 'editor',
                        'title' => 'متن محتوای پاورقی',
                        'w' => 'w100',
                    ],
                    'landing_site_types' => [
                        'type' => 'repeater',
                        'title' => 'انواع سایت',
                        'section' => 'landing',
                        'btn' => 'افزودن نوع سایت جدید',
                        'w' => 'w100',
                        'settings' => [
                            'landing_site_types[0][image]' => [
                                'type' => 'image-uploader',
                                'title' => 'عکس',
                            ],
                            'landing_site_types[0][content_header]' => [
                                'type' => 'textarea',
                                'title' => 'هدر محتوا',
                            ],
                            'landing_site_types[0][content]' => [
                                'type' => 'textarea',
                                'title' => 'محتوا',
                            ],
                            'landing_site_types[0][feature_header]' => [
                                'type' => 'textarea',
                                'title' => 'هدر ویژگی',
                            ],
                            'landing_site_types[0][feature_1]' => [
                                'type' => 'textarea',
                                'title' => 'ویژگی 1',
                            ],
                            'landing_site_types[0][feature_2]' => [
                                'type' => 'textarea',
                                'title' => 'ویژگی 2',
                            ],
                            'landing_site_types[0][feature_3]' => [
                                'type' => 'textarea',
                                'title' => 'ویژگی 3',
                            ],
                        ],
                    ],
                    'heading_landing_pricing_header' => [
                        'type' => 'heading',
                        'title' => 'محتوای هدر قیمت‌گذاری',
                    ],
                    'landing_pricing_header' => [
                        'type' => 'editor',
                        'title' => 'متن محتوای هدر قیمت‌گذاری',
                        'w' => 'w100',
                    ],
                    'landing_pricing_rows' => [
                        'type' => 'repeater',
                        'title' => 'سطرهای قیمت‌گذاری',
                        'section' => 'landing',
                        'btn' => 'افزودن سطر جدید',
                        'w' => 'w100',
                        'settings' => [
                            'landing_pricing_rows[0][description]' => [
                                'type' => 'text',
                                'title' => 'شرح خدمات',
                            ],
                            'landing_pricing_rows[0][duration]' => [
                                'type' => 'text',
                                'title' => 'مدت زمان',
                            ],
                            'landing_pricing_rows[0][price]' => [
                                'type' => 'text',
                                'title' => 'قیمت',
                            ],
                        ],
                    ],
                    'heading_landing_pricing_footer' => [
                        'type' => 'heading',
                        'title' => 'محتوای فوتر قیمت‌گذاری',
                    ],
                    'landing_pricing_footer' => [
                        'type' => 'editor',
                        'title' => 'محتوای فوتر قیمت‌گذاری',
                        'w' => 'w100',
                    ],
                    'landing_page_faqs' => [
                        'type' => 'repeater',
                        'title' => 'سوالات متداول',
                        'section' => 'landing',
                        'btn' => 'افزودن سوال جدید',
                        'w' => 'w100',
                        'settings' => [
                            'landing_page_faqs[0][title]' => [
                                'type' => 'text',
                                'title' => 'عنوان سوال',
                            ],
                            'landing_page_faqs[0][content]' => [
                                'type' => 'textarea',
                                'title' => 'متن پاسخ',
                            ],
                        ],
                    ],
                ],
            ],
            'portfolio' => [
                'menu' => 'صفحه نمونه کارها',
                'lable' => 'تنظیمات صفحه نمونه کارها',
                'settings' => [
                    'theme_portfolios' => [
                        'type' => 'repeater',
                        'title' => 'نمونه کارها',
                        'section' => 'portfolio',
                        'btn' => 'افزودن نمونه کار جدید',
                        'w' => 'w100',
                        'settings' => [
                            'theme_portfolios[0][name]' => [
                                'type' => 'text',
                                'title' => 'نام نمونه کار',
                            ],
                            'theme_portfolios[0][type]' => [
                                'type' => 'text',
                                'title' => 'نوع سایت',
                            ],
                            'theme_portfolios[0][duration]' => [
                                'type' => 'text',
                                'title' => 'مدت زمان انجام',
                            ],
                            'theme_portfolios[0][location]' => [
                                'type' => 'text',
                                'title' => 'موقعیت',
                            ],
                            'theme_portfolios[0][url]' => [
                                'type' => 'text',
                                'title' => 'URL سایت',
                            ],
                            'theme_portfolios[0][blue_effect]' => [
                                'type' => 'select',
                                'title' => 'افکت آبی',
                                'content' => [
                                    'enabled' => 'فعال',
                                    'disabled' => 'غیرفعال',
                                ],
                                'default' => 'disabled',
                            ],
                            'theme_portfolios[0][main_image]' => [
                                'type' => 'image-uploader',
                                'title' => 'عکس اصلی',
                            ],
                            'theme_portfolios[0][desktop_image]' => [
                                'type' => 'image-uploader',
                                'title' => 'عکس دسکتاپ',
                            ],
                            'theme_portfolios[0][mobile_image]' => [
                                'type' => 'image-uploader',
                                'title' => 'عکس موبایل',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $settings;
    }

    protected function General_Settings($current_tab) {
        $all_settings = $this->All_Settings();
        $theme_options = get_option('cyberisho_main_option', []);

        foreach ($all_settings as $name => $section) {
            $lable = $section['lable'];
            $settings = $section['settings'];
            $get_option = (!empty($theme_options[$name]) ? $theme_options[$name] : '');

            if ($name == $current_tab) {
                echo "<div class='content-tab $name-options'>"
                    . "<h2>$lable</h2>"
                    . "<div class='cyberisho-form-setting flex flex-wrap'>";
                foreach ($settings as $id => $setting) {
                    $type = $setting['type'];
                    $title = $setting['title'];
                    $width = (!empty($setting['w']) ? $setting['w'] : 'w100');
                    $default = (!empty($get_option[$id]) ? $get_option[$id] : '');
                    switch ($type) {
                        case 'text':
                            echo $this->cyberisho_Text($id, $title, $default, $width);
                            break;
                        case 'url':
                            echo $this->cyberisho_URL($id, $title, $default, $width);
                            break;
                        case 'textarea':
                            echo $this->cyberisho_Textarea($id, $title, $default, $width);
                            break;
                        case 'image-uploader':
                            echo $this->cyberisho_Image_Uploader($id, $title, $default, $width);
                            break;
                        case 'gallery-uploader':
                            echo $this->cyberisho_Multiple_Image_Uploader($id, $title, $default, $width);
                            break;
                        case 'checkbox':
                            echo $this->cyberisho_Checkbox($id, $title, $default, $width);
                            break;
                        case 'select':
                            $content = $setting['content'];
                            echo $this->cyberisho_Select($id, $title, $content, $default, $width);
                            break;
                        case 'select2':
                            $select_id = $setting['id'];
                            $content = $setting['content'];
                            echo $this->cyberisho_Select2($id, $select_id, $title, $content, $default, $width);
                            break;
                        case 'color':
                            echo $this->cyberisho_Color($id, $title, $default, $width);
                            break;
                        case 'repeater':
                            $btn = $setting['btn'];
                            $repeater_settings = $setting['settings'];
                            $section = $setting['section'];
                            echo $this->cyberisho_Repeater($id, $title, $section, $btn, $repeater_settings, $default, $width);
                            break;
                        case 'heading':
                            echo $this->cyberisho_Heading($id, $title);
                            break;
                        case 'editor':
                            echo $this->cyberisho_Editor($id, $title, $default, $width);
                            break;
                    }
                }
                echo "</div>"
                    . "</div>";
            }
        }
    }
}

class Theme_Settings extends Main_Settings {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_theme_settings_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_head', [$this, 'admin_font']);
    }

    public function add_theme_settings_page() {
        add_menu_page(
            'تنظیمات قالب',
            'تنظیمات قالب',
            'manage_options',
            'cyberisho_theme_settings',
            array($this, 'render_settings_page'),
            'dashicons-admin-generic',
            30
        );
    }

    public function render_settings_page() {
        $this->Save_Change();
        echo FlashMessage::get();
        $settings = $this->All_Settings();
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'contact';
        echo "<div class='wrap'>"
            . "<nav class='nav-tab-wrapper'>";
        foreach ($settings as $id => $menu) {
            $menu_title = $menu['menu'];
            $tab_url = admin_url('admin.php?page=cyberisho_theme_settings&tab=' . $id);
            $active_class = ($active_tab == $id) ? ' nav-tab-active' : '';
            echo "<a href='$tab_url' class='nav-tab$active_class'>$menu_title</a>";
        }
        echo "</nav>";

        echo "<main class='cyberisho-main-content-options'>"
            . "<form action='' method='POST' id='setting-form'>";

        echo "<input type='hidden' name='current_tab' value='$active_tab'>";
        $this->General_Settings($active_tab);
        echo "<div class='form-row'>"
            . "<button type='submit' class='button cyberisho-submit' name='SaveSetting'>ذخیره تغییرات</button>"
            . "</div>"
            . "</form>"
            . "</main>"
            . "</div>";
    }

    public function Save_Change() {
        if (isset($_POST['SaveSetting'])) {
            $current_tab = isset($_POST['current_tab']) ? $_POST['current_tab'] : 'contact';
            if ($current_tab) {
                $main_options = get_option('cyberisho_main_option', []);

                $all_settings = $this->All_Settings();
                foreach ($all_settings[$current_tab]['settings'] as $id => $setting) {
                    $type = $setting['type'];
                    $field_value = isset($_POST[$id]) ? $_POST[$id] : '';

                    switch ($type) {
                        case 'text':
                        case 'select':
                        case 'color':
                        case 'gallery-uploader':
                            $value = sanitize_text_field($field_value);
                            break;
                        case 'textarea':
                            $value = sanitize_textarea_field($field_value);
                            break;
                        case 'select2':
                            $value = $field_value;
                            break;
                        case 'image-uploader':
                        case 'url':
                            $value = sanitize_url($field_value);
                            break;
                        case 'checkbox':
                            $value = isset($field_value);
                            break;
                        case 'repeater':
                            $value = $field_value;
                            break;
                        case 'editor':
                            $value = $this->Code_Validator($field_value);
                            break;
                    }

                    $main_options[$current_tab][$id] = $value;
                }

                update_option('cyberisho_main_option', $main_options);

                $this->start_session();
                FlashMessage::add('تنظیمات با موفقیت ذخیره شد.');
                $this->end_session();
            }
        }
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_style('style', get_template_directory_uri() . '/_inc/meta-box/css/style.css', [], '1.0.0');
        wp_enqueue_media();
        wp_enqueue_script('theme-settings-script', get_template_directory_uri() . '/_inc/meta-box/js/admin.js', array('jquery'), '1.0', true);
        wp_enqueue_script('select2', get_template_directory_uri() . '/_inc/meta-box/js/select2.min.js', array('jquery'), '4.1.0', true);
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker-alpha', get_template_directory_uri() . '/_inc/meta-box/js/wp-color-picker-alpha.min.js', array('wp-color-picker'), '4.1.0', true);
    }

    private function Code_Validator($code) {
        return str_replace(array('\'', '\"'), '"', $code);
    }

    public function start_session() {
        if (!session_id()) {
            session_start();
        }
    }

    public function end_session() {
        session_write_close();
    }

    public function admin_font() {
        echo "<style type='text/css'>@font-face {font-family: 'YekanBakh';font-style: normal;font-weight: normal;src:  url('".get_template_directory_uri()."/assets/fonts/PeydaWeb-Regular.woff') format('woff'),   url('".get_template_directory_uri()."/assets/fonts/PeydaWeb-Regular.woff') format('woff2');}@font-face {font-family: 'YekanBakh';font-style: normal;font-weight: bold;src: url('".get_template_directory_uri()."/assets/fonts/PeydaWeb-Regular.woff') format('woff'),   url('".get_template_directory_uri()."/assets/fonts/PeydaWeb-Regular.woff') format('woff2'); }body.rtl, #wpadminbar *:not([class='ab-icon']), .wp-core-ui, .media-menu, .media-frame *, .media-modal *,.rtl h1, .rtl h2, .rtl h3, .rtl h4, .rtl h5, .rtl h6 {font-family:'YekanBakh' !important;}.php-error #adminmenuback, .php-error #adminmenuwrap {margin-top: 0 !important;}#sub-accordion-section-custom_codes textarea {direction: ltr;}</style>" . PHP_EOL;
    }
}

new Theme_Settings;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class FlashMessage {

    const SUCCESS = 1;
    const ERROR = 2;

    public static function add($message, $type = self::SUCCESS) {
        $_SESSION['cyberisho_message'] = [
            'message' => $message,
            'type' => $type
        ];
    }

    public static function show() {
        if (isset($_SESSION['cyberisho_message'])) {
            $message = $_SESSION['cyberisho_message'];
            if ($message['type'] = self::SUCCESS) {
                echo "<div class='alert alert-success'>" . $message['message'] . "</div>";
            } else {
                echo "<div class='alert alert-danger'>" . $message['message'] . "</div>";
            }

            self::clear();
        }
    }

    public static function get() {
        $message_text = '';

        if (isset($_SESSION['cyberisho_message'])) {
            $message = $_SESSION['cyberisho_message'];
            if ($message['type'] = self::SUCCESS) {
                $message_text = "<div class='alert alert-success flex align-items-center'>"
                    . "<svg width='60' height='60' viewBox='0 0 60 60' fill='none' xmlns='http://www.w3.org/2000/svg'>"
                    . "<path fill-rule='evenodd' clip-rule='evenodd' d='M55 27.0548C55 28.0973 54.1525 28.9448 53.11 28.9448H53.0875V28.8998C52.0325 28.8998 51.1775 28.0473 51.175 26.9923V26.9873V20.6323C51.175 12.9998 47 8.82476 39.39 8.82476H20.64C13.025 8.82476 8.825 13.0248 8.825 20.6323V39.3823C8.825 46.9673 13.025 51.1673 20.6325 51.1673H39.3825C46.99 51.1673 51.1675 46.9673 51.1675 39.3823C51.1675 38.3273 52.0225 37.4698 53.08 37.4698C54.1375 37.4698 54.9925 38.3273 54.9925 39.3823C55 49.0198 49.02 54.9998 39.39 54.9998H20.6325C10.98 54.9998 5 49.0198 5 39.3898V20.6398C5 10.9798 10.98 4.99976 20.6325 4.99976H39.3825C48.975 4.99976 55 10.9798 55 20.6323V27.0548ZM27.034 33.2835L37.574 22.741C38.3065 22.0085 39.494 22.0085 40.2265 22.741C40.959 23.4735 40.959 24.661 40.2265 25.3935L28.359 37.261C28.0065 37.611 27.529 37.8085 27.034 37.8085C26.534 37.8085 26.059 37.611 25.7065 37.261L19.774 31.326C19.0415 30.5935 19.0415 29.406 19.774 28.6735C20.5065 27.941 21.694 27.941 22.4265 28.6735L27.034 33.2835Z' fill='#00C689'/>"
                    . "</svg>"
                    . $message['message'] . "</div>";
            } else {
                $message_text = "<div class='alert alert-danger flex align-items-center'>"
                    . "<svg width='44' height='44' viewBox='0 0 44 44' fill='none' xmlns='http://www.w3.org/2000/svg'>"
                    . "<path fill-rule='evenodd' clip-rule='evenodd' d='M41.6953 20.7523C42.5988 20.7523 43.3333 20.0178 43.3333 19.1143V13.5482C43.3333 5.18267 38.1117 0 29.7982 0H13.5482C5.18267 0 0 5.18267 0 13.5547V29.8047C0 38.1507 5.18267 43.3333 13.5482 43.3333H29.8047C38.1507 43.3333 43.3333 38.1507 43.3268 29.7982C43.3268 28.8838 42.5837 28.1407 41.6693 28.1407C40.7528 28.1407 40.0118 28.8838 40.0118 29.7982C40.0118 36.3718 36.3913 40.0118 29.7982 40.0118H13.5482C6.955 40.0118 3.315 36.3718 3.315 29.7982V13.5482C3.315 6.955 6.955 3.315 13.5547 3.315H29.8047C36.4 3.315 40.0183 6.93333 40.0183 13.5482V19.0558V19.0602C40.0205 19.9745 40.7615 20.7133 41.6758 20.7133V20.7523H41.6953ZM16.9321 24.1484L15.4501 25.6304C14.7892 26.2587 14.7524 27.3009 15.3677 27.9747L15.4154 28.0094C16.0481 28.642 17.0664 28.6594 17.7186 28.0484L19.1941 26.5729C19.8636 25.9489 19.9004 24.9002 19.2764 24.2285C18.6502 23.5612 17.6016 23.5222 16.9321 24.1484ZM28.4756 27.7405C27.8386 28.3753 26.8095 28.3883 26.1573 27.7665L26.075 27.6863L15.7183 17.3318C15.0856 16.6602 15.0726 15.6158 15.6901 14.9312C16.3228 14.2833 17.3585 14.2703 18.0063 14.903C18.0128 14.9073 18.0171 14.9116 18.0236 14.9181L22.0645 18.9611L25.7413 15.2822C26.4021 14.6517 27.4443 14.6581 28.0986 15.2973C28.2156 15.4143 28.3153 15.5465 28.3911 15.6938C28.766 16.346 28.6576 17.165 28.1268 17.698L24.4651 21.3575L28.4475 25.342C29.1191 25.9768 29.1451 27.0363 28.5081 27.7058C28.5032 27.7132 28.4969 27.7192 28.4903 27.7254C28.4854 27.7301 28.4803 27.7349 28.4756 27.7405Z' fill='#F15271'/>"
                    . "</svg>"
                    . $message['message'] . "</div>";
            }

            self::clear();
        }

        return $message_text;
    }

    public static function clear() {
        unset($_SESSION['cyberisho_message']);
    }
}
?>