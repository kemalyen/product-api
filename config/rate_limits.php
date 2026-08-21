<?php

return [
    // Default limits per role (requests per minute)
    'user' => [
        'guest' => 30,
        'standard' => 60,
        'premium' => 120,
    ],
    'product' => [
        'guest' => 30,
        'standard' => 80,
        'premium' => 200,
    ],
    'price' => [
        'guest' => 10,
        'standard' => 30,
        'premium' => 60,
    ],
];
