<?php
// حذف ویرایشگر پیش‌فرض برای پست‌ها
function remove_editor_from_post() {
    if (isset($_GET['post']) && get_post_type($_GET['post']) === 'post' || isset($_GET['post_type']) && $_GET['post_type'] === 'post') {
        remove_post_type_support('post', 'editor');
    }
}
add_action('admin_init', 'remove_editor_from_post');

// افزودن متاباکس برای محتوای وبلاگ
function post_add_meta_box() {
    add_meta_box(
        'post_content_meta_box',
        'محتوای این وبلاگ',
        'post_content_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'post_add_meta_box');

// callback برای نمایش محتوای متاباکس
function post_content_meta_box_callback($post) {
    wp_nonce_field('post_content_meta_box', 'post_content_meta_box_nonce');
    $intro = get_post_meta($post->ID, '_post_intro', true);
    $content = get_post_meta($post->ID, '_post_content', true);
    ?>
    <div class="post-metabox">
        <!-- مقدمه -->
        <div class="post-section">
            <label for="post_intro"><strong>مقدمه</strong></label><br>
            <?php
            wp_editor(
                wp_kses_post($intro),
                'post_intro',
                array(
                    'textarea_name' => 'post_intro',
                    'textarea_rows' => 5,
                    'media_buttons' => true,
                    'teeny' => false,
                    'quicktags' => true,
                )
            );
            ?>
        </div>

        <!-- محتوای اصلی -->
        <div class="post-section">
            <label for="post_content"><strong>محتوای اصلی</strong></label><br>
            <?php
            wp_editor(
                wp_kses_post($content),
                'post_content',
                array(
                    'textarea_name' => 'post_content',
                    'textarea_rows' => 10,
                    'media_buttons' => true,
                    'teeny' => false,
                    'quicktags' => true,
                )
            );
            ?>
        </div>
    </div>

    <style>
        .post-metabox { padding: 10px; }
        .post-section { margin-bottom: 20px; }
    </style>

    <script>
        jQuery(document).ready(function($) {
            // اطمینان از لود شدن Quicktags
            if (typeof QTags !== 'undefined') {
                // افزودن دکمه‌های Quicktags برای ویرایشگر مقدمه
                QTags.addButton('h2_tag', 'h2', '<h2>', '</h2>', '', 'درج تگ h2', 101, 'post_intro');
                QTags.addButton('h3_tag', 'h3', '<h3>', '</h3>', '', 'درج تگ h3', 102, 'post_intro');
                QTags.addButton('h4_tag', 'h4', '<h4>', '</h4>', '', 'درج تگ h4', 103, 'post_intro');
                QTags.addButton('p_tag', 'p', '<p>', '</p>', '', 'درج تگ p', 104, 'post_intro');
                QTags.addButton('div_tag', 'div', '<div class="normal-content-wrapper">', '</div>', '', 'درج تگ div با کلاس normal-content-wrapper', 105, 'post_intro');

                // افزودن دکمه‌های Quicktags برای ویرایشگر محتوای اصلی
                QTags.addButton('h2_tag_content', 'h2', '<h2>', '</h2>', '', 'درج تگ h2', 101, 'post_content');
                QTags.addButton('h3_tag_content', 'h3', '<h3>', '</h3>', '', 'درج تگ h3', 102, 'post_content');
                QTags.addButton('h4_tag_content', 'h4', '<h4>', '</h4>', '', 'درج تگ h4', 103, 'post_content');
                QTags.addButton('p_tag_content', 'p', '<p>', '</p>', '', 'درج تگ p', 104, 'post_content');
                QTags.addButton('div_tag_content', 'div', '<div class="normal-content-wrapper">', '</div>', '', 'درج تگ div با کلاس normal-content-wrapper', 105, 'post_content');
            }
        });
    </script>
    <?php
}

// ذخیره داده‌های متاباکس محتوای وبلاگ
function post_save_meta_box_data($post_id) {
    if (!isset($_POST['post_content_meta_box_nonce']) || !wp_verify_nonce($_POST['post_content_meta_box_nonce'], 'post_content_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // ذخیره مقدمه
    if (isset($_POST['post_intro'])) {
        update_post_meta($post_id, '_post_intro', wp_kses_post($_POST['post_intro']));
    } else {
        delete_post_meta($post_id, '_post_intro');
    }

    // ذخیره محتوای اصلی
    if (isset($_POST['post_content'])) {
        update_post_meta($post_id, '_post_content', wp_kses_post($_POST['post_content']));
    } else {
        delete_post_meta($post_id, '_post_content');
    }

    // حذف متای قدیمی _post_sections (برای اطمینان از پاکسازی داده‌های قدیمی)
    delete_post_meta($post_id, '_post_sections');
}
add_action('save_post', 'post_save_meta_box_data');

// افزودن متاباکس سوالات متداول
function faq_metabox_add() {
    add_meta_box(
        'faq_metabox',
        'سوالات متداول',
        'faq_metabox_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'faq_metabox_add');

// رندر محتوای متاباکس سوالات متداول
function faq_metabox_callback($post) {
    wp_nonce_field('faq_metabox_nonce', 'faq_metabox_nonce_field');
    $faqs = get_post_meta($post->ID, '_faq_data', true);
    $faqs = is_array($faqs) ? $faqs : [];
    ?>
    <div id="faq-container">
        <?php foreach ($faqs as $index => $faq) : ?>
            <div class="faq-item" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <h4>سوال <?php echo $index + 1; ?></h4>
                <p>
                    <label for="faq_title_<?php echo $index; ?>">عنوان سوال:</label><br>
                    <input type="text" name="faqs[<?php echo $index; ?>][title]" id="faq_title_<?php echo $index; ?>" value="<?php echo esc_attr($faq['title']); ?>" style="width: 100%;" />
                </p>
                <p>
                    <label for="faq_content_<?php echo $index; ?>">محتوای سوال:</label><br>
                    <textarea name="faqs[<?php echo $index; ?>][content]" id="faq_content_<?php echo $index; ?>" rows="4" style="width: 100%;"><?php echo esc_textarea($faq['content']); ?></textarea>
                </p>
                <button type="button" class="button remove-faq" style="background: #d63638; color: #fff;">حذف سوال</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-faq" class="button button-primary">افزودن سوال جدید</button>

    <script>
        jQuery(document).ready(function($) {
            let faqIndex = <?php echo count($faqs); ?>;
            // افزودن سوال جدید
            $('#add-faq').on('click', function() {
                const faqHtml = `
                    <div class="faq-item" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <h4>سوال ${faqIndex + 1}</h4>
                        <p>
                            <label for="faq_title_${faqIndex}">عنوان سوال:</label><br>
                            <input type="text" name="faqs[${faqIndex}][title]" id="faq_title_${faqIndex}" style="width: 100%;" />
                        </p>
                        <p>
                            <label for="faq_content_${faqIndex}">محتوای سوال:</label><br>
                            <textarea name="faqs[${faqIndex}][content]" id="faq_content_${faqIndex}" rows="4" style="width: 100%;"></textarea>
                        </p>
                        <button type="button" class="button remove-faq" style="background: #d63638; color: #fff;">حذف سوال</button>
                    </div>`;
                $('#faq-container').append(faqHtml);
                faqIndex++;
            });
            // حذف سوال
            $(document).on('click', '.remove-faq', function() {
                $(this).closest('.faq-item').remove();
            });
        });
    </script>
    <?php
}

// ذخیره داده‌های متاباکس سوالات متداول
function faq_metabox_save($post_id) {
    if (!isset($_POST['faq_metabox_nonce_field']) || !wp_verify_nonce($_POST['faq_metabox_nonce_field'], 'faq_metabox_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $faqs = isset($_POST['faqs']) && is_array($_POST['faqs']) ? $_POST['faqs'] : [];
    $sanitized_faqs = [];
    foreach ($faqs as $faq) {
        $sanitized_faqs[] = [
            'title' => sanitize_text_field($faq['title']),
            'content' => sanitize_textarea_field($faq['content']),
        ];
    }
    update_post_meta($post_id, '_faq_data', $sanitized_faqs);
}
add_action('save_post', 'faq_metabox_save');

// افزودن متاباکس نام انگلیسی
function add_english_name_meta_box() {
    add_meta_box(
        'english_name_meta_box',
        'نام انگلیسی',
        'render_english_name_meta_box',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_english_name_meta_box');

// نمایش فیلد نام انگلیسی
function render_english_name_meta_box($post) {
    wp_nonce_field('english_name_meta_box', 'english_name_nonce');
    $value = get_post_meta($post->ID, '_english_name_value_key', true);
    ?>
    <label for="english_name_field">نام انگلیسی:</label>
    <input type="text" id="english_name_field" name="english_name_field" value="<?php echo esc_attr($value); ?>" class="widefat" />
    <?php
}

// ذخیره داده‌های نام انگلیسی
function save_english_name_meta_box_data($post_id) {
    if (!isset($_POST['english_name_nonce']) || !wp_verify_nonce($_POST['english_name_nonce'], 'english_name_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['english_name_field'])) {
        $sanitized_value = sanitize_text_field($_POST['english_name_field']);
        update_post_meta($post_id, '_english_name_value_key', $sanitized_value);
    }
}
add_action('save_post', 'save_english_name_meta_box_data');

// لود اسکریپت‌های مورد نیاز
function post_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_editor();
    wp_enqueue_script('wp-tinymce');
    wp_enqueue_script('quicktags');
}
add_action('admin_enqueue_scripts', 'post_enqueue_scripts');

// تابع برای استخراج سرتیترها و ایجاد فهرست مطالب
function generate_table_of_contents($content) {
    if (empty($content)) {
        return '';
    }

    // استفاده از DOMDocument برای تجزیه HTML
    $doc = new DOMDocument();
    // تنظیم برای پشتیبانی از UTF-8
    @$doc->loadHTML('<?xml encoding="UTF-8">' . $content); // @ برای سرکوب هشدارهای HTML نامعتبر
    $headings = $doc->getElementsByTagName('*');
    $toc = [];
    $index = 0;

    // استخراج تمام تگ‌های h (h2, h3, h4, h5, h6)
    foreach ($headings as $heading) {
        if (preg_match('/^h[2-6]$/i', $heading->tagName)) {
            $text = trim($heading->textContent);
            if (!empty($text)) {
                // ایجاد یک ID منحصربه‌فرد برای سرتیتر
                $id = 'heading-' . $index;
                // افزودن ID به تگ سرتیتر در محتوا
                $heading->setAttribute('id', $id);
                $toc[] = [
                    'tag' => $heading->tagName,
                    'text' => $text,
                    'id' => $id,
                ];
                $index++;
            }
        }
    }

    // اگر هیچ سرتیتری یافت نشد، خالی برگردان
    if (empty($toc)) {
        return '';
    }

    // ایجاد HTML فهرست مطالب
    $output = '<div class="list-content-wrapper normal-content-wrapper">';
    $output .= '<h5>فهرست مطالب</h5>';
    $output .= '<ul>';
    foreach ($toc as $item) {
        $output .= '<li><a href="#' . esc_attr($item['id']) . '">' . esc_html($item['text']) . '</a></li>';
    }
    $output .= '</ul>';
    $output .= '</div>';

    // به‌روزرسانی محتوای اصلی با IDهای اضافه‌شده
    $content = $doc->saveHTML($doc->getElementsByTagName('body')->item(0));
    // حذف تگ‌های body اضافی
    $content = preg_replace('/<body[^>]*>|<\/body>/i', '', $content);

    return [
        'toc' => $output,
        'content' => $content,
    ];
}
?>