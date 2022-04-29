<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $fillable = [
        'username','password','fullname','email','address','agent','tel','parrentid','created_at','updated_at','deleted_at'
   ];
 
}
