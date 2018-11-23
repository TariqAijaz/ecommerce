<?php

/**
 * @package Read_Only_Admin_Plugin
 * 
 */

 /*
  Plugin Name: Read_Only_Admin Plugin
  Description: Creates a read only admin user.
  Version:     1.1.1.0
  Author:      codup.io
  Author URI:  http://codup.io/
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: Read_Only_Admin_Plugin 
  WC requires at least: 3.0
  WC tested up to: 4.9.4
 */

// prevent direct access
if (!defined('ABSPATH'))
    exit;
define('PLUGIN_DIR', __DIR__);

/*
 * Include local dependencies.
 */
include(PLUGIN_DIR . '/includes/class-read-only-admin-plugin.php');


