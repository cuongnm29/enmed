<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'name','countryid','citiesid','address','latitude','longitude','isshow' ,'created_at','updated_at','deleted_at'
   ];
   public function country()
   {
       return $this->hasMany(Country::class,'id');
   }
   public function city()
   {
       return $this->hasMany(City::class,'id');
   }
   public function district()
   {
       return $this->hasMany(District::class,'id');
   }
}