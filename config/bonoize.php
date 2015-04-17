<?php

return [
    'default' => 'Bonoize\Http\Controllers\BonoizeController',

    'mapping' => [
        '/user' => [
            'controller'  => null,
            'name'        => 'user',
            'middlewares' => 'auth|content',
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
