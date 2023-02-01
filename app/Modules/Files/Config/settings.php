<?php

return [
    'group' => [
        'title'     => trans('AdminPanel::adminpanel.system_group'),
        'name'      => 'system_group',
        'icon'      => 'fa fa-list',
        'priority'  => 2,
    ],
    'menu_items' => [
        [
            'icon'      => 'fa fa-files-o',
            'route'     => 'admin.files.filesView',
            'group'     => 'system_group',
            'title'     => trans('Files::adminpanel.files'),
            'priority'  => 50,
        ],
        [
            'icon'      => 'fa fa-file-image-o',
            'route'     => 'admin.images.imagesView',
            'group'     => 'system_group',
            'title'     => trans('Files::adminpanel.images'),
            'priority'  => 50,
        ],
    ],
];