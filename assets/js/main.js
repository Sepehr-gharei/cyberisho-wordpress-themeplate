document.addEventListener("DOMContentLoaded", function () {
  const openMenuBtn = document.getElementById("openMenu");
  const closeMenuBtn = document.getElementById("closeMenu");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.createElement("div");
  overlay.className = "overlay";
  document.body.appendChild(overlay);

  openMenuBtn.addEventListener("click", function () {
    sidebar.classList.add("open");
    overlay.classList.add("active");
  });

  closeMenuBtn.addEventListener("click", function () {
    sidebar.classList.remove("open");
    overlay.classList.remove("active");
  });

  overlay.addEventListener("click", function () {
    sidebar.classList.remove("open");
    overlay.classList.remove("active");
  });
});

// تابع تبدیل اعداد انگلیسی به فارسی
function toPersianNum(num) {
    const persianNumbers = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
    return num.toString().replace(/\d/g, (digit) => persianNumbers[digit]);
  }
  
  // تبدیل تمام اعداد در صفحه
  document.addEventListener("DOMContentLoaded", function () {
    const walker = document.createTreeWalker(
      document.body,
      NodeFilter.SHOW_TEXT,
      null,
      false
    );
  
    let node;
    while ((node = walker.nextNode())) {
      node.textContent = node.textContent.replace(/\d+/g, (num) =>
        toPersianNum(num)
      );
    }
  });