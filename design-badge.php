<?php
/*
Plugin Name: Design Badge
Description: Add a badge to pages with link to design file.
Version: 1.0
Author: Brian Landi
*/

// Define plugin path constants
define( 'DB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include separate files
require_once DB_PLUGIN_DIR . 'includes/meta-boxes.php';
require_once DB_PLUGIN_DIR . 'includes/frontend-display.php';
require_once DB_PLUGIN_DIR . 'includes/enqueue-scripts.php';
require_once DB_PLUGIN_DIR . 'includes/settings-page.php';
require_once DB_PLUGIN_DIR . 'includes/additional-settings.php';

