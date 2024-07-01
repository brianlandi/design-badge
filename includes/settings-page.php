<?php
add_action( 'admin_menu', 'db_add_admin_menu' );
add_action( 'admin_init', 'db_settings_init' );

function db_add_admin_menu() {
	add_options_page(
		'Design Badge Settings',
		'Design Badge',
		'manage_options',
		'design-badge',
		'db_options_page'
	);
}

function db_settings_init() {
	register_setting( 'db_plugin_page', 'db_settings' );

	add_settings_section(
		'db_plugin_page_section',
		__( 'Design Badge', 'design-badge' ),
		'db_settings_section_callback',
		'db_plugin_page'
	);

	add_settings_field(
		'db_text_field_design_link',
		__( 'Default Design Link', 'design-badge' ),
		'db_text_field_design_link_render',
		'db_plugin_page',
		'db_plugin_page_section'
	);

	add_settings_field(
		'db_select_field_design_tool',
		__( 'Design Tool', 'design-badge' ),
		'db_select_field_design_tool_render',
		'db_plugin_page',
		'db_plugin_page_section'
	);

	add_settings_field(
		'db_range_position_on_page',
		__( 'Position on Page', 'design-badge' ),
		'db_range_position_on_page_render',
		'db_plugin_page',
		'db_plugin_page_section'
	);
}

function db_text_field_design_link_render() {
	$options = get_option( 'db_settings' );
	?>
	<p class="settings-page-label">Set a global design link for any pages that show badge and have not specified a
		page-specific
		link.</p>
	<input type='text' name='db_settings[db_text_field_design_link]'
		value='<?php echo $options['db_text_field_design_link']; ?>'>
	<?php
}

function db_select_field_design_tool_render() {
	$options = get_option( 'db_settings' );
	?>

	<div>
		<p class="settings-page-label">Please select the design tool you will be using.</p>
		<select name="db_settings[db_select_field_design_tool]" id="db_select_field_design_tool">
			<option value='figma' <?php selected( $options['db_select_field_design_tool'], 'figma' ); ?>>Figma</option>
			<option value='sketch' <?php selected( $options['db_select_field_design_tool'], 'sketch' ); ?>>Sketch</option>
			<option value='adobe' <?php selected( $options['db_select_field_design_tool'], 'adobe' ); ?>>Adobe</option>
			<option value='custom' <?php selected( $options['db_select_field_design_tool'], 'custom' ); ?>>Custom</option>
		</select>

		<div class="custom-image-wrapper"
			style="<?php echo ( $options['db_select_field_design_tool'] === 'custom' ) ? '' : 'display: none;'; ?>">
			<input type="button" id="upload_image_button" class="button"
				value="<?php _e( 'Upload Image', 'design-badge' ); ?>" />
			<input type="hidden" id="db_image_field" name="db_settings[db_image_field]"
				value="<?php echo esc_attr( $options['db_image_field'] ); ?>" />
			<div id="db_image_preview">
				<?php if ( $options['db_image_field'] ) : ?>
					<img src="<?php echo esc_url( $options['db_image_field'] ); ?>" style="max-width: 300px;" />
					<input type="button" id="remove_image_button" class="button"
						value="<?php _e( 'Remove Image', 'design-badge' ); ?>" />

				<?php endif; ?>
			</div>
			<div class="custom-bg-color-wrapper">
				<label for="db_custom_image_background_color"><?php _e( 'Background Color', 'design-badge' ); ?></label>
				<input type="color" id="db_custom_image_background_color"
					name="db_settings[db_custom_image_background_color]"
					value="<?php echo esc_attr( $options['db_custom_image_background_color'] ); ?>" />
			</div>
		</div>
	</div>
	<?php
}


function db_range_position_on_page_render() {
	$options = get_option( 'db_settings' );
	$value = isset( $options['db_range_position_on_page'] ) ? $options['db_range_position_on_page'] : 50;
	?>
	<p class="settings-page-label">Set the vertical position of the badge on the page.</p>
	<input type="range" id="db_range_position_on_page" name="db_settings[db_range_position_on_page]" min="1" max="100"
		value="<?php echo $value; ?>" oninput="document.getElementById('db_range_value').innerText = this.value + '%'">
	<label for="db_range_position_on_page"><span id="db_range_value"><?php echo $value; ?>%</span></label>
	<?php
}


function db_settings_section_callback() {
	echo __( '
	Configure the default settings for the Design Badge plugin.', 'design-badge' );
}

function db_options_page() {
	?>
	<form action='options.php' method='post'>
		<?php
		settings_fields( 'db_plugin_page' );
		do_settings_sections( 'db_plugin_page' );
		submit_button();
		?>
	</form>
	<?php
}
?>