<?php
/**
 */

namespace OpenSumsWp;

/**
 */
class Plugin {

    /** Name of the class to load an admin page. */
    protected $adminLoaderClass;

    /** @var self $instance Singleton instance. */
    protected static $instance;

    /** @var string Plugin name. */
    protected $name;

    /** @var string Path to the plugin. */
    protected $path;

    /** @var string Plugin slug (aka text domain). */
    protected $slug;

    /** @var mixed[] Configuration etc. */
    protected $values;

    /** @var string Current version. */
    protected $version;

    protected function __construct(string $path) {
        $this->path = $path;
        $this->values = [
            'plugin' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'version' => $this->version,
            ],
        ];

        // Load the module hooks.
        $this->load();
        // Load the module admin hooks.
        $cls = $this->adminLoaderClass ?? null;
        if (is_admin() && $cls) {
            new $cls($this);
        }
    }

    /**
     * Add a page under 'Settings' in the Admin menu.
     *
     * @param mixed{} $options Options for the menu entry.
     * - `title => string` <title> tag for the page.
     * - `label => string` Label for the menu entry.
     * - `permission => string` Permission required to show the entry.
     * - `slug => string` Unique slug used in the URI query string.
     * - `callback => callable` The action to call.
     * @return self Chainable.
     */
    public function addSettingsPage(array $settings = []): self {
        \add_options_page(
            $settings['title'] ?? "{$this->name} Settings", // html <title>
            $settings['label'] ?? "{$this->name}", // Menu label
            $settings['permission'] ?? 'manage_options', // Permission required
            $settings['slug'] ?? "{$this->slug}-options", // Slug
            $settings['callback'] ?? function () { echo("<h2>{$this->name}</h2>"); }, // Callback
        );
        return $this;
    }

    /**
     * Get the singleton instance.
     *
     * @param string $path The plugin's base path.
     * @return self  The singleton instance of the plugin.
     */
    public static function getInstance(string $path = null): self {
        if (!isset(static::$instance)) {
            static::$instance = new static($path);
        }
        return static::$instance;
    }

    /**
     * Set a value for use as a container.
     *
     * @param string $key The key.
     * @return mixed The value.
     */
    public function get(string $key) {
        return $this->values[$key];
    }

    public function render($template, $vars) {
        extract($this->values);
        extract($vars);
        require("{$this->path}/templates/{$template}.tpl.php");
    }

    public function set($key, $value = null) {
        if (is_array($key)) {
            $this->values = array_merge($this->values, $key);
        } else {
            $this->values[$key] = $value;
        }
    }

    protected function load() {}

    protected function loadAdmin() {}
}
