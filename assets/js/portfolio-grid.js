document.addEventListener('DOMContentLoaded', function() {
    const gridSection = document.querySelector('.grid-section');
    let items = Array.from(gridSection.querySelectorAll('.item'));
    let currentPortfolioIndex = totalPortfolios >= 11 ? 11 : 0; // اگر کمتر، از تکرار استفاده می‌کنیم
    let itemCount = getItemCount(); // responsive

    // تابع برای گرفتن تعداد ایتم بر اساس عرض
    function getItemCount() {
        return window.innerWidth < 992 ? 5 : 11;
    }

    // تنظیم اولیه تعداد ایتم‌ها (اگر نیاز به حذف/اضافه)
    function adjustItemCount() {
        const newCount = getItemCount();
        if (items.length > newCount) {
            // حذف ایتم‌های اضافی
            for (let i = items.length - 1; i >= newCount; i--) {
                items[i].remove();
            }
            items = items.slice(0, newCount);
        } else if (items.length < newCount && totalPortfolios > items.length) {
            // اضافه کردن ایتم‌های جدید
            for (let i = items.length; i < newCount; i++) {
                const newItem = createNewItem(i);
                gridSection.appendChild(newItem);
                items.push(newItem);
            }
        } else if (items.length < newCount) {
            // اگر کمتر، رندوم تکرار
            for (let i = items.length; i < newCount; i++) {
                const randomIndex = Math.floor(Math.random() * totalPortfolios);
                const portfolio = allPortfolios[randomIndex];
                const newItem = createItemFromPortfolio(portfolio, getRandomOpacityClass());
                gridSection.appendChild(newItem);
                items.push(newItem);
            }
        }
    }

    // تابع ایجاد ایتم جدید از پورتفولیو
    function createItemFromPortfolio(portfolio, opacityClass) {
        const item = document.createElement('div');
        item.classList.add('item', opacityClass);
        item.innerHTML = `
            <div class="fa-name"><p>${portfolio.name}</p></div>
            <div class="space">|</div>
            <div class="en-name"><p>${portfolio.url}</p></div>
        `;
        return item;
    }

    // کلاس opacity رندوم
    function getRandomOpacityClass() {
        const classes = ['dark-opacity', 'medium-opacity', 'light-opacity'];
        return classes[Math.floor(Math.random() * classes.length)];
    }

    // ایجاد ایتم جدید با data-index
    function createNewItem(index) {
        const randomClass = getRandomOpacityClass();
        const item = document.createElement('div');
        item.classList.add('item', randomClass);
        item.dataset.index = index;
        // محتوای اولیه (از allPortfolios اگر موجود، иначе رندوم)
        const portfolio = allPortfolios[index % totalPortfolios];
        item.innerHTML = `
            <div class="fa-name"><p>${portfolio.name}</p></div>
            <div class="space">|</div>
            <div class="en-name"><p>${portfolio.url}</p></div>
        `;
        return item;
    }

    // مدیریت انیمیشن برای هر ایتم
    function animateItems() {
        items.forEach(item => {
            item.addEventListener('transitionend', handleTransitionEnd);
            // بسته به opacity فعلی، جهت انیمیشن تعیین کن
            const currentOpacity = parseFloat(window.getComputedStyle(item).opacity);
            if (currentOpacity > 0.5) {
                // پررنگ: fade out به 0
                item.style.opacity = 0;
            } else {
                // کم‌رنگ: fade in به 1
                item.style.opacity = 1;
            }
        });
    }

    // وقتی transition تمام شد
    function handleTransitionEnd(event) {
        if (event.propertyName !== 'opacity') return;
        const item = event.target;
        const newOpacity = parseFloat(window.getComputedStyle(item).opacity);

        if (newOpacity === 0) {
            // وقتی به 0 رسید، محتوا عوض کن و fade in به 1 شروع کن
            replaceContent(item);
            item.style.opacity = 1;
        } else if (newOpacity === 1) {
            // وقتی به 1 رسید، بعد از تاخیر کوتاه، fade out شروع کن
            setTimeout(() => {
                item.style.opacity = 0;
            }, 1000); // تاخیر اختیاری برای ماندن در 1
        }
    }

    // جایگزینی محتوا با نمونه کار بعدی
    function replaceContent(item) {
        // اگر همه نشان داده شد، از اول یا رندوم
        if (currentPortfolioIndex >= totalPortfolios) {
            currentPortfolioIndex = Math.floor(Math.random() * totalPortfolios); // رندوم اگر تمام شد
        }
        const nextPortfolio = allPortfolios[currentPortfolioIndex % totalPortfolios];
        currentPortfolioIndex++;

        item.querySelector('.fa-name p').textContent = nextPortfolio.name;
        item.querySelector('.en-name p').textContent = nextPortfolio.url;

        // کلاس‌ها را حذف/اضافه برای ریست (اختیاری)
        item.classList.remove('dark-opacity', 'medium-opacity', 'light-opacity');
        item.classList.add('light-opacity'); // شروع از کم‌رنگ بعد از جایگزینی
    }

    // تنظیم اولیه
    adjustItemCount();
    animateItems();

    // مدیریت resize برای responsive
    window.addEventListener('resize', () => {
        const newCount = getItemCount();
        if (items.length !== newCount) {
            adjustItemCount();
            animateItems(); // ریست انیمیشن
        }
    });
});