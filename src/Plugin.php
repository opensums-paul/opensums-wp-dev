<?php
namespace OpenSumsWpDev;

class Plugin extends \OpenSumsWp\Plugin {

    /** @var string Plugin name. */
    const NAME = 'OpenSums Development';

    /** @var string Plugin slug (aka text domain). */
    const SLUG = 'opensums-wp-dev';

    /** @var string Current version. */
    const VERSION = '1.0.0-dev';

    protected function loadAdmin() {
        new Admin\Loader($this);
    }
}
