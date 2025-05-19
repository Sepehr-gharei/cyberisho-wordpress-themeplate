<!--************************* start metting section *************************-->
<div class="meeting-section animated-section">
    <div class="container-fluid">
        <div class="row">
            <div class="metting-form-container">
                <h3>درخاست ملاقات حضوری :</h3>
                <input type="text" placeholder="نام شما" />
                <input type="text" placeholder="شماره تماس" />
                <input class="submit" type="submit" value="ثبت درخواست" />
            </div>
            <div class="text-field">
                <h3>
                    <h2><?php echo get_option('home_meeting_title'); ?></h2>
                </h3>
                <p>
                <p><?php echo get_option('home_meeting_content') ?></p>
                </p>
            </div>
        </div>
    </div>
</div>
<!--************************* end metting section *************************-->