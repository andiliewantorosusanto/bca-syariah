<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'sts',
        'created_by',
        'updated_by'
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}
