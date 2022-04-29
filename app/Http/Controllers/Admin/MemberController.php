<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMemberRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Member;
class MemberController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('member_access'), 403);
        $members  = Member::all();
        return view('admin.member.index', compact('members'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('member_create'), 403);
        return view('admin.member.create');
    }

    public function store(StoreMemberRequest $request)
    {
        abort_unless(\Gate::allows('member_create'), 403);
        $members = Member::create($request->all());
        return redirect()->route('admin.member.index');
    }

    public function edit(Member $member)
    {
        abort_unless(\Gate::allows('member_edit'), 403);
        return view('admin.member.edit', compact('member'));
    }
    public function update(UpdateMemberRequest $request, Member $member)
    {
        abort_unless(\Gate::allows('member_edit'), 403);

        $member->update($request->all());
        return redirect()->route('admin.member.index');
    }
    public function destroy(Member $member)
    {
        abort_unless(\Gate::allows('member_delete'), 403);
        $member->delete();
        return back();
    }

    public function massDestroy(MassDestroyMemberRequest $request)
    {
        Member::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
    public function getDownload($id)
{
    $member = Member::where('id', $id)->firstOrFail();
    $path = public_path().  $member->fileupload;
    return response()->download($path, 'profile.pdf', ['Content-Type' => 'application/pdf']); 
}
}