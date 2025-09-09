const collapseItems = document.querySelectorAll(".collapse-item");
const collapseContents = document.querySelectorAll(".collapse-content");

// تابع برای مدیریت نمایش محتوا
function handleCollapseClick(event) {
  // پاک کردن کلاس active از همه عناوین و محتواها
  collapseItems.forEach((item) => item.classList.remove("active"));
  collapseContents.forEach((content) =>
    content.classList.remove("active")
  );

  // اضافه کردن کلاس active به عنوان کلیک شده
  event.target.classList.add("active");

  // نمایش محتوای مرتبط با عنوان کلیک شده
  const targetId = event.target.getAttribute("data-target");
  const targetContent = document.getElementById(targetId);
  if (targetContent) {
    targetContent.classList.add("active");
  }
}

// اضافه کردن رویداد کلیک به همه عناوین
collapseItems.forEach((item) => {
  item.addEventListener("click", handleCollapseClick);
});