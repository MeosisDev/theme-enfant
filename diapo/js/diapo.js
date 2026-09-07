$(document).ready(function() {
	$('#galerie-dynamique').magnificPopup({
		delegate: 'a',
		type:'image',
		gallery: {
			enabled:true
		}
	});
});