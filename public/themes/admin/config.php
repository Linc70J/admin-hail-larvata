<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists, this
    | is work with "layouts", "partials", "views" and "widgets"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities this is cool
    | feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => array(

        'before' => function ($theme) {
            $theme->setTitle('後台管理介面');
            $theme->setAuthor('Larvata');
        },

        'asset' => function ($asset) {
            $asset->themePath()->add([
                ['vendor-style', 'css/vendors.bundle.css'],
                ['style', 'css/style.bundle.css', ['vendor-style']],
                ['header-base-style', 'css/skins/header/base/light.css', ['style']],
                ['header-menu-style', 'css/skins/header/menu/light.css', ['style']],
                ['brand-style', 'css/skins/brand/dark.css', ['style']],
                ['aside-style', 'css/skins/aside/dark.css', ['style']],
                ['vendor-script', 'js/vendors.bundle.js'],
                ['script', 'js/scripts.bundle.js', ['vendor-script']]
            ]);

            // You may use elixir to concat styles and scripts.
            $asset->themePath()->add([
                ['common-styles', 'css/style.css'],
                ['common-scripts', 'js/script.js']
            ]);

            // Or you may use this event to set up your assets.
            /*
            $asset->themePath()->add('core', 'core.js');
            $asset->add([
                            ['jquery', 'vendor/jquery/jquery.min.js'],
                            ['jquery-ui', 'vendor/jqueryui/jquery-ui.min.js', ['jquery']]
                        ]);
            */
        },

        'beforeRenderTheme' => function ($theme) {
            // To render partial composer
            /*
            $theme->partialComposer('header', function($view){
                $view->with('auth', Auth::user());
            });
            */

        },

        'beforeRenderLayout' => array(

            'mobile' => function ($theme) {
                // $theme->asset()->themePath()->add('ipad', 'css/layouts/ipad.css');
            }

        )

    )

);
