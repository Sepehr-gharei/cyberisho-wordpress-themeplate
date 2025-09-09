const items = document.querySelectorAll(".client-items .item img");
const activeIndex = 3; // آیتم وسط

setInterval(() => {
  // ذخیره عکس اکتیو
  let prevSrc = items[activeIndex].src;

  // لیست همه آیتم‌ها به ترتیب از active به راست
  for (let i = activeIndex + 1; i < items.length; i++) {
    let temp = items[i].src;
    items[i].src = prevSrc;
    prevSrc = temp;
  }

  // از راست آخرین آیتم بریم سمت چپ تا به اکتیو برسیم
  for (let i = 0; i < activeIndex; i++) {
    let temp = items[i].src;
    items[i].src = prevSrc;
    prevSrc = temp;
  }

  // در نهایت عکس جدیدی برای active میذاریم
  items[activeIndex].src = prevSrc;
}, 2000);