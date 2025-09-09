document
  .getElementById("file_upload")
  .addEventListener("change", function () {
    const fileInput = this;
    const fileNameDiv = document.getElementById("file_name");

    if (fileInput.files.length > 0) {
      const file = fileInput.files[0];
      const allowedExtensions = ["pdf", "jpg", "png", "doc", "docx"];
      const maxSize = 2 * 1024 * 1024; // 2MB

      const fileExtension = file.name.split(".").pop().toLowerCase();

      if (!allowedExtensions.includes(fileExtension)) {
        alert(
          "فایل انتخابی مجاز نیست. پسوند مجاز: pdf، jpg، png، doc، docx"
        );
        fileInput.value = ""; // پاک کردن انتخاب
        fileNameDiv.textContent =
          "پسوند مجاز: pdf، jpg، png، word و حداکثر حجم مجاز 2 مگابایت می‌باشد.";
        return;
      }

      if (file.size > maxSize) {
        alert("حجم فایل بیشتر از 2 مگابایت است.");
        fileInput.value = "";
        fileNameDiv.textContent =
          "پسوند مجاز: pdf، jpg، png، word و حداکثر حجم مجاز 2 مگابایت می‌باشد.";
        return;
      }

      // نمایش نام فایل
      fileNameDiv.textContent = file.name;
    } else {
      // اگر فایلی انتخاب نشد، متن پیش‌فرض برگرده
      fileNameDiv.textContent =
        "پسوند مجاز: pdf، jpg، png، word و حداکثر حجم مجاز 2 مگابایت می‌باشد.";
    }
  });