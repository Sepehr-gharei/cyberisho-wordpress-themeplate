<!--************************* start metting section *************************-->
<?php
  $theme_options = get_option('cyberisho_main_option', []);
  $home_options = $theme_options['home'];
  ?>
<div class="meeting-section animated-section">
    <div class="container-fluid">
        <div class="row">
        <?php $form = new Form;
            echo $form->meeting_form(); ?>
            <div class="text-field">
                <h3>
                    <h2><?php echo $home_options['home_meeting_title']; ?></h2>
                </h3>
                <p>
                <p><?php echo $home_options['home_meeting_content'];?></p>
                </p>
            </div>
        </div>
    </div>
</div>
<!--************************* end metting section *************************-->