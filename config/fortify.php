<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'middleware' => ['web'],
    'auth_middleware' => 'auth',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'views' => false,
    'home' => '/dashboard',
    'prefix' => '',
    'domain' => null,
    'lowercase_usernames' => false,
    'limiters' => [
        'login' => null,
        'passkeys' => null,
    ],
    'features' => [
        // Features::registration(), // Disable public self-registration
        Features::resetPasswords(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
    ],
];
