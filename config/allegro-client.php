<?php
return [
    // this resources has been auto load to layout
    'dist' => [
        'js/main.js',
        'js/main.legacy.js',
        'css/main.css',
    ],
    'routes' => [
        // all routes is active
        'active' => true,

        // Administrator section.
        'admin' => [
            'installation' => [
                'active' => true,
                'prefix' => '/installation/allegro-client',
                'name_prefix' => 'allegro_client.admin.installation.',
                // this routes has beed except for installation module
                'expect' => [
                    'module-assets.assets',
                    'allegro_client.admin.installation.index',
                    'allegro_client.admin.installation.store',
                    'allegro_client.admin.installation.index_default_setting',
                    'allegro_client.admin.installation.store_default_setting',
                ]
            ],
            'setting' => [
                'active' => true,
                'prefix' => '/admin/allegro-client/settings',
                'name_prefix' => 'allegro_client.admin.setting.',
                'middleware' => [
                    'web',
                    'auth',
                    'can:manage_allegro_client_settings'
                ]
            ],
        ],

        // User section.
        'user' => [
            'application' => [
                'active' => true,
                'prefix' => '/allegro-client/applications',
                'name_prefix' => 'allegro_client.user.application.',
                'middleware' => [
                    'web',
                    'auth',
                    'verified'
                ]
            ],

            'account' => [
                'active' => true,
                'prefix' => '/allegro-client/accounts',
                'name_prefix' => 'allegro_client.user.account.',
                'middleware' => [
                    'web',
                    'auth',
                    'verified'
                ]
            ],

            'callback' => [
                'active' => true,
                'prefix' => '/allegro-client/callback',
                'name_prefix' => 'allegro_client.user.callback.',
                'middleware' => [
                    'web',
                    'auth',
                    'verified',
                ]
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Use permissions in application.
    |--------------------------------------------------------------------------
    |
    | This permission has been insert to database with migrations
    | of module permission.
    |
    */
    'permissions' =>[
        'install_packages', 'manage_allegro_client_settings',
    ],

    /*
    |--------------------------------------------------------------------------
    | Can merge permissions to module permission
    |--------------------------------------------------------------------------
    */
    'merge_permissions' => true,

    'installation' => [
        'auto_redirect' => [
            // user with this permission has been automation redirect to
            // installation package
            'permission' => 'install_packages'
        ]
    ],

    'database' => [
        'tables' => [
            'users' => 'users',
            'allegro_client_settings' => 'allegro_client_settings',
            'allegro_client_applications'=> 'allegro_client_applications',
            'allegro_client_accounts' =>'allegro_client_accounts',
        ]
    ],

];
