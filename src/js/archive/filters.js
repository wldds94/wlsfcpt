/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";
import Wlhelper from "./../wlninja/helpers/helper";

class WlsfcptFilter {

    constructor() {
        this.el = $('body')

        this.listeners()

        this.init()
    }

    init() {
        console.log('WlsfcptFilter Initialized...');

        let hashtag = $(location).attr('hash').substring(1)
        let linkToActive = hashtag ? $(`.nav.nav-tabs li[data-slug=${hashtag}]`) : $('.nav.nav-tabs li.no-filter')
        linkToActive.trigger('click')
        // console.log('Hashtag: ', hashtag)
        // console.log('Hashtag: ', hashtag, 'Link', linkToActive);
    }

    listeners() {
        if (this.el) {
            this.el.on('click', '.nav.nav-tabs li', this.filterArchive)
        }
    }

    async filterArchive(event) {
        console.log('WlsfcptFilter Filtering...');
        Wlhelper.cleanEvent(event)

        let slugFilter = $(event.target).data('slug')
        window.location.hash = '#' + slugFilter

        $('.nav.nav-tabs li').removeClass('active')
        $(event.target).closest('li').addClass('active')

        let prodCards = $('.wlsfcpt-single-card-archive')

        prodCards.each( function(key, value) { 
            $(value).addClass('d-none')
        })

        prodCards.each( function(key, value) { 
            setTimeout(function(){
                let slugContainer = $(value).data('slug')
                if ( slugFilter != '' && slugContainer != slugFilter) {
                    $(value).addClass('d-none')
                } 
                else {
                    $(value).removeClass('d-none')
                }
            }, 150 * key);
            
        })
        // prodCards.each( function(key, value) { // console.log(key, value);
        //     let slugContainer = $(value).data('slug')
        //     // console.log('Slug: ', $(value).data('slug'));
        //     if ( slugFilter != '' && slugContainer != slugFilter) {
        //         $(value).addClass('d-none')
        //     } else {
        //         $(value).removeClass('d-none')
        //     }
        // })
    }
}

export default WlsfcptFilter