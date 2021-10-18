<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'nama',
        'sts',
        'updated_by',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function menus()
    {
        $groups = $this->groups()->get();
        $menu = collect();

        foreach($groups as $group)
        {
            $menu = $menu->merge($group->menus()->get());
        }

        $menu = $menu->unique('id')->sortBy('menu_sort');

        return $menu;
    }

    public function hasPermissionTo($permission)
    {
        $permission = Menu::where('menu_link',$permission)->first();

        if($permission !== null) {
            return true;
        }

        return false;
    }
}
