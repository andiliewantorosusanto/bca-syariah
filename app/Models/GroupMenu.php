<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMenu extends Model
{
    use HasFactory;

    protected $table = 'group_menu';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'menu_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function groups()
    {
        return $this->belongsTo('App\Models\Group','group_id');
    }

    public function menus()
    {
        return $this->belongsTo('App\Models\Menu','menu_id');
    }

}
