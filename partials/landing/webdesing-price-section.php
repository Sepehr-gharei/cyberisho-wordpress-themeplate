<!--************************* start webdesing price section  *************************-->
<div class="webdesing-price-section animated-section">
  <div class="container">
    <div class="title-wrapper">
      <h3>قیمت و تعرفه طراحی سایت</h3>





      <?php
      // Retrieve pricing section content
      $pricing_header = get_option('landing_pricing_header', '');
      $pricing_rows = get_option('landing_pricing_rows', []);
      $pricing_footer = get_option('landing_pricing_footer', '');
      // Display pricing section
      ?>
      <p>
        <?php echo esc_html($pricing_header); ?>
      </p>
    </div>
    <div class="price-container">
      <div class="wrapper-box header">
        <div class="line-box box col-1">
          <p>ردیف</p>
          <span>|</span>
        </div>
        <div class="service-box box col-5">
          <p>شرح خدمات</p>
        </div>
        <div class="time-box box col-3">
          <span>|</span>
          <p>مدت زمان انجام</p>
          <span>|</span>
        </div>
        <div class="price-box box col-3">
          <p>قیمت</p>
        </div>
      </div>


      <?php if (!empty($pricing_rows)): ?>

        <?php foreach ($pricing_rows as $index => $row): ?>

          <div class="wrapper-box">

            <div class="line-box box col-1">
              <p><?php echo esc_html($index + 1); ?></p>
            </div>
            <div class="service-box box col-5">
              <p> <?php echo esc_html($row['description']); ?></p>
            </div>
            <div class="time-box box col-3">
              <p><?php echo esc_html($row['duration']); ?></p>
            </div>
            <div class="price-box box col-3">
              <p><?php echo esc_html($row['price']); ?></p>
            </div>

          </div>
        <?php endforeach; ?>

      <?php endif; ?>




    </div>
    <div class="bott-info">
      <?php echo esc_html($pricing_footer); ?>
    </div>
  </div>
</div>
<!--************************* start webdesing price section  *************************-->