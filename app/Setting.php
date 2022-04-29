<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'companyName', 
        'email',
        'tel', 
        'lang',
        'address',
        'facebook',
         'google',
         'youtube',
         'footer',
         'map',
         'image',
         'logo',
         'logofooter',
         'service',
         'customer',
         'value',
         'choose',
         'enablepopup',
         'linkpopup',
         'imagepopup',
         'created_at',
         'updated_at',
         'deleted_at'
    ];
}
