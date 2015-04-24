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

            // More drivers will come, you can create Mock Driver to get data for Controller
        ],
    ],

    'mapping' => [
        '/user' => [
            'controller'  => null,
            'name'        => 'user',
            'middlewares' => 'auth|criteria|contentify',
        ],
    ],

    'schemas' => [
        'user' => [
            'name'     => app()->make('Bonoize\Schemas\Str'),
            'email'    => app()->make('Bonoize\Schemas\Email'),
            'age'      => app()->make('Bonoize\Schemas\Integer'),
            'password' => app()->make('Bonoize\Schemas\Password'),
        ],
    ],

];
