<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySettingRequest;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Setting;
class SettingController extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('setting_access'), 403);
        $settings  = Setting::where('lang',$lang)->get();
        return view('admin.setting.index', compact('settings'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('setting_create'), 403);
        return view('admin.setting.create');
    }

    public function store(StoreSettingRequest $request)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('setting_create'), 403);
        $request['lang']=$lang;
        $setting = Setting::create($request->all());
        return redirect()->route('admin.setting.index');
    }

    public function edit(Setting $setting)
    {
        abort_unless(\Gate::allows('setting_edit'), 403);
        return view('admin.setting.edit', compact('setting'));
    }
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('setting_edit'), 403);
        $request['lang']=$lang;
        $setting->update($request->all());
        return redirect()->route('admin.setting.index');
    }

    public function destroy(Setting $setting)
    {
        abort_unless(\Gate::allows('setting_delete'), 403);
        $setting->delete();
        return back();
    }
    public function massDestroy(MassDestroySettingRequest $request)
    {
        Setting::whereIn('id', request('ids'))->delete();
        return response(null, 204);
    }
}
