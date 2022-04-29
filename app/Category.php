<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    protected $fillable = [
        'name', 'image','slug','icon','content', 'lang','parentid','istype','ismenu','isfooter','isorder','created_at','updated_at','deleted_at'
    ];
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    /**
     * A Category has many child categories
     *
     * @return void
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parentid','id')->where('ismenu',2)->orderBy('isorder', 'asc');
    }
    public function child()
    {
        return $this->hasMany(Category::class, 'parentid','id');
    }
    public function parent() {
        return $this->belongsTo(Category::class, 'parentid');
    }
  
    public function post() {
        return $this->hasMany(Post::class);
    }
    public function product() {
        return $this->hasMany(AgentProduct::class);
    }
    //
}
