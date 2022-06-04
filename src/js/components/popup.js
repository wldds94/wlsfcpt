/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";

class WlsfcptDimensions {

    constructor() {
        this.body = $('body')
        this.popup = this.body.find('#wlsf-popup-container')
        this.isClosed = false

        this.listeners()

        this.init()
    }

    init() {
        console.log('WlsfcptPopup Initialized...');
    }

    listeners() {
        if (this.body && this.popup) {
            this.popup.on('click', '.sticky-ads-close', this.closePopUp.bind(this))
        }
    }

    closePopUp(e) {
        e.preventDefault()
        e.stopImmediatePropagation()

        $("#wlsf-popup-container").css("display", "none");
        this.isClosed = true;
    }
}

export default WlsfcptDimensions