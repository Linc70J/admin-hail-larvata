<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Config;

class SideMenu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $menu = Config::get('administrator.menu', []);

        return view('widgets.side_menu', [
            'menu' => $menu,
        ]);
    }
}
