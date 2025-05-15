
<?php
function remove_editor_from_post() {
    // فقط برای برگه‌ها
    if (isset($_GET['post']) && get_post_type($_GET['post']) === 'post' || isset($_GET['post_type']) && $_GET['post_type'] === 'post') {
        // حذف ویرایشگر پیش‌فرض
        remove_post_type_support('post', 'editor');
    }
}
add_action('admin_init', 'remove_editor_from_post');
// افزودن متاباکس به پست تایپ post
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
    $sections = get_post_meta($post->ID, '_post_sections', true);
    if (!is_array($sections)) {
        $sections = [];
    }
    ?>
    <div class="post-metabox">
        <!-- مقدمه -->
        <div class="post-section">
            <label for="post_intro"><strong>مقدمه</strong></label><br>
            <textarea id="post_intro" name="post_intro" rows="5" style="width:100%;"><?php echo esc_textarea($intro); ?></textarea>
        </div>

        <!-- کانتینرهای محتوا -->
        <div id="post-sections-container">
            <?php
            foreach ($sections as $index => $section) {
                $header_type = esc_attr($section['header_type']);
                $header_content = esc_textarea($section['header_content']);
                $paragraphs = isset($section['paragraphs']) ? $section['paragraphs'] : [];
                ?>
                <div class="post-section-container" data-index="<?php echo $index; ?>">
                    <div class="post-section-header">
                        <strong><?php echo $header_type; ?></strong>
                        <button type="button" class="button post-remove-section">حذف بخش</button>
                    </div>
                    <div class="post-section-content">
                        <label for="post_section_<?php echo $index; ?>_header">هدر (<?php echo $header_type; ?>)</label><br>
                        <textarea id="post_section_<?php echo $index; ?>_header" name="post_sections[<?php echo $index; ?>][header_content]" rows="3" style="width:100%;"><?php echo $header_content; ?></textarea>
                        <input type="hidden" name="post_sections[<?php echo $index; ?>][header_type]" value="<?php echo $header_type; ?>">
                        
                        <!-- پاراگراف‌ها -->
                        <div class="post-paragraphs-container">
                            <?php
                            foreach ($paragraphs as $p_index => $paragraph) {
                                ?>
                                <div class="post-paragraph">
                                    <label for="post_section_<?php echo $index; ?>_paragraph_<?php echo $p_index; ?>">محتوا (p)</label><br>
                                    <textarea id="post_section_<?php echo $index; ?>_paragraph_<?php echo $p_index; ?>" name="post_sections[<?php echo $index; ?>][paragraphs][<?php echo $p_index; ?>]" rows="4" style="width:100%;"><?php echo esc_textarea($paragraph); ?></textarea>
                                    <button type="button" class="button post-remove-paragraph">حذف پاراگراف</button>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <button type="button" class="button post-add-paragraph">افزودن محتوا (p)</button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <!-- دکمه‌های افزودن بخش جدید -->
        <div class="post-add-section-buttons">
            <button type="button" class="button post-add-section" data-header-type="h2">محتوا همراه با h2</button>
            <button type="button" class="button post-add-section" data-header-type="h3">محتوا همراه با h3</button>
            <button type="button" class="button post-add-section" data-header-type="h4">محتوا همراه با h4</button>
        </div>
    </div>

    <style>
        .post-metabox { padding: 10px; }
        .post-section { margin-bottom: 20px; }
        .post-section-container { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; background: #f9f9f9; }
        .post-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .post-section-content { margin-bottom: 10px; }
        .post-paragraph { margin-bottom: 10px; }
        .post-add-section-buttons { margin-top: 20px; }
        .post-add-section-buttons button { margin-right: 10px; }
        .post-remove-section, .post-remove-paragraph { background: #d63638; color: #fff; border-color: #d63638; }
        .post-remove-section:hover, .post-remove-paragraph:hover { background: #b32d2e; border-color: #b32d2e; }
    </style>

    <script>
        jQuery(document).ready(function($) {
            let sectionIndex = <?php echo count($sections); ?>;

            // افزودن بخش جدید
            $('.post-add-section').on('click', function() {
                const headerType = $(this).data('header-type');
                const container = $('#post-sections-container');
                const newSection = `
                    <div class="post-section-container" data-index="${sectionIndex}">
                        <div class="post-section-header">
                            <strong>${headerType}</strong>
                            <button type="button" class="button post-remove-section">حذف بخش</button>
                        </div>
                        <div class="post-section-content">
                            <label for="post_section_${sectionIndex}_header">هدر (${headerType})</label><br>
                            <textarea id="post_section_${sectionIndex}_header" name="post_sections[${sectionIndex}][header_content]" rows="3" style="width:100%;"></textarea>
                            <input type="hidden" name="post_sections[${sectionIndex}][header_type]" value="${headerType}">
                            <div class="post-paragraphs-container">
                                <div class="post-paragraph">
                                    <label for="post_section_${sectionIndex}_paragraph_0">محتوا (p)</label><br>
                                    <textarea id="post_section_${sectionIndex}_paragraph_0" name="post_sections[${sectionIndex}][paragraphs][0]" rows="4" style="width:100%;"></textarea>
                                    <button type="button" class="button post-remove-paragraph">حذف پاراگراف</button>
                                </div>
                            </div>
                            <button type="button" class="button post-add-paragraph">افزودن محتوا (p)</button>
                        </div>
                    </div>
                `;
                container.append(newSection);
                sectionIndex++;
            });

            // افزودن پاراگراف جدید
            $(document).on('click', '.post-add-paragraph', function() {
                const sectionContainer = $(this).closest('.post-section-container');
                const sectionIndex = sectionContainer.data('index');
                const paragraphsContainer = sectionContainer.find('.post-paragraphs-container');
                const paragraphIndex = paragraphsContainer.find('.post-paragraph').length;
                const newParagraph = `
                    <div class="post-paragraph">
                        <label for="post_section_${sectionIndex}_paragraph_${paragraphIndex}">محتوا (p)</label><br>
                        <textarea id="post_section_${sectionIndex}_paragraph_${paragraphIndex}" name="post_sections[${sectionIndex}][paragraphs][${paragraphIndex}]" rows="4" style="width:100%;"></textarea>
                        <button type="button" class="button post-remove-paragraph">حذف پاراگراف</button>
                    </div>
                `;
                paragraphsContainer.append(newParagraph);
            });

            // حذف بخش
            $(document).on('click', '.post-remove-section', function() {
                $(this).closest('.post-section-container').remove();
            });

            // حذف پاراگراف
            $(document).on('click', '.post-remove-paragraph', function() {
                $(this).closest('.post-paragraph').remove();
            });
        });
    </script>
    <?php
}

// ذخیره داده‌های متاباکس
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
        update_post_meta($post_id, '_post_intro', sanitize_textarea_field($_POST['post_intro']));
    }

    // ذخیره بخش‌ها
    if (isset($_POST['post_sections'])) {
        $sections = [];
        foreach ($_POST['post_sections'] as $index => $section) {
            $sections[$index] = [
                'header_type' => sanitize_text_field($section['header_type']),
                'header_content' => sanitize_textarea_field($section['header_content']),
                'paragraphs' => isset($section['paragraphs']) ? array_map('sanitize_textarea_field', $section['paragraphs']) : [],
            ];
        }
        update_post_meta($post_id, '_post_sections', $sections);
    } else {
        delete_post_meta($post_id, '_post_sections');
    }
}
add_action('save_post', 'post_save_meta_box_data');
?>


<?php
// افزودن متاباکس به پست‌تایپ post
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

// رندر محتوای متاباکس
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

// ذخیره داده‌های متاباکس
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

// اطمینان از وجود jQuery
function faq_enqueue_scripts() {
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'faq_enqueue_scripts');
?>