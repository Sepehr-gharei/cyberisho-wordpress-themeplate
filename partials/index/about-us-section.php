<!--************************* start about us *************************-->
<div class="about-us-section">
    <div class="container">
        <div class="row">
            <div id="videoContainer " class="video-container animated-section-right">
                <!-- ویدیو -->
                <?Php
                $about_page = get_page_by_path('about-us');
                $video_url = get_post_meta($about_page->ID, '_aboutus_video_url', true);
                $thumbnail_id = get_post_meta($about_page->ID, '_aboutus_video_thumbnail_id', true);
                $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
                ?>
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
            <div class="about-us-text-field animated-section-left">
                <h2>درباره ما</h2>
                <p>
                    <?php
                    $theme_options = get_option('cyberisho_main_option', []);
                    $home_options = $theme_options['home'];
                    $meta_content = $home_options['home_about_text'];
                    $limited_content = mb_substr($meta_content, 0, 485, 'UTF-8'); // برش با پشتیبانی از UTF-8
                    echo $limited_content;
                    ?>

                </p>
                <div class="about-us-redirect">
                    <a href="">درباره ما</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--************************* end about us *************************-->