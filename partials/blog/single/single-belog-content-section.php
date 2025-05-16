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

          <?php
          $post_sections = get_post_meta(get_the_ID(), '_post_sections', true);
          if (!empty($post_sections) && is_array($post_sections)) {
            echo '<div class="list-content-wrapper normal-content-wrapper">';
            echo '<h5>فهرست مطالب</h5>';
            echo '<ul>';

            foreach ($post_sections as $section) {
              if (!empty($section['header_content'])) {
                echo '<li>' . esc_html($section['header_content']) . '</li>';
              }
            }

            echo '</ul>';
            echo '</div>';
          }
          ?>

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