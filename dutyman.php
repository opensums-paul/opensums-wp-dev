<?php

/**
 * This file is part of the Dutyman plugin for WordPress™.
 *
 * ```
 * Plugin Name:       Dutyman
 * Description:       Integrate Dutyman into your WordPress™ site.
 * Version:           1.0.0-dev
 * Requires at least: 5.3.3
 * Requires PHP:      7.2
 * Author:            OpenSums
 * Author URI:        https://opensums.com/
 * Text Domain:       dutyman
 * License:           MIT
 * License URI:       https://github.com/opensums/dutyman-plugin/LICENSE
 * ```
 *
 * @link      https://github.com/opensums/dutyman-plugin
 * @package   dutyman-plugin
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

defined('WPINC') || die;

require_once(__DIR__ . '/vendor/autoload.php');

DutymanPlugin\Plugin::getInstance(__DIR__);
