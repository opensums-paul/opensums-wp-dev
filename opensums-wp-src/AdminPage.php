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
    public function renderSettingsPage(): void {
        if (!current_user_can($this->settings['permission'])) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        $vars = $this->settings;
        $vars['messagesSlug'] = $this->plugin->getSlug('messages');
        if (isset($_GET['settings-updated'])) {
            // add settings saved message with the class of "updated"
            add_settings_error(
                $this->plugin->getSlug('messages'),
                $this->plugin->getSlug('message'),
                __('Settings Saved', $this->settings['pageSlug']),
                'updated' // CSS class.
            );
        }
        $this->plugin->render($this->settings['template'], $vars);
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
     *
     * @param mixed[] $sections An array of sections. Each section is an array:
     * - `string 'id'` The id for the admin page section.
     * - `string 'title'` HTML for the section's title.
     */
    public function addSections(array $sections = []) {
        add_action('admin_init', function () use ($sections) {
            foreach ($sections as $section) {
                add_settings_section(
                    $section['id'] ?? 'id-' . mt_rand(),
                    $section['title'] ?? null,
                    [$this, 'renderSection'],
                    $this->settings['pageSlug']
                );
            }
        });
    }

    /**
     *
     * @param mixed[] $sections An array of sections. Each section is an array:
     * - `string 'id'` The id for the admin page section.
     * - `string 'title'` HTML for the section's title.
     */
    public function addFields(array $fields = []) {
        add_action('admin_init', function () use ($fields) {
            $groups = [];
            foreach ($fields as $field) {
                // Use label_for in preference to id (since WP 4.6).
                $field['label_for'] = $field['label_for'] ?? $field['id'];
                $field['id'] = $field['label_for'];

                // Group names by group if provided, otherwise by section, and prefix.
                $field['name'] = $field['name'] ?? $field['id'];
                $field['group'] = $field['group'] ?? $field['section'];
                $group = $this->plugin->getSlug($field['group']);
                $groups[$group] = true;
                $field['name_attr'] = "{$group}[{$field[name]}]";

                add_settings_field(
                    $field['id'],
                    $field['label'],
                    [$this, 'renderField'],
                    $this->settings['pageSlug'],
                    $field['section'],
                    $field
                );
            }
            foreach (array_keys($groups) as $group) {
                register_setting($this->settings['pageSlug'], $group);
            }
        });
    }

    /**
     * @see https://www.smashingmagazine.com/2016/04/three-approaches-to-adding-configurable-fields-to-your-plugin/
     */
    public function renderField($field) {
        $values = get_option($this->plugin->getSlug($field[group])); // Get the current value, if there is one
        $value = $values[$field['name']];
        if (!$value) { // If no value exists
            $value = $field['default']; // Set to our default
        }

        // Check which type of field we want
        switch ($field['type']) {
            case 'text': // If it is a text field
                printf(
                    '<input name="%1$s" id="%2$s" type="%3$s" placeholder="%4$s"'
                        . ' value="%5$s" />',
                    $field['name_attr'],
                    $field['label_for'],
                    $field['type'],
                    $field['placeholder'],
                    $value
                );
                break;
            case 'textarea': // If it is a textarea
                printf(
                    '<textarea name="%1$s" id="%2$s" placeholder="%3$s" rows="5"'
                        . ' cols="50">%4$s</textarea>',
                    $field['name_attr'],
                    $field['id'],
                    $field['placeholder'],
                    $value
                );
                break;
            case 'select': // If it is a select dropdown
                if (!empty($field['options']) && is_array($field['options'])) {
                    $options_markup = '';
                    foreach ($field['options'] as $key => $label) {
                        $options_markup .= sprintf(
                            '<option value="%s" %s>%s</option>',
                            $key,
                            selected($value, $key, false),
                            $label
                        );
                    }
                    printf(
                        '<select name="%1$s" id="%2$s">%3$s</select>',
                        $field['name_attr'],
                        $field['id'],
                        $options_markup
                    );
                }
                break;
            default:
        }

        // If there is help text
        if ($helper = $field['helper']) {
            printf('<span class="helper"> %s</span>', $helper); // Show it
        }

        // If there is supplemental text
        if ($supplemental = $field['supplemental']) {
            printf('<p class="description">%s</p>', $supplemental); // Show it
        }
    }

    public function renderSection($section) {
        $this->plugin->render($this->settings['sectionTemplate'], $section);
    }
}
