<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySliderRequest;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Slider;
use DB;

class SliderController extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('slider_access'), 403);

        $sliders = Slider::where('lang',$lang)->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('slider_create'), 403);
        return view('admin.slider.create');
    }

    public function store(StoreSliderRequest $request)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('slider_create'), 403);
        $request['lang']=$lang;
        $slider = Slider::create($request->all());
        return redirect()->route('admin.slider.index');
    }

    public function edit(Slider $slider)
    {
        abort_unless(\Gate::allows('slider_edit'), 403);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('slider_edit'), 403);
        $request['lang']=$lang;
        $slider->update($request->all());

        return redirect()->route('admin.slider.index');
    }

    

    public function destroy(Slider $slider)
    {
        abort_unless(\Gate::allows('slider_delete'), 403);

        $slider->delete();

        return back();
    }

    public function massDestroy(MassDestroySliderRequest $request)
    {
        Slider::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
