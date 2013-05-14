(function( $ ){


$.fn.djegSlider = function()
{

	var header = this;
	var images = this.data('slider');
	var transitionDuration = 10000;
	var loader = null;
	var animator = null;
	var index = -1;
	var length = images.length;
	var sliderBlock = $('#slider .slider-content');
	var arrowLeft = $('.arrow-left');
	var arrowRight = $('.arrow-right');

	var imagesIsLoad = function()
	{

		for(i in images){
			if(!images[i].complete){
				return false;
			}
		}

		window.clearInterval(loader);

		animate();
		animator = window.setInterval(doAnimation, transitionDuration);
		return true;
	}

	var animate = function(right, untoggle,  callback)
	{
		var left = (right) ? false : true;
		var toggle = (untoggle) ? false : true;

		if(toggle){
			if(left){
				index += 1;
				if(index >= length){
					index = 0;
				}
			} else {
				index -= 1;
				if(index < 0){
					index = length-1;
				}
			}
		}

		var css = {
			'background-image':"url('"+images[index].src+"')"
		};

		var animation = {};

		if(left){
			if(toggle){
				css.left = '0px';
				// animation.left = '0px';
			} else {
				css.left = '0px';
				// animation.left = '100px';
			}
		} else {
			if(toggle){
				css.left = '0px';
				// animation.left = '0px';
			} else {
				css.left = '0px';
				// animation.left = '-100px';
			}
		}

		if(toggle){
			css.opacity = 0;
			animation.opacity = 1;
		} else {
			css.opacity = 1;
			animation.opacity = 0;
		}

		sliderBlock.css(css).animate(animation, 250, callback);

	}

	var doAnimation = function()
	{
		animate(true, true, function(){
			animate();
		});
	}

	// load images
	for(i in images){
		var src = images[i];
		images[i] = new Image();
		images[i].src = src;
	}

	sliderBlock.css('opacity', 0);

	loader = window.setInterval(imagesIsLoad, 10);

	arrowLeft.click(function(){
		window.clearInterval(animator);
		animate(false, true, function(){
			animate(true);
			animator = window.setInterval(doAnimation, transitionDuration);
		});
	});

	arrowRight.click(function(){
		window.clearInterval(animator);
		animate(true, true, function(){
			animate();
			animator = window.setInterval(doAnimation, transitionDuration);
		});
	});
}

})( jQuery )