    <!--************************* start video landing section  *************************-->
    <div class="video-landing-section">
      <div class="container">
        <div class="row">
          <div class="right-info animated-section-right">
            <div class="item">
              <span><p>1</p></span>
              <p class="text">کنسـل کنید و بیخیال حـوزه سـایت شوید!</p>
            </div>
            <div class="item">
              <span><p>2</p></span>
              <p class="text">کســی را به ما برای یادگیـری معـرفی کنیـد</p>
            </div>
          </div>
          <div class="video-wrapper animated-section">
            <div id="videoContainer" class="video-container">
              <video
                id="myVideo"
                class="video"
                src="<?php echo get_template_directory_uri() . '/assets/video/115_1.mp4'?>"
                poster="<?php echo get_template_directory_uri() . '/assets/img/bryan-cranston-aaron-paul-breaking-bad_11zon-min.jpg' ?>"
              >
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
              <span><p>3</p></span>
              <p class="text">به مـــا جهـت ارائـه خدمـات اعتمــاد کنیـد</p>
            </div>
            <div class="item">
              <span><p>4</p></span>
              <p class="text">رقبای کاربلــد را ما به شــــما معـرفی کنیم</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--************************* end video landing section  *************************-->