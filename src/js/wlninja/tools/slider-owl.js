/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";
// import 'owl.carousel/dist/assets/owl.carousel.css';
// import 'owl.carousel';
// var owlCarousel = require('owl.carousel')($);

// import Wlhelper from "../helpers/helper";

class SliderOwl {

    constructor() {
        this.body = $('body')

        this.init()

        this.listeners()
    }

    init() {
        console.log('SliderOwl Initialized...');

        /** Height Image Slider */
        let sliders = $('#image-slider img')
        let maxHg = 0
        sliders.each(function(key, value) {
            let valueHg = $(value).outerHeight()
            if( valueHg > maxHg ) {
                maxHg = valueHg
            }
        })
        $('#image-slider').find('ul').css('height', maxHg);
        // console.log(maxHg);

        /* Thumbails */
        let thumbailsCounter = $('#thumbnail li').length
        let imgWidth = $('#image-slider').width()
        console.log(imgWidth);
        var ThumbailsWidth = 90
        if(thumbailsCounter > 6) {
            ThumbailsWidth = ( ( imgWidth > 540 ? imgWidth : 540 ) - 18.5) / 7;
        }
        $('#thumbnail li').find('img').css('width', ThumbailsWidth);

        // this.startCarousel()
    }

    listeners() {
        // code
        if (this.body) {
            this.body.on('click', '#thumbnail li', this.selectImage)
        }
    }

    // Select Image -> Active Slider
    selectImage(event) {
        event.preventDefault()

        var thisIndex = $(this).index()
        
        let imgSlider = $("#image-slider")

        if(thisIndex < $('#thumbnail li.active').index()){
            prevImage(thisIndex, imgSlider);
        } else if(thisIndex > $('#thumbnail li.active').index()){
            nextImage(thisIndex, imgSlider);
        }
            
        $('#thumbnail li.active').removeClass('active');
        $(this).addClass('active');


        function nextImage(newIndex, parent){
            var width = $('#image-slider').width();
            parent.find('li').eq(newIndex).addClass('next-img').css('left', width).animate({left: 0},600);
            parent.find('li.active-img').removeClass('active-img').css('left', '0').animate({left: -width},600);
            parent.find('li.next-img').attr('class', 'active-img');
        }
        function prevImage(newIndex, parent){
            var width = $('#image-slider').width();
            parent.find('li').eq(newIndex).addClass('next-img').css('left', -width).animate({left: 0},600);
            parent.find('li.active-img').removeClass('active-img').css('left', '0').animate({left: width},600);
            parent.find('li.next-img').attr('class', 'active-img');
        }
    }

    // Carousel Main
    startCarousel() {
        // $('#thumbnail li').click(function(){
        //     var thisIndex = $(this).index()
                
        //     if(thisIndex < $('#thumbnail li.active').index()){
        //         prevImage(thisIndex, $(this).parents("#thumbnail").prev("#image-slider"));
        //     } else if(thisIndex > $('#thumbnail li.active').index()){
        //         nextImage(thisIndex, $(this).parents("#thumbnail").prev("#image-slider"));
        //     }
                
        //     $('#thumbnail li.active').removeClass('active');
        //     $(this).addClass('active');
    
        // });
        
        
        // function nextImage(newIndex, parent){
        //     var width = $('#image-slider').width();
        //     parent.find('li').eq(newIndex).addClass('next-img').css('left', width).animate({left: 0},600);
        //     parent.find('li.active-img').removeClass('active-img').css('left', '0').animate({left: -width},600);
        //     parent.find('li.next-img').attr('class', 'active-img');
        // }
        // function prevImage(newIndex, parent){
        //     var width = $('#image-slider').width();
        //     parent.find('li').eq(newIndex).addClass('next-img').css('left', -width).animate({left: 0},600);
        //     parent.find('li.active-img').removeClass('active-img').css('left', '0').animate({left: width},600);
        //     parent.find('li.next-img').attr('class', 'active-img');
        // }
        
        // /* Thumbails */
        // var ThumbailsWidth = ($('#image-slider').width() - 18.5)/7;
        // $('#thumbnail li').find('img').css('width', ThumbailsWidth);
        
    }

}

export default SliderOwl