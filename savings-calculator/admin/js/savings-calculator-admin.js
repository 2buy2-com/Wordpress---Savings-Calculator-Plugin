/**
 * 
 * @param {event} evt 
 */
function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
/**
 * 
 * @param {object} ref 
 * @param {int} min 
 * @param {int} max 
 */
function validateInput(ref, min, max) {
	var val = parseFloat(ref.val());
	min = parseFloat(min);
	max = parseFloat(max);
	if((val > max) || (val < min)){
		alert('Please enter a number between '+min+' and '+max);
		ref.val(max);
	}
}

jQuery(document).on('keyup', '.form-table input[type="number"]', function(e) {
	isNumber(e);
	validateInput(jQuery(this), 0, 100);
});
