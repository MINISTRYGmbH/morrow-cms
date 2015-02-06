
// navi tree functionality
/*
$(window).load(function(){
	'use strict';

	var $tree = $('.navi-tree');
	$tree.css('visibility', 'visible');

	// fix the width of the expanded navigation tree
	$tree.closest('.navi').css('min-width', $tree.closest('.navi').width() + 'px');

	// tree menu for pages
	// on page load the opening of .js-open should occur instantly
	var instant = true;
	$tree.find('.navi-tree').hide();
	$tree.find('.js-toggle').click(function(e){
		e.preventDefault();
		$(this).parent().next().slideToggle(instant ? 0 : 100).toggleClass('is-visible');
	}).filter('.js-open').click();
	instant = false;
});

// slug preview functionality
$(window).load(function(){
	'use strict';

	$('.js-slug-target').on('keyup', function(){
		$(this).data('js-slug-target-locked', $(this).val() !== '' ? 'yes' : null);
	});

	$('.js-slug-source').on('keyup', function(){
		if ($('.js-slug-target').data('js-slug-target-locked') === 'yes') return;
		$('.js-slug-target').val($(this).val().replace('/', '-'));
	});
});
*/

document.addEventListener("DOMContentLoaded", function() {

	// submit functionality for all elements with .js-submit
	var elements = document.getElementsByClassName('js-submit');
	for (var i = 0; i < elements.length; i++) {
		elements[i].addEventListener('click', function(e){
			e.preventDefault();
			this.parentNode.parentNode.submit();
		});
	}
	
});
