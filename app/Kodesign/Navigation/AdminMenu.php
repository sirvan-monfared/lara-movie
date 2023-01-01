<?php

namespace App\Kodesign\Navigation;

use App\Models\Menu;

class AdminMenu
{
    public $menus_tree;

    /**
     * Instantiates the class
     * @param Menu $menu
     * @throws \Exception
     */
    public function __construct(Menu $menu)
    {
        $this->menus_tree = cache()->rememberForever($this->cacheKey(), function() use ($menu){
            return $menu->makeTree('admin');
        });
    }

    /**
     * Returns the cache key name
     *
     * @return string
     */
    public function cacheKey() {
        return 'admin_menus';
    }

    public function clearCache(){
        return cache()->forget($this->cacheKey());
    }

    public function render(){

        $this->clearCache();

        /** @var Menu $menu */
        foreach ($this->menus_tree as $menu) {
            if ($menu->hasChildren()) {
                echo $this->withChildrenMarkup($menu);
            } else {
                echo $this->withoutChildrenMarkup($menu);
            }
        }

        return false;
    }

    protected function withoutChildrenMarkup($menu)
    {
        return "
            <li class='m-menu__item' aria-haspopup='true' m-menu-link-redirect='1' id='menu-item-{$menu->id}'>
                <a href='{$menu->link()}' class='m-menu__link' target='{$menu->url_target}'>
                    <span class='m-menu__item-here'></span>
                    <i class='m-menu__link-icon {$menu->icon}'></i>
                    <span class='m-menu__link-text'>{$menu->title}</span>
                </a>
            </li>
        ";
    }

    protected function withChildrenMarkup(Menu $menu)
    {
        return "
            <li class='m-menu__item  m-menu__item--submenu' id='menu-item-{$menu->id}' aria-haspopup='true' m-menu-submenu-toggle='hover'>
                <a href='javascript:;' class='m-menu__link m-menu__toggle'>
                    <span class='m-menu__item-here'></span>
                    <i class='m-menu__link-icon {$menu->icon}'></i>
                    <span class='m-menu__link-text'>{$menu->title}</span>
                    <i class='m-menu__ver-arrow la la-angle-left'></i>
                </a>
                <div class='m-menu__submenu '><span class='m-menu__arrow'></span>
                    <ul class='m-menu__subnav'>
                        " . $this->childMarkup($menu->children) . "
                    </ul>
                </div>
            </li>
        ";
    }

    /**
     * Returns the markup for array of sub menus
     *
     * @param $children
     * @return string
     */
    protected function childMarkup($children)
    {
        $output = "";

        /** @var Menu $child */
        foreach ($children as $child) {
            $output .= "
                <li id='menu-item-{$child->id}' class='m-menu__item ' aria-haspopup='true'>
                    <a href='{$child->link()}' class='m-menu__link' target='{$child->url_target}'>
                        <i class='m-menu__link-bullet m-menu__link-bullet--dot'> <span></span></i>
                        <span class='m-menu__link-text'>{$child->title}</span>
                    </a>
                </li>
            ";
        }

        return $output;
    }
}
