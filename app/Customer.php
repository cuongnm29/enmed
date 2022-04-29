<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'name', 'content', 'note','image','istype','lang','created_at','updated_at','deleted_at'
    ];
    
    
}
