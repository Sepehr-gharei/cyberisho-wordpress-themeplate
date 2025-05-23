<!--************************* start banner container*************************-->
<div class="col-8 banner-container container animated-section">

  <?php
  $theme_options = get_option('cyberisho_main_option', [] );
  $site_info_options = $theme_options['site-info'];
  
  $banner_header =  $site_info_options['banner_header'];
  $banner_content = $site_info_options['banner_content'];
  if (!empty($banner_header) || !empty($banner_content)) {
    ?>
    <h2><?php echo wp_kses_post($banner_header); ?></h2>
    <h4><?php echo wp_kses_post($banner_content); ?></h4>
    <?php
  }
  ?>
</div>
<!--************************* end banner container*************************-->