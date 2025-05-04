// تابع برای فعال‌سازی اسکرول‌بار برای هر wrapper
function initImageScrollbars() {
  document
    .querySelectorAll(".image-scrollbar-container")
    .forEach((el) => el.remove());

  const wrappers = document.querySelectorAll(
    ".portfolio-web-design-sample-section .wrapper"
  );
  if (!wrappers.length) {
    console.error("No wrappers found");
    return;
  }

  wrappers.forEach((wrapper) => {
    const container = wrapper.querySelector(".image-container");
    if (!container) {
      console.error("Image container not found in wrapper");
      return;
    }

    const scrollbarContainer = document.createElement("div");
    scrollbarContainer.className = "image-scrollbar-container";

    const thumb = document.createElement("div");
    thumb.className = "image-scrollbar-thumb";

    const inside = document.createElement("div");
    inside.className = "inside";

    thumb.appendChild(inside);
    scrollbarContainer.appendChild(thumb);
    wrapper.appendChild(scrollbarContainer);

    function updateThumbPosition() {
      const containerHeight = container.clientHeight;
      const contentHeight = container.scrollHeight;

      if (contentHeight <= containerHeight) {
        scrollbarContainer.style.display = "none";
        return;
      } else {
        scrollbarContainer.style.display = "block";
      }

      const scrollRatio = containerHeight / contentHeight;
      const thumbMaxTop =
        scrollbarContainer.clientHeight - thumb.offsetHeight;
      const scrollTop = container.scrollTop;
      const maxScroll = contentHeight - containerHeight;
      const thumbTop = (scrollTop / maxScroll) * thumbMaxTop;

      thumb.style.top = `${thumbTop}px`;
    }

    container.addEventListener("scroll", updateThumbPosition);

    let isDragging = false;
    let startY, startThumbTop;

    thumb.addEventListener("mousedown", (e) => {
      isDragging = true;
      startY = e.clientY;
      startThumbTop = parseFloat(thumb.style.top || 0);
      e.preventDefault();
    });

    document.addEventListener("mousemove", (e) => {
      if (!isDragging) return;

      const deltaY = e.clientY - startY;
      const thumbMaxTop =
        scrollbarContainer.clientHeight - thumb.offsetHeight;

      let newThumbTop = startThumbTop + deltaY;
      newThumbTop = Math.max(0, Math.min(newThumbTop, thumbMaxTop));
      thumb.style.top = `${newThumbTop}px`;

      const contentHeight = container.scrollHeight;
      const containerHeight = container.clientHeight;
      const scrollRatio = newThumbTop / thumbMaxTop;
      container.scrollTop =
        scrollRatio * (contentHeight - containerHeight);
    });

    document.addEventListener("mouseup", () => {
      isDragging = false;
    });

    updateThumbPosition();

    const resizeObserver = new ResizeObserver(updateThumbPosition);
    resizeObserver.observe(container);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initImageScrollbars();
});


document.addEventListener("DOMContentLoaded", function () {
  // انتخاب تمام لینک‌های title
  const titleLinks = document.querySelectorAll(
    ".example-of-portfolio-container .title a"
  );
  // انتخاب تمام لینک‌های footer
  const footerLinks = document.querySelectorAll(
    ".portfolio-web-design-sample-section .footer a"
  );

  // افزودن رویداد کلیک به هر لینک title
  titleLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault(); // جلوگیری از رفتار پیش‌فرض لینک
      // پیدا کردن نزدیک‌ترین example-of-portfolio-section
      const portfolioSection = this.closest(
        ".example-of-portfolio-section"
      );
      portfolioSection.classList.add("active");
    });
  });

  // افزودن رویداد کلیک به هر لینک footer
  footerLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault(); // جلوگیری از رفتار پیش‌فرض لینک
      // پیدا کردن نزدیک‌ترین example-of-portfolio-section
      const portfolioSection = this.closest(
        ".example-of-portfolio-section"
      );
      portfolioSection.classList.remove("active");
    });
  });
});