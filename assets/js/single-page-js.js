// اشتراک گذاری در واتس‌اپ
function shareToWhatsApp(event) {
    event.preventDefault();
    const url = window.location.href;
    const text = document.title + " " + url;
    const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(
      text
    )}`;
    window.open(shareUrl, "_blank");
  }
  
  // اشتراک گذاری در تلگرام
  function shareToTelegram(event) {
    event.preventDefault();
    const url = window.location.href;
    const text = document.title;
    const shareUrl = `https://t.me/share/url?url=${encodeURIComponent(
      url
    )}&text=${encodeURIComponent(text)}`;
    window.open(shareUrl, "_blank");
  }
  
  // اشتراک گذاری در لینکدین
  function shareToLinkedIn(event) {
    event.preventDefault();
    const url = window.location.href;
    const shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(
      url
    )}`;
    window.open(shareUrl, "_blank");
  }
  
  // اشتراک گذاری در توییتر
  function shareToTwitter(event) {
    event.preventDefault();
    const url = window.location.href;
    const text = document.title;
    const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(
      url
    )}&text=${encodeURIComponent(text)}`;
    window.open(shareUrl, "_blank");
  }
  
  // کپی کردن لینک
  function copyCurrentURL() {
    const urlText = document.getElementById("url-display").innerText.trim();
    navigator.clipboard
      .writeText(urlText)
      .then(() => {
        showCustomAlert("لینک کپی شد ✅");
      })
      .catch(() => {
        showCustomAlertRed("خطا در کپی لینک ❌");
      });
  }
  
  // نمایش پیام قرمز
  function showCustomAlert(message) {
    const alertBox = document.getElementById("customAlert");
    const alertMessage = document.getElementById("alertMessage");
  
    alertMessage.textContent = message;
    alertBox.classList.remove("hidden");
  
    setTimeout(() => {
      alertBox.classList.add("hidden");
    }, 3000);
  }
  function showCustomAlertRed(message) {
      const alertBox = document.getElementById("customAlertRed");
      const alertMessage = document.getElementById("alertMessageRed");
    
      alertMessage.textContent = message;
      alertBox.classList.remove("hidden");
    
      setTimeout(() => {
        alertBox.classList.add("hidden");
      }, 3000);
    }
    
  