<?php

function wpcallback_display_form($lightbox = true) {
	$field_email = null;
	$field_time = null;
	$field_message = null;

	$label = null;
	$script = null;
	$description = wpautop(wpcallback_get_description());

	if($lightbox) {
		$label = '<h1>' . wpcallback_get_option('label') . '</h1>';
		$script = '<script type="text/javascript" src="' . plugins_url('js/request-callback.js', __FILE__) . '"></script>';
	}

	if(wpcallback_get_option('field_email') != 'disabled') {
		$validate = null;
		$optional = null;
		if(wpcallback_get_option('field_email') == 'required') {
			$validate = 'validate';
		}
		else {
			$optional = '<span>(optional)</span>';
		}

		$field_email = '<label><span class="callback-label">Email ' . $optional . '</span><input class="' . $validate . '" type="text" autocomplete="off" name="callback_email" placeholder="Your email"></label>';
	}

	if(wpcallback_get_option('field_time') != 'disabled') {
		$time_from = wpcallback_get_option('allowable_from');
		$time_to = wpcallback_get_option('allowable_to');

		$validate = null;
		$optional = null;
		if(wpcallback_get_option('field_time') == 'required') {
			$validate = 'validate';
		}
		else {
			$optional = '<span>(optional)</span>';
		}

		$select_range = build_time_intervals($time_from, $time_to, 0.5);

		$select_options = '<option value=""></option><option value="anytime">Any time</option>';
		foreach($select_range as $item) {
			$select_options .= '<option value="' . $item['decimal'] . '">' . $item['time'] . '</option>';
		}

		$field_time = '<label><span class="callback-label">When to call ' . $optional . '</span><select class="' . $validate . '" name="callback_time">' . $select_options . '</select></label>';
	}

	if(wpcallback_get_option('field_message') != 'disabled') {
		$validate = null;
		$optional = null;
		if(wpcallback_get_option('field_message') == 'required') {
			$validate = 'validate';
		}
		else {
			$optional = '<span>(optional)</span>';

		}

		$field_message = '<label><span class="callback-label">Message ' . $optional . '</span><textarea class="' . $validate . '" name="callback_message" placeholder="Your message"></textarea></label>';
	}

	$form_action = get_site_url() . '/?wpcallback_action=email';

	$form = <<<EOT
	<div class="callback-form">{$label}{$description}<form class="clearfix callback-form-container" action="{$form_action}" method="post"><label class="hear-about-us"><span>Hear about us</span><input type="text" autocomplete="off" name="hear_about_us"></label><label><span class="callback-label">Name</span><input class="validate" type="text" autocomplete="off" name="callback_name" placeholder="Your name"></label><label><span class="callback-label">Telephone</span><input class="validate" type="text" autocomplete="off" name="callback_telephone" placeholder="Your telephone number"></label>{$field_email}{$field_time}{$field_message}<input class="submit-button" type="submit" value="Submit"></form></div>{$script}
EOT;

	return $form;
}
