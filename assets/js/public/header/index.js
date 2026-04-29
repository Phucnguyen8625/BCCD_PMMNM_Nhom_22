document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-banner__dot');
    let currentIndex = 0;
    let autoSlide;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });

        currentIndex = index;
    }

    function nextSlide() {
        const nextIndex = (currentIndex + 1) % slides.length;
        showSlide(nextIndex);
    }

    function startAutoSlide() {
        autoSlide = setInterval(nextSlide, 4000);
    }

    function resetAutoSlide() {
        clearInterval(autoSlide);
        startAutoSlide();
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', function () {
            showSlide(index);
            resetAutoSlide();
        });
    });

    if (slides.length > 0) {
        startAutoSlide();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const accountToggle = document.getElementById('accountToggle');
    const accountMenu = document.getElementById('accountMenu');

    if (accountToggle && accountMenu) {
        accountToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            accountMenu.classList.toggle('show');
            accountToggle.setAttribute(
                'aria-expanded',
                accountMenu.classList.contains('show') ? 'true' : 'false'
            );
        });

        document.addEventListener('click', function (e) {
            if (!accountMenu.contains(e.target) && !accountToggle.contains(e.target)) {
                accountMenu.classList.remove('show');
                accountToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
});