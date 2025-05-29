<!--************************* start header information *************************-->
<?php
        $theme_options = get_option('cyberisho_main_option', []);
        $home_options = $theme_options['home'];

        ?>
<div class="header-information  animated-section">
  <div class="container header-information-container">
    <img class="city-bg" src="<?php echo get_template_directory_uri() . '/assets/img/city-bg.png' ?>" alt="" />
    <div class="wrapper">
      <div>
        <img src="<?php echo   $home_options['home_header_image_content']; ?>" alt="" />
      </div>
      <div class="text-field">
     
        <h2>
          <?php
          echo $home_options['home_header_title'];
          ?>
        </h2>
        <strong>
          <?php
          echo $home_options['home_header_title_content'];
          ?>
        </strong><a href="
        <?php
        $page = get_page_by_path('portfolio'); 
        if ($page) {
          $portfolio_url = get_permalink($page->ID);
          echo $portfolio_url; 
        } 
        ?>
        ">نمونه کارها</a>
      </div>
    </div>
  </div>
</div>
<!--************************* end header information *************************-->