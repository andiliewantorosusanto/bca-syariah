<?php

namespace App\Models\CSF;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vrys_autodebetnormal_syariah extends Model
{
    use HasFactory;
    protected $table = 'vrys_autodebetnormal_syariah';
    protected $connection= 'csf';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
