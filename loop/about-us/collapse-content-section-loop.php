<?php
// گرفتن تمام بخش‌های ذخیره شده از متا باکس
$sections = get_post_meta(get_the_ID(), '_aboutus_info_sections', true);

if (!empty($sections) && is_array($sections)) :
    $index = 1; // شمارنده از 1 شروع می‌شود
    foreach ($sections as $section):
        // بررسی اینکه عنوان یا محتوا وجود داشته باشد
        if (!empty($section['title']) || !empty($section['content'])):
            ?>
            <?php if (!empty($section['content'])): ?>
                <div id="content-<?php echo $index; ?>" class="collapse-content<?php echo ($index === 1) ? ' active' : ''; ?>">
                    <p>
                        <?php echo wpautop(esc_html($section['content'])); ?>
                    </p>
                </div>
            <?php
            endif;
            $index++; // افزایش شمارنده
        endif;
    endforeach;
else :
    ?>
    <p>هیچ بخشی تعریف نشده است.</p>
<?php
endif;
?>