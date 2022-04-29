<?php

namespace App\Http\Controllers\Admin;
use App\City;
use App\District;
class HomeController
{
    public function home()
    {
        return view('home');
    }
    public function getCitiesByCountry($id)
    {
        $cities= City::where("countryid",$id)->select('id','name')->get();
        return response()->json($cities);
    }
    public function getDistrictByCities($cityid,$countryid)
    {
        $district= District::where("citiesid",$cityid)
        ->where("countryid",$countryid)->select('id','name')->get();
        return response()->json($district);
    }
}
