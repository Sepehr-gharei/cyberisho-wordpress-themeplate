<!--************************* start comment and brands *************************-->
<div class="comment-and-brands animated-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 brands-container">
                <h2>نظرات مشتریان</h2>
                <p>مشتریان ما چه برندهایی و چه کسانی هستن؟</p>
                <p>در همکاری با ما چه تجربه ای دارند و نظرشان درباره ما چیست؟</p>
                <div class="brands d-flex">
                    <?php
                    // Retrieve brand images from the options
                    $brand_images = get_option('brand_images', ['']);

                    // Check if there are images to display
                    if (!empty($brand_images) && is_array($brand_images)): ?>
                        <?php foreach ($brand_images as $index => $image_url):
                            // Skip empty URLs
                            if (!empty($image_url)): ?>
                                <div class="item">
                                    <div class="image-container">
                                        <img src="<?php echo esc_url($image_url); ?>"
                                            alt="برند <?php echo esc_attr($index + 1); ?>">
                                    </div>
                                </div>
                            <?php endif;
                        endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="bott-text">
                    <a href="">+ شما هم میتوانید در کنار برترین برند ها به موفقیت برسید...</a>
                </div>
            </div>
            <div class="col-12 col-lg-4 comment">
                <section>
                    <div class="header">
                        <div class="profile">
                            <img src="<?php echo get_template_directory_uri() . '/assets/img/profile.png' ?>" alt="" />
                        </div>
                        <div class="profile-text">
                            <h4>ســایبریشــــو</h4>
                            <small>آنلاین</small>
                        </div>
                    </div>
                    <div class="body">
                        <div class="comment-item">
                            <div class="profile">
                                <img src="<?php echo get_template_directory_uri() . '/assets/img/comment-profile.png' ?>"
                                    alt="" />
                            </div>
                            <div class="text-field">
                                <h6>اقای نسجیان</h6>
                                <p>
                                    از همکاری با تیم فوق العاده شما لذت بردیم.سریع و حرفه ای
                                </p>
                            </div>
                        </div>
                        <div class="comment-item">
                            <div class="profile">
                                <img src="<?php echo get_template_directory_uri() . '/assets/img/comment-profile-2.png' ?>"
                                    alt="" />
                            </div>
                            <div class="text-field">
                                <h6>اقای حسینی</h6>
                                <p>
                                    از همکاری با تیم فوق العاده شـما باز هم از خوش قولیتون
                                    ممنونم
                                </p>
                            </div>
                        </div>
                        <div class="comment-item">
                            <div class="profile">
                                <img src="<?php echo get_template_directory_uri() . '/assets/img/comment-profile.png' ?>"
                                    alt="" />
                            </div>
                            <div class="text-field">
                                <h6>اقای صمدی</h6>
                                <p>
                                    پشـتیبانی پاســخگو و همیشـه در دسـترس یکی مهمتریـن
                                    امتیـازات هر مجموعه ای هست که شما این حسـن بزرگ رو دارید و
                                    همیشـه در کنارمون و همراهمون بودید.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <input type="text" placeholder="پیام خود را بنویسید" />
                        <button type="submit">
                            <div class="icon">
                                <svg width="512pt" height="512pt" viewBox="0 0 512 512" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="#000000ff">
                                        <path fill="#ffff" opacity="1.00"
                                            d=" M 439.62 40.57 C 446.09 37.82 452.89 35.53 459.97 35.26 C 473.73 34.40 487.65 39.85 497.36 49.60 C 506.21 58.19 511.27 70.22 512.00 82.47 L 512.00 84.64 C 511.84 93.06 509.29 101.13 507.27 109.22 C 494.95 157.56 482.62 205.89 470.30 254.22 C 469.90 255.66 470.13 257.16 470.48 258.59 C 482.04 303.68 493.49 348.80 505.01 393.91 C 507.52 405.01 511.60 415.89 512.00 427.37 L 512.00 429.54 C 511.26 442.26 505.78 454.71 496.35 463.37 C 486.20 473.01 471.84 478.01 457.90 476.59 C 450.46 476.03 443.51 473.08 436.71 470.21 C 301.78 414.20 166.82 358.24 31.89 302.22 C 19.95 297.56 9.68 288.42 4.46 276.63 C 1.71 270.65 0.41 264.10 0.00 257.55 L 0.00 253.71 C 0.53 247.42 1.81 241.14 4.45 235.39 C 9.67 223.59 19.93 214.46 31.87 209.79 C 167.78 153.36 303.72 97.00 439.62 40.57 M 453.34 67.35 C 318.34 123.37 183.33 179.39 48.32 235.41 C 43.64 237.39 38.53 239.03 35.00 242.90 C 28.49 249.97 28.47 261.95 34.95 269.04 C 38.49 272.97 43.66 274.62 48.38 276.62 C 183.61 332.71 318.81 388.85 454.05 444.92 C 461.11 448.13 469.97 447.11 475.61 441.61 C 481.13 436.80 483.11 428.85 481.17 421.88 C 468.41 371.58 455.51 321.32 442.74 271.02 C 393.48 270.98 344.22 271.01 294.96 271.00 C 289.98 271.22 284.84 269.22 281.83 265.16 C 277.51 259.82 277.69 251.49 282.23 246.34 C 285.29 242.57 290.24 240.79 295.02 241.00 C 344.26 240.99 393.50 241.02 442.74 240.98 C 455.51 190.70 468.40 140.45 481.16 90.17 C 483.50 82.22 480.34 73.15 473.38 68.61 C 467.59 64.35 459.70 64.44 453.34 67.35 Z" />
                                    </g>
                                </svg>
                            </div>
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!--************************* end comment and brands *************************-->