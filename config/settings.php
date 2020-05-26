<?php

return [
    // Stored in the `wp_options` table.
    'options' => [

        // Stored under `dutyman-user`.
        'user' => [
            // Users with the `manage_options` capability can edit fields in this group.
            'capability' => 'manage_options',
            'fields' => [
                'dutyman-id' => [],
                'embed-css' => [],
            ],
        ],

        // Stored under `dutyman-data`.
        'data' => [
            'fields' => [
                'dutyman-title' => [],
                'stylesheets' => [
                    'type' => 'array',
                    'default' => [],
                ],
            ],
        ],

        // Stored under `dutyman-config`.
        'config' => [
            'fields' => [
                'dutyman-home-uri' => [
                    'default' => 'https://dutyman.biz/',
                ],
                'dutyman-home-link' => [
                ],
                'dutyman-default-stylesheet' => [
                    'default' => 'https://dutyman.biz/css/default.css',
                ],
                'dutyman-embed-stylesheet' => [
                    'default' => 'https://dutyman.biz/scripts/dmembed.css',
                ],
            ],
        ],
    ],
];
