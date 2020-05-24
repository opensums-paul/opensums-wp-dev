<?php

namespace OpenSumsWpDev;

class Admin extends \OpenSumsWp\Admin {

    /**
     * Add an entry for the plugin to the Admin menu.
     * 
     * Invoked as a callback when the admin menu is being created.
     */
    public function loadAdminMenu(): void {
        $this->addAdminMenuEntry([
            // 'parent' => 'settings',
            'callback' => [$this, 'renderSettingsPage'],
        ]);
    }

    /**
     * Show the settings page.
     * 
     * Invoked as a callback when the realted admin menu item is selected.
     */
    public function renderSettingsPage():void {
        if (!current_user_can('manage_options')) {
            wp_die(__( 'You do not have sufficient permissions to access this page.'));
        }
        $this->plugin->render('admin/settings-page', []);
    }

    protected function load():void {
        // Add my entry to the admin menu.
        add_action('admin_menu', [$this, 'loadAdminMenu']);
    }
}
