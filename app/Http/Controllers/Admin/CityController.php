<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCitiesRequest;
use App\Http\Requests\StoreCitiesRequest;
use App\Http\Requests\UpdateCitiesRequest;
use App\City;
use App\Country;
use DB;

class CityController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('cities_access'), 403);
        $cities  = City::all();
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('cities_create'), 403);
        $countries  = Country::all();
        return view('admin.cities.create',compact('countries'));
    }

    public function store(StoreCitiesRequest $request)
    {
        abort_unless(\Gate::allows('cities_create'), 403);
        $citites = City::create($request->all());
        return redirect()->route('admin.cities.index');
    }

    public function edit(City $city)
    {
        abort_unless(\Gate::allows('cities_edit'), 403);
        $countries  = Country::all();
        return view('admin.cities.edit', compact('city','countries'));
    }
    public function update(UpdateCitiesRequest $request, City $city)
    {
        abort_unless(\Gate::allows('cities_edit'), 403);

        $city->update($request->all());

        return redirect()->route('admin.cities.index');
    }

    public function destroy(City $city)
    {
        abort_unless(\Gate::allows('cities_delete'), 403);
        $city->delete();
        return back();
    }

    public function massDestroy(MassDestroyCitiesRequest $request)
    {
        City::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
