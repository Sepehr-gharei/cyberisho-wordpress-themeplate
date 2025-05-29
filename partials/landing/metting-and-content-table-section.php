<!--************************* start metting and content table section *************************-->
<div class="metting-and-content-table-section ">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 section animated-section-right">
        <div class="wrapper">
          <h4>فهرست مطالب</h4>
          <div class="content">
            <div class="scroll-container">
              <div class="scroll-content" id="content">
                <div class="item"><a href="#toc-header-0">بخش اول</a></div>
                <div class="item"><a href="#toc-header-1">بخش دوم</a></div>
              </div>
              <div class="custom-scrollbar" id="scrollbar">
                <div class="custom-scrollbar-thumb" id="thumb">
                  <div class="inside"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 section animated-section-left">
        <div class="wrapper">
          <h4>درخواست جلسه ملاقات حضوری:</h4>
          <div class="form-section">
            <?php $form = new Form;
            echo $form->inperson_meeting_form(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--************************* end metting and content table section *************************-->