document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("custom-comment-form");
    if (!form) return;

    // خواندن URL از ویژگی data-ajax-url
    const ajaxUrl = form.getAttribute("data-ajax-url") || "/wp-admin/admin-ajax.php";

    // مدیریت ارسال فرم
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const responseDiv = document.getElementById("ajax-response");

        fetch(ajaxUrl + "?action=custom_ajax_comment", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                console.log("داده دریافتی:", data);
                if (data.success) {
                    responseDiv.innerHTML = `<div class="success">${data.data.message}</div>`;
                    form.reset();
                    document.getElementById("comment_parent").value = "0"; // ریست کردن فیلد پاسخ
                    document.querySelector('.comment-form-title p').textContent = 
                        "دیدگاه خود را بنویسید . نشانی ایمیل شما منتشر نخواهد شد";
                    setTimeout(() => {
                        window.location.href = data.data.permalink + "#comment-" + data.data.comment_id;
                    }, 1000);
                } else {
                    responseDiv.innerHTML = `<div class="error">${data.data}</div>`;
                }
            })
            .catch(error => {
                console.error("AJAX Error:", error);
                responseDiv.innerHTML = `<div class="error">خطایی رخ داده است. لطفاً دوباره تلاش کنید.</div>`;
            });
    });

    // مدیریت دکمه‌های پاسخ
    const replyLinks = document.querySelectorAll('.answer a[data-comment-id]');
    const commentFormTitle = document.querySelector('.comment-form-title p');

    replyLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const commentId = this.getAttribute("data-comment-id");
            const commentAuthor = this.getAttribute("data-comment-author");
            document.getElementById("comment_parent").value = commentId;

            // تغییر عنوان فرم برای نشان دادن پاسخ
            commentFormTitle.textContent = `در حال پاسخ به ${commentAuthor}`;

            // اسکرول به فرم و فوکوس روی textarea
            form.scrollIntoView({ behavior: "smooth" });
            document.getElementById("comment").focus();
        });
    });
});