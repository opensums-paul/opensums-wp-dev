<?php
/**
 * OpenSums development plugin for WordPress.
 *
 * Plugin Name:       OpenSums development plugin 
 * Description:       For testing and development of the OpenSums WordPress framework.
 * Version:           1.0.0-dev
 * Requires at least: 5.2 - check this
 * Requires PHP:      7.2 - check this
 * Author:            OpenSums
 * Author URI:        https://opensums.com/
 * Text Domain:       opensums-wp-dev
 * License:           MIT
 * License URI:       https://github.com/opensums/opensums-wp-dev/LICENSE
 */

namespace OpenSumsWpDev;

defined('WPINC') || die;

require_once(__DIR__.'/vendor/autoload.php');

Plugin::getInstance(__DIR__);
