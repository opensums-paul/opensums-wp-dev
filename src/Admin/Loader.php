<?php

namespace OpenSumsWpDev\Admin;

class Loader {

    protected $plugin;

    public function __construct($plugin) {
        $this->plugin = $plugin;
        $this->load();
    }

    public function adminMenu() {
        $this->plugin->addSettingsPage([
            'callback' => [$this, 'renderSettingsPage'],
        ]);
    }

    protected function load() {
        // Add my entry to the admin menu.
        add_action('admin_menu', [$this, 'adminMenu']);
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
