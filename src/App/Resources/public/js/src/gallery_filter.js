(function($){

    /**
     * Bind forms events for the gallery filter
     */
    $.fn.galleryFilterForm = function() {
        var form = this;

        var categoryButtons = (function() {
            var buttons = [];

            form.find('.categories button').each(function() {
                buttons.push($(this));
            });

            return buttons;
        })();

        var typeButtons = (function() {
            var btns = [];

            form.find('.types button').each(function() {
                btns.push($(this));
            });

            return btns;
        })();

        // bind categories events
        for (i in categoryButtons) {
            categoryButtons[i].bind('click', function(e) {
                if ($(this).hasClass('disabled')) {
                    e.preventDefault();
                    return;
                }

                var category = $(this).data('category');

                $('#category_input').val(category);

                console.log(category);
                console.log(form.find('#category_input').val());
            });
        }

        // bind types events
        for (i in typeButtons) {
            typeButtons[i].bind('click', function(e) {
                if ($(this).hasClass('disabled')) {
                    e.preventDefault();
                    return;
                }

                var type = $(this).data('type');

                $('#type_input').val(type);
            });
        }
    }

})( jQuery );
