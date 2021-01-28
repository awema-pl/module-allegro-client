<?php

return [
    'merge_to_navigation' => true,

    'navs' => [
        'sidebar' =>[
            [
                'name' => 'Allegro client',
                'link' => '/allegro-client/accounts',
                'icon' => 'speed',
                'key' => 'allegro-client::menus.allegro_client',
                'children_top' => [
                    [
                        'name' => 'Accounts',
                        'link' => '/allegro-client/accounts',
                        'key' => 'allegro-client::menus.accounts',
                    ],
                    [
                        'name' => 'Applications',
                        'link' => '/allegro-client/applications',
                        'key' => 'allegro-client::menus.applications',
                    ],
                ],
                'children' => [
                    [
                        'name' => 'Accounts',
                        'link' => '/allegro-client/accounts',
                        'key' => 'allegro-client::menus.accounts',
                    ],
                    [
                        'name' => 'Applications',
                        'link' => '/allegro-client/applications',
                        'key' => 'allegro-client::menus.applications',
                    ],
                ],
            ]
        ],
        'adminSidebar' =>[
            [
                'name' => 'Allegro client',
                'link' => '/admin/allegro-client/settings',
                'icon' => 'speed',
                'permissions' => 'manage_allegro_client_settings',
                'key' => 'allegro-client::menus.allegro_client',
                'children_top' => [
                    [
                        'name' => 'Settings',
                        'link' => '/admin/allegro-client/settings',
                        'key' => 'allegro-client::menus.settings',
                    ],
                ],
                'children' => [
                    [
                        'name' => 'Settings',
                        'link' => '/admin/allegro-client/settings',
                        'key' => 'allegro-client::menus.settings',
                    ],
                ],
            ]
        ]
    ]
];
