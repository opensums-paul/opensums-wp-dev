<?php

/**
 * File header goes here.
 */

namespace OpenSumsWp;

/**
 */
class Plugin {
    // --- YOU MUST OVERRIDE THESE IN THE PLUGIN CLASS -------------------------
    /** @var string Name of the admin class. */
    protected $adminClass;

    /** @var string Plugin human name. */
    protected $name;

    /** @var string Plugin slug (aka text domain). */
    protected $slug;

    /** @var string Current version. */
    protected $version;
    // -------------------------------------------------------------------------

    /** @var self $instance Singleton instance. */
    protected static $instance;

    /** @var string Path to the plugin. */
    protected $path;

    /** @var mixed[] Configuration etc. */
    protected $values;

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
    public function slugify(string $slug = null, $separator = null): string {
        if ($slug === null) {
            $ret = $this->slug;
        } else {
            $ret = "{$this->slug}-{$slug}";
        }
        if ($separator === null) {
            return $ret;
        }
        return str_replace('-', $separator, $ret);
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
