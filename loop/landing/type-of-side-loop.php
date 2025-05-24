<?php
$theme_options = get_option('cyberisho_main_option', []);
$landing_options = $theme_options['landing'];

$site_types = $landing_options['landing_site_types'];

// Get the 5 most recent site types (last 5 items in the array)
$current_site_types = array_slice($site_types, -5, 5, true);

if (!empty($current_site_types)): ?>
    <?php foreach ($current_site_types as $site_type):
        ?>
        <div class="wrapper animated-section">
            <div class="img-section">
                <img src="<?php echo esc_url($site_type['image']); ?>" alt="" />
            </div>
            <div class="text-field">
                <div class="text-wrapper">
                    <h4><?php echo esc_html($site_type['content_header']); ?></h4>
                    <p><?php echo esc_html($site_type['content']); ?></p>
                </div>
                <div class="text-wrapper">
                    <h5><?php echo esc_html($site_type['feature_header']); ?></h5>
                    <ul>
                        <li><?php echo esc_html($site_type['feature_1']); ?></li>
                        <li><?php echo esc_html($site_type['feature_2']); ?></li>
                        <li><?php echo esc_html($site_type['feature_3']); ?></li>
                    </ul>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php else: ?>
    <p>هیچ نوع سایتی یافت نشد.</p>
<?php endif; ?>