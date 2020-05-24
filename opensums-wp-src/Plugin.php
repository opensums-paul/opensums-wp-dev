<?php
/**
 */

namespace OpenSumsWp;

/**
 */
class Plugin {

    /** @var self $instance Singleton instance. */
    protected static $instance;

    /** @var string Plugin name. */
    protected $name;

    /** @var string Plugin slug (aka text domain). */
    protected $slug;

    /** @var string Path to the plugin. */
    protected $path;

    /** @var string Current version. */
    protected $version;

    /** @var mixed[] Configuration etc. */
    protected $values;

    protected function __construct(string $path) {
        $this->path = $path;
        $this->name = static::NAME;
        $this->slug = static::SLUG;
        $this->version = static::VERSION;
        $this->values = [
            'plugin' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'version' => $this->version,
            ],
        ];
        $this->load();
        if (is_admin()) {
            $this->loadAdmin();
        }
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
