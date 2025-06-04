<?php
if (have_posts()):
    while (have_posts()):
        the_post();
        ?>
        <div class="item">
            <div class="title">
                <strong><?Php echo get_the_title() ?></strong>
            </div>
            <div class="text-field">
                <p>
                <?Php echo get_the_content() ?>
                </p>
            </div>
        </div>
        <?php
    endwhile;
else:
endif;
