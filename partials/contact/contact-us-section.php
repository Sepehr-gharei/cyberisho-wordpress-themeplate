<!-- ************************* start contact us container   *************************-->
<div class="contact-us-container animated-section">
  <div class="container">
    <div class="row">
      <div class="col-12 au-text">
        <small>CONTACT US</small>
        <h2>تماس با ما</h2>
      </div>
      <?php custom_breadcrumb(); ?>
      <div class="col-12 about-us-text">
        <p id="main-text" class="main-text">
          <?php
          $header_text = get_the_content();
          if (!empty($header_text)) {
            echo $header_text;
          }
          ?>
        </p>
      </div>
    </div>
  </div>
</div>
<!-- ************************* end contact us container   *************************-->