<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCountriesRequest;
use App\Http\Requests\StoreCountriesRequest;
use App\Http\Requests\UpdateCountriesRequest;
use App\Country;
use DB;

class CountryController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('countries_access'), 403);

        $countries  = Country::all();
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('countries_create'), 403);
        return view('admin.countries.create');
    }

    public function store(StoreCountriesRequest $request)
    {
        abort_unless(\Gate::allows('countries_create'), 403);
        $countries = Country::create($request->all());
        return redirect()->route('admin.countries.index');
    }

    public function edit(Country $country)
    {
        abort_unless(\Gate::allows('countries_edit'), 403);
        return view('admin.countries.edit', compact('country'));
    }
    public function update(UpdateCountriesRequest $request, Country $country)
    {
        abort_unless(\Gate::allows('countries_edit'), 403);

        $country->update($request->all());

        return redirect()->route('admin.countries.index');
    }

    public function destroy(Country $country)
    {
        abort_unless(\Gate::allows('countries_delete'), 403);
        $country->delete();
        return back();
    }

    public function massDestroy(MassDestroyCountriesRequest $request)
    {
        Country::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
    public function getCities($id)
    {
        $task = City::where('countryid', $id)->get();
        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}
