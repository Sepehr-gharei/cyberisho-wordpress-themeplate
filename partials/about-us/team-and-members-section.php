<div class="team-and-members-section">
    <div class="container team-and-members-container">
        <div class="image-wrapper">
            <?php
            // در فایل قالب صفحه (مثل page-about-us.php)
            global $post;

            if ($post && $post->post_name === 'about-us') {
                $image_id = get_post_meta($post->ID, '_aboutus_info_image_id', true);
                if ($image_id) {
                    $image_url = wp_get_attachment_url($image_id);
                    if ($image_url) {
                        echo '<img src="' . esc_url($image_url) . '" alt="عکس کانتینر اطلاعات بیشتر" />';
                    } else {
                        echo '<p>تصویری یافت نشد.</p>';
                    }
                } else {
                    echo '<p>تصویری برای نمایش انتخاب نشده است.</p>';
                }
            }
            ?>
        </div>
        <div class="text-wrapper">
            <div class="top-text">
                <p>
                    <?php
                    $theme_options = get_option('cyberisho_main_option', []);
                    $site_info_options = $theme_options['site-info'];
                    $banner_header = $site_info_options['banner_header'];
                    $banner_content = $site_info_options['banner_content'];
                    if (!empty($banner_header) || !empty($banner_content)) {
                        ?>
                        <strong> <?php echo wp_kses_post($banner_header); ?></strong>
                        <?php echo wp_kses_post($banner_content); ?>
                        <?php
                    }
                    ?>
                </p>
            </div>
            <?php
            $team_total = $site_info_options['team_total'];
            $team_1 = $site_info_options['team_item_1'];
            $team_2 = $site_info_options['team_item_2'];
            $team_3 = $site_info_options['team_item_3'];
            $team_4 = $site_info_options['team_item_4'];
            ?>
            <div class="blue-section">
                <p><?php if (!empty($team_total)) {
                    echo wp_kses_post($team_total);
                } ?></p>
            </div>
            <div class="members-items">
                <div class="item">
                    <span><?php mb_internal_encoding("UTF-8");
                    echo preg_replace('/[^\p{N}]/u', '', $team_1); ?></span>
                    <p><?php mb_internal_encoding("UTF-8");
                    echo preg_replace('/[^\p{L}\s]/u', '', $team_1); ?> </p>
                </div>
                <div class="item">
                    <span><?php mb_internal_encoding("UTF-8");
                    echo preg_replace('/[^\p{N}]/u', '', $team_2); ?></span>
                    <p><?php mb_internal_encoding("UTF-8");
                    echo preg_replace('/[^\p{L}\s]/u', '', $team_2); ?> </p>
                </div>
                <div class="item">
                    <span><?php mb_internal_encoding("UTF-8");
                    echo preg_replace('/[^\p{N}]/u', '', $team_3); ?></span>
                    <p><?php mb_internal_encoding("UTF-8");
                    echo preg_replace('/[^\p{L}\s]/u', '', $team_3); ?> </p>
                </div>
                <div class="item">
                    <span><?php mb_internal_encoding("UTF-8");
                    echo preg_replace('/[^\p{N}]/u', '', $team_4); ?></span>
                    <p><?php mb_internal_encoding("UTF-8");
                    echo preg_replace('/[^\p{L}\s]/u', '', $team_4); ?> </p>
                </div>
            </div>
        </div>
    </div>
</div>