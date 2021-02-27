<?php

/**
 * Plugin Name: MWD - Block Library
 * Plugin URI: https://minervawebdevelopment.com/
 * Description: Library of custom blocks bootstrapped together using create-guten-block.
 * Author URI: https://minervawebdevelopment.com/
 * Version: 1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path(__FILE__) . 'src/init.php';
