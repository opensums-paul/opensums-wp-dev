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
class Admin extends \OpenSumsWp\Admin {

    /** @var \OpenSumsWp\AdminPage The admin page. */
    protected $adminPage;

    protected function load(): void {
        $this->adminPage = new \OpenSumsWp\AdminPage($this->plugin, [
            'template' => 'admin/settings-page',
            'sectionTemplate' => 'admin/settings-page-sections',
            'savedMessage' => __('Settings saved at', 'dutyman'),
        ]);

        $this->adminPage->addSections([
            // placeholder
            // helper to the right
            // supplemental underneath
            [
                // The default settings options group for this section.
                'group' => 'user',
                // Prefixed and used as the section element's id.
                'id' => 'account',
                'title' => 'Dutyman account',
                'fields' => [
                    [
                        // Prefixed and used as the element's id.
                        'id' => 'dutyman-id',
                        'label' => __('Dutyman ID', 'dutyman'),
                        'placeholder' => 'M0000000',
                    ],
                ],
            ],
        ]);
    }
}
