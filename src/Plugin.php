<?php

/**
 * This file is part of the Dutyman plugin for WordPress™.
 *
 * @link      https://github.com/opensums/dutyman-plugin
 * @package   dutyman-plugin
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */

namespace DutymanPlugin;

/**
 * Main class for the Dutyman plugin.
 */
class Plugin extends \OpenSumsWp\Plugin {

    /** @var string Name of the admin class. */
    protected $adminClass = Admin::class;

    /** @var string Plugin human name. */
    protected $name = 'Dutyman';

    /** @var string Plugin slug (aka text domain). */
    protected $slug = 'dutyman';

    /** @var string Current version. */
    protected $version = '1.0.0-dev';
}
