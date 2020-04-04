<?php
/*
    API Parameters rules
    Auto generated at 2020-04-04 20:24:03
*/
return [
    '/api/admin/article' => [
        'POST' => [
            'title' => [
                'type' => 'string',
                'required' => true,
            ],
            'text' => [
                'type' => 'string',
                'min' => 1,
                'max' => 0,
                'required' => true,
            ],
            'slug' => [
                'type' => 'string',
            ],
            'summary' => [
                'type' => 'string',
            ],
            'visible' => [
                'type' => 'boolean',
            ],
            'status' => [
                'type' => 'integer',
            ],
            'allowComment' => [
                'type' => 'boolean',
            ],
            'tags' => [
                'type' => 'array',
            ],
            'category' => [
                'type' => 'integer',
            ],
            '__permission' => 'api.admin.article.write',
        ],
    ],
    '/api/admin/article/@id' => [
        'PUT' => [
            'title' => [
                'type' => 'string',
                'required' => true,
            ],
            'text' => [
                'type' => 'string',
                'required' => true,
            ],
            'slug' => [
                'type' => 'string',
            ],
            '__permission' => 'api.admin.article.update',
        ],
        'DELETE' => [
            '__permission' => 'api.admin.article.delete',
        ],
        'GET' => [
            '__permission' => 'admin.article.get',
        ],
    ],
    '/api/admin/article/list' => [
        'GET' => [
            'page' => [
                'type' => 'integer',
                'min' => 1,
                'max' => 0,
                'default' => 1,
            ],
            'perpage' => [
                'type' => 'integer',
                'min' => 1,
                'max' => 2000,
                'default' => 20,
            ],
            'countTotal' => [
                'type' => 'boolean',
                'default' => 'true',
            ],
            'columns' => [
                'type' => 'array',
            ],
            'where' => [
                'type' => 'array',
            ],
            '__permission' => 'api.admin.article.list',
        ],
    ],
    '/api/admin/article/@id/status' => [
        'PUT' => [
            'status' => [
                'type' => 'string',
                'required' => true,
            ],
            '__permission' => 'admin.article.get',
        ],
    ],
    '/api/auth/login' => [
        'POST' => [
            'username' => [
                'type' => 'string',
                'required' => true,
            ],
            'password' => [
                'type' => 'string',
                'required' => true,
            ],
            '__permission' => 'none',
        ],
    ],
    '/api/auth/logout' => [
        'POST' => [
            '__permission' => 'api.auth.logout',
        ],
    ],
    '/api/auth.info' => [
        'GET' => [
            '__permission' => 'api.auth.info',
        ],
    ],
    '/api/content/' => [
        'POST' => [
            '__permission' => 'none',
        ],
    ],
    '/api/admin/field/meta' => [
        'POST' => [
            'name' => [
                'type' => 'string',
                'required' => true,
            ],
            'option' => [
                'type' => 'string',
                'required' => true,
            ],
            'slug' => [
                'type' => 'string',
                'required' => true,
            ],
            'param' => [
                'type' => 'string',
            ],
            '__permission' => 'api.admin.field.meta.add',
        ],
    ],
    '/api/admin/field/meta/list/@name' => [
        'GET' => [
            '__permission' => 'api.admin.field.meta.list',
        ],
    ],
    '/api/admin/field/meta/@id' => [
        'PUT' => [
            'option' => [
                'type' => 'string',
                'required' => true,
            ],
            'slug' => [
                'type' => 'string',
                'required' => true,
            ],
            '__permission' => 'api.admin.field.meta.update',
        ],
        'DELETE' => [
            '__permission' => 'api.admin.field.meta.remove',
        ],
    ],
    '/api/admin/content/@id/field' => [
        'GET' => [
            'full' => [
                'type' => 'bool',
                'default' => 'false',
            ],
            '__permission' => 'api.admin.content.field.get',
        ],
        'POST' => [
            'properties' => [
                'type' => 'array',
                'required' => true,
            ],
            '__permission' => 'api.admin.content.field.get',
        ],
    ],
    '/api' => [
        'GET' => [
            '__permission' => 'none',
        ],
    ],
    '/api/admin/page' => [
        'POST' => [
            'title' => [
                'type' => 'string',
                'required' => true,
            ],
            'text' => [
                'type' => 'string',
                'min' => 1,
                'max' => 0,
                'required' => true,
            ],
            'slug' => [
                'type' => 'string',
            ],
            'summary' => [
                'type' => 'string',
            ],
            'visible' => [
                'type' => 'boolean',
            ],
            'status' => [
                'type' => 'integer',
            ],
            'allowComment' => [
                'type' => 'boolean',
            ],
            'tags' => [
                'type' => 'array',
            ],
            'category' => [
                'type' => 'integer',
            ],
            '__permission' => 'api.admin.page.write',
        ],
    ],
    '/api/admin/page/@id' => [
        'PUT' => [
            'title' => [
                'type' => 'string',
                'required' => true,
            ],
            'text' => [
                'type' => 'string',
                'required' => true,
            ],
            'slug' => [
                'type' => 'string',
            ],
            '__permission' => 'api.admin.page.update',
        ],
        'DELETE' => [
            '__permission' => 'api.admin.page.delete',
        ],
        'GET' => [
            '__permission' => 'admin.page.get',
        ],
    ],
    '/api/admin/page/list' => [
        'GET' => [
            'page' => [
                'type' => 'integer',
                'min' => 1,
                'max' => 0,
                'default' => 1,
            ],
            'perpage' => [
                'type' => 'integer',
                'min' => 1,
                'max' => 2000,
                'default' => 20,
            ],
            'countTotal' => [
                'type' => 'boolean',
                'default' => 'true',
            ],
            'columns' => [
                'type' => 'array',
            ],
            'where' => [
                'type' => 'array',
            ],
            '__permission' => 'api.admin.page.list',
        ],
    ],
    '/archive/@uuid' => [
        'GET' => [
            '__permission' => 'none',
        ],
    ],
    '/' => [
        'GET' => [
            '__permission' => 'none',
        ],
    ],
    '/page/@page' => [
        'GET' => [
            '__permission' => 'none',
        ],
    ],
    '/search' => [
        'GET' => [
            's' => [
                'type' => 'string',
                'min' => 2,
                'max' => 0,
                'required' => true,
            ],
            '__permission' => 'none',
        ],
    ],
    '/search/page/@page' => [
        'GET' => [
            's' => [
                'type' => 'string',
                'min' => 2,
                'max' => 0,
                'required' => true,
            ],
            '__permission' => 'none',
        ],
    ],
    '/@slug:.*\\.html' => [
        'GET' => [
            '__permission' => 'none',
        ],
    ],
    '/assets/*' => [
        'GET' => [
            '__permission' => 'none',
        ],
    ],
    '/admin/article/write(/@id)' => [
        'GET' => [
            '__permission' => 'admin.article.write',
        ],
    ],
    '/admin/article/manage' => [
        'GET' => [
            '__permission' => 'admin.article.manage',
        ],
    ],
    '/admin/article/manage/page/@page' => [
        'GET' => [
            '__permission' => 'none',
        ],
    ],
    '/admin/login' => [
        'GET' => [
            '__permission' => 'none',
        ],
        'POST' => [
            'username' => [
                'type' => 'string',
                'required' => true,
            ],
            'password' => [
                'type' => 'string',
                'required' => true,
            ],
            '__permission' => 'none',
        ],
    ],
    '/admin/collection/manage' => [
        'GET' => [
            '__permission' => 'admin.collection.manage',
        ],
    ],
    '/admin/field/manage' => [
        'GET' => [
            '__permission' => 'admin.article.manage',
        ],
    ],
    '/admin(/@page)' => [
        'GET' => [
            '__permission' => 'admin.home.index',
        ],
    ],
    '/admin/page/write(/@id)' => [
        'GET' => [
            '__permission' => 'admin.page.write',
        ],
    ],
    '/admin/page/manage' => [
        'GET' => [
            '__permission' => 'admin.page.manage',
        ],
    ],
    '/admin/page/manage/page/@page' => [
        'GET' => [
            '__permission' => 'none',
        ],
    ],
    '/admin/theme/manage' => [
        'GET' => [
            '__permission' => 'admin.theme.manage',
        ],
    ],
    '__permissions' => [
        0 => 'api.admin.article.write',
        1 => 'api.admin.article.update',
        2 => 'api.admin.article.delete',
        3 => 'api.admin.article.list',
        4 => 'admin.article.get',
        5 => 'api.auth.logout',
        6 => 'api.auth.info',
        7 => 'api.admin.field.meta.add',
        8 => 'api.admin.field.meta.list',
        9 => 'api.admin.field.meta.update',
        10 => 'api.admin.field.meta.remove',
        11 => 'api.admin.content.field.get',
        12 => 'api.admin.page.write',
        13 => 'api.admin.page.update',
        14 => 'api.admin.page.delete',
        15 => 'api.admin.page.list',
        16 => 'admin.page.get',
        17 => 'admin.article.write',
        18 => 'admin.article.manage',
        19 => 'admin.collection.manage',
        20 => 'admin.home.index',
        21 => 'admin.page.write',
        22 => 'admin.page.manage',
        23 => 'admin.theme.manage',
    ],
];