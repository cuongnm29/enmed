<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentProduct extends Model
{
    protected $table = 'product_agents';
    protected $fillable = [
        'name','slug','catid', 'lang','summary','content', 'note','image','created_at','updated_at','deleted_at'
    ];
}
