<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Category;
use DB;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('category_access'), 403);

        $categories = Category::where('lang',$lang)->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('category_create'), 403);
        $categories = Category::where('parentid', -1)->where('lang',$lang)->get();
        return view('admin.category.create',compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('category_create'), 403);
        $request['slug']=Str::slug($request->name, '-');
        $request['lang']=$lang;
        $product = Category::create($request->all());
        return redirect()->route('admin.category.index');
    }

    public function edit(Category $category)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('category_edit'), 403);
        $categories = Category::where('parentid', -1)->where('lang',$lang)->get();
        return view('admin.category.edit', compact('category','categories'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('category_edit'), 403);
        $request['slug']=Str::slug($request->name, '-');
        $request['lang']=$lang;
        $category->update($request->all());

        return redirect()->route('admin.category.index');
    }

    

    public function destroy(Category $category)
    {
        abort_unless(\Gate::allows('category_delete'), 403);

        $category->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        Category::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
