<!--************************* start work text samples section  *************************-->
<div class="work-text-samples-section animated-section">
  <div class="container">
    <div class="row">
      <div class="col-12 header-text">
        <small>PORTFOLIO</small>
        <h2>نمونه کار ها</h2>
      </div>
      <?php custom_breadcrumb(); ?>
      <div class="col-12 text-container">
        <p class="main-text">
          <span class="text-info">نمونه کار ها :</span> 
          <?php 
          if(!empty(get_the_content())){
            echo get_the_content();
          }
          ?>
        </p>
      </div>
    </div>
  </div>
</div>
<!--************************* end work text samples section  *************************-->