<?php

return [
    'image' => [
        'path'      => '/uploads/news/img/',
        'validator' => 'mimes:jpeg,jpg,png|max:10000',
        'sizes'    => [
            'big'  => [
                'path'   => 'big/',
                'webp'   => 60,
                'width'  => 1920,
                'height' => false,
            ],
            'middle' => [
                'path'   => 'middle/',
                'webp'   => 100,
                'width'  => 760,
                'height' => false,
            ],
            'small'  => [
                'path'   => 'small/',
                'webp'   => false,
                'width'  => 375,
                'height' => false,
            ]
        ]
    ],
    'bg' => [
        'path'      => '/uploads/news/bg/',
        'validator' => 'mimes:jpeg,jpg,png|max:10000',
        'sizes'    => [
            'big'  => [
                'path'   => 'big/',
                'webp'   => 100,
                'width'  => 1000,
                'height' => false,
            ],
            'small'  => [
                'path'   => 'small/',
                'webp'   => 100,
                'width'  => 50,
                'height' => false,
            ]
        ]
    ],
    'file' => [
        'path'      => '/uploads/news/files/',
        'validator' => 'mimes:jpeg,jpg,png|max:10000',
    ]
];