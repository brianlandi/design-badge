<?php
// Add settings link to plugin page
function db_add_settings_link( $links ) {
	$settings_link = '<a href="options-general.php?page=design-badge">' . __( 'Settings' ) . '</a>';
	$links[] = $settings_link;
	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename( dirname( __FILE__, 2 ) . '/design-badge.php' ), 'db_add_settings_link' );

