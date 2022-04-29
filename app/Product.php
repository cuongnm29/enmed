<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'catid',
        'name',
        'price',
        'description',
        'content',
        'contentPackage',
        'old_price',
        'lang',
        'slug',
        'discount',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
    ];
    public function categories() {
        return $this->belongsTo(Category::class, 'catid');
    }
    public function images()
    {
    	return $this->hasMany('App\ProductImage');
    }
}
