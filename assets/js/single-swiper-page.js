const swiper = new Swiper(".swiper-single-page", {
  slidesPerView: 3,
  centeredSlides: true,
  spaceBetween: 20,
  grabCursor: true, // نمایش اشاره‌گر دست برای کشیدن
  mousewheel: {
    enabled: true, // امکان اسلاید با چرخ ماوس
  },
  pagination: false,
  navigation: false,
  breakpoints: {
    // برای موبایل
    320: {
      slidesPerView: 1.2,
      spaceBetween: 10,
    },
    // برای تبلت
    768: {
      slidesPerView: 2.2,
      spaceBetween: 15,
    },
    // برای دسکتاپ
    1024: {
      slidesPerView: 3.2,
      spaceBetween: 20,
    },
  },
  on: {
    init: function () {
      // محاسبه تعداد کل اسلایدها
      const totalSlides = this.slides.length;
      // ایندکس وسط (برای تعداد فرد، دقیق وسط؛ برای زوج، سمت چپ وسط)
      const middleIndex = Math.floor(totalSlides / 2);
      // برو به وسط بدون انیمیشن (سرعت ۰)
      this.slideTo(middleIndex, 0);
    },
  },
});
