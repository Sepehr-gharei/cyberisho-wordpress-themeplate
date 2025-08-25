<?php

$theme_options = get_option('cyberisho_main_option', []);
$landing_options = $theme_options['landing'];

// دریافت داده‌ها از get_option
$faq_items = $landing_options['landing_page_faqs'];

// بررسی وجود داده
if (!empty($faq_items) && is_array($faq_items)) {
    foreach ($faq_items as $index => $item) {
        $title = isset($item['title']) ? esc_html($item['title']) : '';
        $content = isset($item['content']) ? esc_html($item['content']) : '';
        ?>
      
      <div class="accordion-item d-flex">
        <div class="col-12 wrapper-text">
          <button class="accordion-header">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0.00 0.00 12.00 20.00">
                <path fill="#000000" d="
                          M 12.00 5.72
                          L 12.00 7.20
                          C 11.21 10.35 9.04 11.54 7.66 12.93
                          A 1.25 1.24 65.1 0 0 7.30 13.92
                          Q 7.30 13.94 7.33 14.25
                          A 0.71 0.71 0.0 0 1 6.62 15.02
                          L 4.61 15.02
                          A 0.66 0.66 0.0 0 1 3.95 14.40
                          C 3.72 11.24 5.63 10.04 7.65 8.21
                          C 9.17 6.82 8.56 4.56 6.45 4.25
                          Q 5.57 4.13 1.87 4.72
                          A 0.70 0.69 85.4 0 1 1.07 4.03
                          L 1.07 2.16
                          A 0.62 0.61 80.9 0 1 1.49 1.57
                          C 5.91 0.10 11.32 -0.13 12.00 5.72
                          Z" />
                <rect fill="#000000" x="-1.76" y="-1.74" transform="translate(5.49,18.01) rotate(0.1)" width="3.52"
                  height="3.48" rx="0.44" />
              </svg>
            </div>
            <p class="text">
            <?php echo $title; ?>
            </p>
          </button>
          <div class="accordion-content">
            <p>
            <?php echo $content; ?>
            </p>
          </div>
        </div>
      </div>

        <?php
    }
} else {
    echo '<p>سوالی یافت نشد.</p>';
}
?>