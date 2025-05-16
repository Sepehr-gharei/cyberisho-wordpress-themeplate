  document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector('.programming-fields');
  const items = document.querySelectorAll('.programming-fields .section .content .item');
  const imageContainers = document.querySelectorAll('.programming-fields .image-container');

  items.forEach(item => {
    item.addEventListener('click', () => {
      // حذف کلاس active از همه آیتم‌ها
      items.forEach(i => i.classList.remove('active'));
      // اضافه کردن کلاس active به آیتم کلیک‌شده
      item.classList.add('active');

      // گرفتن شماره آیتم از id (مثلاً item-1 -> 1)
      const itemNumber = item.id.split('-')[1];
      // پیدا کردن image-container مربوطه
      const targetContainer = container.querySelector(`#content-${itemNumber}`);

      // حذف کلاس active-content از همه کانتینرها
      imageContainers.forEach(container => container.classList.remove('active-content'));
      // اضافه کردن کلاس active-content به کانتینر هدف
      targetContainer.classList.add('active-content');
    });
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".programming-fields");
  const items = document.querySelectorAll(
    ".programming-fields .section .content .item"
  );
  const imageContainers = document.querySelectorAll(
    ".programming-fields .image-container"
  );
  const content = document.getElementById("scroll-content");
  const scrollbar = document.getElementById("custom-scrollbar");
  const thumb = document.getElementById("scrollbar-thumb");

  // مدیریت کلیک روی آیتم‌ها
  items.forEach((item) => {
    item.addEventListener("click", () => {
      items.forEach((i) => i.classList.remove("active"));
      item.classList.add("active");

      const itemNumber = item.id.split("-")[1];
      const targetContainer = container.querySelector(`#content-${itemNumber}`);

      imageContainers.forEach((container) =>
        container.classList.remove("active-content")
      );
      targetContainer.classList.add("active-content");
    });
  });

  // مدیریت اسکرول بار سفارشی
  function updateThumbPosition() {
    if (!content || !scrollbar || !thumb) {
      console.error("One or more elements are missing:", { content, scrollbar, thumb });
      return;
    }

    const contentHeight = content.scrollHeight;
    const containerHeight = content.clientHeight;

    // اگر محتوا کوتاه‌تر از ظرف باشد، اسکرول بار را مخفی کن
    if (contentHeight <= containerHeight) {
      scrollbar.classList.add("hidden");
      thumb.style.display = "none";
      return;
    } else {
      scrollbar.classList.remove("hidden");
      thumb.style.display = "block";
    }

    const scrollTop = content.scrollTop;
    const maxScroll = contentHeight - containerHeight;
    const thumbMaxHeight = scrollbar.clientHeight - thumb.offsetHeight;
    const scrollRatio = scrollTop / maxScroll;
    const thumbPosition = scrollRatio * thumbMaxHeight;

    thumb.style.top = `${thumbPosition}px`;

    // لاگ برای دیباگ
    console.log("Scroll Update:", {
      scrollTop,
      contentHeight,
      containerHeight,
      thumbPosition,
    });
  }

  // اطمینان از اتصال رویداد اسکرول
  if (content) {
    content.addEventListener("scroll", () => {
      updateThumbPosition();
    });
  } else {
    console.error("Content element not found!");
  }

  // پشتیبانی از کشیدن thumb
  let isDragging = false;
  let startY, startThumbTop;

  if (thumb) {
    thumb.addEventListener("mousedown", (e) => {
      isDragging = true;
      startY = e.clientY;
      startThumbTop = parseFloat(thumb.style.top || 0);
      e.preventDefault();
    });
  }

  document.addEventListener("mousemove", (e) => {
    if (!isDragging) return;
    const deltaY = e.clientY - startY;
    const thumbMaxHeight = scrollbar.clientHeight - thumb.offsetHeight;
    let newThumbTop = startThumbTop + deltaY;
    newThumbTop = Math.max(0, Math.min(newThumbTop, thumbMaxHeight));
    thumb.style.top = `${newThumbTop}px`;

    const contentHeight = content.scrollHeight;
    const containerHeight = content.clientHeight;
    const scrollRatio = newThumbTop / thumbMaxHeight;
    content.scrollTop = scrollRatio * (contentHeight - containerHeight);
  });

  document.addEventListener("mouseup", () => {
    isDragging = false;
  });

  // به‌روزرسانی اولیه موقعیت thumb
  updateThumbPosition();

  // به‌روزرسانی هنگام تغییر اندازه
  if (content) {
    const resizeObserver = new ResizeObserver(updateThumbPosition);
    resizeObserver.observe(content);
  }
});