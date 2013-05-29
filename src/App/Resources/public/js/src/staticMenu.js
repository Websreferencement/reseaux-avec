(function($) {

    $.fn.staticMenu = function() {
        var header = this; 
        var menu = this.find('#menu');

        var menuHeight = menu.outerHeight(true);

        $(window).scroll(function() {
            if ($(window).scrollTop() > (header.outerHeight(true)-menuHeight)) {
                if (menu.find('.visible-desktop').is(':visible')) {
                    menu.addClass('static-menu');
                }
            } else {
                if (menu.hasClass('static-menu')) {
                    menu.removeClass('static-menu');
                }
            }
        });
    }

})(jQuery)
