<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Choose;
use DB;

class ChooseController  extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_access'), 403);

        $customers = Choose::where('istype',4)->where('lang',$lang)->get();
        return view('admin.choose.index', compact('customers'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('customer_create'), 403);
        return view('admin.choose.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_create'), 403);
        $request['istype']=4;
        $request['lang']=$lang;
        $customer =Choose::create($request->all());
        return redirect()->route('admin.choose.index');
    }

    public function edit(Choose $service)
    {
        abort_unless(\Gate::allows('category_edit'), 403);
        
        return view('admin.choose.edit', compact('service'));
    }

    public function update(UpdateCustomerRequest $request, Choose $choose)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_edit'), 403);
        $request['istype']=4;
        $request['lang']=$lang;
        $choose->update($request->all());

        return redirect()->route('admin.choose.index');
    }

    

    public function destroy(Choose $choose)
    {
        abort_unless(\Gate::allows('customer_delete'), 403);

        $choose->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        Choose::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
