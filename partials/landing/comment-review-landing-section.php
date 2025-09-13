<section class="comment-review-landing-section landing-item-section">
  <div class="comment-review-landing-container">
    <div class="purple-ball-icon item-one ease-icon-animation-low">
      <div class="inside">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
      </div>
    </div>
    <div class="purple-ball-icon item-two ease-icon-animation-low">
      <div class="inside">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
      </div>
    </div>
    <div class="purple-ball-icon item-three ease-icon-animation-low">
      <div class="inside">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
      </div>
    </div>
    <div class="right-text-side">
      <div class="title">
        <p>نظرات مشتریان</p>
      </div>
      <div class="text">
        <p>بازخوردهای برخی از کارفرمایان و مشتریان محترم ما</p>
      </div>
    </div>
    <div class="comment-review-swiper">
      <div class="swiper-wrapper">
      <?php get_template_part('loop/landing/comment-review-landing-section', 'comment-review-landing-section') ?>
      </div>
    </div>
  </div>
</section>