<?php
// Get pricing plans and audio URL from post meta
$pricing_plans = get_post_meta(get_the_ID(), '_landing_pricing_plans', true);
$pricing_plans_data = !empty($pricing_plans) ? json_decode($pricing_plans, true) : array_fill(0, 3, ['title' => '', 'features' => array_fill(0, 4, ''), 'footer' => '']);
$pricing_audio_url = get_post_meta(get_the_ID(), '_landing_pricing_audio_url', true);
?>
<section class="price-plans-section landing-item-section">
  <div class="price-plans-container container">
    <div class="title-wrapper">
      <h3>پلن‌های قیمتی ما</h3>
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
            <audio src="<?php echo esc_url($pricing_audio_url ?: './central.mp3'); ?>" preload="none"></audio>
          </div>
        </div>
      </div>
    </div>
    <div class="plans-item">
      <?php foreach ($pricing_plans_data as $plan): ?>
        <div class="item">
          <div class="title">
            <p><?php echo esc_html($plan['title'] ?? ''); ?></p>
          </div>
          <div class="text-field">
            <?php foreach ($plan['features'] as $feature): ?>
              <?php if (!empty($feature)): ?>
                <p><?php echo esc_html($feature); ?></p>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <div class="footer-text">
            <p><?php echo esc_html($plan['footer'] ?? ''); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="button">
      <a href="">مشاوره و ثبت سفارش</a>
    </div>
  </div>
</section>