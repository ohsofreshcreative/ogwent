import Swiper from 'swiper';
import { Pagination, Navigation } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

const initSlider = () => {
  const sliders = document.querySelectorAll('.slider-carousel');
  if (!sliders.length) {
    return;
  }

  sliders.forEach((slider) => {
    new Swiper(slider, {
      modules: [Pagination, Navigation],
      loop: true,
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 1,
      spaceBetween: 32,
      pagination: {
        el: slider.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: slider.closest('.b-carousel').querySelector('.slider-carousel-next'),
        prevEl: slider.closest('.b-carousel').querySelector('.slider-carousel-prev'),
      },
      breakpoints: {
        320: {
          slidesPerView: 1.2,
        },
        580: {
          slidesPerView: 2.3,
        },
        767: {
          slidesPerView: 2.3,
        },
        992: {
          slidesPerView: 2.3,
        },
        1200: {
          slidesPerView: 3.2,
        },
        1400: {
          slidesPerView: 3.2,
        },
      },
    });
  });
};

initSlider();