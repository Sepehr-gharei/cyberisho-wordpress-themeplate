// انتخاب تمام دکمه‌های پخش ویدیو و ویدیوها
const playButtons = document.querySelectorAll("[id='playButton']");
const videos = document.querySelectorAll("[id='myVideo']");
const videoContainers = document.querySelectorAll("[id='videoContainer']");

// تابع شروع ویدیو
function startVideo(event) {
  // پیدا کردن ویدیوی مربوطه (والد مشترک)
  const clickedPlayButton = event.currentTarget;
  const container = clickedPlayButton.closest(".video-container");
  const video = container.querySelector("video");

  // فعال کردن کنترل‌ها و شروع ویدیو
  video.setAttribute("controls", "controls");
  video.play();

  // پنهان کردن دکمه پلی
  clickedPlayButton.style.display = "none";

  // اضافه کردن کلاس hide-effects به container مربوطه
  if (container) {
    container.classList.add("hide-effects");
  }

  // اختیاری: اگر بخواهید .video-wrapper را هم تغییر دهید
  const videoWrapper = container.querySelector('.video-wrapper');
  if (videoWrapper) {
    videoWrapper.classList.add('hide-after');
  }
}

// اضافه کردن رویداد به تمام دکمه‌ها
playButtons.forEach(button => {
  button.addEventListener("click", startVideo);
});