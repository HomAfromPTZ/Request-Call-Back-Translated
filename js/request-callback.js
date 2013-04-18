jQuery(document).ready(function($) {
	if($.isFunction($.colorbox)){
		$(".callback-form-show").colorbox({
			width:"400px"
		});
	}
	jQuery(document).ready(function($) {
		$('.callback-form-container').submit(function() {
			var isValid = true;
			var formInputs = $(this).find('input[type=text]');

			$(formInputs).each(function() {
				if($.trim(this.value) == '' && this.name != 'hear_about_us') {
					isValid = false;
				}
			});

			if(isValid) {
				$('.submit-button').val('Please wait...');
				$('.submit-button').attr('disabled', 'disabled');
				return true;
			}
			else {
				alert('Please provide both your name and telephone number.');
				return false;
			}
		});
	});
});