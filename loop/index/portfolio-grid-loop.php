<?php
            $theme_options = get_option('cyberisho_main_option', []);
            $portfolio_options = $theme_options['portfolio'];
            $portfolios = $portfolio_options['theme_portfolios'];

            $total_items = count($portfolios);

            // اگر هیچ نمونه کاری نبود
            if ($total_items === 0) {
                echo '<p>نمونه کاری نیست.</p>';
            } else {
                // کلاس‌های ممکن برای opacity
                $opacity_classes = ['dark-opacity', 'light-opacity', 'medium-opacity'];

                // اگر بیش از یا برابر 11 تا باشد، 11 تا اخیر را بگیریم (از آخر آرایه)
                if ($total_items >= 11) {
                    $selected_portfolios = array_slice($portfolios, -11, 11);
                } else {
                    // اگر کمتر از 11 تا باشد، از موجودها رندوم انتخاب کنیم تا 11 تا شود (با امکان تکرار)
                    $selected_portfolios = [];
                    for ($i = 0; $i < 11; $i++) {
                        $random_index = rand(0, $total_items - 1);
                        $selected_portfolios[] = $portfolios[$random_index];
                    }
                }

                // لوپ برای نمایش 11 آیتم
                foreach ($selected_portfolios as $portfolio) {
                    // انتخاب رندوم کلاس opacity
                    $random_class = $opacity_classes[array_rand($opacity_classes)];

                    if (!empty($portfolio['name']) && !empty($portfolio['url'])) {
                        ?>
                        <div class="item <?php echo esc_attr($random_class); ?>">
                            <div class="fa-name">
                                <p><?php echo esc_html($portfolio['name']); ?></p>
                            </div>
                            <div class="space">|</div>
                            <div class="en-name">
                                <p><?php echo esc_html($portfolio['url']); ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>