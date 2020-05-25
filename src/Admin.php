<?php

namespace OpenSumsWpDev;

class Admin extends \OpenSumsWp\Admin {

    /** @var \OpenSumsWp\AdminPage The admin page. */
    protected $adminPage;

    protected function load(): void {
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

        $this->adminPage->addFields([
            [
                'id' => 'our_first_field',
                'label' => 'Awesome Date',
                'section' => 'section-1',
                'type' => 'text',
                'options' => false,
                'placeholder' => 'DD/MM/YYYY',
                'helper' => 'Does this help?',
                'supplemental' => 'I am underneath!',
                'default' => '01/01/2015',
            ],
            [
                'id' => 'our_second_field',
                'label' => 'Awesome Date',
                'section' => 'section-1',
                'type' => 'textarea',
                'helper' => 'Does this help?',
                'supplemental' => 'I am underneath!',
                'default' => '01/01/2015',
            ],
            [
                'id' => 'our_third_field',
                'label' => 'Awesome Select',
                'section' => 'section-1',
                'type' => 'select',
                'options' => [
                    'yes' => 'Yeppers',
                    'no' => 'No way dude!',
                    'maybe' => 'Meh, whatever.',
                ],
                'helper' => 'Does this help?',
                'supplemental' => 'I am underneath!',
                'default' => 'maybe',
            ],
        ]);
    }
}
