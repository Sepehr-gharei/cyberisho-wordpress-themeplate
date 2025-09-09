<!-- ************************* start contact us container   *************************-->
<section class="header-page-title-section">
  <div class="container">
    <div class="row">
      <div class="col-12 title-header-text">
        <small>CONTACT US</small>
        <h2>تماس با ما</h2>
      </div>
      <?php custom_breadcrumb(); ?>

      <div class="col-12 content-title-text">
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
</section>
<!-- ************************* end contact us container   *************************-->