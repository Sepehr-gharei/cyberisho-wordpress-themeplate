<!--************************* start article slider *************************-->
<div class="article-slider animated-section">
  <div class="container title-container">
    <h2>مقالات مرتبط</h2>
  </div>
  <div class="container-fluid container-article-slider" dir="ltr">
    <div class="panorama-slider">
      <div class="swiper">
        <div class="swiper-wrapper">
          
          <?php
          get_template_part('loop\landing\article-slider-loop', 'article-slider-loop');
          ?>
        </div>
        <!-- <div class="swiper-pagination"></div> -->
      </div>
    </div>
  </div>
  <div class="footer-container">
    <a href="">مشاهده همه</a>
  </div>
</div>
<!--************************* end article slider *************************-->