

<?php
$faqs = get_post_meta(get_the_ID(), '_faq_data', true);
if (!empty($faqs) && is_array($faqs)):
    ?>
    <?php foreach ($faqs as $index => $faq): ?>
        <div class="accordion-item d-flex">
            <div class="col-11 wrapper-text">
                <button class="accordion-header">
                    <p class="text">
                        <?php echo esc_html($faq['title']); ?>
                    </p>
                </button>
                <div class="accordion-content">
                    <p>
                        <?php echo wp_kses_post($faq['content']); ?>
                    </p>
                </div>
            </div>
            <div class="col-1 wrapper-icon">
                <div class="icon">
                    <svg width="218pt" height="146pt" viewBox="0 0 218 146" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <g id="#000000ff">
                            <path fill="var(--light-shadow-white-color)" opacity="1.00"
                                d="M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>