<!--************************* start more information container *************************-->
<div class="more-information">
  <div class="container">
    <div class="row">
      <div id="videoContainer" class="video-container animated-section-right">
        <?Php
        $about_page = get_page_by_path('about-us');
        $video_url = get_post_meta($about_page->ID, '_aboutus_video_url', true);
        $thumbnail_id = get_post_meta($about_page->ID, '_aboutus_video_thumbnail_id', true);
        $info_img_id = get_post_meta($about_page->ID, '_aboutus_info_image_id', true);
        $info_img_url = $thumbnail_id ? wp_get_attachment_url($info_img_id) : '';
        $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
        ?>
        <!-- ویدیو -->
        <video id="myVideo" class="video" src="<?php echo $video_url ?>" poster="<?php echo $thumbnail_url ?>">
          <source src="mov_bbb.mp4" type="video/mp4" />
          <source src="mov_bbb.ogg" type="video/ogg" />
          Your browser does not support HTML video.
        </video>
        <div id="viewContainer" class="view-container">
          <a href="">(ببینید)</a><small>|</small><span>صادقانه برای یک انتخــــاب درست...</span>
        </div>

        <!-- دکمه شروع ویدیو -->
        <div id="playButton" class="play-button">
          <svg>
            <use href="#play-button-icon"></use>
          </svg>
        </div>
      </div>

      <div class="right-side-information animated-section-left">
        <div class="d-flex wrapper">
          <div class="img-container">
            <img src="<?php echo $info_img_url ?>" alt="" />
          </div>
          <div class="inf-container">
            <?php
            $project_count = get_option('project_count', '');
            $project_start_year = get_option('project_start_year', '');

            if (!empty($project_count) || !empty($project_start_year)) {
              ?>
              <p><?php echo wp_kses_post($project_count); ?></p>
              <p><?php echo wp_kses_post($project_start_year); ?></p>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
      <div class="left-side-information animated-section-left">
        <div class="d-flex wrapper">
          <div class="inf-top">
            <?php
            $team_total = get_option('team_total', '');
            $team_developer = get_option('team_developer', '');
            $team_graphic = get_option('team_graphic', '');
            $team_support = get_option('team_support', '');
            $team_seo = get_option('team_seo', '');
            ?>

            <p>تیم <?php echo wp_kses_post($team_total); ?> نفره شامل</p>

            <li>+ <?php echo wp_kses_post($team_developer); ?> برنامه نویس</li>
            <li>+ <?php echo wp_kses_post($team_graphic); ?>
              گرافیست</li>
            <li>+ <?php echo wp_kses_post($team_support); ?> پشتیبان</li>
            <li>+ <?php echo wp_kses_post($team_seo); ?> سئوکار</li>
          </div>
          <div class="inf-bottom">
            <div>
              <svg>
                <use href="#headphone-icon"></use>
              </svg>
            </div>
            <div>
              <p> <?php echo get_option('contact_hotline', ''); ?></p>
              <p><?php echo get_option('contact_emergency', ''); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--************************* end more information container *************************-->