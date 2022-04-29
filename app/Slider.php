<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'position', 'image', 'lang','caption', 'created_at','updated_at','deleted_at'
    ];
}
