<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'catid', 'title','slug', 'lang', 'isshow','content', 'summary','tag','image','created_at','updated_at','deleted_at'
    ];
    public function categories() {
        return $this->belongsTo(Category::class, 'catid');
    }
}
