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
        id: '#'+self.attr('id'),
        previewer: {
            el: '<div id="previewer"></div>',
            jq: '#previewer',
            css: {
                'position': 'absolute',
                'display': 'none',
                'background-color': 'rgba(0, 0, 0, 0.5)',
                'width': '960px',
                'text-align': 'center'
            },
            button: [
                '<button',
                'class="btn btn-inverse btn-small"',
                '>',
                'Fermer',
                '<i',
                'class="icon-remove icon-white"',
                '></i>',
                '</button>'
            ].join(' ')
        }
    };

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
        var bframe = $(options.blackframe.jq);
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

    var activePreviewer = function(resource, callback) {
        var previewBlock = $(options.previewer.el);
        previewBlock.appendTo('body');
        previewBlock.append(options.previewer.button); 
        options.previewer.css.left = $('.main-container').offset().left+'px';
        options.previewer.css.top = $(window).scrollTop()+10+'px';
        options.previewer.css.width = $('.main-container').width();
        if (resource.data('type') == 'video') {
            var content = $(resource.data('content'))
                .css({
                    'display': 'block',
                    'margin': 'auto',
                    'padding': '5px'
                });
        } else {
            var image = new Image();
            image.src = resource.data('src');
            var content = $('<img>')
                .attr('src', resource.data('src'))
                .css({
                    'display': 'block',
                    'width': image.width,
                    'height': image.heigth,
                    'margin': 'auto',
                    'padding': '5px'
                }); 
        }
        previewBlock.css(options.previewer.css)
            .append(content);
        previewBlock.slideDown('slow', function(){
            $(options.blackframe.jq).click(disabledPreviewer);
            $(options.previewer.jq+' .btn').click(disabledPreviewer);
        });
    }

    var disabledPreviewer = function(callback) {
        var h = $(options.previewer.jq).height();
        $(options.previewer.jq).height(h);
        var remove = function(){
            $(this).remove();
            $(options.previewer.jq).slideUp('slow', function(){
                $(this).remove();
                blackframe(false);
            });
        }
        $(options.previewer.jq).children().each(function(i){
            if (i == $(options.previewer.jq).children().length-1) {
                var cb = remove;
            } else {
                var cb = null;
            }
            $(this).slideUp('slow', cb);
        });
    }

    var preview = function(init, resource, callback) {
        if (init) {
            activePreviewer(resource, callback);
        } else {
            disabledPreviewer(callback);
        }
    }
    
    // bind events :
    $(options.id + ' .img-thumb').click(function(){
        var resource = $(this);
        if ($(this).data('type') == 'video') {
            var iframe = $(resource.data('content'));
            var content = new (function(){

                this.complete = false;
            });
            iframe.ready(function(){
                content.complete = true;
            });
        } else {
            var content = new Image();
            content.src = $(this).data('src');
        }
        blackframe(true, function(){
            load(true, function(){
                options.timmer.time = window.setInterval(function(){
                    if (content.complete) {
                        clearInterval(options.timmer.time);
                        load(false, function(){
                            preview(true, resource);
                        });
                    } 
                }, 10);
            });
        });
    });
}

})( jQuery );
