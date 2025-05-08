<!--************************* start webdesing text field section *************************-->
<div class="webdesing-text-field-section animated-section">
    <div class="container">
        <div class="wrapper">
        <?php
$initial_header = get_option('landing_initial_header', '');
$initial_content = get_option('landing_initial_content', '');
?>


            <h3><?php echo esc_html($initial_header) ?></h3>
            <p>
            <?php echo esc_html($initial_content); ?>
            </p>
        </div>
    </div>
</div>
<!--************************* end webdesing text field section *************************-->