<?php
/**
 * This file is part of the OpenSums development package for WordPress.
 *
 * @link      https://github.com/opensums/opensums-wp-dev
 * @package   opensums-wp-dev
 * @copyright [OpenSums](https://opensums.com/)
 * @license   MIT
 */
namespace OpenSumsWpDev;

/**
 * Main class for the OpenSums WP development plugin.
 */
class Plugin extends \OpenSumsWp\Plugin {

    /** Plugin name. */
    protected $name = 'OpenSums Development';

    /** Plugin slug (aka text domain). */
    protected $slug = 'opensums-wp-dev';

    /** Current version. */
    protected $version = '1.0.0-dev';

    /** Name of the admin class. */
    protected $adminLoaderClass = Admin\Loader::class;
}
