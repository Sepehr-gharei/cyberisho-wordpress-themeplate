const swiper = new Swiper(".comment-review-swiper", {
  slidesPerView: "auto",
  spaceBetween: 20,
  centeredSlides: false,
  slidesOffsetAfter: 100, // اضافه کردن فاصله بعد از آخرین اسلاید
});
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
const players = document.querySelectorAll(".player");

players.forEach((player) => {
  player.classList.add("landing-item-section");

  const title = player.querySelector(".title");
  if (title) {
    title.classList.add("title-wrapper");
  }

  const audioWrapper = player.querySelector("audio")?.parentElement;
  if (audioWrapper) {
    audioWrapper.classList.add("audio-wrapper");
  }

  const btn = player.querySelector("button");
  const audio = player.querySelector("audio");
  const border = player.querySelector(".progress-border");
  let playing = false;

  player.style.backgroundColor = "black";

  const playSVG = `
<p>توضیحات بیشتر</p>
<svg class="pause-svg" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" fill="var(--background-color)" fill-opacity="0.01"/>
<path d="M16 12V36" stroke="blue" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M32 12V36" stroke="blue" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
</svg>`;

  const pauseSVG = `
<p>توضیحات بیشتر</p>
<svg id="play-icon" viewBox="0 0 330 330">
                <path d="M37.728,328.12c2.266,1.256,4.77,1.88,7.272,1.88c2.763,0,5.522-0.763,7.95-2.28l240-149.999
                  c4.386-2.741,7.05-7.548,7.05-12.72c0-5.172-2.664-9.979-7.05-12.72L52.95,2.28c-4.625-2.891-10.453-3.043-15.222-0.4
                  C32.959,4.524,30,9.547,30,15v300C30,320.453,32.959,325.476,37.728,328.12z" fill="black"></path>
   </svg>`;

  btn.addEventListener("click", () => {
    if (!playing) {
      audio.load(); // Reload the audio to ensure it’s ready
      const playPromise = audio.play();
      if (playPromise !== undefined) {
        playPromise
          .then(() => {
            btn.innerHTML = playSVG;
            player.style.backgroundColor = "black";
            playing = true;
          })
          .catch((err) => {
            console.error("Error playing audio:", err);
            // Display a user-friendly message if needed
            alert(
              "خطا در پخش فایل صوتی: لطفاً مطمئن شوید که فایل صوتی معتبر است."
            );
          });
      }
    } else {
      audio.pause();
      btn.innerHTML = pauseSVG;
      player.style.backgroundColor = "black";
      playing = false;
    }
  });

  audio.addEventListener("canplay", () => {
    console.log("Audio is ready to play");
  });

  audio.addEventListener("error", (e) => {
    console.error("Audio error:", e);
    alert("خطا در بارگذاری فایل صوتی: " + e.message);
  });

  audio.addEventListener("timeupdate", () => {
    if (audio.duration > 0) {
      const progress = audio.currentTime / audio.duration;
      const angle = progress * 360;
      border.style.background = `conic-gradient(
  var(--text-medium-blue-color) 0deg ${angle}deg,
  transparent ${angle}deg 360deg
)`;
    }
  });

  audio.addEventListener("ended", () => {
    playing = false;
    btn.innerHTML = pauseSVG;
    player.style.backgroundColor = "var(--background-color)";
    border.style.background = `conic-gradient(
var(--text-medium-blue-color) 0deg 0deg,
transparent 0deg 360deg
)`;
  });
});
const wheelContainer = document.querySelector(
  ".spinning-wheel-section .wheel-container"
);
const canvas = wheelContainer.querySelector("#wheel");
const ctx = canvas.getContext("2d");
const W = canvas.width;
const H = canvas.height;
const cx = W / 2;
const cy = H / 2;
const radius = Math.min(W, H) / 2 - 8;
let segments = [
  { label: "50% تخفیف", color: "#2743da", audio: "central.mp3" },
  { label: "هدیه", color: "#2743da", audio: "central.mp3" },
  { label: "هیچ‌چی", color: "#2743da", audio: "central.mp3" },
  { label: "جایزه ویژه", color: "#2743da", audio: "central.mp3" },
  { label: "کوپن", color: "#2743da", audio: "central.mp3" },
];
let usedSegments = []; // Track used segments
const originalSegments = [...segments]; // Store original segments for reset
let rotation = 0;
let spinning = false;
let animationId = null;
let n = segments.length;
const anglePer = (Math.PI * 2) / n;
const redAngle = 0;
const player = wheelContainer.querySelector(".carrousel-player");
const btn = player.querySelector("button");
const audio = wheelContainer.querySelector("#result-audio");
const border = player.querySelector(".progress-border");
const result = wheelContainer.querySelector("#result");
let playing = false;
const playSVG = `<div class="inside"><svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" fill="var(--background-color)" fill-opacity="0.01"/>
<path d="M16 12V36" stroke="var(--background-color)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M32 12V36" stroke="var(--background-color)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
</svg></div>`;
const pauseSVG = `<div class="inside"><svg id="play-button-icon" viewBox="0 0 330 330">
<path d="M37.728,328.12c2.266,1.256,4.77,1.88,7.272,1.88c2.763,0,5.522-0.763,7.95-2.28l240-149.999
c4.386-2.741,7.05-7.548,7.05-12.72c0-5.172-2.664-9.979-7.05-12.72L52.95,2.28c-4.625-2.891-10.453-3.043-15.222-0.4
C32.959,4.524,30,9.547,30,15v300C30,320.453,32.959,325.476,37.728,328.12z" fill="var(--background-color)"></path>
</svg></div>`;

function drawWheel() {
  ctx.clearRect(0, 0, W, H);
  for (let i = 0; i < n; i++) {
    const start = rotation + i * anglePer;
    const end = start + anglePer;
    ctx.beginPath();
    ctx.moveTo(cx, cy);
    ctx.arc(cx, cy, radius, start, end);
    ctx.closePath();
    ctx.fillStyle = segments[i].color;
    ctx.fill();
    ctx.save();
    ctx.translate(cx, cy);
    const mid = start + anglePer / 2;
    ctx.rotate(mid);
    ctx.textAlign = "right";
    ctx.fillStyle = "#fff";
    ctx.font = "bold 21px peyda-regular";
    ctx.fillText(segments[i].label, radius - 30, 8);
    ctx.restore();
  }
  const alpha = anglePer / 2;
  ctx.beginPath();
  ctx.moveTo(cx, cy);
  ctx.arc(cx, cy, radius, alpha, Math.PI * 2 - alpha);
  ctx.closePath();
  ctx.fillStyle = "#ffd400";
  ctx.fill();
  ctx.save();
  ctx.globalCompositeOperation = "multiply";
  const shadowGradient = ctx.createLinearGradient(
    0,
    cy - radius,
    0,
    cy + radius
  );
  shadowGradient.addColorStop(0, "rgba(0,100,0,0.9)");
  shadowGradient.addColorStop(0.45, "rgba(0,100,0,0)");
  shadowGradient.addColorStop(0.55, "rgba(0,100,0,0)");
  shadowGradient.addColorStop(1, "rgba(0,100,0,0.9)");
  ctx.beginPath();
  ctx.moveTo(cx, cy);
  ctx.arc(cx, cy, radius, -alpha, alpha, false);
  ctx.closePath();
  ctx.fillStyle = shadowGradient;
  ctx.fill();
  ctx.restore();
  ctx.beginPath();
  ctx.arc(cx, cy, 36, 0, Math.PI * 2);
  ctx.fillStyle = "rgba(255,255,255,0.03)";
  ctx.fill();
  ctx.beginPath();
  ctx.arc(cx, cy, radius + 4, 0, Math.PI * 2);
  ctx.strokeStyle = "#142caf";
  ctx.lineWidth = 20;
  ctx.stroke();
}

let targetRotation = 0;
let velocity = 0;

function animate() {
  if (!spinning) return;
  const diff = targetRotation - rotation;
  velocity += diff * 0.05;
  velocity *= 0.95;
  rotation += velocity;
  if (Math.abs(velocity) < 0.0001 && Math.abs(diff) < 0.0001) {
    rotation = targetRotation;
    spinning = false;
    announceResult();
  }
  drawWheel();
  animationId = requestAnimationFrame(animate);
}

function spin() {
  if (spinning) return;
  // Pause any playing audio before spinning
  if (playing) {
    audio.pause();
    btn.innerHTML = pauseSVG;
    player.style.backgroundColor = "#9ca5f1";
    border.style.background = `conic-gradient(from 135deg, rgba(255,255,255,0.8) 0deg 0deg, transparent 0deg 360deg )`;
    playing = false;
  }
  spinning = true;
  // Select only from available (non-used) segments
  const availableSegments = segments.filter(
    (_, i) => !usedSegments.includes(i)
  );
  if (availableSegments.length === 0) {
    // Reset when all segments are used
    usedSegments = [];
    segments = [...originalSegments];
    n = segments.length;
  }
  const availableIndices = segments
    .map((_, i) => i)
    .filter((i) => !usedSegments.includes(i));
  const index =
    availableIndices[Math.floor(Math.random() * availableIndices.length)];
  usedSegments.push(index); // Mark segment as used
  targetRotation =
    -(index * anglePer + anglePer / 2 - redAngle) -
    2 * Math.PI * (5 + Math.floor(Math.random() * 3));
  velocity = 0;
  animate();
}

function announceResult() {
  const normalized =
    ((-rotation % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
  const index = Math.floor(normalized / anglePer) % n;
  const seg = segments[index];
  result.textContent = "نتیجه: " + seg.label;
  // Play audio after wheel stops
  audio.src = seg.audio;
  audio.load();
  audio
    .play()
    .then(() => {
      btn.innerHTML = playSVG;
      playing = true;
    })
    .catch((err) => {
      console.error("Audio playback failed:", err);
      result.textContent += " (خطا در پخش صدا)";
    });
}

btn.addEventListener("click", () => {
  if (!playing) {
    audio
      .play()
      .then(() => {
        btn.innerHTML = playSVG;
        playing = true;
      })
      .catch((err) => {
        console.error("Audio playback failed:", err);
        result.textContent = "خطا در پخش صدا";
      });
  } else {
    audio.pause();
    btn.innerHTML = pauseSVG;
    player.style.backgroundColor = "#9ca5f1";
    border.style.background = `conic-gradient(from 135deg, rgba(255,255,255,0.8) 0deg 0deg, transparent 0deg 360deg )`;
    playing = false;
  }
});

audio.addEventListener("timeupdate", () => {
  if (audio.duration > 0) {
    const progress = audio.currentTime / audio.duration;
    const angle = progress * 270;
    border.style.background = `conic-gradient(from 135deg, rgba(255,255,255,0.8) 0deg ${angle}deg, transparent ${angle}deg 360deg )`;
  }
});

audio.addEventListener("ended", () => {
  playing = false;
  btn.innerHTML = pauseSVG;
  player.style.backgroundColor = "#9ca5f1";
  border.style.background = `conic-gradient(from 135deg, rgba(255,255,255,0.8) 0deg 0deg, transparent 0deg 360deg )`;
});

const initialIndex = Math.floor(Math.random() * n);
rotation = -(initialIndex * anglePer + anglePer / 2 - redAngle);
drawWheel();

wheelContainer.querySelector("#spin").addEventListener("click", spin);
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
      const realIndex = parseInt(slide.getAttribute("data-swiper-slide-index"));
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
document
  .querySelectorAll(
    ".comment-review-landing-section .comment-review-swiper .swiper-slide .audio-player"
  )
  .forEach((player) => {
    const audio = player.querySelector("audio");
    const playIcon = player.querySelector("#play-icon");
    const pauseIcon = player.querySelector(".pause-svg");
    const progressBar = player.querySelector("#progress-bar");
    const progress = player.querySelector("#progress");

    // پخش
    playIcon.addEventListener("click", () => {
      // بستن بقیه پلیرها
      document
        .querySelectorAll(
          ".comment-review-landing-section .comment-review-swiper .swiper-slide .audio-player audio"
        )
        .forEach((otherAudio) => {
          if (otherAudio !== audio) {
            otherAudio.pause();
            otherAudio.currentTime = 0;
            const otherPlayer = otherAudio.closest(".audio-player");
            otherPlayer.querySelector("#play-icon").style.display = "block";
            otherPlayer.querySelector(".pause-svg").style.display = "none";
            otherPlayer.querySelector("#progress").style.width = "0%";
          }
        });

      audio.play();
      playIcon.style.display = "none";
      pauseIcon.style.display = "block";
    });

    // توقف
    pauseIcon.addEventListener("click", () => {
      audio.pause();
      playIcon.style.display = "block";
      pauseIcon.style.display = "none";
    });

    // بروزرسانی نوار پیشرفت
    audio.addEventListener("timeupdate", () => {
      const progressPercent = (audio.currentTime / audio.duration) * 100;
      progress.style.width = `${progressPercent}%`;
    });

    // کلیک روی نوار
    progressBar.addEventListener("click", (e) => {
      const rect = progressBar.getBoundingClientRect();
      const clickX = e.clientX - rect.left;
      const percent = clickX / rect.width;
      audio.currentTime = percent * audio.duration;
    });

    // وقتی آهنگ تموم شد
    audio.addEventListener("ended", () => {
      playIcon.style.display = "block";
      pauseIcon.style.display = "none";
      progress.style.width = "0%";
    });
  });
document.addEventListener("DOMContentLoaded", function () {
  const section = document.querySelector(".website-information-section");
  const textContent = section.querySelector("#textContent");
  const toggleBtn = section.querySelector("#toggleBtn");

  toggleBtn.addEventListener("click", function () {
    textContent.classList.toggle("expanded");
    if (textContent.classList.contains("expanded")) {
      toggleBtn.textContent = "مشاهده کمتر";
    } else {
      toggleBtn.textContent = "مشاهده بیشتر";
    }
  });
});
