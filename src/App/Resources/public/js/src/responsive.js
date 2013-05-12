(function( $ ){

$.fn.djegResponsiveMenu = function()
{
	this.change(function(){
		console.log('foo');
		$('#responsive-menu option:selected').each(function(){
			window.location.href = $(this).attr('value');
		});
	});
}

})( jQuery )