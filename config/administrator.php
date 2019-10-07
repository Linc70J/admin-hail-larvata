<?php

return array(
    // 後台菜單，二維數據嵌套
    // 關鍵字(保留字)說明：
    // type:型態設定，必填項目，可設定為"link"或"menu"
    // icon:圖示設定，可選項目，可輸入HTML
    // menu:餐單設定，搭配型態"menu"使用，可使用
    // link:連結設定，搭配型態"link"使用，可使用route()或直接打URL
    // permission:權限設定，可選項目，可使用 Closure function
    'menu' => [
        'Dashboard' => [
            'type' => 'link',
            'icon' => '<i class="fa fa-tachometer-alt"></i>',
            'link' => function () {
                return route('dashboard');
            },
            'permission' => function () {
                return true;
            },
        ],
        '用戶與權限' => [
            'type' => 'menu',
            'menu' => [
                '用戶' => [
                    'type' => 'link',
                    'icon' => '<i class="fa fa-user-alt"></i>',
                    'link' => function () {
                        return route('users.index');
                    },
                ],
                '職務' => [
                    'type' => 'link',
                    'icon' => '<i class="fa fa-user-tag"></i>',
                    'link' => function () {
                        return route('roles.index');
                    },
                ],
            ],
            'permission' => function () {
                return Auth::user()->hasRole('Founder');
            },
        ],
        '内容管理' => [
            'type' => 'menu',
            'menu' => [
                '分類' => [
                    'type' => 'link',
                    'icon' => '<i class="fa fa-object-group"></i>',
                    'link' => function () {
                        return route('topic_categories.index');
                    },
                ],
                '話題' => [
                    'type' => 'link',
                    'icon' => '<i class="fa fa-comments"></i>',
                    'link' => function () {
                        return route('topics.index');
                    },
                ],
            ]
        ],
        '站點管理' => [
            'type' => 'menu',
            'menu' => [
                '站點設定' => [
                    'type' => 'link',
                    'icon' => '<i class="fa fa-cogs"></i>',
                    'link' => function () {
                        return route('settings.index');
                    }
                ],
            ],
        ],
    ],

    // 權限控制的回調函數。
    'permission' => function () {
        // 只要是能管理内容的用戶，就允許訪問後台
        return Auth::check() && Auth::user()->can('manage_contents');
    },
);
