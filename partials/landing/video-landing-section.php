<!--************************* start video landing section  *************************-->
<div class="video-landing-section">
  <div class="container">
    <div class="row">
      <div class="right-info animated-section-right">
        <?php
        // Start the loop.
        if (have_posts()):
          while (have_posts()):
            the_post();

            // Get meta data
            $video_id = get_post_meta(get_the_ID(), '_landing_video_attachment_id', true);
            $thumbnail_id = get_post_meta(get_the_ID(), '_landing_thumbnail_attachment_id', true);
            $container_1 = get_post_meta(get_the_ID(), '_landing_container_1', true);
            $container_2 = get_post_meta(get_the_ID(), '_landing_container_2', true);
            $container_3 = get_post_meta(get_the_ID(), '_landing_container_3', true);
            $container_4 = get_post_meta(get_the_ID(), '_landing_container_4', true);

            // Get URLs
            $video_url = $video_id ? wp_get_attachment_url($video_id) : '';
            $thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'large') : '';
             ?>

            <?php

          endwhile;
        endif;
        ?>
        <div class="item">
          <span>
            <p>1</p>
          </span>
          <p class="text"><?php echo  $container_1 ?></p>
        </div>
        <div class="item">
          <span>
            <p>2</p>
          </span>
          <p class="text"><?php echo  $container_2 ?></p>
        </div>
      </div>
      <div class="video-wrapper animated-section">
        <div id="videoContainer" class="video-container">
          <video id="myVideo" class="video" src="<?php echo    $video_url  ?>"
            poster="<?php echo    $thumbnail_url ?>">
            <source src="mov_bbb.mp4" type="video/mp4" />
            <source src="mov_bbb.ogg" type="video/ogg" />
            Your browser does not support HTML video.
          </video>
          <div id="videoOverlay" class="video-overlay"></div>
          <!-- المان جدید برای پوشش -->
          <div id="playButton" class="play-button">
            <svg>
              <use href="#play-button-icon"></use>
            </svg>
          </div>
          <div class="text-video" id="landing-video-text">
            <h3>برای یک انتخـــــــــاب درست</h3>
            <p>ویدئوی بالا بهترین مشاوره برای شماست!</p>
          </div>
        </div>
      </div>
      <div class="left-info animated-section-left">
        <div class="item">
          <span>
            <p>3</p>
          </span>
          <p class="text"><?php echo  $container_3 ?></p>
        </div>
        <div class="item">
          <span>
            <p>4</p>
          </span>
          <p class="text"><?php echo  $container_4 ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!--************************* end video landing section  *************************-->