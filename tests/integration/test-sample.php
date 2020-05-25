<?php
/**
 * Class SampleTest
 *
 * @package Opensums_Wp_Dev
 */

namespace OpenSumsWp;

class PluginTest extends \WP_UnitTestCase {
    const REGEXP = '/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(?:-((?:0|[1-9]\d*'
        . '|\d*[a-zA-Z-][0-9a-zA-Z-]*)(?:\.(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z'
        . '-]*))*))?(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?$/';

    public function test_should_have_a_semver_version() {

        $plugin = \OpenSumsWpDev\Plugin::getInstance();

        $info = $plugin->get('plugin');
        $this->assertRegExp(self::REGEXP, $info['version']);
    }
}
