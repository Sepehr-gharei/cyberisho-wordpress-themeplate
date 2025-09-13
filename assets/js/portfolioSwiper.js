document.addEventListener("DOMContentLoaded", function () {
  var swiper = new Swiper(".portfolioSwiper", {
    loop: true,
    centeredSlides: true,
    slidesPerView: "auto",
    spaceBetween: 30,
    initialSlide: 2,
    grabCursor: true,
    speed: 600,
    updateOnWindowResize: true,
    breakpoints: {
      576: {
        spaceBetween: 30, // پیش‌فرض بزرگ‌تر
      },
      0: {
        spaceBetween: 2, // وقتی کوچیک‌تر از 576px بشه
      },
    },
    on: {
      init: function () {
        updateBlurEffect(this);
      },
      slideChangeTransitionEnd: function () {
        updateBlurEffect(this);
      },
    },
  });
  // تابع برای به‌روزرسانی افکت بلور
  function updateBlurEffect(swiperInstance) {
    // حذف کلاس‌های قبلی
    const slides = swiperInstance.slides;
    slides.forEach((slide) => {
      slide.classList.remove(
        "swiper-slide-prev",
        "swiper-slide-next",
        "swiper-slide-prev-prev",
        "swiper-slide-next-next"
      );
    });
    // پیدا کردن اندیس اسلاید فعال
    const activeIndex = swiperInstance.activeIndex;
    // اضافه کردن کلاس‌های جدید بر اساس موقعیت
    slides.forEach((slide, index) => {
      const slideIndex = parseInt(
        slide.getAttribute("data-swiper-slide-index")
      );
      const realIndex = swiperInstance.slides.indexOf(slide);
      // محاسبه فاصله از اسلاید فعال
      let distance;
      if (swiperInstance.params.loop) {
        // در حالت loop محاسبه فاصله پیچیده‌تر است
        const totalSlides = slides.length;
        const activeRealIndex = swiperInstance.realIndex;
        const slideRealIndex = parseInt(
          slide.getAttribute("data-swiper-slide-index")
        );
        // محاسبه فاصله با در نظر گرفتن loop
        let diff = Math.abs(activeRealIndex - slideRealIndex);
        distance = Math.min(diff, totalSlides - diff);
      } else {
        distance = Math.abs(activeIndex - index);
      }
      // اعمال کلاس‌ها بر اساس فاصله
      if (distance === 1) {
        slide.classList.add(
          index < activeIndex ? "swiper-slide-prev" : "swiper-slide-next"
        );
      } else if (distance === 2) {
        slide.classList.add(
          index < activeIndex
            ? "swiper-slide-prev-prev"
            : "swiper-slide-next-next"
        );
      } else if (distance >= 3) {
        slide.classList.add(
          index < activeIndex
            ? "swiper-slide-prev-prev"
            : "swiper-slide-next-next"
        );
        // برای فاصله‌های بیشتر، بلور بیشتری اعمال می‌کنیم
        slide.style.filter = `blur(${5 + (distance - 2) * 2}px)`;
      } else {
        slide.style.filter = "";
      }
    });
  }
});