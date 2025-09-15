<!--************************* start header information *************************-->
<?php
$theme_options = get_option('cyberisho_main_option', []);
$home_options = $theme_options['home'];

?>
<section class="header-home-information-section">
    <div class="container header-home-information-container">
        <div class="text-wrapper">
            <h1 class="title"><?php
            echo $home_options['home_header_title'];
            ?></h1>
            <p>
                <?php
                echo $home_options['home_header_title_content'];
                ?>
            </p>
            <a href=" <?php
            $page = get_page_by_path('portfolio');
            if ($page) {
                $portfolio_url = get_permalink($page->ID);
                echo $portfolio_url;
            }
            ?>
        ">نمونه کارها</a>
        </div>
        <div class="image-wrapper">
            <div class="icons">
                <div class="purple-ball-icon item-one ease-icon-animation-low">
                    <div class="inside">
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
                    </div>
                </div>
                <div class="purple-ball-icon item-two ease-icon-animation-low">
                    <div class="inside">
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
                    </div>
                </div>
                <div class="purple-ball-icon item-three ease-icon-animation-low">
                    <div class="inside">
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
                    </div>
                </div>
            </div>
            <div class="main-image">
                <img src="<?php echo $home_options['home_header_image_content']; ?>" alt="" />
            </div>
            <div class="text-field">
                <p>
                    <?php
                    echo $home_options['home_header_side_text'];
                    ?>
                </p>
            </div>
        </div>
    </div>
</section>
<!--************************* end header information *************************-->