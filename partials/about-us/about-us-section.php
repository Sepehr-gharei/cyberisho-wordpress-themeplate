<!--************************* start about us container *************************-->
<div class="about-us-container animated-section">
  <div class="container">
    <div class="row">
      <div class="col-12 au-text">
        <small> ABOUT US</small>
        <h2>درباره ما</h2>
      </div>
      <?php custom_breadcrumb(); ?>
      <div class="col-12 about-us-text">
        <p id="main-text" class="main-text">
          <?php
          $header_text =get_the_content();
          if (!empty($header_text)) {
            echo $header_text;
          }
          ?>
        </p>
        <button class="show-txt" id="show-txt">مشاهده کامل متن</button>
      </div>
    </div>
  </div>
</div>
<!--************************* end about us container *************************-->