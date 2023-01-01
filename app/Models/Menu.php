<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * returns the tree of parents and children (maximum of 2 level depth) as a collection
     *
     * @param null $type
     * @return array
     */
    public static function makeTree($type = null)
    {
        return static::with([
            'children' => function ($q) use ($type) {
                $q->with(['children' => function ($q) use ($type) {
                    $q->with(['children' => function ($q) use ($type) {
                        $q->with(['children' => function ($q) use ($type) {
                            $q->type($type)->sort();
                        }])->type($type)->sort();
                    }])->type($type)->sort();
                }])->type($type)->sort();
            }
        ])->type($type)->root()->sort()->get();
    }

    /**
     * Returns instance of menu class with the given type
     *
     * @param string $type
     * @return mixed
     */
    public static function getInstance($type = 'admin')
    {
        $menu_class_name = 'App\Kodesign\Navigation\\' . ucfirst($type) . 'Menu';
        return new $menu_class_name(new static);
    }

    /**
     * Each item van have many children
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    /**
     * Each item can have one parent
     *
     * @return HasOne
     */
    public function parent()
    {
        return $this->hasOne(Menu::class, 'id', 'parent_id');
    }

    /**
     * Scope to return only parent menus
     *
     * @param $query
     * @return mixed
     */
    public function scopeRoot($query)
    {
        return $query->where('parent_id', 0);
    }

    /**
     * Scope to eager load any depth of children
     *
     * @param $query
     * @param int $depth
     * @return
     */
    public function scopeEagerChildren($query, $depth = 2)
    {
        return $query->with(implode('.', array_fill(0, $depth, 'children')));
    }

    /**
     * Scope to get only active items
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope to get items with the requested type
     *
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to sort the result properly
     *
     * @param $query
     * @return mixed
     */
    public function scopeSort($query)
    {
        return $query->orderBy('sort', 'ASC');
    }

    /**
     * adds the given item to list of children
     *
     * @param Menu $child
     * @return Menu
     */
    public function createChild(Menu $child)
    {
        $child->parent_id = $this->id;

        $child->save();

        return $this;
    }

    /**
     * makes the current menu the child of the given item
     *
     * @param Menu $parent
     * @return Menu
     */
    public function makeChildOf(Menu $parent)
    {
        $this->parent_id = $parent->id;

        $this->save();

        return $this;
    }

    /**
     * Check if item is parent or not
     *
     * @return bool
     */
    public function isRoot()
    {
        return ($this->parent_id == 0);
    }

    /**
     * Check if menu has any children or not
     *
     * @return bool
     */
    public function hasChildren()
    {
        return (count($this->children) > 0);
    }

    /**
     * Return all the root items
     *
     * @return mixed
     */
    public function roots()
    {
        return Menu::root()->get();
    }

    /**
     * loads all the children within the requested depth
     *
     * @param int $depth
     * @return Menu
     */
    public function loadChildren($depth = 2)
    {
        return $this->load(implode('.', array_fill(0, $depth, 'children')));
    }

    public function link()
    {
        if (! empty($this->route)) {
            return route($this->route);
        }

        return $this->url;
    }
}
