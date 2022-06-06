/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";
import Wlhelper from "./../wlninja/helpers/helper";
import SliderOwl from "./../wlninja/tools/slider-owl";
import SwiperSlider from "./../wlninja/tools/swiper-slider";

class WlsfcptSingle {

    constructor() {
        // this.body = $('body')
        // this.el = this.body.find('.wlsfcpt-primary-archive.wl-set-JS')
        // this.footer = this.body.find('#footer-outer')

        // this.listeners()

        // this.init()
        const sldrOwl = new SliderOwl()
        const swiper = new SwiperSlider()
    }

    init() {
        console.log('WlsfcptSingle Initialized...');

        // new Carousel()
    }

    listeners() {
        if (this.el) {
            // code
        }
    }

}

export default WlsfcptSingle