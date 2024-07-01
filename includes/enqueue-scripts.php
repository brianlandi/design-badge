<?php
// Enqueue styles
add_action( 'wp_enqueue_scripts', 'db_enqueue_styles' );
function db_enqueue_styles() {
	wp_enqueue_style( 'db_styles', plugins_url( '../css/design-badge.css', __FILE__ ) );
}

add_action( 'admin_enqueue_scripts', 'db_enqueue_admin_styles' );

// Enqueue admin styles
function db_enqueue_admin_styles() {
	wp_enqueue_style( 'design-badge-admin', plugins_url( '../css/admin-style.css', __FILE__ ) );
}

// Enqueue media uploader script
function db_enqueue_media_uploader( $hook ) {
	if ( 'settings_page_design-badge' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'db-media-uploader', plugins_url( '../js/db-media-uploader.js', __FILE__ ), array( 'jquery' ), null, true );
}
add_action( 'admin_enqueue_scripts', 'db_enqueue_media_uploader' );

