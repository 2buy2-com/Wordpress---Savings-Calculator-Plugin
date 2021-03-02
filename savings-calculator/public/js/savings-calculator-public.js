/* jQuery(document).on('click', '.savingscalc_submit', function(e){
	e.preventDefault();
	if((jQuery('select[name="savingscalc[cat]"]').val().length > 0) && (jQuery('input[name="savingscalc[spend]"]').val().length > 0 )){
		var data = {
			action: "savingscalculator_AJAX",
			cat: jQuery('select[name="savingscalc[cat]"]').val(),
			spend: jQuery('input[name="savingscalc[spend]"]').val()
		};
		jQuery.post(myAjax.ajaxurl, data, function (response) {
			console.log(response);
		});
	} else {
		alert('Oops - you\'ve broken this!');
	}
}); */

/* jQuery(document).ready(function(){
	jQuery('.savingscalc-main > div').each(function(key, value){
		var height = jQuery(this).height() + 150;
		jQuery('.savingscalc-aside_item'+key).css('height', height+'px');
	});
}); */
