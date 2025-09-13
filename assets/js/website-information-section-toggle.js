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
