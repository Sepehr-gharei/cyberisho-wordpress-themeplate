// Function to handle form submission with frontend validation
function handleFormSubmit(formId, action, hasFileUpload = false) {
  $(formId).on('submit', function(e) {
      e.preventDefault();
      let submitButton = $(this).find('input[type="submit"]');
      let originalButtonText = submitButton.val();
      submitButton.prop('disabled', true).val('در حال ارسال...');

      // ==============================
      // 🚨 FRONTEND VALIDATION
      // ==============================
      let isValid = true;
      let errorMessage = '';
      // Common fields (used in most forms)
      const nameInput = $(this).find('input[name="name"]');
      const phoneInput = $(this).find('input[name="phone"]');
      // Validate name
      if (nameInput.length && !nameInput.val().trim()) {
          errorMessage = 'نام الزامی است!';
          isValid = false;
      }
      // Validate phone (Iranian format: 09XXXXXXXXX or +989XXXXXXXXX)
      if (phoneInput.length) {
          let phone = phoneInput.val().replace(/\D/g, '');
          if (!phone) {
              errorMessage = 'شماره تماس الزامی است!';
              isValid = false;
          } else if (!/^09\d{9}$/.test(phone) && !/^\+989\d{9}$/.test(phone)) {
              errorMessage = 'لطفاً یک شماره تلفن معتبر ایرانی وارد کنید.';
              isValid = false;
          }
      }
      // Specific validations per form type
      if (formId === '#contact-form-id') {
          const emailInput = $(this).find('input[name="email"]');
          const messageInput = $(this).find('textarea[name="message-content"]');
          if (emailInput.length && !emailInput.val().trim()) {
              errorMessage = 'ایمیل الزامی است!';
              isValid = false;
          } else if (emailInput.length && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.val())) {
              errorMessage = 'لطفاً یک ایمیل معتبر وارد کنید.';
              isValid = false;
          }
          if (messageInput.length && !messageInput.val().trim()) {
              errorMessage = 'متن پیام الزامی است!';
              isValid = false;
          }
      } else if (formId === '#meeting-form-id' || formId === '#new-meeting-form-id') {
          // Only name and phone are required (already validated above)
      } else if (formId === '#inperson-meeting-form-id') {
          const cityInput = $(this).find('input[name="city"]');
          if (cityInput.length && !cityInput.val().trim()) {
              errorMessage = 'شهر الزامی است!';
              isValid = false;
          }
      } else if (formId === '#job-application-form-id') {
          const emailInput = $(this).find('input[name="email"]');
          const jobInput = $(this).find('select[name="job_position"]');
          const descriptionInput = $(this).find('textarea[name="description"]');
          const fileInput = $(this).find('input[name="resume"]');
          if (emailInput.length && !emailInput.val().trim()) {
              errorMessage = 'ایمیل الزامی است!';
              isValid = false;
          } else if (emailInput.length && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.val())) {
              errorMessage = 'لطفاً یک ایمیل معتبر وارد کنید.';
              isValid = false;
          }
          if (jobInput.length && jobInput.val() === '') {
              errorMessage = 'ردیف شغلی الزامی است!';
              isValid = false;
          }
          if (descriptionInput.length && !descriptionInput.val().trim()) {
              errorMessage = 'توضیحات الزامی است!';
              isValid = false;
          }
          if (fileInput.length && fileInput[0].files.length === 0) {
              errorMessage = 'فایل رزومه الزامی است!';
              isValid = false;
          }
      }
      // If any field validation failed
      if (!isValid) {
          showCustomAlertRed(errorMessage);
          submitButton.prop('disabled', false).val(originalButtonText);
          return;
      }
      // ==============================
      // 🧩 reCAPTCHA Validation (Only for job application form)
      // ==============================
      if (formId === '#job-application-form-id') {
          let recaptchaResponse = grecaptcha.getResponse();
          if (!recaptchaResponse) {
              showCustomAlertRed('لطفا reCAPTCHA را تکمیل کنید.');
              submitButton.prop('disabled', false).val(originalButtonText);
              return;
          }
      }
      // ==============================
      // 📤 Prepare FormData
      // ==============================
      let formData;
      if (hasFileUpload) {
          formData = new FormData(this);
      } else {
          formData = $(this).serialize();
      }
      // Append reCAPTCHA response for job application form only
      if (formId === '#job-application-form-id') {
          let recaptchaResponse = grecaptcha.getResponse();
          if (hasFileUpload) {
              formData.append('g-recaptcha-response', recaptchaResponse);
          } else {
              formData += '&g-recaptcha-response=' + recaptchaResponse;
          }
      }
      // Append action and nonce
      if (!hasFileUpload) {
          formData += '&action=' + action + '&nonce=' + ajax_object.nonce;
      } else {
          formData.append('action', action);
          formData.append('nonce', ajax_object.nonce);
      }
      // ==============================
      // 🔌 AJAX Request
      // ==============================
      $.ajax({
          url: ajax_object.ajax_url,
          type: 'POST',
          data: formData,
          processData: hasFileUpload ? false : true,
          contentType: hasFileUpload ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
          success: function(response) {
              console.log('AJAX Success Response:', response);
              if (response.success) {
                  let message = response.data;
                  if (typeof message === 'object' && message !== null) {
                      message = message.message || 'عملیات با موفقیت انجام شد.';
                  }
                  showCustomAlert(message);
                  // Reset form and reCAPTCHA for job application form only
                  $(formId)[0].reset();
                  if (formId === '#job-application-form-id') {
                      grecaptcha.reset();
                  }
                  // Reset file name display for job application
                  if (hasFileUpload) {
                      $('#file_name').text('پسوند مجاز: pdf، jpg، png، word و حداکثر حجم مجاز 2 مگابایت می‌باشد.');
                  }
              } else {
                  let errorMessage = response.data;
                  if (typeof errorMessage === 'object' && errorMessage !== null) {
                      errorMessage = errorMessage.message || 'خطای ناشناخته';
                  }
                  if (typeof errorMessage === 'string') {
                      showCustomAlertRed(errorMessage);
                  } else {
                      showCustomAlertRed('خطای ناشناخته. لطفاً دوباره تلاش کنید.');
                  }
              }
              submitButton.prop('disabled', false).val(originalButtonText);
          },
          error: function(xhr, status, error) {
              console.error('AJAX Error:', status, error);
              showCustomAlertRed('خطایی در ارتباط با سرور رخ داد. لطفاً دوباره تلاش کنید.');
              submitButton.prop('disabled', false).val(originalButtonText);
          }
      });
  });
}