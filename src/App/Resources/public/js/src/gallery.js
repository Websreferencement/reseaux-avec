(function($){

$.fn.gallery = function()
{
    var self = this;

    var options = {
        blackframe: {
            el: '<div id="blackframe"></div>',
            jq: '#blackframe',
            css: {
                'display': 'none',
                'position': 'fixed',
                'top': '0px',
                'left': '0px',
                'background-color': 'rgba(0, 0, 0, 0.7)',
            }
        },
        spin: {
            lines: 11, // The number of lines to draw
            length: 29, // The length of each line
            width: 7, // The line thickness
            radius: 18, // The radius of the inner circle
            corners: 0, // Corner roundness (0..1)
            rotate: 0, // The rotation offset
            direction: 1, // 1: clockwise, -1: counterclockwise
            color: '#fff', // #rgb or #rrggbb
            speed: 1, // Rounds per second
            trail: 60, // Afterglow percentage
            shadow: true, // Whether to render a shadow
            hwaccel: false, // Whether to use hardware acceleration
            className: 'spinner', // The CSS class to assign to the spinner
            zIndex: 2e9, // The z-index (defaults to 2000000000)
            top: 'auto', // Top position relative to parent in px
            left: 'auto' // Left position relative to parent in px   
        },
        spinner: null,
        activate: false,
        timmer: {
            isLoad: false,
            time: null
        },
        id: '#'+self.attr('id')
    };

    console.log(options.id);

    var activeBlackframe = function(callback){
        $('body')
            .append(options.blackframe.el);

        var bframe = $(options.blackframe.jq);

        bframe
            .css(options.blackframe.css)
            .width($(window).width())
            .height($(window).height())
            .fadeIn('slow', callback);
    }

    var disabledBlackframe = function(callback){
        bframe.fadeOut('slow', function(){
            bframe.remove();
            if (typeof(callback) == 'function') {
                callback();
            }
        })
    }

    var activeLoader = function(callback) {
        options.spinner.spin($(options.blackframe.jq)[0]);
        callback();
    }

    var disabledLoader = function(callback) {
        $(options.spinner.el).fadeOut('slow', function(){
            options.spinner.stop();
            if (typeof(callback) == 'function') {
                callback();
            }
        });
    }

    var blackframe = function(init, callback) {
       if (init) {
           activeBlackframe(callback);
       } else {
            disabledBlackframe(callback);
       }
    }

    var load = function(init, callback) {
        if (init) {
            options.spinner = new Spinner(options.spin);
            activeLoader(callback);
        } else {
            disabledLoader(callback);
        }
    }
    
    // bind events :
    $(options.id + ' .img-thumb').click(function(){
        if ($(this).data('type') == 'video') {
            var content = new (function(){
                this.complete = true;
            });
        } else {
            var content = new Image();
            content.src = $(this).data('src');
            console.log(content.src);
        }
        blackframe(true, function(){
            load(true, function(){
                options.timmer.time = window.setInterval(function(){
                    if (content.complete) {
                        clearInterval(options.timmer.time);
                        load(false, function(){
                            console.log('OK !');
                        });
                    }            
                }, 10);
            });
        });
    });
}

})( jQuery );
