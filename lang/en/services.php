<?php

declare(strict_types=1);

return [
    'v1' => [
        'create' => [
            'success' => 'We will create your service in the background.',
            'failure' => 'You must verify your email before creating a new service',
        ],
        'update' => [
            'success' => 'We will update your service in the background.',
            'failure' => 'You are not able to update a service that you do not own service.',
        ],
        'delete' => [
            'success' => 'We will delete your service in the background.',
            'failure' => 'You cannot delete a service that you do not own.',
        ]
    ]
];
