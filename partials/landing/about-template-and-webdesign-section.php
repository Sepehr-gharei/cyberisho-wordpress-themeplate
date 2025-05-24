<!--************************* start webdesing text field section *************************-->
<div class="webdesing-text-field-section animated-section">
  <div class="container">
    <div class="wrapper">
      <!--************************* start webdesing text field section *************************-->
      <div class="webdesing-text-field-section animated-section">
        <div class="container">
          <div class="wrapper">
            <?php
            $theme_options = get_option('cyberisho_main_option', []);
            $landing_options = $theme_options['landing'];

            $initial_header = $landing_options['landing_footer_header'];
            $initial_content = $landing_options['landing_footer_content'];
            ?>


            <h3><?php echo esc_html($initial_header) ?></h3>
            <p>
              <?php echo esc_html($initial_content); ?>
            </p>
          </div>
        </div>
      </div>
      <!--************************* end webdesing text field section *************************-->
    </div>
  </div>
</div>
<!--************************* end webdesing text field section *************************-->