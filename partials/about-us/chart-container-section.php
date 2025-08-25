<?php
$theme_options = get_option('cyberisho_main_option', []);
$about_options = $theme_options['about'];

$chart_header = $about_options['about_chart_header'];
$chart_footer = $about_options['about_chart_footer'];

?>

<div class="container-fluid chart-container animated-section">
  <div class="row">
    <div class="col-12 col-lg-6 right-side">
      <div class="content-text">
        <p><?php if (!empty($chart_header))
          echo wp_kses_post($chart_header); ?></p>
        <p><?php if (!empty($chart_footer))
          echo wp_kses_post($chart_footer); ?></p>

        <?php
        $theme_options = get_option('cyberisho_main_option', []);
        $site_info_options = $theme_options['site-info'];
        $contact_options = $theme_options['contact'];

        $project_count = $site_info_options['project_count'];
        $project_start_year = $site_info_options['project_start_year'];

        if (!empty($project_count) || !empty($project_start_year)) {
          ?>
          <p class="out-text"><?php echo wp_kses_post($project_count); ?><?php echo wp_kses_post($project_start_year); ?>
          </p>
          <?php
        }
        ?>
      </div>
    </div>
    <div class="col-12 col-lg-6 left-side">
      <div class="chart-section">
        <svg id="myChart"></svg>
      </div>
    </div>
  </div>
</div>