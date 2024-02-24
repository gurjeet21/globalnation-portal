<?php

return [
    "roles" => [
        'Super Admin' => ['dashboard', 'user', 'user.profile', 'user.update'],
        'Admin' => ['dashboard', 'user', 'user.add', 'user.profile', 'user.update', 'profile.destroy', 'twoFa', 'complete_registration'],
        'Creators' => ['dashboard', 'user.profile', 'user.update', 'profile.destroy', 'twoFa', 'complete_registration'],
    ],
];