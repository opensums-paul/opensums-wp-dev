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

class PluginTest extends \WP_UnitTestCase {

    protected const REGEXP = '/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(?:-((?:0|[1-9]\d*'
        . '|\d*[a-zA-Z-][0-9a-zA-Z-]*)(?:\.(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z'
        . '-]*))*))?(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?$/';

    public function testShouldHaveASemverVersion() {

        $plugin = \DutymanPlugin\Plugin::getInstance();

        $info = $plugin->get('plugin');
        $this->assertRegExp(self::REGEXP, $info['version']);
    }
}
