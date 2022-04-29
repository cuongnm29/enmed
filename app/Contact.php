<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $fillable = [
        'firstname','lastname','email','note','phone' ,'created_at','updated_at','deleted_at'
   ];
}
