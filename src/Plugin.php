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
    const NAME = 'OpenSums Development';

    /** Plugin slug (aka text domain). */
    const SLUG = 'opensums-wp-dev';

    /** Current version. */
    const VERSION = '1.0.0-dev';

    /**
     * Load admin hooks.
     */
    protected function loadAdmin():void {
        new Admin\Loader($this);
    }
}
