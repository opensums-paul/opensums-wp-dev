<?php

/**
 * This file is part of the OpenSums development package for WordPress.
 *
 * @link      https://github.com/opensums/opensums-wp-dev
 * @package   opensums-wp-dev
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 *
 * @wordpress ```
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
 * ```
 */

// namespace OpenSumsWpDev;

defined('WPINC') || die;

require_once(__DIR__ . '/vendor/autoload.php');

OpenSumsWpDev\Plugin::getInstance(__DIR__);
