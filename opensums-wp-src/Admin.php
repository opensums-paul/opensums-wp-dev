<?php

namespace OpenSumsWp;

class Admin {

    protected $plugin;

    public function __construct($plugin) {
        $this->plugin = $plugin;
        $this->load();
    }

    /**
     * Add an entry in the Admin menu.
     *
     * @param mixed{} $options Options for the menu entry.
     * - `parent => string` Parent entry (if any).
     * - `title => string` <title> tag for the page.
     * - `label => string` Label for the menu entry.
     * - `permission => string` Permission required to show the entry.
     * - `slug => string` Unique slug used in the URI query string.
     * - `callback => callable` The action to call.
     * @return self Chainable.
     */
    protected function addAdminMenuEntry(array $settings = []): self {
        $plugin = $this->plugin->get('plugin');
        $options = [
            $settings['title'] ?? "{$plugin[name]} Settings", // html <title>
            $settings['label'] ?? "{$plugin[name]}", // Menu label
            $settings['permission'] ?? 'manage_options', // Permission required
            $settings['slug'] ?? "{$plugin[slug]}-options", // Slug
            $settings['callback'] ?? function () { echo("<h2>{$plugin[name]}</h2>"); }, // Callback
        ];
        switch ($settings['parent'] ?? null) {
            case 'settings':
                call_user_func_array('add_options_page', $options);
                break;
            default:
                call_user_func_array('add_menu_page', $options);
        }
        return $this;
    }

    protected function load() {}
}
