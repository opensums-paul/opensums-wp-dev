<?php
/**
 */

namespace OpenSumsWp;

/**
 */
class Plugin {

    /** Name of the admin class for this plugin. */
    protected $adminClass;

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
        $cls = $this->adminClass ?? null;
        if (is_admin() && $cls) {
            new $cls($this);
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
     * Get a prefixed slug.
     *
     * @param string $path The slug to be prefixed.
     * @return string The slug with an added prefix.
     */
    public function getSlug(string $slug = null): string {
        if ($slug === null) {
            return $this->slug;
        }
        return "{$this->slug}-{$slug}";
    }

    /**
     * Get all the values.
     *
     * @return mixed[] The values.
     */
    public function all() {
        return $this->values;
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
}
