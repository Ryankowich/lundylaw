;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {
		// add arrows to the nav items
		$('#navigation > ul > li.menu-item-has-children').each(function() {
			$(this).append('<span class="arr"></span>');
		});

		// navigation expanding
		$('a.menu-btn').on('click', function(e) {
			$(this).toggleClass('expanded').next('ul').stop(true).slideToggle();

			e.preventDefault();
		});

		// mobile navigation dropdown
		$('#navigation > ul > li.menu-item-has-children > span.arr').on('click', function() {
			var parent = $(this).parent('li');

			$('#navigation > ul').css({'height': 'auto'});

			parent.toggleClass('expanded').siblings('li.menu-item-has-children').removeClass('expanded');
			parent.find('ul').stop(true).slideToggle();
			parent.siblings('li.menu-item-has-children').find('ul').stop(true).slideUp();
		});

		// video popup	
		$('.video a').colorbox({
			iframe:true,
			innerWidth:640,
			innerHeight:390,
			maxWidth: '90%',
			maxHeight: '90%'
		});

		// locations
		$('.cities ul li a').on('click', function(e) {
			var parent = $(this).parent('li'),
				idx = parent.index();
			
			parent.addClass('active').siblings('li').removeClass('active');
			$('.map-holder').eq(idx).show().siblings('.map-holder').hide();
			$('.address-holder').eq(idx).show().siblings('.address-holder').hide();

			e.preventDefault();
		});

		// homepage sidebar nav
		if ( $('body').hasClass('home') ){
			var item_per_list = Math.floor($('#sidebar ul li').length / 3);

			$('#sidebar li:eq( ' + item_per_list + ' )').addClass('end_col');
			$('#sidebar li:eq( ' + item_per_list * 2 + ' )').addClass('end_col');

			$("#sidebar li.end_col").each(function () {
			 	var cols = $(this).removeClass('end_col');
				$(this).parents("#sidebar").find('ul:last').after('<ul />');
				$('#sidebar ul:last').insertAfter(cols.parent()).append(cols.next().nextAll().andSelf())
			
			});
		}
	});

	$win.on('load', function(){
		$('.cities li:first').addClass('current');
		$('.address-holder:first').show();
		$('.map-holder').hide().css('opacity', 1 );
		$('.map-holder:first').show();
	});

})(jQuery, window, document);