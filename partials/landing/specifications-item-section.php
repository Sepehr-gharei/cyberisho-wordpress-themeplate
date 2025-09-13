<?php
$why_audio_url = get_post_meta(get_the_ID(), '_landing_why_audio_url', true);
$why_items = get_post_meta(get_the_ID(), '_landing_why_items', true);
$why_items_data = !empty($why_items) ? json_decode($why_items, true) : array();
?>
<section class="specifications-item-section landing-item-section">
  <div class="specifications-item-container container">
    <div class="title-wrapper">
      <h3>چرا طراحی سایت با سایبریشو ؟</h3>
      <div class="audio-wrapper">
        <div class="voice-field">
          <div class="player">
            <div class="border-frame"></div>
            <div class="progress-border"></div>
            <button>
              <p>توضیحات بیشتر</p>
              <!-- آیکون قبل از پخش -->
              <svg id="play-icon" viewBox="0 0 330 330">
                <path d="M37.728,328.12c2.266,1.256,4.77,1.88,7.272,1.88c2.763,0,5.522-0.763,7.95-2.28l240-149.999
                        c4.386-2.741,7.05-7.548,7.05-12.72c0-5.172-2.664-9.979-7.05-12.72L52.95,2.28c-4.625-2.891-10.453-3.043-15.222-0.4
                        C32.959,4.524,30,9.547,30,15v300C30,320.453,32.959,325.476,37.728,328.12z" fill="black"></path>
              </svg>
            </button>
            <?php if ($why_audio_url): ?>
              <audio src="<?php echo esc_url($why_audio_url); ?>" preload="none"></audio>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="main-items">
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
      <div class="purple-ball-icon item-three ease-icon-animation">
        <div class="inside">
          <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
        </div>
      </div>
      <?php if (!empty($why_items_data)): ?>
        <?php foreach ($why_items_data as $index => $item): ?>
          <div class="item">
            <div class="icon-wrapper">
              <?php
              // فرض بر این است که $item['svg'] حاوی کد SVG کامل یا path است. 
              // برای امنیت، از wp_kses_post استفاده کنید یا آن را escape کنید.
              echo wp_kses_post($item['svg']);
              ?>
            </div>
            <div class="text-wrapper">
              <div class="title">
                <p><?php echo esc_html($item['title']); ?></p>
              </div>
              <div class="contnet">
                <p><?php echo esc_html($item['text']); ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>