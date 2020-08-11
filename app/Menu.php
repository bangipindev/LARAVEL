<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public static function byName($name)
    {
        return self::where('name', '=', $name)->first();
    }

    public function items()
    {
        return $this->hasMany(MenuItems::class,'menu')->with('child')->where('parent', 0)->orderBy('sort', 'ASC');
    }
}
