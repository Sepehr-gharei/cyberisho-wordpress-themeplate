  <!--************************* start more information container *************************-->
  <div class="more-information">
      <div class="container">
        <div class="row">
          <div
            id="videoContainer"
            class="video-container animated-section-right"
          >
          <?Php 
          $about_page = get_page_by_path('about-us');
          $video_url = get_post_meta($about_page->ID, '_aboutus_video_url', true);
          $thumbnail_id = get_post_meta($about_page->ID, '_aboutus_video_thumbnail_id', true);
          $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
          ?>
            <!-- ویدیو -->
            <video
              id="myVideo"
              class="video"
              src="<?php echo  $video_url ?>"
              poster="<?php echo $thumbnail_url ?>"
            >
              <source src="mov_bbb.mp4" type="video/mp4" />
              <source src="mov_bbb.ogg" type="video/ogg" />
              Your browser does not support HTML video.
            </video>
            <div id="viewContainer" class="view-container">
              <a href="">(ببینید)</a><small>|</small
              ><span>صادقانه برای یک انتخــــاب درست...</span>
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
                <img
                  src="<?php echo get_template_directory_uri() . '/assets/img/img-david-lynch-01-184117216071-750x1000.jpgPortrait-min.jpg'?>"
                  alt=""
                />
              </div>
              <div class="inf-container">
                <p>بـیـش از 2600 پـروژه</p>
                <p>از سال 1391 تا امروز</p>
              </div>
            </div>
          </div>
          <div class="left-side-information animated-section-left">
            <div class="d-flex wrapper">
              <div class="inf-top">
                <p>تیم 23 نفره شامل</p>

                <li>+ 7 برنامه نویس</li>
                <li>+ 5 گرافیست</li>
                <li>+ 4 پشتیبان</li>
                <li>+ 7 سئوکار</li>
              </div>
              <div class="inf-bottom">
                <div>
                  <svg>
                    <use href="#headphone-icon"></use>
                  </svg>
                </div>
                <div>
                  <p>021 880 68 221</p>
                  <p>0919 0730 3855</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--************************* end more information container *************************-->