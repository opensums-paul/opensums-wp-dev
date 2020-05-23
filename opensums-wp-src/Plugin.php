<?php

namespace OpenSumsWp;

class Plugin {

    /** @var self Singleton instance. */
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

    protected function __construct($path) {
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

    public static function getInstance($path) {
        if (!isset(static::$instance)) {
            static::$instance = new static($path);
        }
        return static::$instance;
    }

    public function get($key) {
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
