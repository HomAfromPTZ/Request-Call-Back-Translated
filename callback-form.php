<?php

function wpcallback_display_form($lightbox = true) {
	$label = null;
	$description = null;
	$script = null;

	if($lightbox) {
		$label = '<h1>' . wpcallback_get_option('label') . '</h1>';
		$description = wpautop(wpcallback_get_description());
		$script = '<script type="text/javascript" src="' . plugins_url('js/request-callback.js', __FILE__) . '"></script>';
	}

	$form_action = get_site_url() . '/?wpcallback_action=email';

	$form = <<<EOT
	<div class="callback-form">{$label}{$description}<form class="callback-form-container" action="{$form_action}" method="post"><label class="hear-about-us"><span>Hear about us</span><input type="text" autocomplete="off" name="hear_about_us"></label><label><span>Name</span><input type="text" autocomplete="off" name="callback_name" placeholder="Your name"></label><label><span>Telephone</span><input type="text" autocomplete="off" name="callback_telephone" placeholder="Your telephone number"></label><input class="submit-button" type="submit" value="Submit"></form></div>{$script}
EOT;

	return $form;
}