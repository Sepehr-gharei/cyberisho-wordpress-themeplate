// انتخاب المان‌ها
const video = document.getElementById("myVideo");
const playButton = document.getElementById("playButton");
const videoContainer = document.getElementById("videoContainer");
const textContainer = document.getElementById("landing-video-text");

// تابع برای شروع ویدیو
// تابع برای شروع ویدیو
function startVideo() {
  // فعال کردن کنترل‌های پیش‌فرض مرورگر
  video.setAttribute("controls", "controls");

  // شروع ویدیو
  video.play();

  // مخفی کردن دکمه شروع
  playButton.style.display = "none";

  // افزودن کلاس hide-effects به videoContainer
  if (videoContainer) {
    videoContainer.classList.add("hide-effects");
    console.log("کلاس hide-effects اضافه شد:", videoContainer.classList); // برای دیباگ
  } else {
    console.error("videoContainer پیدا نشد!");
  }

  // افزودن کلاس جدید به والد :after
  const videoWrapper = document.querySelector('.video-landing-section .video-wrapper');
  if (videoWrapper) {
    videoWrapper.classList.add('hide-after');
  }
}

// رویداد کلیک روی دکمه شروع
playButton.addEventListener("click", startVideo);