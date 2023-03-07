// use Swiper with webpack and symfony
import Swiper, { Navigation, Pagination, Autoplay } from 'swiper';

// import Swiper styles
import 'swiper/swiper-bundle.css';

// configure Swiper to use modules
Swiper.use([Navigation, Pagination, Autoplay]);

const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    speed: 500,
    autoplay: {
        delay: 2000,
    },
    grabCursor: true,
    slidesPerView: 1,
    spaceBetween: 0,
  
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
        clickable: true,
        enabled: true,
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
        enabled: true,
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  });

swiper.init();