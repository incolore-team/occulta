<?php
$nav = [
    [
        'title' => '概览',
        'icon' => 'fe fe-home',
        'rtype' => 'admin/home'
    ], [
        'title' => '插件',
        'icon' => 'fe fe-box',
        'rtype' => 'admin/plugins',
    ], [
        'title' => '主题',
        'icon' => 'fe fe-image',
        'rtype' => 'admin/themes',
        'children' => [
            [
                'title' => '管理主题',
                'rtype' => 'admin/theme/manage',
            ], [
                'title' => '主题商店',
                'rtype' => 'admin/theme/market',
            ]
        ]
    ], [
        'title' => '文章',
        'icon' => 'fe fe-file-text',
        'rtype' => 'admin/article',
        'children' => [
            [
                'title' => '新文章',
                'rtype' => 'admin/article/write',
            ], [
                'title' => '管理文章',
                'rtype' => 'admin/article/manage',
            ]
        ]
    ], [
        'title' => '页面',
        'icon' => 'fe fe-file',
        'rtype' => 'admin/extensions',
        'children' => [
            [
                'title' => '新页面',
                'rtype' => 'admin/home',
            ], [
                'title' => '管理页面',
                'rtype' => 'admin/home',
            ]
        ]
    ], [
        'title' => '更多',
        'icon' => 'fe fe-command',
        'rtype' => 'admin/extensions',
        'children' => [
            [
                'title' => '分类',
                'rtype' => 'admin/home',
            ], [
                'title' => '文集',
                'rtype' => 'admin/collection',
            ], [
                'title' => '扩展属性',
                'rtype' => 'admin/field/manage',
            ],
        ]
    ], [
        'title' => '设置',
        'icon' => 'fe fe-settings',
        'rtype' => 'admin/themes',
    ]
];
