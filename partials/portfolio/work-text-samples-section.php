<!--************************* start work text samples section  *************************-->
<div class="header-page-title-section">
    <div class="container">
        <div class="row">
            <div class="col-12 title-header-text">
                <small>Portfolio</small>
                <h2>نمونه کار ها</h2>
            </div>
            <?php custom_breadcrumb(); ?>
            <div class="col-12 content-title-text">
                <p id="main-text" class="main-text">
                    <strong class="warning">نکته مهم :</strong> <?php
                    if (!empty(get_the_content())) {
                        echo get_the_content();
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<!--************************* end work text samples section  *************************-->