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
            $theme_options = get_option('cyberisho_main_option', []);
            $site_info_options = $theme_options['site-info'];
            $contact_options = $theme_options['contact'];

            $project_count = $site_info_options['project_count'];
            $project_start_year = $site_info_options['project_start_year'];

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
            $team_total = $site_info_options ['team_total'];
            $team_1 = $site_info_options ['team_item_1'];
            $team_2 = $site_info_options ['team_item_2'];
            $team_3 = $site_info_options ['team_item_3'];
            $team_4 = $site_info_options ['team_item_4'];
            ?>

            <p><?php if(!empty($team_total)){echo wp_kses_post($team_total);}  ?> </p>

            <li>+ <?php if(!empty($team_1))echo wp_kses_post($team_1); ?>  </li>
            <li>+ <?php if(!empty($team_2))echo wp_kses_post($team_2); ?>
              </li>
            <li>+ <?php if(!empty($team_3))echo wp_kses_post($team_3); ?> </li>
            <li>+ <?php if(!empty($team_4)) echo wp_kses_post($team_4); ?></li>
          </div>
          <div class="inf-bottom">
            <div>
              <svg>
                <use href="#headphone-icon"></use>
              </svg>
            </div>
            <div>
              <p> <?php echo $contact_options['contact_hotline'];?></p>
              <p><?php echo $contact_options['contact_emergency'];?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--************************* end more information container *************************-->