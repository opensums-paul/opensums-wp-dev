<?php

namespace OpenSumsWpDev;

class Admin extends \OpenSumsWp\Admin {

    public function loadAdminMenu() {
        $this->addAdminMenuEntry([
            'parent' => 'settings',
            'callback' => [$this, 'renderSettingsPage'],
        ]);
    }

    protected function load() {
        // Add my entry to the admin menu.
        add_action('admin_menu', [$this, 'loadAdminMenu']);
        /**
        * register our wporg_options_page to the admin_menu action hook
        */
        add_action( 'admin_menu', 'wporg_options_page');
    }

    // --- Refactor after here -------------------------------------------------

    /** Step 3. */
    public function renderSettingsPage() {
        if (!current_user_can('manage_options')) {
            wp_die(__( 'You do not have sufficient permissions to access this page.'));
        }
        $this->plugin->render('admin/settings-page', []);
    }
}
