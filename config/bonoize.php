<?php

return [
    'default' => 'Bonoize\Http\Controllers\BonoizeController',

    'transport' => [
        'default' => 'eloquent',

        'drivers' => [
            'eloquent' => [
                // Future feature:
                // - More options will come
            ],
        ],
    ],

    'mapping' => [
        '/user' => [
            'controller'  => null,
            'name'        => 'user',
            'middlewares' => 'auth|contentify',
        ],
    ],

    'schemas' => [
        'user' => [
            'name'     => app()->make('Bonoize\Schemas\Str'),
            'email'    => app()->make('Bonoize\Schemas\Email'),
            'password' => app()->make('Bonoize\Schemas\Password'),
        ],
    ],
];
