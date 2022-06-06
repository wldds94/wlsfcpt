/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";

import WlHelper from "./helpers/helper.js";

class Modal {
    constructor(modalName = 'wl-modal', modalEvent = 'wlModalEvent', openCallback = 'openModalCallback', closeCallback = 'closeModalCallback') {
        this.el = $( '.wrapRootWl' );
 
        // Initialize all elements of modal
        this.showBtn = $(`[data-for-modal=\'${modalName}\']`)
        this.modalWrapper = $(`[data-modal=\'${modalName}\']`)
        this.closeBtn = $(`[data-off-modal=\'${modalName}\']`)


        this.listeners(modalEvent, openCallback, closeCallback);
        this.init();
    }
 
    init() {
        // eslint-disable-next-line no-console
        console.info( 'Modal Initialized' );
    }
 
    listeners(modalEvent, openCallback, closeCallback) {
        this.showBtn.on('click', this.showModal.bind({instance: this, modalEvent: modalEvent, callback: openCallback}))
        this.closeBtn.on('click', this.hideModal.bind({instance: this, modalEvent: modalEvent, callback: closeCallback}))
    }

    showModal(event) {
        // console.log(event); console.log(this.instance);
        WlHelper.cleanEvent(event)
        console.log('Open Modal checking...');
        
        // Create the container to trigger event // console.log('El: ', this.instance.el);
        this.instance.toggleModal(this.modalEvent, this.callback)
        // $(`<div id="${this.modalEvent}"></div>`).appendTo(this.instance.el)
        // // Then open the modal
        // $(`#${this.modalEvent}`).trigger(this.callback)
        // this.instance.modalWrapper.addClass('open')
        // $(`#${this.modalEvent}`).remove()
    }
    
    hideModal(event) {
        WlHelper.cleanEvent(event)
        console.log('Close Modal...');

        this.instance.toggleModal(this.modalEvent, this.callback)

    }

    toggleModal(modalEvent, callback, classModalOpen = 'open') { // console.log(this);
        $(`<div id="${modalEvent}"></div>`).appendTo(this.el)
        $(`#${modalEvent}`).trigger(callback)
        // if (state == 'open') {
        //     this.modalWrapper.addClass('open')
        // } else {
        //     this.modalWrapper.removeClass('open')
        // }
        this.modalWrapper.toggleClass(classModalOpen)
        $(`#${modalEvent}`).remove()
    }
}
 
export default Modal;