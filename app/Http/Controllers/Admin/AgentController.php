<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAgentRequest;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\City;
use App\Country;
use App\District;
use App\Agent;
class AgentController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('agent_access'), 403);
        $agents  = Agent::all();
        return view('admin.agent.index', compact('agents'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('agent_create'), 403);
        $countries  = Country::all();
        return view('admin.agent.create',compact('countries'));
    }

    public function store(StoreAgentRequest $request)
    {
        abort_unless(\Gate::allows('agent_create'), 403);
        $agent = Agent::create($request->all());
        return redirect()->route('admin.agent.index');
    }

    public function edit(Agent $agent)
    {
        abort_unless(\Gate::allows('agent_edit'), 403);
        $countries  = Country::all();
        return view('admin.agent.edit', compact('agent','countries'));
    }
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        abort_unless(\Gate::allows('agent_edit'), 403);

        $agent->update($request->all());

        return redirect()->route('admin.agent.index');
    }

    public function destroy(Agent $agent)
    {
        abort_unless(\Gate::allows('agent_delete'), 403);
        $agent->delete();
        return back();
    }

    public function massDestroy(MassDestroyAgentRequest $request)
    {
        Agent::whereIn('id', request('ids'))->delete();
        return response(null, 204);
    }
}
