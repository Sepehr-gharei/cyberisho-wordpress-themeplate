document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("custom-comment-form");
    if (!form) return;

    // پیدا کردن URL admin-ajax.php از طریق دیتا-اتریبیوت
    const ajaxUrl = form.getAttribute("data-ajax-url");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const responseDiv = document.getElementById("ajax-response");

        // ارسال با fetch
        fetch(ajaxUrl + "?action=custom_ajax_comment", {
            method: "POST",
            body: formData,
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            console.log("داده دریافتی:", data); // ✅ مهم!
            if (data.success) {
                responseDiv.innerHTML = `<div class="success">${data.data.message}</div>`;
                form.reset();
                setTimeout(() => {
                    window.location.href = data.data.permalink + "#comment-" + data.data.comment_id;
                }, 1000);
            } else {
                responseDiv.innerHTML = `<div class="error">${data.data}</div>`;
            }
        })
        .catch(function (error) {
            console.error("AJAX Error:", error);
            responseDiv.innerHTML = `<div class="error">خطایی رخ داده است. لطفاً دوباره تلاش کنید.</div>`;
        });
    });
});



