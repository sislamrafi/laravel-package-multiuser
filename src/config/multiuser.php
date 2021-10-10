<?php

return [
    'roles' => [
        'superadmin' => [
            'name'=>'Super Admin',
            'redirect' => 'multiuser.root',
            'registerable' => false,
        ],
        'player' => [
            'name'=>'Player Login',
            'redirect' => 'multiuser.rooti',
            'registerable' => false,
        ],
        'user' => [
            'name'=>'User Login',
            'redirect' => 'user.home',
            'registerable' => true,
        ],
    ],
];