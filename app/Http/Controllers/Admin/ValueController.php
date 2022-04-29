<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Value;
use DB;

class ValueController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('customer_access'), 403);
        $lang=app()->getLocale();
        $customers = Value::where('istype',3)->where('lang',$lang)->get();
        return view('admin.value.index', compact('customers'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('customer_create'), 403);
        return view('admin.value.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        abort_unless(\Gate::allows('customer_create'), 403);
        $request['istype']=3;
        $lang=app()->getLocale();
        $customer = Value::create($request->all());
        return redirect()->route('admin.value.index');
    }

    public function edit(Value $value)
    {
        abort_unless(\Gate::allows('category_edit'), 403);
        return view('admin.value.edit', compact('value'));
    }

    public function update(UpdateCustomerRequest $request, Value $value)
    {
        abort_unless(\Gate::allows('customer_edit'), 403);
        $request['istype']=3;
        $lang=app()->getLocale();
        $value->update($request->all());

        return redirect()->route('admin.value.index');
    }

    

    public function destroy(Value $value)
    {
        abort_unless(\Gate::allows('customer_delete'), 403);

        $value->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        Value::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
