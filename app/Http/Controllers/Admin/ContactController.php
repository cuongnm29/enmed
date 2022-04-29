<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAgentRequest;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Contact;

class ContactController  extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('contact_access'), 403);
        $contacts  = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }

    public function create()
    {
        
    }

    public function store(StoreAgentRequest $request)
    {
       
    }

    public function edit(Agent $agent)
    {
       
    }
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
       
    }
    public function show(Contact $contact)
    {
        abort_unless(\Gate::allows('contact_show'), 403);
        return view('admin.contact.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        abort_unless(\Gate::allows('contact_delete'), 403);
        $contact->delete();
        return back();
    }

    public function massDestroy(MassDestroyContactRequest $request)
    {
        Contact::whereIn('id', request('ids'))->delete();
        return response(null, 204);
    }
}
