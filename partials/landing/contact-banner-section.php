<!--************************* start contact banner section  *************************-->
<?php
$theme_options = get_option('cyberisho_main_option', []);
$contact_options = $theme_options['contact'];
?>
<div class="contact-banner-section animated-section">
  <div class="container col-6 contact-banner-container">
    <div class="row">
      <div class="col-12 col-lg-6 wrapper right-side d-flex">
        <div class="text-section">
          <strong>برای مشاوره تماس بگیرید</strong>
          <p>با افتخار پاسخگوی شما هستیم</p>
        </div>
      </div>
      <div class="col-12 col-lg-6 wrapper left-side d-flex">
        <div class="text-field">
          <strong><?php echo $contact_options['contact_hotline']; ?></strong>
          <p><?php echo $contact_options['contact_emergency']; ?></p>
        </div>
        <div class="icon">
          <svg>
            <use href="#headphone-icon"></use>
          </svg>
        </div>
      </div>
    </div>
  </div>
</div>
<!--************************* end contact banner section  *************************-->