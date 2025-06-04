<div class="portfolio-section animated-section">
  <div class="container portfolio-container">
    <div class="btn"><a href="<?php echo home_url() . '/portfolio' ?>">مشاهده تمام نمونه کار ها</a></div>
    <div class="text-loop animated-section">
      <div class="ticker-container">
        <div class="ticker-content" id="tickerContent">
          <?php
          get_template_part('loop/global/work-sample-text-loop', 'work-sample-text-loop');
          ?>
        </div>
        <div class="ticker-content" id="tickerContent">
          <?php
          get_template_part('loop/global/work-sample-text-loop', 'work-sample-text-loop');
          ?>
        </div>
      </div>
    </div>
  </div>
</div>