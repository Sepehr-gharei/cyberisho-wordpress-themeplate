const players = document.querySelectorAll(".player");

players.forEach((player) => {
  const btn = player.querySelector("button");
  const audio = player.querySelector("audio");
  const border = player.querySelector(".progress-border");
  let playing = false;

  // رنگ اولیه در هنگام لود
  player.style.backgroundColor = "#9ca5f1";
  player.style.transition = "background-color 0.3s ease";

  const playSVG = `<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
        <path d="M16 12V36" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M32 12V36" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>`;

  const pauseSVG = `<svg id="play-button-icon" viewBox="0 0 330 330">
        <path d="M37.728,328.12c2.266,1.256,4.77,1.88,7.272,1.88c2.763,0,5.522-0.763,7.95-2.28l240-149.999
            c4.386-2.741,7.05-7.548,7.05-12.72c0-5.172-2.664-9.979-7.05-12.72L52.95,2.28c-4.625-2.891-10.453-3.043-15.222-0.4
            C32.959,4.524,30,9.547,30,15v300C30,320.453,32.959,325.476,37.728,328.12z" fill="black"></path>
    </svg>`;

  btn.addEventListener("click", () => {
    if (!playing) {
      audio
        .play()
        .then(() => {
          btn.innerHTML = playSVG;
          player.style.backgroundColor = "rgb(255 255 255 / 27%)"; // تغییر رنگ هنگام پخش
          playing = true;
        })
        .catch((err) => console.log(err));
    } else {
      audio.pause();
      btn.innerHTML = pauseSVG;
      player.style.backgroundColor = "#9ca5f1"; // برگشت رنگ هنگام توقف
      playing = false;
    }
  });

  audio.addEventListener("timeupdate", () => {
    if (audio.duration > 0) {
      const progress = audio.currentTime / audio.duration;
      const angle = progress * 360;

      border.style.background = `conic-gradient(
                rgba(255,255,255,0.8) 0deg ${angle}deg,
                transparent ${angle}deg 360deg
            )`;
    }
  });

  audio.addEventListener("ended", () => {
    playing = false;
    btn.innerHTML = pauseSVG;
    player.style.backgroundColor = "#9ca5f1"; // برگشت رنگ بعد از اتمام
    border.style.background = `conic-gradient(
            rgba(255,255,255,0.8) 0deg 0deg,
            transparent 0deg 360deg
        )`;
  });
});