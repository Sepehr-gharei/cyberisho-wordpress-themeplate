<!--************************* start article slider *************************-->
<div class="article-slider animated-section shadow-around">
  <div class="container-fluid container-article-slider">
    <div class="swiper-single-page">
      <div class="swiper-wrapper">
        <?php 
        get_template_part('loop/blog/single/article-slider-loop', 'article-slider-loop');
        ?>
      </div>
    </div>
  </div>
  <div class="footer-container">
    <a class="main-btn-blue" href="">مشاهده مقالات ورپرس</a>
  </div>
</div>
<!--************************* end article slider *************************-->