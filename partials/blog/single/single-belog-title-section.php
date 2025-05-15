<!--************************* start  single belog title section *************************-->
<div class="single-belog-title-section animated-section">
  <div class="container">
    <div class="row">
      <div class="col-12 header-text">
        <small>SINGLE BLOG</small>
        <h2>صفحه تکی مقالات</h2>
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
          <li class="breadcrumb-page"><a href="">صفحه تکی مقالات</a></li>
        </div>
      </div>
    </div>
    <div class="content-section">
      <div class="image-wrapper">
        <img src="<?php
        if (has_post_thumbnail()) {
          $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
        }
        echo $thumbnail_url;
        ?>" alt="" />
      </div>
      <div class="text-field">
        <div class="header">
          <p><span> <?php
          // فرض کنید taxonomy ما 'blog_category_tax' است
          $terms = get_the_terms(get_the_ID(), 'category');
          if (!empty($terms) && !is_wp_error($terms)) {
            // فقط اولین دسته را نمایش بده
            echo esc_html($terms[0]->name);
          }
          ?></span></p>
        </div>
        <div class="body">
          <?php
          $reading_data = calculate_reading_time(get_the_ID());
          ?>
          <p class="item">انتشار : <?php echo get_the_date('Y/m/d'); ?></p>
          <span>|</span>
          <p class="item">زمان تقریبی مطالعه : <?php echo $reading_data['reading_time'] ?> دقیقه</p>
          <span>|</span>
          <p class="item">بازدید : <?php echo do_shortcode('[post_views]'); ?></p>
          <span>|</span>
          <p class="item">دیدگاه :
            <?php
            $post_id = get_the_ID();
            $approved_comments = get_approved_comments($post_id);
            $approved_count = count($approved_comments);
            echo $approved_count;
            ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!--************************* end single belog title section  *************************-->