// navi tree functionality
$(window).load(function(){
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
	$('.js-slug-target').on('keyup', function(){
		$(this).data('js-slug-target-locked', $(this).val() !== '' ? 'yes' : null);
	});

	$('.js-slug-source').on('keyup', function(){
		if ($('.js-slug-target').data('js-slug-target-locked') === 'yes') return;
		$('.js-slug-target').val($(this).val().replace('/', '-'));
	});

});

