/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";
import Wlhelper from "./../wlninja/helpers/helper";

class WlsfcptDimensions {

    constructor() {
        this.body = $('body')
        this.el = this.body.find('.wlsfcpt-primary-archive.wl-set-JS')
        this.footer = this.body.find('#footer-outer')

        this.listeners()

        this.init()
    }

    init() {
        console.log('WlsfcptDimensions Initialized...');

        if (this.el && this.footer) {
            let footerHg = this.footer.outerHeight()
            this.el.css({
                'margin-bottom': footerHg,
                'padding-top': 0
            })
        }
    }

    listeners() {
        if (this.el && this.footer) {
            // code
        }
    }

}

export default WlsfcptDimensions