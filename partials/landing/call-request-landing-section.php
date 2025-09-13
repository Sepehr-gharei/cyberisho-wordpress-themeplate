<section class="call-request-landing-section">
  <div class="container call-request-landing-container">
    <div class="title">
      <p class="header">درخواست تماس</p>
      <p class="footer">
        اکنون که در حال تصمیم گیری هستید، رقبای شما در حال کسب درآمد
        آنلاین هستند!
      </p>
    </div>
    <div class="form-wrapper">
      <div class="purple-ball-icon item-one ease-icon-animation">
        <div class="inside">

          <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
        </div>
      </div>
      <div class="purple-ball-icon item-two ease-icon-animation-low">
        <div class="inside">
          <img src="<?php echo get_template_directory_uri() . '/assets/img/ball.png' ?>" alt="" />
        </div>
      </div>
      <?php $form = new Form;
      echo $form->new_meeting_form(); ?>
    </div>
  </div>
</section>