<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGalleryRequest;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Gallery;
use App\Category;

use DB;

class GalleryController extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('slider_access'), 403);

        $galleries = Gallery::where('lang',$lang)->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('slider_create'), 403);
        $categories = Category::where('parentid', -1)->where("istype",5)->where('lang',$lang)->get();
        return view('admin.gallery.create',compact('categories'));
    }

    public function store(StoreGalleryRequest $request)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('slider_create'), 403);
        $request['lang']=$lang;
        $slider = Gallery::create($request->all());
        return redirect()->route('admin.gallery.index');
    }

    public function edit(Gallery $gallery)
    {
        abort_unless(\Gate::allows('slider_edit'), 403);
        $lang=app()->getLocale();
        $categories = Category::where('parentid', -1)->where("istype",5)->where('lang',$lang)->get();
        return view('admin.gallery.edit', compact('gallery','categories'));
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('slider_edit'), 403);
        $request['lang']=$lang;
        $gallery->update($request->all());

        return redirect()->route('admin.gallery.index');
    }

    public function destroy(Gallery $gallery)
    {
        abort_unless(\Gate::allows('slider_delete'), 403);

        $gallery->delete();

        return back();
    }

    public function massDestroy(MassDestroyGalleryRequest $request)
    {
        Gallery::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
