/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";

class Alert {
    constructor() {
        // this.el = $( '.wrapRootWl' );
        this.defaults = {
            width: "",
            icon: "",
            displayDuration: 3000,// 3000,
            pos: ""
        }

        this.getAlert = this.getAlert.bind(this)
    }

    static info(message, title, options) {
        return this.getAlert("info", message, title, "fas fa-info-circle", options);
    }

    static warning(message, title, options) {
        return this.getAlert("warning", message, title, "fas fa-exclamation-triangle", options);
    }

    static error(message, title, options) {
        return this.getAlert("error", message, title, "fas fa-exclamation-circle", options);
    };

    static trash(message, title, options) {
        return this.getAlert("trash", message, title, "fas fa-trash-alt", options);
    };

    static success(message, title, options) {
        return this.getAlert("success", message, title, "fas fa-check-circle", options);
    };

    static getAlert(type, message, title, icon, options) {
        // console.log('Creating Alert...');  // console.log('This: ', this); // console.log('Defaults: ', this.defaults);
        let defaults = {
            width: "",
            icon: "",
            displayDuration: 3000,// 3000,
            pos: ""
        }

        var alertElem, messageElem, titleElem, iconElem, innerElem, _container;
        if (typeof options === "undefined") {
            options = {};
        }
        // options = $.extend({}, this.defaults, options);
        options = $.extend({}, defaults, options);

        if (!_container) {
            _container = $("#alerts");
            if (_container.length === 0) {
                _container = $("<ul>").attr("id", "alerts").appendTo($("body"));
            }
        }
        if (options.width) {
            _container.css({
                width: options.width
            });
        }
        alertElem = $("<li>").addClass("alert").addClass("alert-" + type);
        setTimeout(function() {
            alertElem.addClass('open');
        }, 1);
        if (icon) {
            iconElem = $("<i>").addClass(icon);
            alertElem.append(iconElem);
        }
        innerElem = $("<div>").addClass("alert-block");
        //innerElem = $("<i>").addClass("fa fa-times");
        alertElem.append(innerElem);
        if (title) {
            titleElem = $("<div>").addClass("alert-title").append(title);
            innerElem.append(titleElem); 
        }
        if (message) {
            messageElem = $("<div>").addClass("alert-message").append(message);
            //innerElem.append("<i class="fa fa-times"></i>");
            innerElem.append(messageElem);
            // innerElem.append("<em>Click to Dismiss</em>");
            // innerElemc = $("<i>").addClass("fa fa-times");
        }
        if (options.displayDuration > 0) { // console.log('Set TimeOut Leave...');
            setTimeout((function() {
                leave();
            }), options.displayDuration);
        } // else {
          //  innerElem.append("<em>Click to Dismiss</em>");
        // }
        innerElem.append("<em>Click to Dismiss</em>");
        
        alertElem.on("click", function() {
            leave();
        });
    
        function leave() {
            alertElem.removeClass('open');
            alertElem.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
                return alertElem.remove();
            });
        }
        return _container.prepend(alertElem);
    };
}

export default Alert;

/*
//
// Alerts
//
 var Alert = undefined;

 (function(Alert) {
    var alert, error, trash, info, success, warning, _container;
    info = function(message, title, options) {
       return alert("info", message, title, "fas fa-info-circle", options);
    };
    warning = function(message, title, options) {
       return alert("warning", message, title, "fas fa-exclamation-triangle", options);
    };
    error = function(message, title, options) {
       return alert("error", message, title, "fas fa-exclamation-circle", options);
    };
  
    trash = function(message, title, options) {
       return alert("trash", message, title, "fas fa-trash-alt", options);
    };
  
    success = function(message, title, options) {
       return alert("success", message, title, "fas fa-check-circle", options);
    };
    alert = function(type, message, title, icon, options) {
       var alertElem, messageElem, titleElem, iconElem, innerElem, _container;
       if (typeof options === "undefined") {
         options = {};
       }
       options = $.extend({}, Alert.defaults, options);
       if (!_container) {
         _container = $("#alerts");
         if (_container.length === 0) {
           _container = $("<ul>").attr("id", "alerts").appendTo($("body"));
         }
       }
       if (options.width) {
         _container.css({
           width: options.width
         });
       }
       alertElem = $("<li>").addClass("alert").addClass("alert-" + type);
       setTimeout(function() {
         alertElem.addClass('open');
       }, 1);
       if (icon) {
         iconElem = $("<i>").addClass(icon);
         alertElem.append(iconElem);
       }
       innerElem = $("<div>").addClass("alert-block");
       //innerElem = $("<i>").addClass("fa fa-times");
       alertElem.append(innerElem);
       if (title) {
         titleElem = $("<div>").addClass("alert-title").append(title);
         innerElem.append(titleElem);
         
       }
       if (message) {
         messageElem = $("<div>").addClass("alert-message").append(message);
         //innerElem.append("<i class="fa fa-times"></i>");
         innerElem.append(messageElem);
         // innerElem.append("<em>Click to Dismiss</em>");
         // innerElemc = $("<i>").addClass("fa fa-times");
   
       }
       if (options.displayDuration > 0) {
         setTimeout((function() {
           leave();
         }), options.displayDuration);
       } else {
         innerElem.append("<em>Click to Dismiss</em>");
       }
       alertElem.on("click", function() {
         leave();
       });
   
       function leave() {
         alertElem.removeClass('open');
         alertElem.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
           return alertElem.remove();
         });
       }
       return _container.prepend(alertElem);
     };
     Alert.defaults = {
       width: "",
       icon: "",
       displayDuration: 3000,
       pos: ""
     };
     Alert.info = info;
     Alert.warning = warning;
     Alert.error = error;
     Alert.trash = trash;
     Alert.success = success;
     return _container = void 0;
  
 })(Alert || (Alert = {}));
  
 this.Alert = Alert; */