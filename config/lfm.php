<?php

/*
|--------------------------------------------------------------------------
| Documentation for this config :
|--------------------------------------------------------------------------
| online  => http://unisharp.github.io/laravel-filemanager/config
| offline => vendor/unisharp/laravel-filemanager/docs/config.md
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
     */

    'use_package_routes'       => true,

    /*
    |--------------------------------------------------------------------------
    | Shared folder / Private folder
    |--------------------------------------------------------------------------
    |
    | If both options are set to false, then shared folder will be activated.
    |
     */

    'allow_private_folder'     => true,

    // Flexible way to customize client folders accessibility
    // If you want to customize client folders, publish tag="lfm_handler"
    // Then you can rewrite userField function in App\Handler\ConfigHandler class
    // And set 'user_field' to App\Handler\ConfigHandler::class
    // Ex: The private folder of user will be named as the user id.
    'private_folder_name'      => UniSharp\LaravelFilemanager\Handlers\ConfigHandler::class,

    'allow_shared_folder'      => false,

    'shared_folder_name'       => 'shares',

    /*
    |--------------------------------------------------------------------------
    | Folder Names
    |--------------------------------------------------------------------------
     */

    'folder_categories'        => [
        'file'  => [
            'folder_name'  => 'lr_files/files',
            'startup_view' => 'list',
            'max_size'     => 100000, // size in KB
            'thumb' => false,
            'thumb_width' => 80,
            'thumb_height' => 80,
            'valid_mime'   => [
                'application/msword',
                'application/octet-stream',
                'application/pdf',
                'application/rtf',
                'application/vnd',
                'application/vnd.ms-excel',
                'application/vnd.ms-office',
                'application/vnd.ms-powerpoint',
                'application/vnd.oasis.opendocument.text',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/x-compressed',
                'application/x-rar-compressed',
                'application/x-zip-compressed',
                'application/zip',
                'audio/mp3',
                'audio/mp4',
                'audio/mpeg',
                'audio/ogg',
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/svg+xml',
                'image/webp',
                'multipart/x-zip',
                'text/css',
                'text/html',
                'text/plain',
                'text/xml',
                'video/mp4',
                'video/ogg',
                'video/webm',
                'video/x-flv',
                'video/x-m4v',
                'video/x-ms-wmv',
                'video/x-msvideo',
            ],
        ],
        'image' => [
            'folder_name'  => 'lr_files/images',
            'startup_view' => 'list',
            'max_size'     => 100000, // size in KB
            'thumb' => false,
            'thumb_width' => 80,
            'thumb_height' => 80,
            'valid_mime'   => [
                'image/gif',
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/svg+xml',
                'image/webp',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
     */

    'paginator' => [
        'perPage' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload / Validation
    |--------------------------------------------------------------------------
     */

    'disk'                     => 'public_uploads',

    'rename_file'              => true,

    'rename_duplicates'        => false,

    'alphanumeric_filename'    => true,

    'alphanumeric_directory'   => true,

    'should_validate_size'     => false,

    'should_validate_mime'     => true,

    // behavior on files with identical name
    // setting it to true cause old file replace with new one
    // setting it to false show `error-file-exist` error and stop upload
    'over_write_on_duplicate'  => false,

    // mimetypes of executables to prevent from uploading
    'disallowed_mimetypes' => ['text/x-php', 'text/html', 'text/plain'],

    // Item Columns
    'item_columns' => ['name', 'url', 'time', 'icon', 'is_file', 'is_image', 'thumb_url'],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
     */

    // If true, image thumbnails would be created during upload
    'should_create_thumbnails' => false,

    'thumb_folder_name'        => 'thumbs',

    // Create thumbnails automatically only for listed types.
    'raster_mimetypes'         => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
    ],

    'thumb_img_width'          => 200, // px

    'thumb_img_height'         => 200, // px

    /*
    |--------------------------------------------------------------------------
    | File Extension Information
    |--------------------------------------------------------------------------
     */

    'file_type_array'          => [
        'pdf'  => 'Adobe Acrobat',
        'doc'  => 'Microsoft Word',
        'docx' => 'Microsoft Word',
        'xls'  => 'Microsoft Excel',
        'xlsx' => 'Microsoft Excel',
        'zip'  => 'Archive',
        'gif'  => 'GIF Image',
        'jpg'  => 'JPEG Image',
        'jpeg' => 'JPEG Image',
        'png'  => 'PNG Image',
        'ppt'  => 'Microsoft PowerPoint',
        'pptx' => 'Microsoft PowerPoint',
    ],

    /*
    |--------------------------------------------------------------------------
    | php.ini override
    |--------------------------------------------------------------------------
    |
    | These values override your php.ini settings before uploading files
    | Set these to false to ingnore and apply your php.ini settings
    |
    | Please note that the 'upload_max_filesize' & 'post_max_size'
    | directives are not supported.
     */
    'php_ini_overrides'        => [
        'memory_limit' => '256M',
    ],
];
