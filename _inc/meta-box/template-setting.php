<?php
class Admin_Helper
{
    public function cyberisho_Text($id, $title, $content, $width)
    {
        $field = "<div id='$id' class='cyberisho-field $width field-text'>"
            . "<label for='$id'>$title</label>"
            . "<input type='text' value='" . (!empty($content) ? esc_attr($content) : '') . "' name='$id' />"
            . "</div>";

        return $field;
    }

    public function cyberisho_Textarea($id, $title, $content, $width)
    {
        $field = "<div id='$id' class='cyberisho-field $width field-textarea'>"
            . "<label for='$id'>$title</label>"
            . "<textarea name='$id' rows='4' cols='50'>" . (!empty($content) ? esc_textarea($content) : '') . "</textarea>"
            . "</div>";

        return $field;
    }

    public function cyberisho_URL($id, $title, $content, $width)
    {
        $field = "<div id='$id' class='cyberisho-field $width field-url'>"
            . "<label for='$id'>$title</label>"
            . "<input type='url' value='" . (!empty($content) ? esc_url($content) : '') . "' name='$id' />"
            . "</div>";

        return $field;
    }

    public function cyberisho_Image_Uploader($id, $title, $content, $width)
    {
        $field = "<div id='$id' class='cyberisho-field $width field-image-uploader'>"
            . "<label for='$id'>$title</label>"
            . "<div class='flex align-items-center'>"
            . "<button type='button' class='button field-upload-img' data-input-id='$id'>انتخاب تصویر</button>"
            . "<input value='" . (!empty($content) ? esc_url($content) : '') . "' type='text' class='field-img-url' name='$id' readonly />"
            . "<div class='field-img-container'>" . (!empty($content) ? '<img src="' . esc_url($content) . '" alt="' . esc_attr($title) . '" style="max-width: 100px; max-height: 100px;" />' : '') . "</div>"
            . "<a class='field-delete-img" . (empty($content) ? ' hidden' : '') . "' href='#' data-input-id='$id'>حذف تصویر</a>"
            . "</div>"
            . "</div>";

        return $field;
    }

    public function cyberisho_Multiple_Image_Uploader($id, $title, $content, $width)
    {
        $content = is_array($content) ? $content : explode(',', $content);
        $field = "<div id='$id' class='cyberisho-field $width field-multiple-image-uploader'>"
            . "<label for='$id'>$title</label>"
            . "<div class='flex align-items-center flex-wrap'>"
            . "<button type='button' class='button field-upload-img multiple' data-input-id='$id'>انتخاب تصاویر</button>"
            . "<input value='" . (!empty($content) ? esc_attr(implode(',', $content)) : '') . "' type='text' class='field-img-ids' name='$id' readonly />"
            . "<div class='field-img-container'>";
        if (!empty($content) && is_array($content)) {
            foreach ($content as $image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                if ($image_url) {
                    $field .= "<div class='field-img-item' data-id='" . esc_attr($image_id) . "'><img src='" . esc_url($image_url) . "' alt='' style='max-width: 100px; max-height: 100px;' /><a href='#' class='field-delete-img' data-id='" . esc_attr($image_id) . "'>حذف</a></div>";
                }
            }
        }
        $field .= "</div>"
            . "</div>"
            . "</div>";

        return $field;
    }

    public function cyberisho_Checkbox($id, $title, $content, $width)
    {
        $field = "<div id='$id' class='cyberisho-field $width field-checkbox'>"
            . "<label for='$id'>$title</label>"
            . "<div>"
            . "<input type='checkbox' name='$id' " . ($content ? 'checked' : '') . " value='1' />"
            . "<span class='btn-toggle'></span>"
            . "</div>"
            . "</div>";

        return $field;
    }

    public function cyberisho_Select($id, $title, $content, $selected, $width)
    {
        $field = "<div id='$id' class='cyberisho-field $width field-select'>"
            . "<label for='$id'>$title</label>"
            . "<select class='cyberisho-select select-single' name='$id'>";
        foreach ($content as $key => $value) {
            $field .= "<option " . (strval($selected) === strval($key) ? 'selected' : '') . " value='" . esc_attr($key) . "'>" . esc_html($value) . "</option>";
        }
        $field .= "</select>"
            . "</div>";

        return $field;
    }

    public function cyberisho_Select2($id, $select_id, $title, $content, $selected, $width)
    {
        $field = "<div id='$id' class='cyberisho-field $width field-select2'>"
            . "<label for='$id'>$title</label>"
            . "<select class='cyberisho-select select-multiple' name='" . esc_attr($select_id) . "[]' multiple='multiple'>";
        foreach ($content as $key => $value) {
            $field .= "<option " . (is_array($selected) && in_array($key, $selected) ? 'selected' : '') . " value='" . esc_attr($key) . "'>" . esc_html($value) . "</option>";
        }
        $field .= "</select>"
            . "</div>";

        return $field;
    }

    public function cyberisho_Color($id, $title, $content, $width)
    {
        $field = "<div id='$id' class='cyberisho-field $width field-color'>"
            . "<label for='$id'>$title</label>"
            . "<input type='text' class='color-picker' data-alpha-color-type='hex' data-alpha-enabled='true' value='" . (!empty($content) ? esc_attr($content) : '#000') . "' name='$id' />"
            . "</div>";

        return $field;
    }

    public function cyberisho_Editor($id, $title, $content, $width)
    {
        $settings = array(
            'textarea_name' => $id,
            'wpautop' => false,
            'textarea_rows' => 15,
            'media_buttons' => false,
            'drag_drop_upload' => false,
            'editor_height' => 200,
            'tinymce' => array('plugins' => 'fullscreen,wordpress,wplink,textcolor'),
        );

        ob_start();
        echo "<div id='$id' class='cyberisho-field $width field-editor'>";
        echo "<label for='$id'>$title</label>";
        wp_editor(html_entity_decode(stripslashes($content)), $id, $settings);
        echo "</div>";
        return ob_get_clean();
    }

    public function cyberisho_Repeater($id, $title, $section, $btn, $settings, $default, $width)
    {
        $field = '';
        $theme_options = get_option('cyberisho_main_option', []);
        $field .= "<div id='$id' class='cyberisho-field field-repeater $width'>"
            . "<label for='$id'>$title</label>"
            . "<div class='main-repeater flex flex-wrap'>";
        $get_option = (!empty($theme_options[$section]) ? $theme_options[$section] : '');
        if (!empty($get_option[$id])) {
            $i = -1;
            foreach ($get_option[$id] as $repeater) {
                $i++;
                $field .= "<div id='" . esc_attr($id . "[" . $i . "]") . "' class='repeater-table $width'>"
                    . "<div class='repeater-table-entry'>"
                    . "<button type='button' class='button delete-repeater-row'>حذف</button>";
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
                    }
                }
                $field .= "</div>"
                    . "</div>";
            }
        } else {
            $field .= "<div id='" . esc_attr($id . "[0]") . "' class='repeater-table $width'>"
                . "<div class='repeater-table-entry'>"
                . "<button type='button' class='button delete-repeater-row'>حذف</button>";
            foreach ($settings as $key => $setting) {
                $parts = explode('[', $key);
                $lastPart = end($parts);
                $default_id = rtrim($lastPart, ']');
                $type = $setting['type'];
                $title = $setting['title'];
                $key = $id . '[0][' . $default_id . ']';
                $w = '';
                $default = '';
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
                }
            }
            $field .= "</div>"
                . "</div>";
        }
        $field .= "<button type='button' class='button w100 button-primary add-repeater-row' data-settings='" . esc_attr(json_encode($settings)) . "'>$btn</button>"
            . "</div>"
            . "</div>";

        return $field;
    }

    public function cyberisho_Heading($id, $title)
    {
        $field = "<h3 id='$id' class='cyberisho-field w100 field-heading'>" . esc_html($title) . "</h3>";

        return $field;
    }

    public function cyberisho_Get_Post_Type($post_type)
    {
        $posts = [];
        $get_posts = get_posts(array('post_type' => $post_type, 'numberposts' => -1, 'post_status' => 'publish'));
        if (!empty($get_posts)) {
            foreach ($get_posts as $post) {
                $posts[$post->ID] = $post->post_title;
            }
        }
        return $posts;
    }
}

class Main_Settings extends Admin_Helper
{
    protected function All_Settings()
    {
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
                    // بخش جدید: متن بالای عنوان
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
                    // بخش جدید: متن پایین برندها
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
                        'type' => 'textarea',
                        'title' => 'هدر اولیه',
                        'w' => 'w50',
                    ],
                    'landing_initial_content' => [
                        'type' => 'textarea',
                        'title' => 'محتوای اولیه',
                        'w' => 'w50',
                    ],
                    'landing_footer_header' => [
                        'type' => 'textarea',
                        'title' => 'هدر پاورقی',
                        'w' => 'w50',
                    ],
                    'landing_footer_content' => [
                        'type' => 'textarea',
                        'title' => 'محتوای پاورقی',
                        'w' => 'w50',
                    ],
                    'landing_pricing_header' => [
                        'type' => 'textarea',
                        'title' => 'محتوای هدر قیمت‌گذاری',
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
                                'type' => 'textarea',
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
                    'landing_pricing_footer' => [
                        'type' => 'textarea',
                        'title' => 'محتوای فوتر قیمت‌گذاری',
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
                                'type' => 'url',
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

    protected function General_Settings($current_tab)
    {
        $all_settings = $this->All_Settings();
        $theme_options = get_option('cyberisho_main_option', []);

        foreach ($all_settings as $name => $section) {
            $lable = $section['lable'];
            $settings = $section['settings'];
            $get_option = (!empty($theme_options[$name]) ? $theme_options[$name] : '');

            if ($name == $current_tab) {
                $output = "<div class='content-tab $name-options'>"
                    . "<h2>" . esc_html($lable) . "</h2>";
                $output .= settings_errors('cyberisho_messages', false, true) ? settings_errors('cyberisho_messages', false, true) : '';
                $output .= "<form method='post' action='' class='cyberisho-form-setting flex flex-wrap'>";
                $output .= wp_nonce_field('cyberisho_save_settings', 'cyberisho_nonce', true, false);
                foreach ($settings as $id => $setting) {
                    $type = $setting['type'];
                    $title = $setting['title'];
                    $width = (!empty($setting['w']) ? $setting['w'] : 'w100');
                    $default = (!empty($get_option[$id]) ? $get_option[$id] : '');
                    switch ($type) {
                        case 'text':
                            $output .= $this->cyberisho_Text($id, $title, $default, $width);
                            break;
                        case 'url':
                            $output .= $this->cyberisho_URL($id, $title, $default, $width);
                            break;
                        case 'textarea':
                            $output .= $this->cyberisho_Textarea($id, $title, $default, $width);
                            break;
                        case 'image-uploader':
                            $output .= $this->cyberisho_Image_Uploader($id, $title, $default, $width);
                            break;
                        case 'gallery-uploader':
                            $output .= $this->cyberisho_Multiple_Image_Uploader($id, $title, $default, $width);
                            break;
                        case 'checkbox':
                            $output .= $this->cyberisho_Checkbox($id, $title, $default, $width);
                            break;
                        case 'select':
                            $content = $setting['content'];
                            $default_select = isset($setting['default']) ? $setting['default'] : '';
                            $output .= $this->cyberisho_Select($id, $title, $content, $default, $width);
                            break;
                        case 'select2':
                            $select_id = $setting['id'];
                            $content = $setting['content'];
                            $output .= $this->cyberisho_Select2($id, $select_id, $title, $content, $default, $width);
                            break;
                        case 'color':
                            $output .= $this->cyberisho_Color($id, $title, $default, $width);
                            break;
                        case 'repeater':
                            $btn = $setting['btn'];
                            $repeater_settings = $setting['settings'];
                            $section = $setting['section'];
                            $output .= $this->cyberisho_Repeater($id, $title, $section, $btn, $repeater_settings, $default, $width);
                            break;
                        case 'heading':
                            $output .= $this->cyberisho_Heading($id, $title);
                            break;
                        case 'editor':
                            $output .= $this->cyberisho_Editor($id, $title, $default, $width);
                            break;
                    }
                }
                $output .= "<p><input type='submit' name='submit' class='button button-primary' value='ذخیره تغییرات'></p>"
                    . "</form></div>";
                return $output;
            }
        }
        return '';
    }

    public function __construct()
    {
        add_action('admin_menu', [$this, 'custom_theme_settings_menu']);
        add_action('admin_enqueue_scripts', [$this, 'theme_settings_enqueue_scripts']);
        add_action('admin_init', [$this, 'save_theme_settings']);
    }

    public function custom_theme_settings_menu()
    {
        add_menu_page(
            'تنظیمات قالب',
            'تنظیمات قالب',
            'manage_options',
            'theme-settings',
            [$this, 'theme_settings_page'],
            'dashicons-admin-generic',
            30
        );
    }

    public function theme_settings_page()
    {
        $tabs = [
            'footer-content' => 'محتواهای پاورچین',
            'site-info' => 'اطلاعات سایت',
            'contact' => 'اطلاعات تماس',
            'home' => 'صفحه اصلی',
            'about' => 'صفحه درباره ما',
            'landing' => 'صفحه لندینگ',
            'portfolio' => 'صفحه نمونه کارها'
        ];

        $current_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'footer-content';
        ob_start();
        ?>
        <div class="wrap">
            <h1>تنظیمات قالب</h1>
            <h2 class="nav-tab-wrapper">
                <?php foreach ($tabs as $tab_slug => $tab_name): ?>
                    <a href="?page=theme-settings&tab=<?php echo esc_attr($tab_slug); ?>"
                        class="nav-tab <?php echo $current_tab === $tab_slug ? 'nav-tab-active' : ''; ?>">
                        <?php echo esc_html($tab_name); ?>
                    </a>
                <?php endforeach; ?>
            </h2>
            <?php echo $this->General_Settings($current_tab); ?>
        </div>
        <?php
        echo ob_get_clean();
    }

    public function theme_settings_enqueue_scripts($hook)
    {
        if ($hook !== 'toplevel_page_theme-settings') {
            return;
        }

        wp_enqueue_style(
            'theme-settings',
            get_template_directory_uri() . '/_inc/meta-box/css/style.css',
            [],
            '1.0.1',
            'all'
        );

        wp_enqueue_style(
            'wp-color-picker'
        );

        wp_enqueue_media();
        wp_enqueue_script(
            'theme-admin-js',
            get_template_directory_uri() . '/_inc/meta-box/js/admin.js',
            ['jquery', 'wp-color-picker'],
            '1.0.1',
            true
        );

        wp_localize_script(
            'theme-admin-js',
            'cyberisho_vars',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('cyberisho_nonce'),
            ]
        );
    }

    public function save_theme_settings()
    {
        if (!isset($_POST['submit']) || !isset($_POST['cyberisho_nonce']) || !wp_verify_nonce($_POST['cyberisho_nonce'], 'cyberisho_save_settings')) {
            return;
        }

        $current_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'footer-content';
        $theme_options = get_option('cyberisho_main_option', []);
        $all_settings = $this->All_Settings();
        $settings = $all_settings[$current_tab]['settings'];

        $new_options = [];
        foreach ($settings as $id => $setting) {
            if (isset($_POST[$id])) {
                $value = $this->sanitize_field($setting['type'], $_POST[$id]);
                $new_options[$id] = $value;
            }
        }

        $theme_options[$current_tab] = $new_options;
        update_option('cyberisho_main_option', $theme_options);

        add_settings_error(
            'cyberisho_messages',
            'settings_updated',
            __('تنظیمات با موفقیت ذخیره شد.', 'textdomain'),
            'success'
        );
    }

    private function sanitize_field($type, $value)
    {
        switch ($type) {
            case 'text':
                return sanitize_text_field($value);
            case 'url':
                return esc_url_raw($value);
            case 'textarea':
                return sanitize_textarea_field($value);
            case 'checkbox':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'select':
                return sanitize_text_field($value);
            case 'select2':
                return is_array($value) ? array_map('sanitize_text_field', $value) : sanitize_text_field($value);
            case 'color':
                return sanitize_hex_color($value);
            case 'repeater':
                $sanitized = [];
                if (is_array($value)) {
                    foreach ($value as $index => $repeater_item) {
                        foreach ($repeater_item as $key => $item_value) {
                            $sanitized[$index][$key] = $this->sanitize_field_by_key($key, $item_value);
                        }
                    }
                }
                return $sanitized;
            case 'image-uploader':
            case 'gallery-uploader':
                return esc_url_raw($value);
            case 'editor':
                return wp_kses_post($value);
            default:
                return sanitize_text_field($value);
        }
    }

    private function sanitize_field_by_key($key, $value)
    {
        if (strpos($key, 'image') !== false || strpos($key, 'url') !== false) {
            return esc_url_raw($value);
        } elseif (strpos($key, 'content') !== false || strpos($key, 'description') !== false || strpos($key, 'header') !== false) {
            return sanitize_textarea_field($value);
        } else {
            return sanitize_text_field($value);
        }
    }
}

new Main_Settings();

// حذف تابع تکراری cyberisho_enqueue_admin_scripts
// add_action('admin_enqueue_scripts', 'cyberisho_enqueue_admin_scripts'); // این خط حذف شد

// ثبت تنظیمات Customizer
function cyberisho_customize_register($wp_customize)
{
    // بخش فوتر
    $wp_customize->add_section('footer_settings', [
        'title' => __('تنظیمات فوتر', 'cyberisho'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('footer_icon_1_image', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_icon_1_image', [
        'label' => __('تصویر آیکون ۱', 'cyberisho'),
        'section' => 'footer_settings',
        'settings' => 'footer_icon_1_image',
    ]));

    $wp_customize->add_setting('footer_icon_2_image', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_icon_2_image', [
        'label' => __('تصویر آیکون ۲', 'cyberisho'),
        'section' => 'footer_settings',
        'settings' => 'footer_icon_2_image',
    ]));

    $wp_customize->add_setting('footer_text', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('footer_text', [
        'label' => __('متن فوتر', 'cyberisho'),
        'section' => 'footer_settings',
        'type' => 'textarea',
    ]);

    // بخش اطلاعات سایت
    $wp_customize->add_section('site_info', [
        'title' => __('اطلاعات سایت', 'cyberisho'),
        'priority' => 31,
    ]);

    $wp_customize->add_setting('site_logo', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'site_logo', [
        'label' => __('لوگوی سایت', 'cyberisho'),
        'section' => 'site_info',
        'settings' => 'site_logo',
    ]));

    // بخش صفحه لندینگ
    $wp_customize->add_section('landing_page', [
        'title' => __('صفحه لندینگ', 'cyberisho'),
        'priority' => 32,
    ]);

    $wp_customize->add_setting('landing_banner_image', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'landing_banner_image', [
        'label' => __('تصویر بنر لندینگ', 'cyberisho'),
        'section' => 'landing_page',
        'settings' => 'landing_banner_image',
    ]));

    // بخش نمونه‌کارها
    $wp_customize->add_section('portfolio_settings', [
        'title' => __('نمونه‌کارها', 'cyberisho'),
        'priority' => 33,
    ]);

    $wp_customize->add_setting('portfolio_items', [
        'default' => '',
        'sanitize_callback' => 'cyberisho_sanitize_repeater',
    ]);
    $wp_customize->add_control('portfolio_items', [
        'label' => __('نمونه‌کارها', 'cyberisho'),
        'section' => 'portfolio_settings',
        'type' => 'textarea',
    ]);

    function cyberisho_customize_register($wp_customize)
    {
        // ... (بخش‌های دیگر بدون تغییر باقی می‌مانند)

        // بخش درباره ما
        $wp_customize->add_section('about_us', [
            'title' => __('درباره ما', 'cyberisho'),
            'priority' => 34,
        ]);

        $wp_customize->add_setting('about_us_image', [
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'about_us_image', [
            'label' => __('تصویر درباره ما', 'cyberisho'),
            'section' => 'about_us',
            'settings' => 'about_us_image',
        ]));

        $wp_customize->add_setting('about_chart_header', [
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        ]);
        $wp_customize->add_control('about_chart_header', [
            'label' => __('درباره نمودار هدر', 'cyberisho'),
            'section' => 'about_us',
            'type' => 'textarea',
        ]);

        $wp_customize->add_setting('about_chart_right_container', [
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        ]);


        $wp_customize->add_setting('about_chart_footer', [
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        ]);
        $wp_customize->add_control('about_chart_footer', [
            'label' => __('درباره نمودار فوتر', 'cyberisho'),
            'section' => 'about_us',
            'type' => 'textarea',
        ]);

        $wp_customize->add_setting('chart_items_data', [
            'default' => '',
            'sanitize_callback' => 'cyberisho_sanitize_repeater',
        ]);
        $wp_customize->add_control('chart_items_data', [
            'label' => __('آیتم‌های نمودار', 'cyberisho'),
            'section' => 'about_us',
            'type' => 'textarea',
        ]);
    }
    // بخش برندها
    $wp_customize->add_section('brands', [
        'title' => __('برندها', 'cyberisho'),
        'priority' => 35,
    ]);

    $wp_customize->add_setting('brands_items', [
        'default' => '',
        'sanitize_callback' => 'cyberisho_sanitize_repeater',
    ]);
    $wp_customize->add_control('brands_items', [
        'label' => __('برندها', 'cyberisho'),
        'section' => 'brands',
        'type' => 'textarea',
    ]);

    // بخش سوالات
    $wp_customize->add_section('faq', [
        'title' => __('سوالات متداول', 'cyberisho'),
        'priority' => 36,
    ]);

    $wp_customize->add_setting('faq_items', [
        'default' => '',
        'sanitize_callback' => 'cyberisho_sanitize_repeater',
    ]);
    $wp_customize->add_control('faq_items', [
        'label' => __('سوالات متداول', 'cyberisho'),
        'section' => 'faq',
        'type' => 'textarea',
    ]);

    // بخش آیتم‌های نمودار
    $wp_customize->add_section('chart_items', [
        'title' => __('آیتم‌های نمودار', 'cyberisho'),
        'priority' => 37,
    ]);

    $wp_customize->add_setting('chart_items_data', [
        'default' => '',
        'sanitize_callback' => 'cyberisho_sanitize_repeater',
    ]);
    $wp_customize->add_control('chart_items_data', [
        'label' => __('آیتم‌های نمودار', 'cyberisho'),
        'section' => 'chart_items',
        'type' => 'textarea',
    ]);

    // بخش انواع سایت
    $wp_customize->add_section('site_types', [
        'title' => __('انواع سایت', 'cyberisho'),
        'priority' => 38,
    ]);

    $wp_customize->add_setting('site_types_items', [
        'default' => '',
        'sanitize_callback' => 'cyberisho_sanitize_repeater',
    ]);
    $wp_customize->add_control('site_types_items', [
        'label' => __('انواع سایت', 'cyberisho'),
        'section' => 'site_types',
        'type' => 'textarea',
    ]);
}
add_action('customize_register', 'cyberisho_customize_register');

function cyberisho_sanitize_repeater($input)
{
    if (empty($input)) {
        return '';
    }

    $input = json_decode($input, true);
    $sanitized = [];
    if (is_array($input)) {
        foreach ($input as $item) {
            $sanitized[] = [
                'image' => isset($item['image']) ? esc_url_raw($item['image']) : '',
                'title' => isset($item['title']) ? sanitize_text_field($item['title']) : '',
                'description' => isset($item['description']) ? wp_kses_post($item['description']) : '',
            ];
        }
    }
    return json_encode($sanitized);
}
?>