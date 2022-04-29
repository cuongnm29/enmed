<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Customer;
use DB;

class CustomerController extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_access'), 403);

        $customers = Customer::where('istype',1)->where('lang',$lang)->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('customer_create'), 403);
        return view('admin.customer.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_create'), 403);
        $request['istype']=1;
        $request['lang']=$lang;
        $customer = Customer::create($request->all());
        return redirect()->route('admin.customer.index');
    }

    public function edit(Customer $customer)
    {
        abort_unless(\Gate::allows('category_edit'), 403);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('customer_edit'), 403);
        $request['istype']=1;   
        $request['lang']=$lang;
        $customer->update($request->all());

        return redirect()->route('admin.customer.index');
    }

    

    public function destroy(Customer $customer)
    {
        abort_unless(\Gate::allows('customer_delete'), 403);

        $customer->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        Customer::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
