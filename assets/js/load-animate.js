document.addEventListener("DOMContentLoaded", function () {
    // انتخاب دکمه‌ها و بخش‌هایی که انیمیشن دارند
    const buttons = document.querySelectorAll("#back-to-top-btn-1, #back-to-top-btn-2");
    const sections = document.querySelectorAll(
        ".animated-section-left, .animated-section-right, .animated-section-top, .animated-section-bottom-slow, .animated-section"
    );
  
    // تعریف IntersectionObserver برای مدیریت انیمیشن‌ها
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                    entry.target.classList.remove("reverse");
                }
            });
        },
        {
            threshold: 0.2, // حداقل 20% از بخش باید در صفحه قابل مشاهده باشد
        }
    );
  
    // مشاهده همه بخش‌ها توسط IntersectionObserver
    sections.forEach((section) => {
        observer.observe(section);
    });
  
    // تابع برای معکوس کردن انیمیشن‌ها
    function reverseAnimations() {
        sections.forEach((section) => {
            section.classList.remove("active"); // حذف کلاس فعال
            section.classList.add("reverse"); // اضافه کردن کلاس معکوس
        });
    }
  
    // تابع برای ریست کردن انیمیشن‌ها
    function resetAnimations() {
        sections.forEach((section) => {
            section.classList.remove("reverse"); // حذف کلاس معکوس
        });
  
        // به‌روزرسانی IntersectionObserver برای فعال کردن دوباره انیمیشن‌ها
        sections.forEach((section) => {
            observer.unobserve(section); // حذف مشاهده قبلی
            observer.observe(section); // مشاهده مجدد
        });
    }
  
    // تابع برای حرکت به بالای صفحه
    function scrollToTop() {
        reverseAnimations(); // معکوس کردن انیمیشن‌ها
  
        // حرکت به بالای صفحه با استفاده از requestAnimationFrame
        const scrollDuration = 800; // مدت زمان اسکرول (میلی‌ثانیه)
        const scrollStep = -window.scrollY / (scrollDuration / 15); // مقدار حرکت در هر فریم
        const scrollInterval = setInterval(() => {
            if (window.scrollY !== 0) {
                window.scrollBy(0, scrollStep);
            } else {
                clearInterval(scrollInterval); // پایان اسکرول
                resetAnimations(); // ریست کردن انیمیشن‌ها
            }
        }, 15);
    }
  
    // اضافه کردن رویداد کلیک به دکمه‌ها
    buttons.forEach((button) => {
        button.addEventListener("click", scrollToTop);
    });
  });