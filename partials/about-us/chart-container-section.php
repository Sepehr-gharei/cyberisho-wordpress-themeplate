<!--************************* start chart container *************************-->
<div class="container-fluid chart-container animated-section">
  <div class="row">
    <div class="col-12 col-md-6 right-side">
      <?php
      $theme_options = get_option('cyberisho_main_option', []);
      $about_options = $theme_options['about'];

      $chart_header = $about_options['about_chart_header'];
      $chart_footer = $about_options['about_chart_footer'];

      ?>
      <p><?php if(!empty($chart_header))echo wp_kses_post($chart_header); ?></p>
      <h3><?php if(!empty($chart_footer))echo wp_kses_post($chart_footer); ?></h3>
    </div>
    <div class="col-12 col-md-6 left-side">
      <div class="chart-section">
        <svg id="myChart"></svg>
      </div>
    </div>
  </div>
</div>
<!--************************* end chart container *************************-->