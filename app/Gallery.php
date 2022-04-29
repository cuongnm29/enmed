<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';
    protected $fillable = [
        'catid', 'image', 'lang','status', 'created_at','updated_at','deleted_at'
    ];
}
