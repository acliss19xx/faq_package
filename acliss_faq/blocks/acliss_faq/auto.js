ccmValidateBlockForm = function() {
	if ($('select[name=sortBy').val() == '' || $('select[name=sortBy').val() == 0) {
		ccm_addError('not selected:sortBy');
	}
	return false;
}