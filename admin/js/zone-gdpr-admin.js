(function( $ ) {
	'use strict';
	 $( window ).load(function() {
		$('#tbl-request').DataTable({
			"order": [
				[0, "desc"]
			]
		});
		$('#tbl-type-request').DataTable();
	 });
})( jQuery );
