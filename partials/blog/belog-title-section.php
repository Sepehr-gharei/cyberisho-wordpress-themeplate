<!--************************* start  belog title section *************************-->
<div class="belog-title-section animated-section">
  <div class="container">
    <div class="row">
      <div class="col-12 header-text">
        <small>BLOG</small>
        <h2>وبلاگ</h2>
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
          <li class="breadcrumb-page"><a href="">وبلاک</a></li>
        </div>
      </div>
    </div>
    <div class="programming-fields">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-8 image-preview">
            <div class="image-wrapper">
            <?php get_template_part('loop/blog/blog-title-loop', 'blog-title-loop') ?>

            </div>
          </div>
          <div class="col-12 col-md-4 section">
            <div class="wrapper">
              <h4>در کدام زمینه نیاز به آزمایش دارید؟</h4>
              <div class="content-wrapper">
                <div class="content" id="scroll-content">
                <?php get_template_part('loop/blog/blog-title-category-loop', 'blog-title-category-loop') ?>

                </div>
                <div class="custom-scrollbar" id="custom-scrollbar">
                  <div class="scrollbar-thumb" id="scrollbar-thumb">
                    <div class="inside"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--************************* end belog title section  *************************-->