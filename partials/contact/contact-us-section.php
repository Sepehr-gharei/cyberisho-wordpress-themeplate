   <!-- ************************* start contact us container   *************************-->
   <div class="contact-us-container animated-section">
      <div class="container">
        <div class="row">
          <div class="col-12 au-text">
            <small>CONTACT US</small>
            <h2>تماس ما</h2>
          </div>
          <div class="col-12 breadcrumb">
            <div class="d-flex">
              <li class="home-page">
                <a href="">
                  <svg>
                    <use href="#house-icon"></use>
                  </svg>
                </a>
              </li>
              <div class="arrow-icon">
                <svg>
                  <use href="#double-arrow-icon"></use>
                </svg>
              </div>
              <li class="breadcrumb-page"><a href="">تماس ما</a></li>
            </div>
          </div>
          <div class="col-12 about-us-text">
            <p id="main-text" class="main-text">
            <?php
          $current_post_id = get_the_ID();
          $header_text = get_post_meta($current_post_id, '_page_header_text_key', true);
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