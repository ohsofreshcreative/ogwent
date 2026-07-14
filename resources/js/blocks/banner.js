import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const animateSlideContent = (activeSlide) => {
    if (!activeSlide) return;

    const title = activeSlide.querySelector('.__title');
    const header = activeSlide.querySelector('.__header');
    const button = activeSlide.querySelector('.m-btn');
    const image = activeSlide.querySelector('.__image');

    const allSlides = activeSlide.parentElement.querySelectorAll('.swiper-slide');
    allSlides.forEach((slide) => {
        if (slide !== activeSlide) {
            gsap.killTweensOf([
                slide.querySelector('.__title'), 
                slide.querySelector('.__header'), 
                slide.querySelector('.m-btn'), 
                slide.querySelector('.__image')
            ]);
        }
    });

    const tl = gsap.timeline();

    // Napisy wjeżdżają z lewej strony jeden po drugim (stagger)
    const animElements = [title, header, button].filter(Boolean);
    if (animElements.length > 0) {
        tl.fromTo(
            animElements,
            { opacity: 0, x: -80, filter: 'blur(5px)' },
            {
                opacity: 1,
                x: 0,
                filter: 'blur(0px)',
                duration: 0.9,
                stagger: 0.12,
                ease: 'back.out(1.2)', // Lekkie sprężynowanie na końcu
                overwrite: 'auto'
            }
        );
    }

    // Zdjęcie wjeżdża z prawej strony z efektem blura
    if (image) {
        gsap.fromTo(
            image,
            { opacity: 0, x: 80, filter: 'blur(10px)' },
            {
                opacity: 1,
                x: 0,
                filter: 'blur(0px)',
                duration: 1.2,
                ease: 'power2.out',
                overwrite: 'auto'
            }
        );
    }
};

const initSliderSwiper = (scope = document) => {
    const swiperElements = scope.querySelectorAll(
        '.banner-slider:not(.swiper-initialized)'
    );

    if (!swiperElements.length) return;

    swiperElements.forEach((swiperEl) => {
        const section = swiperEl.closest('section') || scope;
        const nextEl = section.querySelector('.__next');
        const prevEl = section.querySelector('.__prev');

        new Swiper(swiperEl, {
            modules: [Navigation],
            loop: true,
            grabCursor: false,
            centeredSlides: false,
            slidesPerView: 1,
            spaceBetween: 0,
            navigation: {
                nextEl: nextEl,
                prevEl: prevEl,
            },
            on: {
                init: function (swiper) {
                    const activeSlide = swiper.slides[swiper.activeIndex];
                    animateSlideContent(activeSlide);
                },
                slideChangeTransitionStart: function (swiper) {
                    const activeSlide = swiper.slides[swiper.activeIndex];
                    animateSlideContent(activeSlide);
                },
            },
        });
    });
};

// odpalenie
initSliderSwiper();

if (window.acf) {
    window.acf.addAction('render_block', (el) => {
        const node = el?.[0] ?? el;
        if (node) initSliderSwiper(node);
    });
}

export default initSliderSwiper;