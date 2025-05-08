<!--************************* start banner container*************************-->
<div class="col-8 banner-container container animated-section">

  <?php
  $banner_header = get_option('banner_header', '');
  $banner_content = get_option('banner_content', '');
  if (!empty($banner_header) || !empty($banner_content)) {
    ?>
    <h2><?php echo wp_kses_post($banner_header); ?></h2>
    <h4><?php echo wp_kses_post($banner_content); ?></h4>
    <?php
  }
  ?>
</div>
<!--************************* end banner container*************************-->