<?php
$theme_options = get_option('cyberisho_main_option', []);
$contact_options = $theme_options['contact'];
$theme_options = get_option('cyberisho_main_option', []);
$footer_content_options = $theme_options['footer-content'];

?>
<footer class="animated-section">
  <div class="container-fluid">
    <div class="back-to-top-section">
      <div class="scroll-to-top">
        <button id="back-to-top-btn-1" title="Go to top">
          بازگشت به بالا
        </button>
      </div>
      <div class="scroll-to-top-responsive">
        <button id="back-to-top-btn-2" title="Go to top">
          <svg width="218pt" height="146pt" viewBox="0 0 218 146" version="1.1" xmlns="http://www.w3.org/2000/svg"
            fill="var(--dark-blue-text-color)">
            <g id="#000000ff">
              <path fill="var(--dark-blue-text-color)" opacity="1.00"
                d="M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z" />
            </g>
          </svg>
        </button>
      </div>
    </div>
    <div class="container col-12 col-md-9 col-xl-8">
      <div class="logo-section">
        <h2>
          <svg>
            <use href="#logo-icon"></use>
          </svg>
        </h2>
      </div>
      <div class="text-section">
        <?php
        // بازیابی مقادیر ذخیره‌شده
        $footer_text = $footer_content_options['footer_text'];
        $footer_icon_1_image = $footer_content_options['footer_icon_1_image'];
        $footer_icon_2_image = $footer_content_options['footer_icon_2_image'];
        $footer_icon_1_url = $footer_content_options['footer_icon_1_url'];
        $footer_icon_2_url = $footer_content_options['footer_icon_2_url'];
        ?>
        <strong> <?php echo wp_kses_post($footer_text); ?></strong>


      </div>
      <div class="main-section d-flex">
        <div class="enamad col-12 col-md-2">
          <div class="copyright-responsive">
            <p>کیله حقوق متعلق به سایبریشو میباشد</p>
          </div>
          <a href="<?php echo esc_url($footer_icon_1_url); ?>" target="_blank"><img
              src="<?php echo esc_url($footer_icon_1_image); ?>" alt="enamad" /></a>
          <div class="samandehi-2">
            <a href="<?php echo esc_url($footer_icon_2_url); ?>" target="_blank"><img
                src="<?php echo esc_url($footer_icon_2_image); ?>" alt="enamad" /></a>
          </div>
        </div>

        <div class="contact col-12 col-md-8">

          <?php
          wp_nav_menu([
            'theme_location' => 'footer-menu',
            'menu_class' => 'd-flex header',
            'depth' => 1,
            'fallback_cb' => false,
            'walker' => new Cyberisho_Footer_Nav_Walker(),
          ]);
          ?>
          <div class="footer d-flex">
            <div class="col-12 col-md-6 location">
              <div>
                <svg viewBox="0 0 512 512">
                  <g id="#000000ff">
                    <path fill="var(--normal-text-color)" opacity="1.00"
                      d=" M 238.46 31.70 C 269.49 28.45 301.49 35.02 328.71 50.30 C 343.32 58.39 356.31 69.14 367.68 81.34 C 390.02 104.37 404.04 135.07 407.55 166.91 C 410.56 193.67 405.90 221.20 394.50 245.58 C 389.39 256.61 382.72 266.85 375.24 276.40 C 344.62 316.77 314.02 357.16 283.38 397.51 C 279.35 403.00 275.10 408.68 268.92 411.89 C 260.20 416.53 249.31 416.83 240.44 412.41 C 234.53 409.73 230.15 404.76 226.38 399.63 C 194.02 357.40 161.58 315.22 129.22 272.99 C 110.99 249.31 100.37 219.91 99.11 190.06 C 97.72 158.30 106.95 126.14 125.12 100.03 C 133.21 88.40 143.07 78.09 153.64 68.71 C 177.14 47.92 207.28 34.95 238.46 31.70 M 205.52 71.66 C 186.22 79.83 169.83 93.66 156.36 109.54 C 140.42 128.71 130.84 153.12 129.78 178.06 C 128.33 205.05 136.76 232.44 153.22 253.89 C 174.56 281.81 196.02 309.64 217.38 337.54 C 229.70 353.39 241.65 369.53 254.17 385.21 C 287.51 341.50 320.62 297.61 353.88 253.84 C 368.63 234.45 377.27 210.42 377.73 186.03 C 378.65 156.55 367.77 126.90 347.93 105.07 C 339.63 95.95 330.51 87.45 320.04 80.86 C 286.60 58.90 242.05 55.47 205.52 71.66 Z" />
                    <path fill="var(--normal-text-color)" opacity="1.00"
                      d=" M 240.43 116.63 C 253.74 114.00 267.78 115.60 280.26 120.87 C 298.96 128.76 313.80 145.40 319.22 165.00 C 322.84 177.31 322.85 190.64 319.22 202.95 C 313.96 222.10 299.68 238.40 281.61 246.54 C 267.55 252.82 251.37 254.40 236.44 250.45 C 223.51 247.28 211.64 240.08 202.70 230.21 C 191.08 217.86 184.75 200.90 184.71 184.00 C 184.74 169.42 189.44 154.83 198.19 143.14 C 208.38 129.49 223.63 119.71 240.43 116.63 M 246.50 146.61 C 235.07 148.63 224.82 156.23 219.57 166.59 C 215.31 174.57 214.35 184.11 216.37 192.89 C 219.05 204.05 227.02 213.83 237.51 218.54 C 244.13 221.69 251.69 222.57 258.92 221.58 C 270.91 219.89 281.76 211.97 287.20 201.18 C 291.33 193.32 292.25 183.99 290.36 175.37 C 287.65 163.65 279.03 153.46 267.89 148.92 C 261.20 146.03 253.66 145.41 246.50 146.61 Z" />
                    <path fill="var(--normal-text-color)" opacity="1.00"
                      d=" M 125.74 346.76 C 129.82 345.49 134.35 345.81 138.10 347.93 C 145.05 351.36 147.85 360.72 144.62 367.63 C 142.78 371.56 139.22 374.75 135.00 375.91 C 121.12 379.61 107.17 383.67 94.39 390.40 C 89.22 393.36 83.71 396.38 80.20 401.36 C 78.14 403.62 80.58 406.11 82.11 407.82 C 88.57 413.93 96.78 417.73 104.85 421.23 C 129.82 431.28 156.55 435.86 183.12 439.27 C 234.17 445.07 285.99 444.75 336.87 437.50 C 359.77 433.99 382.73 429.32 404.16 420.27 C 411.28 417.11 418.43 413.56 424.16 408.17 C 425.72 406.78 426.68 404.89 427.64 403.08 C 424.30 397.47 418.61 394.00 413.10 390.84 C 400.17 383.92 386.05 379.63 371.91 376.00 C 364.17 374.22 359.19 365.60 361.08 357.99 C 362.22 352.12 367.28 347.29 373.15 346.26 C 377.53 345.32 381.79 347.08 385.98 348.10 C 402.26 352.60 418.52 358.06 432.97 366.98 C 443.28 373.43 453.13 382.30 456.58 394.37 C 459.82 404.40 457.00 415.62 450.89 423.97 C 444.24 432.74 435.01 439.15 425.31 444.15 C 406.23 453.83 385.39 459.36 364.56 463.77 C 314.37 473.63 262.87 475.68 211.89 472.67 C 182.35 470.67 152.85 466.89 124.12 459.60 C 108.86 455.60 93.70 450.69 79.72 443.28 C 69.33 437.59 59.09 430.46 53.19 419.90 C 49.17 412.62 47.46 403.80 49.71 395.69 C 52.10 385.88 58.94 377.75 66.82 371.73 C 84.15 358.87 105.09 352.16 125.74 346.76 Z" />
                  </g>
                </svg>
              </div>
              <div class="text">
                <p>
                  <?php echo $contact_options['contact_location']; ?>
                </p>
              </div>
            </div>
            <div class="col-12 col-md-6 telephone">
              <div class="number">
                <pre><?php echo $contact_options['contact_hotline']; ?></pre>
                <pre><?php echo $contact_options['contact_emergency']; ?></pre>
              </div>
              <div>
                <svg viewBox="0 0 458 458">
                  <g id="#000000ff">
                    <path fill="var(--normal-text-color)" opacity="1.00"
                      d=" M 97.47 5.71 C 110.04 2.90 123.72 5.34 134.44 12.52 C 140.01 16.17 144.43 21.23 149.16 25.85 C 164.96 41.72 180.89 57.47 196.63 73.40 C 209.71 86.73 213.58 107.96 206.20 125.10 C 203.29 132.30 198.28 138.39 192.69 143.69 C 186.37 150.05 179.95 156.32 173.69 162.74 C 169.13 167.49 168.01 175.14 171.07 180.98 C 196.32 224.79 233.27 261.71 276.95 287.15 C 281.39 289.67 287.04 289.86 291.65 287.65 C 295.15 286.03 297.65 282.97 300.37 280.34 C 306.75 274.05 312.97 267.58 319.45 261.40 C 334.34 247.56 358.19 245.29 375.81 255.11 C 380.25 257.48 384.12 260.75 387.63 264.33 C 404.80 281.50 421.99 298.67 439.16 315.86 C 453.17 329.03 457.88 350.86 450.45 368.61 C 447.87 375.10 443.73 380.88 438.74 385.73 C 426.12 398.12 414.13 411.22 400.19 422.18 C 384.19 434.90 365.95 445.27 345.99 450.20 C 326.01 455.29 304.76 454.32 285.03 448.62 C 261.03 441.81 239.13 429.29 218.62 415.35 C 158.12 373.37 104.41 321.68 59.90 263.03 C 47.03 245.92 34.59 228.37 24.57 209.42 C 11.33 184.57 2.46 156.30 5.60 127.88 C 8.50 99.26 23.18 73.21 41.76 51.78 C 51.66 40.38 62.71 30.05 73.30 19.30 C 79.85 12.59 88.30 7.73 97.47 5.71 M 103.24 37.27 C 98.23 38.64 95.07 43.01 91.48 46.42 C 81.22 56.86 70.36 66.80 61.30 78.36 C 51.61 90.62 43.52 104.46 39.67 119.71 C 35.54 135.61 36.75 152.55 41.66 168.14 C 48.03 188.59 59.36 207.03 71.44 224.57 C 103.53 270.30 141.49 311.89 183.91 348.23 C 204.58 365.80 226.09 382.47 249.00 397.03 C 268.76 409.22 290.50 419.90 314.06 421.25 C 333.87 422.52 353.44 415.72 369.76 404.80 C 387.11 393.57 400.95 378.04 415.60 363.68 C 423.17 357.87 424.24 345.56 417.05 339.02 C 399.71 321.68 382.36 304.34 365.02 287.00 C 362.17 283.85 358.43 281.28 354.10 280.94 C 348.64 280.14 343.05 282.36 339.46 286.50 C 331.95 293.97 324.57 301.59 316.92 308.92 C 302.48 322.25 279.59 325.08 262.35 315.64 C 212.85 287.31 171.14 245.57 142.82 196.07 C 133.60 179.05 136.23 156.57 149.17 142.17 C 157.22 133.56 165.90 125.55 174.02 117.01 C 179.42 111.12 179.16 101.13 173.49 95.50 C 156.54 78.44 139.49 61.49 122.51 44.47 C 117.97 38.80 110.57 34.82 103.24 37.27 Z" />
                    <path fill="var(--normal-text-color)" opacity="1.00"
                      d=" M 284.42 6.59 C 285.91 6.03 287.48 5.68 289.08 5.61 C 320.36 5.27 351.66 14.35 377.94 31.32 C 403.89 47.95 424.97 72.07 437.91 100.05 C 447.92 121.56 453.09 145.31 452.95 169.03 C 452.86 176.65 446.47 183.51 438.92 184.30 C 431.80 185.31 424.50 180.72 422.01 174.03 C 420.77 170.84 421.02 167.34 420.88 163.98 C 419.99 131.97 406.57 100.60 384.29 77.64 C 360.24 52.45 325.79 37.58 290.94 37.57 C 283.60 37.90 276.39 32.72 274.63 25.55 C 272.48 17.92 276.98 9.26 284.42 6.59 Z" />
                    <path fill="var(--normal-text-color)" opacity="1.00"
                      d=" M 284.44 70.58 C 288.43 69.04 292.78 69.61 296.95 69.80 C 319.91 71.27 342.15 81.24 358.67 97.24 C 378.00 115.72 389.34 142.29 388.95 169.06 C 388.85 174.64 385.40 179.87 380.55 182.51 C 375.08 185.55 367.87 184.88 363.06 180.89 C 359.13 177.84 356.86 172.93 356.99 167.96 C 356.92 152.82 351.50 137.79 341.87 126.12 C 331.30 113.11 315.71 104.31 299.08 102.15 C 295.48 101.60 291.82 101.69 288.19 101.39 C 280.64 100.57 274.20 93.72 274.14 86.06 C 273.80 79.39 278.18 72.87 284.44 70.58 Z" />
                  </g>
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="samandehi col-12 col-md-2">
          <a href="<?php echo esc_url($footer_icon_1_url); ?>" target="_blank"><img
              src="<?php echo esc_url($footer_icon_1_image); ?>" alt="enamad" /></a>
        </div>
      </div>
    </div>
    <div class="copyright-container">
      <div class="copyright-section">
        <p id="back-to-top-btn">کلیه حقوق مطعلق به سایبریشو میباشد</p>
      </div>
    </div>
  </div>
</footer>
<div class="bottom-line"></div>
<?php wp_footer() ?>


</body>

</html>