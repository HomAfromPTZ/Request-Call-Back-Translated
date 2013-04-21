jQuery(document).ready(function($) {
	if($.isFunction($.colorbox)){
		$(".callback-form-show").colorbox({
			width:"400px"
		});
	}
	jQuery(document).ready(function($) {
		$('.callback-form-container').submit(function() {
			var formInputs = $(this).find('.validate');
			var errors = '';

			$(formInputs).each(function() {
				if($.trim(this.value) == '') {
					fieldLabel = $(this).parent().find('span').html();
					errors += '- ' + fieldLabel + '\n';
				}
			});

			if(errors.length > 0) {
				alert('The following information is missing:\n\n' + errors);
				return false;
			}
			else {
				$('.submit-button').val('Please wait...');
				$('.submit-button').attr('disabled', 'disabled');
				return true;
			}
		});
	});
});