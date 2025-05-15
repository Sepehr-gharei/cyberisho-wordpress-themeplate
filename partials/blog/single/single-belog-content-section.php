<!--************************* start  single belog contect section *************************-->
<div class="single-belog-content-section">
  <div class="container">
    <div class="content-container">




      <?php

      if (have_posts()):
        while (have_posts()):
          the_post();
          // دریافت داده‌های متاباکس
          $intro = get_post_meta(get_the_ID(), '_post_intro', true);
          $sections = get_post_meta(get_the_ID(), '_post_sections', true);
          if (!is_array($sections)) {
            $sections = [];
          }
          ?>

          <!-- نمایش مقدمه -->
          <?php if (!empty($intro)): ?>
            <div class="normal-content-wrapper">
              <h6>مقدمه</h6>
              <p>
                <?php echo wp_kses_post($intro); ?>
              </p>
            </div>
          <?php endif; ?>

          <div class="list-content-wrapper normal-content-wrapper">
            <h5>فهرست مطالب</h5>
            <ul>
              <li>سئو محتوایی چیست ؟</li>
              <li>مهمترین نکات در سئو چیست</li>
              <li>سئو محتوای متنی چیست</li>
              <li>سئوی تصاویر و متن جایگرین</li>
              <li>چگونه نمره ستو محتول را ارتقا دهیم ؟</li>
              <li>
                15 نکته در رابطه با ایجاد یک محتوای بهینه برای موتور های جستجو
              </li>
              <li>اشتباه رایج در سئو محتوایی</li>
              <li>جمع بندی</li>
            </ul>
          </div>


          <!-- نمایش بخش‌ها -->
          <?php foreach ($sections as $section):
            $header_type = esc_html($section['header_type']);
            $header_content = wp_kses_post($section['header_content']);
            $paragraphs = isset($section['paragraphs']) ? $section['paragraphs'] : [];
            ?>
            <div class="normal-content-wrapper">
              <<?php echo $header_type ?>><?php echo $header_content ?></<?php echo $header_type ?>>


              <?php foreach ($paragraphs as $paragraph): ?>
                <p><?php echo $paragraph ?></p>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>

          <?php
        endwhile;
      endif;

      ?>


    </div>
  </div>
</div>
<!--************************* end  single belog contect section *************************-->