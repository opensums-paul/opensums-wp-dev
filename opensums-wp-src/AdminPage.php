<?php

namespace OpenSumsWp;

class AdminPage {

    protected $plugin;

    protected $page;

    protected static $defaults = [
        'menuParent' => null,
        'permission' => 'manage_options',
    ];

    protected $settings;

    public function __construct($plugin, $options) {
        $this->plugin = $plugin;
        $this->settings = array_merge(self::$defaults, $options);
        $this->constructSettings();

        // Add my entry to the admin menu.
        add_action('admin_menu', [$this, 'addAdminMenuEntry']);
    }

    protected function constructSettings() {
        $plugin = $this->plugin->get('plugin');
        $settings = $this->settings;
        $this->settings = array_merge($this->settings, [
            'menuLabel' => $settings['menuLabel'] ?? "{$plugin[name]}",
            'pageTitle' => $settings['pageTitle'] ?? "{$plugin[name]} Settings",

            'pageSlug' => $this->plugin->getSlug($settings['pageSlug'] ?? 'admin'),
            'optionsSlug' => $this->plugin->getSlug($settings['optionsSlug'] ?? 'options'),
        ]);
    }

    /**
     * Add an entry for the plugin to the Admin menu.
     * 
     * Invoked as a callback when the admin menu is being created.
     */
    public function loadAdminMenu(): void {
        $this->adminPage->addAdminMenuEntry([
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
        if (!current_user_can($this->settings['permission'])) {
            wp_die(__( 'You do not have sufficient permissions to access this page.'));
        }
        $this->plugin->render($this->settings['template'], $this->settings);
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
     * - `callback => callable` Callback to render the page.
     * @return self Chainable.
     */
    public function addAdminMenuEntry(): self {
        $plugin = $this->plugin->get('plugin');
        $settings = $this->settings;
        $options = [
            $settings['pageTitle'],
            $settings['menuLabel'],
            $settings['permission'],
            $settings['pageSlug'],
            [$this, 'renderSettingsPage'],
        ];
        switch ($settings['menuParent'] ?? null) {
            case 'settings':
                call_user_func_array('add_options_page', $options);
                break;
            default:
                call_user_func_array('add_menu_page', $options);
        }

        return $this;
    }

    /**
     * Settings are managed in groups, each group has a page.
     * 
     * @param mixed[] $options The options for the group.
     * - `string 'page'` The slug for the admin page to manage this group
     *   (defaults to the plugin slug).
     * - `string 'group'` The slug for the wp_options table (defaults to the
     *   plugin slug).
     */
    public function registerSettingsPage() {
        register_setting(
            $this->settings['pageSlug'],
            $this->settings['optionsSlug']
        );
    }

    /**
     * Settings are managed in groups, each group has a page.
     * 
     * @param mixed[] $options The options for the group.
     * - `string 'page'` The slug for the admin page to manage this group
     *   (defaults to the plugin slug).
     * - `string 'section'` The slug for the admin page section.
     * - `string 'title'` HTML for the section's title.
     * - `string 'callback'` function rendering the top of the setion.
     */
    public function addSections(array $sections = []) {
        add_action('admin_init', function() use ($sections) {
            foreach($sections as $section) {
                add_settings_section(
                    $section['id'] ?? 'id-' . mt_rand(),
                    $section['title'] ?? null,
                    [$this, 'renderSection'],
                    $this->settings['pageSlug']
                );
            }
        });
    }

    public function renderSection($section) {
        $this->plugin->render($this->settings['sectionTemplate'], $section);
    }
}
