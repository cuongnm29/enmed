<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'productimage';
    protected $fillable = [
        'image','image_large','productid' ,'created_at','updated_at','deleted_at'
   ];
   public function products()
    {
    	return $this->belongsTo('App\Product');
    }
}
