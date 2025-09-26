<?php
// Get process steps and audio URL from post meta
$process_steps = get_post_meta(get_the_ID(), '_landing_process_steps', true);
$process_steps_data = !empty($process_steps) ? json_decode($process_steps, true) : array_fill(0, 4, '');
$process_audio_url = get_post_meta(get_the_ID(), '_landing_process_audio_url', true);
?>
<section class="implementation-steps-section landing-item-section">
  <div class="implementation-steps-container container">
    <div class="title-wrapper">
      <h3>فرآیند و مراحل اجرا</h3>
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
            <audio src="<?php echo esc_url($process_audio_url ?: './central.mp3'); ?>" preload="none"></audio>
          </div>
        </div>
      </div>
    </div>
    <div class="main-content">
      <div class="dot-wrapper">
        <p>
          &#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;
        </p>
      </div>
      <div class="arrow-item arrow-one">
        <svg  width="9px" height="14px">
          <image x="0px" y="0px" width="9px" height="14px"
            xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAOCAQAAABXnf4jAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfpCQYQOBTEhxaxAAAAT0lEQVQY063PsQnAMBBD0Q9pMs5tFI+UETxJqgx0lcGV3LiQDelynR4CceB3E0umIpI4DC7gpHtDiPoJzw7vDtAQovt8TMwV8w8s/mOQFBja4TDS7tbBzwAAAABJRU5ErkJggg==" />
        </svg>
      </div>
      <div class="arrow-item arrow-two">
        <svg width="9px" height="14px">
          <image x="0px" y="0px" width="9px" height="14px"
            xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAOCAQAAABXnf4jAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfpCQYQOBTEhxaxAAAAT0lEQVQY063PsQnAMBBD0Q9pMs5tFI+UETxJqgx0lcGV3LiQDelynR4CceB3E0umIpI4DC7gpHtDiPoJzw7vDtAQovt8TMwV8w8s/mOQFBja4TDS7tbBzwAAAABJRU5ErkJggg==" />
        </svg>
      </div>
      <?php for ($i = 0; $i < 4; $i++): ?>
        <div class="item-implementation">
          <div class="number"><?php echo $i + 1; ?></div>
          <div class="text-field">
            <p><?php echo esc_html($process_steps_data[$i] ?? ''); ?></p>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>