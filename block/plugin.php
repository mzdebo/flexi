<?php
/**
 * Plugin Name: flexi-block — CGB Gutenberg Block Plugin
 * Plugin URI: https://github.com/ahmadawais/create-guten-block/
 * Description: flexi-block — is a Gutenberg plugin created via create-guten-block.
 * Author: mrahmadawais, maedahbatool
 * Author URI: https://AhmadAwais.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
 exit;
}

/**
 * Block Initializer.
 */
if (function_exists('register_block_type')) {
 // Gutenberg is  active.
 require_once plugin_dir_path(__FILE__) . 'src/init.php';
 require_once plugin_dir_path(__FILE__) . 'src/block/sample.php';
}
