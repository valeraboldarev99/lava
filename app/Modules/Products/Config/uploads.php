<?php

return [
    'image' => [
        'path'      => '/uploads/products/img/',
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
        'path'      => '/uploads/products/bg/',
        'validator' => 'max:10000',
    ],
    'file' => [
        'path'      => '/uploads/products/files/',
        'validator' => 'max:50000',
        'field_name' => 'file_name',
        'field_size' => 'file_size',
    ],
    'file2' => [
        'path'      => '/uploads/products/files2/',
        'validator' => 'max:50000',
        'field_name' => 'file_name2',
        'field_size' => 'file_size2',
    ],

    // category
    'category_image' => [
        'path'      => '/uploads/products/category_img/',
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
    'category_bg' => [
        'path'      => '/uploads/products/category_bg/',
        'validator' => 'max:10000',
    ],
    'category_file' => [
        'path'      => '/uploads/products/category_files/',
        'validator' => 'max:50000',
        'field_name' => 'category_file_name',
        'field_size' => 'category_file_size',
    ],
    'category_file2' => [
        'path'      => '/uploads/products/category_files2/',
        'validator' => 'max:50000',
        'field_name' => 'category_file_name2',
        'field_size' => 'category_file_size2',
    ],

    // multi_uploading products
    'products_multi_images1' => [
        'path'      => '/uploads/products/products_multi_images1/',
        'validator' => 'mimes:png|max:10000',
        'multiple'  => true,
        'save_type' => 'as_image',
        'field_name' => 'name',
        'sizes'    => [
            'big'  => [
                'path'   => 'big/',
                'webp'   => 60,
                'width'  => 500,
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
    'products_multi_files1' => [
        'path'      => '/uploads/products/products_multi_files1/',
        'validator' => 'max:100000',
        'multiple'  => true,
        'save_type' => 'as_file',
        'field_name' => 'file_name',
        'field_size' => 'file_size',
    ],
    'products_multi_images2' => [
        'path'      => '/uploads/products/products_multi_images2/',
        'validator' => 'mimes:png|max:10000',
        'multiple'  => true,
        'save_type' => 'as_image',
        'field_name' => 'name',
    ],
    'products_multi_files2' => [
        'path'      => '/uploads/products/products_multi_files2/',
        'validator' => 'max:100000',
        'multiple'  => true,
        'save_type' => 'as_file',
        'field_name' => 'file_name',
        'field_size' => 'file_size',
    ],
];