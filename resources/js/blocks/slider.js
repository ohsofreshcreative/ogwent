import Swiper from 'swiper';
import { Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';

const initSlider = () => {
  const sliders = document.querySelectorAll('.slider-standard');
  if (!sliders.length) {
    return;
  }

  sliders.forEach((slider) => {
    new Swiper(slider, {
      modules: [Pagination],
      loop: true,
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 1,
      spaceBetween: 24,
      pagination: {
        el: slider.querySelector('.swiper-pagination'),
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        580: {
          slidesPerView: 2,
        },
        767: {
          slidesPerView: 3,
        },
        992: {
          slidesPerView: 3.5,
        },
        1200: {
          slidesPerView: 4,
        },
        1400: {
          slidesPerView: 4.5,
        },
      },
    });
  });
};

initSlider();