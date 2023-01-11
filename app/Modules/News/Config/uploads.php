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
    'multi_images' => [
        'path'      => '/uploads/news/multi_images/',
        'validator' => 'mimes:jpeg,jpg,png|max:10000',
        'multiple'  => true,
        'save_type' => 'as_image',
        'field_name' => 'name',
        // 'width'  => 500,
        // 'height' => false,
        // 'sizes'    => [
        //     'big'  => [
        //         'path'   => 'big/',
        //         'webp'   => 60,
        //         'width'  => 500,
        //         'height' => false,
        //     ],
        //     'small'  => [
        //         'path'   => 'small/',
        //         'webp'   => false,
        //         'width'  => 375,
        //         'height' => false,
        //     ]
        // ]
    ],
    'file' => [
        'path'      => '/uploads/news/files/',
        'validator' => 'max:50000',
        'field_name' => 'file_name',
        'field_size' => 'file_size',
    ],
    'multi_files' => [
        'path'      => '/uploads/news/multi_files/',
        'validator' => 'max:100000',
        'multiple'  => true,
        'save_type' => 'as_file',
        'field_name' => 'file_name',
        'field_size' => 'file_size',
    ],
];