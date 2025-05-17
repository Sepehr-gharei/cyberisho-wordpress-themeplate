function initPortfolioScrollbars() {
  // فقط اسکرول‌بارهای مربوط به portfolio را حذف کنید
  document
    .querySelectorAll(".portfolio-web-design-sample-section .image-scrollbar-container")
    .forEach((el) => el.remove());

  const wrappers = document.querySelectorAll(
    ".portfolio-web-design-sample-section .wrapper"
  );
  if (!wrappers.length) {
    console.error("No wrappers found in portfolio section");
    return;
  }

  wrappers.forEach((wrapper) => {
    const container = wrapper.querySelector(".image-container");
    if (!container) {
      console.error("Image container not found in portfolio wrapper");
      return;
    }

    const scrollbarContainer = document.createElement("div");
    scrollbarContainer.className = "image-scrollbar-container portfolio-scrollbar"; // کلاس اختصاصی برای شناسایی

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
      const thumbMaxTop = scrollbarContainer.clientHeight - thumb.offsetHeight;
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
      const thumbMaxTop = scrollbarContainer.clientHeight - thumb.offsetHeight;

      let newThumbTop = startThumbTop + deltaY;
      newThumbTop = Math.max(0, Math.min(newThumbTop, thumbMaxTop));
      thumb.style.top = `${newThumbTop}px`;

      const contentHeight = container.scrollHeight;
      const containerHeight = container.clientHeight;
      const scrollRatio = newThumbTop / thumbMaxTop;
      container.scrollTop = scrollRatio * (contentHeight - containerHeight);
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
  initPortfolioScrollbars();

  // مدیریت کلیک لینک‌های title و footer
  const titleLinks = document.querySelectorAll(
    ".example-of-portfolio-container .title a"
  );
  const footerLinks = document.querySelectorAll(
    ".portfolio-web-design-sample-section .footer a"
  );

  titleLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const portfolioSection = this.closest(".example-of-portfolio-section");
      if (portfolioSection) {
        portfolioSection.classList.add("active");
        initPortfolioScrollbars(); // به‌روزرسانی اسکرول‌بارها پس از فعال شدن
      }
    });
  });

  footerLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const portfolioSection = this.closest(".example-of-portfolio-section");
      if (portfolioSection) {
        portfolioSection.classList.remove("active");
      }
    });
  });
});