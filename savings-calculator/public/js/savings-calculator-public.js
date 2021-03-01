jQuery(document).on('change', 'select[name="savingscalc[cat]"]', function () {
	alert('You have selected: ' + jQuery('select[name="savingscalc[cat]"] option:selected').text());
});

jQuery(document).on('click', '.savingscalc_submit', function (e) {
	if ((jQuery('select[name="savingscalc[cat]"]').val().length > 0) && (jQuery('input[name="savingscalc[spend]"]').val().length > 0)) {
		alert('This will calculate something');
	} else {
		alert('Oops - you\'ve broken this!');
	}
});
