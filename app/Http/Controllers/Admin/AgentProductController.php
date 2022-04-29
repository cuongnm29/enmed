<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAgentProductRequest;
use App\Http\Requests\StoreAgentProductRequest;
use App\Http\Requests\UpdateAgentProductRequest;
use App\Agent;
use App\Category;
use App\AgentProduct;
use Illuminate\Support\Str;
class AgentProductController extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('agentproduct_access'), 403);
        $agentproducts  = AgentProduct::where('lang',$lang)->get();
        return view('admin.agentproduct.index', compact('agentproducts'));
    }

    public function create()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('agentproduct_create'), 403);
        $categories = Category::where('parentid', -1)->where("istype",2)->where('lang',$lang)->get();
        return view('admin.agentproduct.create',compact('agents','categories'));
    }

    public function store(StoreAgentProductRequest $request)
    {
        abort_unless(\Gate::allows('agentproduct_create'), 403);
        $request['slug']=Str::slug($request->name, '-');
        $request['lang']=$lang;
        $agent = AgentProduct::create($request->all());
        return redirect()->route('admin.agentproduct.index');
    }

    public function edit(AgentProduct $agentproduct)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('agentproduct_edit'), 403);
        $categories = Category::where('parentid', -1)->where("istype",2)->where('lang',$lang)->get();
        return view('admin.agentproduct.edit', compact('agentproduct','agents','categories'));
    }
    public function update(UpdateAgentProductRequest $request, AgentProduct $agentproduct)
    {
        abort_unless(\Gate::allows('agentproduct_edit'), 403);
        $request['slug']=Str::slug($request->name, '-');
        $request['lang']=$lang;
        $agentproduct->update($request->all());

        return redirect()->route('admin.agentproduct.index');
    }

    public function destroy(AgentProduct $agentproduct)
    {
        abort_unless(\Gate::allows('agentproduct_delete'), 403);
        $agentproduct->delete();
        return back();
    }

    public function massDestroy(MassDestroyAgentProductRequest $request)
    {
        AgentProduct::whereIn('id', request('ids'))->delete();
        return response(null, 204);
    }
}
