<!--************************* start chart container *************************-->
<div class="container-fluid chart-container animated-section">
  <div class="row">
    <div class="col-12 col-md-6 right-side">
      <?php
      $chart_title = get_option('about_chart_title', '');
      $chart_years = get_option('about_chart_years', '');
      $desktop_image = get_option('about_chart_desktop_image', '');
      $mobile_image = get_option('about_chart_mobile_image', '');
      ?>
      <p><?php echo wp_kses_post($chart_title); ?></p>
      <h3><?php echo wp_kses_post($chart_years); ?></h3>
    </div>
    <div class="col-12 col-md-6 left-side">
      <div class="chart-section">
        <svg id="myChart"></svg>
      </div>
    </div>
  </div>
</div>
<!--************************* end chart container *************************-->