<!--************************* start about us *************************-->
<?php
$theme_options = get_option('cyberisho_main_option', []);
$home_options = $theme_options['home'];

?>
<section class="home-about-us-section">
    <div class="container home-about-us-container">
        <div class="image-wrapper">
            <div class="main-image">
                <img src=" <?php
            echo $home_options['home_about_side_image'];
            ?> " alt="" />
            </div>
        </div>
        <div class="text-wrapper">
            <div class="title">
                <p>درباره ما</p>
            </div>
            <div class="text-field">
                <p>
                    <?php

                    $meta_content = $home_options['home_about_text'];
                    $limited_content = mb_substr($meta_content, 0, 485, 'UTF-8'); // برش با پشتیبانی از UTF-8
                    echo $limited_content;
                    ?>
                </p>
            </div>
            <a class="main-btn-get-blue" href=" <?php
            $page = get_page_by_path('about-us');
            if ($page) {
                $about_url = get_permalink($page->ID);
                echo $about_url;
            }
            ?>">درباره ما</a>
        </div>
    </div>
</section>
<!--************************* end about us *************************-->