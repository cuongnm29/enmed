<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Service;
use DB;

class ServiceController  extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_access'), 403);

        $customers = Service::where('istype',2)->where('lang',$lang)->get();
        return view('admin.service.index', compact('customers'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('customer_create'), 403);
        return view('admin.service.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_create'), 403);
        $request['istype']=2;
        $customer =Service::create($request->all());
        return redirect()->route('admin.service.index');
    }

    public function edit(Service $service)
    {
        abort_unless(\Gate::allows('category_edit'), 403);
        
        return view('admin.service.edit', compact('service'));
    }

    public function update(UpdateCustomerRequest $request, Service $service)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_edit'), 403);
        $request['istype']=2;
        $service->update($request->all());

        return redirect()->route('admin.service.index');
    }

    

    public function destroy(Service $service)
    {
        abort_unless(\Gate::allows('customer_delete'), 403);

        $service->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        Service::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
