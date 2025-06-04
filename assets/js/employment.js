


// باز و بسته کردن منو
document
  .querySelector(".select-box")
  .addEventListener("click", function () {
    this.parentElement.classList.toggle("open");
  });

// انتخاب گزینه
document.querySelectorAll(".options li").forEach(function (item) {
  item.addEventListener("click", function () {
    const value = this.getAttribute("data-value");
    const text = this.textContent;
    this.parentElement.previousElementSibling.textContent = text;
    this.parentElement.parentElement.querySelector(
      'input[name="job_role"]'
    ).value = value;
    this.parentElement.parentElement.classList.remove("open");
  });
});

// بستن منو با کلیک خارج از آن
document.addEventListener("click", function (e) {
  if (!e.target.closest(".custom-select")) {
    document
      .querySelectorAll(".custom-select")
      .forEach(function (select) {
        select.classList.remove("open");
      });
  }
});
const fileInput = document.getElementById("file_upload");
const fileNameDisplay = document.getElementById("file_name");

fileInput.addEventListener("change", function () {
  const file = fileInput.files[0];
  const allowedExtensions = ["pdf", "jpg", "png", "doc", "docx"];
  const maxSize = 2 * 1024 * 1024; // 2 مگابایت

  if (file) {
    const fileExtension = file.name.split(".").pop().toLowerCase();
    if (
      allowedExtensions.includes(fileExtension) &&
      file.size <= maxSize
    ) {
      fileNameDisplay.textContent = `فایل انتخاب شده: ${file.name}`;
      fileNameDisplay.classList.remove("error");
    } else {
      fileNameDisplay.textContent =
        "خطا: فایل نامعتبر است. پسوند مجاز: pdf، jpg، png، word و حداکثر حجم 2 مگابایت.";
      fileNameDisplay.classList.add("error");
      fileInput.value = ""; // پاک کردن فایل انتخاب شده
    }
  } else {
    fileNameDisplay.textContent =
      "پسوند مجاز: pdf، jpg، png، word و حداکثر حجم مجاز 2 مگابایت می‌باشد.";
    fileNameDisplay.classList.remove("error");
  }
});