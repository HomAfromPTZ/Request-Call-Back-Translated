jQuery(document).ready(function($) {

	function setStyleMode() {
		var selectedStyle = $('input[name=wpcallback_plugin_option\\[styling\\]]:checked').val();

		if(selectedStyle == 'custom') {
			$('#button_colour_select').prop('disabled', 'disabled');
		}
		else {
			$('#button_colour_select').prop('disabled', false);
		}
	}

	function setLightboxMode() {
		var selectedStyle = $('input[name=wpcallback_plugin_option\\[lightbox\\]]:checked').val();

		if(selectedStyle == 'disabled') {
			$('#link_to_page').show();
		}
		else {
			$('#link_to_page').hide();
		}
	}

	setStyleMode();
	setLightboxMode();

	$('.callback_options input[name=wpcallback_plugin_option\\[styling\\]]').click(function() {
		setStyleMode();
	});

	$('.callback_options input[name=wpcallback_plugin_option\\[lightbox\\]]').click(function() {
		setLightboxMode();
	});

});