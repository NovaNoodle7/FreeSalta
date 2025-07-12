jQuery(document).ready(function($) {
	$(document).on('click', '.storeone_go_to_section', function (event) {
		event.preventDefault();
		var id = jQuery(this).attr('href');
		if( typeof(id) != 'undefined' ) {
			jQuery(id).find('h3').trigger('click');
		}
	});
});