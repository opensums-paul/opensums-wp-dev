<?php

namespace OpenSumsWpDev;

class Admin extends \OpenSumsWp\Admin {

    protected $adminPage;

    protected function load():void {
        $this->adminPage = new \OpenSumsWp\AdminPage($this->plugin, [
            'template' => 'admin/settings-page',
        ]);
    }
}
