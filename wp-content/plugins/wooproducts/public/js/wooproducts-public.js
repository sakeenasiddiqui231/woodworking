(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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


	// function openForm() {
	// 	document.getElementById("myForm").style.display = "block";
	//   }
	  
	//   function closeForm() {
	// 	document.getElementById("myForm").style.display = "none";
	//   }


	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).is(":checked")){
				

				
					var first_name = $('#firstname').val();
					var last_name = $('#lastname').val();					
					var country =$('#country').val();
					var street = $('#street').val();
					var town_city =$('#town_city').val();
					var pincode = $('#pincode').val();
					var phone_number = $('#phone_number').val();
					var email = $('#email').val();


					$('#f_name').val(first_name);
					$('#l_name').val(last_name);
					$('#country_name').val(country);
					$('#street_name').val(street);
					$('#town_city_name').val(town_city);
					$('#pincode_number').val(pincode);
					$('#p_number').val(phone_number);
					$('#user_email').val(email);
					// alert("hello");
            }
            
		});
		
		$("#add_cart").click(function()
		{
		alert("Product added successfully");
		});



	});
	





})( jQuery );
