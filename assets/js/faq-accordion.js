  document.addEventListener("DOMContentLoaded", () => {
  const items = document.querySelectorAll(".accordion-item");

  items.forEach((item) => {
    const header = item.querySelector(".accordion-header");

    // تابع مشترک برای مدیریت باز/بسته شدن
    function toggleAccordion() {
      const isActive = item.classList.contains("active");

      // بستن تمام آیتم‌ها
      items.forEach((i) => i.classList.remove("active"));

      // باز کردن فقط آیتم فعلی اگر بسته بود
      if (!isActive) {
        item.classList.add("active");
      }
    }

    // رویداد کلیک برای header
    if (header) {
      header.addEventListener("click", toggleAccordion);
    }

    // رویداد کلیک برای icon
 
  });
});