<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
         'name', 'created_at','updated_at','deleted_at'
    ];
    public function states()
    {
        return $this->hasMany(city::class);
    }
}
