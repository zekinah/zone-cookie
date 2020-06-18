(function($) {
	'use strict';
	$ = jQuery.noConflict();
	$(window).on('load', function () {
		$('#tbl-request').DataTable({
			"order": [
				[0, "desc"]
			]
		});
		$('.zn-color-field').wpColorPicker();
		$('#tbl-type-request').DataTable();
		viewRequest();
	 });

	 function viewRequest() {
	 	$(".zn_view_request").on('click', function () {
	 		$("#zn_fname_request").val(($(this).data('zn_fname_request')));
	 		$("#zn_lname_request").val(($(this).data('zn_lname_request')));
	 		$("#zn_phone_request").val(($(this).data('zn_phone_request')));
	 		$("#zn_email_request").val(($(this).data('zn_email_request')));
	 		$("#zn_type_request").val(($(this).data('zn_type_request')));
	 		$("#zn_message_request").val(($(this).data('zn_message_request')));
	 	});
	 }
})( jQuery );
