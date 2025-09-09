$(document).ready(function () {
  // متن اصلی و دکمه را انتخاب کنید
  const mainText = $("#main-text");
  const toggleButton = $("#show-txt");

  // متن کامل را ذخیره کنید
  const fullText = mainText.text().trim();

  // متن خلاصه را با استفاده از CSS مدیریت کنید
  const shortText = fullText;

  // وضعیت نمایش متن (در ابتدا خلاصه است)
  let isFullTextVisible = false;

  // رویداد کلیک برای دکمه
  toggleButton.on("click", function () {
    if (isFullTextVisible) {
      // اگر متن کامل نمایش داده شده باشد، به حالت خلاصه بازگردید
      mainText.css({
        "-webkit-line-clamp": "7",
        overflow: "hidden",
      });

      mainText.removeClass("hide-after");
      toggleButton.text("مشاهده کامل متن");
      isFullTextVisible = false;
    } else {
      // اگر متن خلاصه نمایش داده شده باشد، کل متن را نمایش دهید
      mainText.css({
        "-webkit-line-clamp": "unset",
        overflow: "visible",
      });
      mainText.addClass("hide-after");

      toggleButton.text("مشاهده متن خلاصه");
      isFullTextVisible = true;
    }
  });
});