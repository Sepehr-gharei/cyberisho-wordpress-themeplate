const swiperTwo = new Swiper(".mySwiper", {
  slidesPerView: "auto",
  spaceBetween: 4,
  loop: true,
  centeredSlides: true,
  autoplay: {
    delay: 0,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
    reverseDirection: true,
  },
  speed: 2200,
  direction: "horizontal",
  breakpoints: {
    320: { slidesPerView: 3 },
    480: { slidesPerView: 4 },
    768: { slidesPerView: 5 },
    1024: { slidesPerView: 6 },
  },
  on: {
    init: function () {
      updateBlurEffect(this);
    },
    slideChange: function () {
      updateBlurEffect(this);
    },
    transitionEnd: function () {
      updateBlurEffect(this);
    },
  },
});

function updateBlurEffect(swiperInstance) {
  // حذف کلاس‌های قبلی
  const slides = swiperInstance.slides;
  slides.forEach((slide) => {
    slide.style.filter = "";
    slide.classList.remove("center-slide", "near-slide", "far-slide");
  });

  // پیدا کردن اسلاید فعال (مرکزی)
  const activeIndex = swiperInstance.activeIndex;

  // اعمال افکت بلور بر اساس فاصله از اسلاید مرکزی
  slides.forEach((slide, index) => {
    // محاسبه فاصله از اسلاید فعال
    let distance = Math.abs(index - activeIndex);

    // در حالت loop، فاصله ممکن است از انتهای آرایه محاسبه شود
    if (swiperInstance.params.loop) {
      const realIndex = parseInt(
        slide.getAttribute("data-swiper-slide-index")
      );
      distance = Math.abs(realIndex - swiperInstance.realIndex);
      // برای حالت loop، فاصله ممکن است از دو طرف محاسبه شود
      distance = Math.min(distance, slides.length - distance);
    }

    // اعمال بلور بر اساس فاصله
    if (distance === 0) {
      // اسلاید مرکزی - بدون بلور
      slide.style.filter = "blur(0px)";
      slide.classList.add("center-slide");
    } else if (distance === 1) {
      // اسلایدهای نزدیک - بلور کم
      slide.style.filter = "blur(1px)";
      slide.classList.add("near-slide");
    } else if (distance === 2) {
      // اسلایدهای دورتر - بلور متوسط
      slide.style.filter = "blur(2px)";
      slide.classList.add("far-slide");
    } else {
      // اسلایدهای خیلی دور - بلور زیاد
      slide.style.filter = "blur(3px)";
    }
  });
}