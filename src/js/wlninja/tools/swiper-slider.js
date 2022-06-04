/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";

// Swiper Js Modules
// import Swiper, { Navigation, Pagination } from 'swiper';
// import Swiper from 'swiper';
const Swiper = require('./../../../../node_modules/swiper/swiper-bundle');
// // Style
// import 'swiper/css';
// import 'swiper/css/navigation';
// import 'swiper/css/pagination';
// var owlCarousel = require('owl.carousel')($);

// import Wlhelper from "../helpers/helper";

class SwiperSlider {

    constructor() {

        this.init()

        this.listeners()
    }

    init() {
        console.log('SliderSwiper Initialized...');

        // code
        this.swiper  = new Swiper('.swiper-container', {
            // Optional parameters
            loop: true,
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            dynamicBullets: true,
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
            watchOverflow: false,
            watchSlidesVisibility: false
        })
    }

    listeners() {
        // code
    }

}

export default SwiperSlider