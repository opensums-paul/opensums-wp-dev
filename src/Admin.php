<?php

namespace OpenSumsWpDev;

class Admin extends \OpenSumsWp\Admin {

    protected $adminPage;

    protected function load():void {
        $this->adminPage = new \OpenSumsWp\AdminPage($this->plugin, [
            'template' => 'admin/settings-page',
            'sectionTemplate' => 'admin/settings-page-sections',
        ]);
        $this->adminPage->addSections([
            [
                'id' => 'section-1',
                'title' => 'Section 1',
            ],
            [
                'id' => 'section-2',
                'title' => 'Section 2',
            ],
            [
                'id' => 'section-3',
                'title' => 'Section 3',
            ],
        ]);
    }
}
