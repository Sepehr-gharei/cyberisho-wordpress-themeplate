<!--************************* start about cyberisho *************************-->
<?php
$theme_options = get_option('cyberisho_main_option', []);
$home_options = $theme_options['home'];

?>
<div class="about-cyberisho">
  <div class="header">
    <h2>چرا سایبریشو را انتخاب کنیم؟</h2>
  </div>
  <section class="container about-cyberisho-container d-flex justify-content-between large-responsive animated-section">
    <div class="item col-6 col-lg-3">
      <strong><span><?php
      if (!empty($home_options['home_cyberwhy_1'])) {
        echo $home_options['home_cyberwhy_1'];
      }
      ?></span></strong>
    </div>
    <div class="item col-6 col-lg-3">
      <strong><span><?php
      if (!empty($home_options['home_cyberwhy_2'])) {
        echo $home_options['home_cyberwhy_2'];
      }
      ?></span></strong>
    </div>
    <div class="item col-6 col-lg-3">
      <strong><span><?php
      if (!empty($home_options['home_cyberwhy_3'])) {
        echo $home_options['home_cyberwhy_3'];
      }
      ?></span></strong>
    </div>
    <div class="item col-6 col-lg-3">
      <strong><span><?php
      if (!empty($home_options['home_cyberwhy_4'])) {
        echo $home_options['home_cyberwhy_4'];
      }
      ?></span></strong>
    </div>
  </section>
</div>
<!--************************* end about cyberisho *************************-->