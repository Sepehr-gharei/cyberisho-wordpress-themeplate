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



  
document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector('.belog-title-section .programming-fields');
  const items = document.querySelectorAll('.belog-title-section .programming-fields .blog-scroll-content .item');
  const imageContainers = document.querySelectorAll('.belog-title-section .programming-fields .image-container');

  items.forEach(item => {
    item.addEventListener('click', () => {
      items.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      const itemNumber = item.id.split('-')[1];
      const targetContainer = container.querySelector(`#content-${itemNumber}`);
      imageContainers.forEach(container => container.classList.remove('active-content'));
      targetContainer.classList.add('active-content');
    });
  });
});




document.addEventListener("DOMContentLoaded", () => {
  const tickerContainer = document.querySelector(".ticker-container");
  let tickerContents = document.querySelectorAll(".ticker-content");

  // Function to clone and append the last ticker-content
  function appendNewTickerContent() {
    const lastTickerContent = tickerContents[tickerContents.length - 1];
    const newTickerContent = lastTickerContent.cloneNode(true);
    tickerContainer.appendChild(newTickerContent);
    tickerContents = document.querySelectorAll(".ticker-content"); // Update the NodeList
  }

  // Function to handle animation end
  function handleAnimationEnd(event) {
    if (event.target === tickerContents[0]) {
      // Remove the first ticker-content
      event.target.remove();
      tickerContents = document.querySelectorAll(".ticker-content"); // Update the NodeList

      // Append a new copy of the last ticker-content
      appendNewTickerContent();
    }
  }

  // Add animationend event listener to all ticker-content elements
  tickerContents.forEach((content) => {
    content.addEventListener("animationend", handleAnimationEnd);
  });

  // Ensure there’s always a second ticker-content to start with
  if (tickerContents.length === 1) {
    appendNewTickerContent();
  }
});


document.addEventListener("DOMContentLoaded", function () {
  const tickerContent = document.getElementById("tickerContent");
  const tickerItems = tickerContent.querySelectorAll(".ticker-item");
  const itemCount = tickerItems.length;

  // اگر تعداد آیتم‌ها 5 یا کمتر باشد، محتوا را دو برابر کن
  if (itemCount <= 10) {
    tickerContent.innerHTML += tickerContent.innerHTML;
  }
});

