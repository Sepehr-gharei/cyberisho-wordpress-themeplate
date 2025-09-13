<section class="website-information-section">
    <div class="container website-information-container">
        <div class="purple-ball-icon item-one ease-icon-animation">
            <div class="inside">
                <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
            </div>
        </div>
        <div class="website-information-main-wrapper">
            <div class="text-container">
                <div class="text-content" id="textContent">
                    <?php
                    // Retrieve the content from the _landing_content_info meta field
                    $content_info = get_post_meta(get_the_ID(), '_landing_content_info', true);
                    if (!empty($content_info)) {
                        echo wp_kses_post($content_info);
                    } else {
                        echo '<p>محتوایی برای نمایش وجود ندارد.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <button class="toggle-btn" id="toggleBtn">مشاهده بیشتر</button>
    </div>
</section>