<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDistrictRequest;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\City;
use App\Country;
use App\District;
use DB;

class DistrictController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('district_access'), 403);
        $districts  = District::all();
        return view('admin.district.index', compact('districts'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('district_create'), 403);
        $countries  = Country::all();
        $cities  = City::all();
        return view('admin.district.create',compact('countries','cities'));
    }

    public function store(StoreDistrictRequest $request)
    {
        abort_unless(\Gate::allows('district_create'), 403);
        $district = District::create($request->all());
        return redirect()->route('admin.district.index');
    }

    public function edit(District $district)
    {
        abort_unless(\Gate::allows('district_edit'), 403);
        $countries  = Country::all();
        $cities  = City::all();
        return view('admin.district.edit', compact('district','countries','cities'));
    }
    public function update(UpdateDistrictRequest $request, District $district)
    {
        abort_unless(\Gate::allows('district_edit'), 403);

        $district->update($request->all());

        return redirect()->route('admin.district.index');
    }

    public function destroy(District $district)
    {
        abort_unless(\Gate::allows('district_delete'), 403);
        $district->delete();
        return back();
    }

    public function massDestroy(MassDestroyDistrictRequest $request)
    {
        District::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
