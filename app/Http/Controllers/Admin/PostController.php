<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use App\Category;
use DB;
use Illuminate\Support\Str;
class PostController extends Controller
{
    public function index()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('post_access'), 403);
        $posts = Post::where('lang',$lang)->get();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('post_create'), 403);
        $categories = Category::where('parentid', -1)->where("istype",1)->where('lang',$lang)->get();
        return view('admin.post.create',compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('post_create'), 403);
        $request['slug']=Str::slug($request->title, '-');
        $request['lang']=$lang;
        $post = Post::create($request->all());
        return redirect()->route('admin.post.index');
    }

    public function edit(Post $post)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('post_edit'), 403);
        $categories = Category::where('parentid', -1)->where("istype",1)->where('lang',$lang)->get();
        return view('admin.post.edit', compact('post','categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('post_edit'), 403);
        $request['slug']=Str::slug($request->title, '-');
        $request['lang']=$lang;
        $post->update($request->all());

        return redirect()->route('admin.post.index');
    }

    public function show(Post $post)
    {
        
    }

    public function destroy(Post $post)
    {
        abort_unless(\Gate::allows('post_delete'), 403);
        $post->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostRequest $request)
    {
        Post::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
