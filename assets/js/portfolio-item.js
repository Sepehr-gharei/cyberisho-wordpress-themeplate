document.addEventListener("DOMContentLoaded", function () {
  const asides = document.querySelectorAll("aside.item");

  asides.forEach((aside) => {
    const mobileButton = aside.querySelector(
      ".redirect-mobile-field .button-redirect"
    );
    const desktopButton = aside.querySelector(
      ".redirect-desktop-field .button-redirect"
    );
    const modal = aside.querySelector(".portfolio-site-images");
    const desktopIcon = aside.querySelector(".responsive-icon .desktop-icon");
    const mobileIcon = aside.querySelector(".responsive-icon .mobile-icon");
    const desktopImage = aside.querySelector(".image-section .desktop");
    const mobileImage = aside.querySelector(".image-section .mobile");
    const imageSection = aside.querySelector(".image-section");
    const closeIcon = aside.querySelector(".close-side-icon");
    const contentPortfolioSite = aside.querySelector(".content-portfolio-site");

    // Function to open modal
    function openModal() {
      modal.style.display = "flex";
      document.body.classList.add("modal-open");
    }

    // Function to close modal
    function closeModal() {
      modal.style.display = "none";
      document.body.classList.remove("modal-open");
      // Reset icons and image properties
      desktopIcon.style.display = "none";
      mobileIcon.style.display = "none";
      desktopImage.style.opacity = "0";
      desktopImage.style.height = "0";
      desktopImage.style.width = "0";
      mobileImage.style.opacity = "0";
      mobileImage.style.height = "0";
      mobileImage.style.width = "0";
      // Remove all scrollbars
      const scrolls = imageSection.querySelectorAll(".custom-scrollbar");
      scrolls.forEach((scrollbar) => scrollbar.remove());
      // Reset content-portfolio-site classes
      contentPortfolioSite.classList.remove("desktop", "mobile");
    }

    // Close on close icon click
    if (closeIcon) {
      closeIcon.addEventListener("click", closeModal);
    }

    // Mobile button click: show modal, show desktop-icon, activate mobile image
    if (mobileButton) {
      mobileButton.addEventListener("click", function () {
        openModal();
        desktopIcon.style.display = "block";
        mobileIcon.style.display = "none";
        mobileImage.style.opacity = "1";
        mobileImage.style.height = "100%";
        mobileImage.style.width = "revert-layer"; // Use CSS-defined width
        desktopImage.style.opacity = "0";
        desktopImage.style.height = "0";
        desktopImage.style.width = "0";
        contentPortfolioSite.classList.remove("desktop");
        contentPortfolioSite.classList.add("mobile");
        initCustomScrollbar(mobileImage, "mobile");
      });
    }

    // Desktop button click: show modal, show mobile-icon, activate desktop image
    if (desktopButton) {
      desktopButton.addEventListener("click", function () {
        openModal();
        mobileIcon.style.display = "block";
        desktopIcon.style.display = "none";
        desktopImage.style.opacity = "1";
        desktopImage.style.height = "100%";
        desktopImage.style.width = "revert-layer"; // Use CSS-defined width
        mobileImage.style.opacity = "0";
        mobileImage.style.height = "0";
        mobileImage.style.width = "0";
        contentPortfolioSite.classList.remove("mobile");
        contentPortfolioSite.classList.add("desktop");
        initCustomScrollbar(desktopImage, "desktop");
      });
    }

    // Desktop icon click: activate desktop image, hide desktop-icon, show mobile-icon
    if (desktopIcon) {
      desktopIcon.addEventListener("click", function () {
        const scrollbars = imageSection.querySelectorAll(".custom-scrollbar");
        scrollbars.forEach((scrollbar) => scrollbar.remove());
        desktopImage.style.opacity = "1";
        desktopImage.style.height = "100%";
        desktopImage.style.width = "revert-layer"; // Use CSS-defined width
        mobileImage.style.opacity = "0";
        mobileImage.style.height = "0";
        mobileImage.style.width = "0";
        desktopIcon.style.display = "none";
        mobileIcon.style.display = "block";
        contentPortfolioSite.classList.remove("mobile");
        contentPortfolioSite.classList.add("desktop");
        initCustomScrollbar(desktopImage, "desktop");
      });
    }

    // Mobile icon click: activate mobile image, hide mobile-icon, show desktop-icon
    if (mobileIcon) {
      mobileIcon.addEventListener("click", function () {
        const scrollbars = imageSection.querySelectorAll(".custom-scrollbar");
        scrollbars.forEach((scrollbar) => scrollbar.remove());
        mobileImage.style.opacity = "1";
        mobileImage.style.height = "100%";
        mobileImage.style.width = "revert-layer"; // Use CSS-defined width
        desktopImage.style.opacity = "0";
        desktopImage.style.height = "0";
        desktopImage.style.width = "0";
        mobileIcon.style.display = "none";
        desktopIcon.style.display = "block";
        contentPortfolioSite.classList.remove("desktop");
        contentPortfolioSite.classList.add("mobile");
        initCustomScrollbar(mobileImage, "mobile");
      });
    }

    // Custom Scrollbar Implementation
    function initCustomScrollbar(image, type) {
      const existingScrollbar = imageSection.querySelector(
        `.custom-scrollbar-${type}`
      );
      if (existingScrollbar) {
        existingScrollbar.remove();
      }

      image.style.overflowY = "scroll";
      image.style.position = "relative";
      image.style.height = "100%";

      const scrollbar = document.createElement("div");
      scrollbar.classList.add("custom-scrollbar", `custom-scrollbar-${type}`);
      scrollbar.style.position = "absolute";
      scrollbar.style.left = "10px";
      scrollbar.style.zIndex = "1001";

      const thumb = document.createElement("div");
      thumb.classList.add("thumb");
      scrollbar.appendChild(thumb);
      imageSection.appendChild(scrollbar);

      // Scrollbar is always display: block
      scrollbar.style.display = "block";

      function getDimensions() {
        return {
          contentHeight: image.scrollHeight,
          viewportHeight: image.clientHeight,
        };
      }

      // Delay dimension check to ensure layout is stable
      setTimeout(() => {
        let { contentHeight, viewportHeight } = getDimensions();

        let isDragging = false;
        let startY = 0;
        let startScrollTop = 0;

        function updateThumbPosition() {
          const { contentHeight, viewportHeight } = getDimensions();
          const scrollRatio =
            image.scrollTop / (contentHeight - viewportHeight);
          const thumbTop = scrollRatio * (viewportHeight - 15);
          thumb.style.top = `${Math.max(
            0,
            Math.min(thumbTop, viewportHeight - 15)
          )}px`;
        }

        function updateScrollPosition(clientY) {
          const { contentHeight, viewportHeight } = getDimensions();
          const deltaY = clientY - startY;
          const scrollDelta =
            (deltaY / (viewportHeight - 15)) * (contentHeight - viewportHeight);
          image.scrollTop = Math.max(
            0,
            Math.min(
              startScrollTop + scrollDelta,
              contentHeight - viewportHeight
            )
          );
          updateThumbPosition();
        }

        image.addEventListener("scroll", function () {
          updateThumbPosition();
        });

        thumb.addEventListener("mousedown", function (e) {
          e.preventDefault();
          isDragging = true;
          startY = e.clientY;
          startScrollTop = image.scrollTop;
          document.addEventListener("mousemove", onMouseMove);
          document.addEventListener("mouseup", onMouseUp);
        });

        function onMouseMove(e) {
          if (!isDragging) return;
          e.preventDefault();
          updateScrollPosition(e.clientY);
        }

        function onMouseUp() {
          isDragging = false;
          document.removeEventListener("mousemove", onMouseMove);
          document.removeEventListener("mouseup", onMouseUp);
        }

        image.addEventListener("wheel", function (e) {
          e.preventDefault();
          const scrollAmount = e.deltaY;
          image.scrollTop += scrollAmount;
          updateThumbPosition();
        });

        updateThumbPosition();
      }, 0); // Run after layout stabilizes
    }
  });
});