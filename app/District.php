<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name', 'countryid','citiesid','created_at','updated_at','deleted_at'
   ];
}
