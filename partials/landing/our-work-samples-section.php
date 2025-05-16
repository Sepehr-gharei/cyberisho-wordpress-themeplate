<!--************************* start our work samples section *************************-->
<div class="our-work-samples-section animated-section ">
    <div class="container">
        <div class="title ">
            <h3>نمونه کار های ما</h3>
        </div>
        <div class="content-wrapper">
            <div class="row">
                <div class="section">
                    <?php
                    get_template_part('loop/landing/work-sample-loop', 'work-sample-loop');
                    ?>
                </div>
            </div>
        </div>
        <div class="text-loop animated-section">
            <div class="ticker-container">
                <div class="ticker-content" id="tickerContent">
                    <?php 
                    get_template_part('loop/landing/work-sample-text-loop', 'work-sample-text-loop');
                    ?>
                </div>
            </div>
            <div class="btn">
                <a href="<?php echo home_url() . '/portfolio' ?>">مشاهده همه</a>
            </div>
        </div>
    </div>
</div>
<!--************************* end our work samples section *************************-->