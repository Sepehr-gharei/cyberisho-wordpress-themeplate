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
            otherPlayer.querySelector("#play-icon").style.display =
              "block";
            otherPlayer.querySelector(".pause-svg").style.display =
              "none";
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
