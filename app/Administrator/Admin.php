<?php

namespace App\Administrator;

use App\Administrator\Config\Factory as ConfigFactory;
use Illuminate\Config\Repository as Config;

class Admin
{
    /**
     * The config instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * The config instance.
     *
     * @var \App\Administrator\Config\Factory
     */
    protected $configFactory;

    /**
     * Create a new Admin instance.
     *
     * @param \Illuminate\Config\Repository $config
     * @param \App\Administrator\Config\Factory $config
     */
    public function __construct(Config $config, ConfigFactory $configFactory)
    {
        $this->config = $config;
        $this->configFactory = $configFactory;
    }

    public static function getCSS()
    {
        $css = array();

        //localization css assets
        $locale = config('app.locale');

        if ($locale !== 'en') {
            $css += array();
        }

        return $css;
    }

    public static function getScript()
    {
        $js = array();

        //localization js assets
        $locale = config('app.locale');

        if ($locale !== 'en') {
            $js += array();
        }

        return $js;
    }

    /**
     * Gets the menu items indexed by their name with a value of the title.
     *
     * @param array $subMenu (used for recursion)
     *
     * @return array
     */
    public function getMenu($subMenu = null)
    {
        $menu = array();

        if (!$subMenu) {
            $subMenu = $this->config->get('administrator.menu');
        }

        //iterate over the menu to build the return array of valid menu items
        foreach ($subMenu as $key => $item) {
            //if the item is a string, find its config
            if (is_string($item)) {
                //fetch the appropriate config file
                $config = $this->configFactory->make($item);

                //if a config object was returned and if the permission passes, add the item to the menu
                if (is_a($config, 'App\Administrator\Config\Config') && $config->getOption('permission')) {
                    $menu[$item] = $config->getOption('title');
                } //otherwise if this is a custom page, add it to the menu
                elseif ($config === true) {
                    $menu[$item] = $key;
                }
            } //if the item is an array, recursively run this method on it
            elseif (is_array($item)) {
                $menu[$key] = $this->getMenu($item);

                //if the submenu is empty, unset it
                if (empty($menu[$key])) {
                    unset($menu[$key]);
                }
            }
        }

        return $menu;
    }
}
