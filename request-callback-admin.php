<?php

function wpcallback_admin_init(){
	register_setting('wpcallback_admin_options', 'wpcallback_plugin_option');
}

function wpcallback_admin_add_page() {
	$wpcallback_plugin_option_page = add_options_page('Request Call Back', 'Request Call Back', 'manage_options', 'wpcallback', 'wpcallback_admin_options');

	add_action( 'admin_print_styles-' . $wpcallback_plugin_option_page, 'wpcallback_admin_styles' );
	add_action( 'admin_print_scripts-' . $wpcallback_plugin_option_page, 'wpcallback_admin_scripts' );
}

function wpcallback_admin_styles() {
	wp_register_style('callback_admin_css', plugins_url('css/request-callback-admin.css', __FILE__));
	wp_enqueue_style('callback_admin_css');
}

function wpcallback_admin_scripts() {
	wp_register_script('callback_admin_js', plugins_url('js/request-callback-admin.js', __FILE__), array( 'jquery' ));
	wp_enqueue_script('callback_admin_js');
}

function wpcallback_admin_options() {
	global $wpcallback_plugin_option;

	$custom_post_types = get_post_types(array('_builtin' => false));
	$all_post_types = array_merge(array('page'=>'page'), $custom_post_types);

?>

<div class="wrap callback_options">
	<div id="icon-options-general" class="icon32"></div>
	<h2>Request Call Back Settings</h2>

	<form method="post" action="options.php">

		<?php settings_fields('wpcallback_admin_options'); ?>
		<?php $wpcallback_plugin_option = get_option('wpcallback_plugin_option'); ?>

		<h3>Button Installation</h3>
		<p>If you want to include a configurable call back button (required if using lightbox mode), copy and paste the following code in to the theme template file where you want the button to appear (e.g. header.php):</p>

		<table class="form-table">
			<tr valign="top">
				<td>
					<code><?php echo htmlspecialchars("<?php do_action('wpcallback_button'); ?>"); ?></code>
				</td>
			</tr>
		</table>

		<h3>Button Options</h3>
		<p>Options to customise button styling, colour, position and CSS</p>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><strong>Button label</strong></th>
				<td>
					<input type="text" class="regular-text" name="wpcallback_plugin_option[label]" value="<?php echo wpcallback_get_option('label'); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><strong>Button styling</strong></th>
				<td>
					<label>
						<input id="styling_custom" type="radio" <?php checked('custom', $wpcallback_plugin_option['styling']); ?> value="custom" name="wpcallback_plugin_option[styling]">
						<span>Remove default styling</span> <span class="description">- Use this if you want to add your own styling</span>
					</label>
					<br>
					<label>
						<input id="styling_preset" type="radio" <?php if($wpcallback_plugin_option['styling']) { checked('preset', $wpcallback_plugin_option['styling']); } else { echo 'checked="checked"'; } ?> value="preset" name="wpcallback_plugin_option[styling]">
						<span>Choose from a list of preset colours</span>
					</label>
				</td>
			</tr>
			<tr valign="top" id="button_colour">
				<th scope="row"><strong>Button colour</strong></th>
				<td>
					<select name="wpcallback_plugin_option[colour]" id="button_colour_select">
						<option value="default" <?php selected( 'default', $wpcallback_plugin_option['colour']); ?>>Default</option>
						<option value="blue" <?php selected( 'blue', $wpcallback_plugin_option['colour']); ?>>Blue</option>
						<option value="red" <?php selected( 'red', $wpcallback_plugin_option['colour']); ?>>Red</option>
						<option value="orange" <?php selected( 'orange', $wpcallback_plugin_option['colour']); ?>>Orange</option>
						<option value="green" <?php selected( 'green', $wpcallback_plugin_option['colour']); ?>>Green</option>
						<option value="turquoise" <?php selected( 'turquoise', $wpcallback_plugin_option['colour']); ?>>Turquoise</option>
						<option value="purple" <?php selected( 'purple', $wpcallback_plugin_option['colour']); ?>>Purple</option>
						<option value="black" <?php selected( 'black', $wpcallback_plugin_option['colour']); ?>>Black</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><strong>Custom CSS</strong></th>
				<td>
					<textarea name="wpcallback_plugin_option[custom_css]"><?php echo wpcallback_get_option('custom_css'); ?></textarea>
					<p class="description">Add your own CSS styling to the button to suit your needs</p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><strong>Custom CSS classes</strong></th>
				<td>
					<input type="text" class="regular-text" name="wpcallback_plugin_option[classes]" value="<?php echo wpcallback_get_option('classes'); ?>" />
					<p class="description">Separate with spaces</p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><strong>Button position</strong></th>
				<td>
					<select name="wpcallback_plugin_option[position]">
						<option value="right" <?php selected( 'right', $wpcallback_plugin_option['position']); ?>>Float right</option>
						<option value="left" <?php selected( 'left', $wpcallback_plugin_option['position']); ?>>Float left</option>
						<option value="none" <?php selected( 'none', $wpcallback_plugin_option['position']); ?>>None</option>
					</select>
				</td>
			</tr>
		</table>

		<h3>Form Options</h3>
		<p>Options to customise the call back form</p>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><strong>Display mode</strong></th>
				<td>
					<label>
						<input type="radio" <?php if($wpcallback_plugin_option['lightbox']) { checked('enabled', $wpcallback_plugin_option['lightbox']); } else { echo 'checked="checked"'; }  ?> value="enabled" name="wpcallback_plugin_option[lightbox]">
						<span>Open form in a lightbox</span> <span class="description">- Requires button code to be installed</span>
					</label>
					<br>
					<label>
						<input type="radio" <?php checked('disabled', $wpcallback_plugin_option['lightbox']); ?> value="disabled" name="wpcallback_plugin_option[lightbox]">
						<span>Display form on an existing page</span>
					</label>
				</td>
			</tr>
			<tr valign="top" id="link_to_page">
				<th scope="row"><strong>Select page</strong></th>
				<td>
					<select name="wpcallback_plugin_option[callback_page]">
						<?php foreach($all_post_types as $type) : ?>
						<?php $query_all_posts = new WP_Query(array('post_type' => $type, 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC')); ?>
						<optgroup label="<?php echo get_post_type_object($type)->labels->name; ?>">
							<?php foreach($query_all_posts->posts as $item) : ?>
							<option value="<?php echo $item->ID; ?>" <?php selected($item->ID, $wpcallback_plugin_option['callback_page']); ?>><?php echo $item->post_title; ?></option>
							<?php endforeach; ?>
						</optgroup>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><strong>Form content</strong></th>
				<td>
					<textarea name="wpcallback_plugin_option[description]"><?php echo wpcallback_get_description(); ?></textarea>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><strong>Email address</strong></th>
				<td>
					<input type="text" class="regular-text" name="wpcallback_plugin_option[email]" value="<?php echo wpcallback_get_option('email'); ?>" />
					<p class="description">Who to send the call back information to</p>
				</td>
			</tr>
			<tr valign="top" id="thankyoupage" <?php if(!$wpcallback_plugin_option['target']) : echo 'class="not-set"'; endif; ?>>
				<th scope="row"><strong>Thank you page</strong></th>
				<td>
					<select name="wpcallback_plugin_option[target]">
						<option value="" class="choose-page">Select page</option>
						<?php foreach($all_post_types as $type) : ?>
							<?php $query_all_posts = new WP_Query(array('post_type' => $type, 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC')); ?>
							<optgroup label="<?php echo get_post_type_object($type)->labels->name; ?>">
								<?php foreach($query_all_posts->posts as $item) : ?>
									<option value="<?php echo $item->ID; ?>" <?php selected($item->ID, $wpcallback_plugin_option['target']); ?>><?php echo $item->post_title; ?></option>
								<?php endforeach; ?>
							</optgroup>
						<?php endforeach; ?>
					</select>
					<p class="description">Where to send the visitor after the request has been sent successfully</p>
				</td>
			</tr>
		</table>

		<h3>Advanced Options</h3>
		<p>Options to enable or disable Colorbox scripts for lightbox display mode</p>
		<p class="description">Note: this plugin comes with the <a target="_blank" href="http://www.jacklmoore.com/colorbox/">Colorbox</a> jQuery plugin to allow the call back form to open in a lightbox. <br>If you think this plugin is conflicting with other plugins that use lightboxes, you can control it using these options.</p>

		<table class="form-table">
			<tr valign="top">
				<th scope="row"><strong>Colorbox</strong></th>
				<td>
					<label>
						<input type="radio" <?php if($wpcallback_plugin_option['colorbox']) { checked('enabled', $wpcallback_plugin_option['colorbox']); } else { echo 'checked="checked"'; }  ?> value="enabled" name="wpcallback_plugin_option[colorbox]">
						<span>Enable Colorbox</span>
					</label>
					<br>
					<label>
						<input type="radio" <?php checked('custom', $wpcallback_plugin_option['colorbox']); ?> value="custom" name="wpcallback_plugin_option[colorbox]">
						<span>Disable Colorbox</span> <span class="description">- Only use this if Colorbox is already installed</span>
					</label>
				</td>
			</tr>

		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes" />
		</p>

		<p class="wpcallback-footer">Request Call Back Plugin by <a target="_blank" href="http://www.scottsalisbury.co.uk">Scott Salisbury</a></p>
	</form>
</div>

<?php

}

function wpcallback_admin_target_page_notice() {
	global $wpcallback_plugin_option;

	if(!$wpcallback_plugin_option['target']) : ?>
	<div class="error">
		<p><strong>Request Call Back Plugin:</strong> Don't forget to create a thank you page for the request call back form and configure it in the plugin <a href="<?php echo get_admin_url(); ?>options-general.php?page=wpcallback#thankyoupage">settings</a>.</p>
	</div>
	<?php endif;
}

add_action('admin_init', 'wpcallback_admin_init' );
add_action('admin_menu', 'wpcallback_admin_add_page');
add_action('admin_notices', 'wpcallback_admin_target_page_notice');