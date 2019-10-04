(function( $ ) {
	'use strict';
	 $( window ).load(function() {
		$('#tbl-request').DataTable({
			"order": [
				[0, "desc"]
			]
		});
	 });
})( jQuery );
