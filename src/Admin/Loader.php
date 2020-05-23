<?php

namespace OpenSumsWpDev\Admin;

class Loader {

    protected $plugin;

    public function __construct($plugin) {
        $this->plugin = $plugin;
        $this->load();
    }

    public function adminMenu() {
        $plugin = $this->plugin->get('plugin');
        add_options_page(
            "{$plugin[name]} Settings", // html <title>
            "{$plugin[name]}", // Menu label
            'manage_options', // Permission required
            "{$plugin[slug]}-settings", // Slug
            [$this, 'my_plugin_options'] // Callback
        );
    }

    /** Step 3. */
    public function my_plugin_options() {
        if (!current_user_can('manage_options')) {
            wp_die(__( 'You do not have sufficient permissions to access this page.'));
        }
        $this->plugin->render('admin-menu', [
        ]);
    }

    protected function load() {
        // Add my entry to the admin menu.
        add_action('admin_menu', [$this, 'adminMenu']);
    }
}
