(function( $ ) {
	'use strict';
	console.log(arr_ajax);
	var res;
	var id;
	jQuery(document).ready(function($) {
		$('#brandmetaid').click(function() {

			res = $('#brandnameid').val();
			id = $('#metaid').val();

	// alert(res+" "+ id);	

	$.ajax({
		type : 'post',
		//dataType : 'json',
		url : arr_ajax.ajax_url,
		data : {
			action : 'js_add_like',
			_ajax_nounce : arr_ajax.nonce,
			name : res,
			id : id,
		},

		//alert(res+" "+ id);
		success: function( response ) {
			alert(response);
		
        },
	});
});
	});

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
