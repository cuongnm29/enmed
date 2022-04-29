<?php

namespace App;
use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class MemberClient extends Authenticatable
{
    use Notifiable;
    protected $table = 'member';
    protected $fillable = [
        'username','password','fullname','email','address','agent','tel','parrentid','countryid','citiesid','fileupload','created_at','updated_at','deleted_at'
   ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
   
   public function setPasswordAttribute($input)
   {
       if ($input) {
           $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
       }
   }
}
