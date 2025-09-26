<section class="client-comment-section">
  <div class="container client-comment-container">
    <div class="title-wrapper">
      <strong>نظرات مشتریان</strong>
    </div>
    <div class="comment-items">
      <?php get_template_part('loop/index/client-comment-loop', 'client-comment-loop') ?>
    </div>
    <div class="client-title">
      <strong>برخی از مشتریان</strong>
      <div class="icon">
        <svg  version="1.1" width="40px" height="40px" viewBox="0 0 3894 1694" style="
                shape-rendering: geometricPrecision;
                text-rendering: geometricPrecision;
                image-rendering: optimizeQuality;
                fill-rule: evenodd;
                clip-rule: evenodd;
              " >
          <g>
            <path style="opacity: 0.999" fill="#2742da"
              d="M -0.5,0.5 C -0.5,0.166667 -0.5,-0.166667 -0.5,-0.5C 18.1667,-0.5 36.8333,-0.5 55.5,-0.5C 1334.67,1.08315 2614,2.08315 3893.5,2.5C 3893.5,2.83333 3893.5,3.16667 3893.5,3.5C 3801.44,11.4799 3712.1,31.6465 3625.5,64C 3497.47,111.991 3379.47,176.991 3271.5,259C 3151.88,350.948 3046.72,457.115 2956,577.5C 2937.28,602.554 2918.95,627.887 2901,653.5C 2716.33,920.167 2531.67,1186.83 2347,1453.5C 2270.74,1563.06 2168.57,1637.23 2040.5,1676C 2006.25,1685.21 1971.58,1691.04 1936.5,1693.5C 1919.17,1693.5 1901.83,1693.5 1884.5,1693.5C 1806.98,1687.87 1733.31,1667.7 1663.5,1633C 1608.38,1606.13 1557.71,1572.8 1511.5,1533C 1475.58,1500.43 1444.08,1464.27 1417,1424.5C 1208.67,1112.5 1000.33,800.5 792,488.5C 765.176,450.329 734.676,415.162 700.5,383C 608.19,302.532 510.857,228.865 408.5,162C 350.338,124.576 289.671,91.2425 226.5,62C 165.931,33.69 102.598,14.3566 36.5,4C 24.134,2.56309 11.8007,1.39642 -0.5,0.5 Z" />
          </g>
        </svg>
      </div>
    </div>
    <div class="client-items">
      <div class="item">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/Ario-logo.png' ?>" alt="" />
      </div>
      <?php
      $theme_options = get_option('cyberisho_main_option', []);
      $site_info_options = $theme_options['site-info'];
      $brand_images = $site_info_options['brand_images'];

      if (!empty($brand_images) && is_array($brand_images)) {
        // گرفتن 7 آیتم آخر
        $recent_brands = array_slice($brand_images, -7);
        $counter = 0; // متغیر شمارشگر
      
        foreach ($recent_brands as $brand) {
          if (!empty($brand['image'])) {
            $counter++; // افزایش شمارشگر
            ?>
            <div class="item<?php echo ($counter === 3) ? ' active' : ''; ?>">
              <img src="<?php echo esc_url($brand['image']); ?>" alt="برند">
            </div>
            <?php
          }
        }
      }
      ?>
    </div>
  </div>
</section>