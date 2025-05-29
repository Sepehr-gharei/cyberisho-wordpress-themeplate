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
          $content = get_post_meta(get_the_ID(), '_post_content', true);
          if (!empty($content)) {
            $toc_data = generate_table_of_contents($content);
            $toc = $toc_data['toc'];
            $content = $toc_data['content'];
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
          if (!empty($toc)) {
            echo $toc; // فهرست مطالب
          }
          ?>
          <?php
          if (!empty($content)) {
            echo $content;
          }

        endwhile;
      endif;
      ?>
    </div>
  </div>
</div>
<!--************************* end  single belog contect section *************************-->