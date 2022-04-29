<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Setting;
use App\Post;
use App\Product;
use App\ProductImage;
use App\Agent;
use App\Slider;
use App\City;
use App\Service;
use App\Gallery;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $lang=app()->getLocale();
        $setting = Setting::where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where("ismenu",2)->where('lang',$lang)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where("isfooter",2)->where('lang',$lang)->get();
        $posts = Post::where('isshow',1)->where('lang',$lang)->get()->take(5);
        $products = Product::where('lang',$lang)->get();
        $sliders =Slider::where('position',0)->where('lang',$lang)->get();
        return view('home',compact('categories','setting','posts','products','sliders','footers'));
    }
    public function listArticle(Request $request)
    {
        $lang=app()->getLocale();
        $catid=$request->route('id');
        $categoryIds = Category::where('lang',$lang)->where('parentid', $parentId = Category::where('id', $catid)
        ->value('id'))
        ->pluck('id')
        ->push($parentId)
        ->all();
        $cat= Category::where('id',$catid)->where('lang',$lang)->first();
        if($cat->parentid==-1){
            $listcategory = Category::where('parentid', -1)->where("istype",1)->where('lang',$lang)->where("id",$catid)->get();
            $categoryRelated=Category::where('parentid',$catid)->where('lang',$lang)->get();
        }
        else{
            $listcategory = Category::where('parentid', -1)->where("istype",1)->where('lang',$lang)->where("id",$cat->parentid)->get();
            $categoryRelated=Category::where('parentid',$cat->parentid)->where('id','<>',$catid)->where('lang',$lang)->get();
        }
        $category =Category::whereIn('id',$categoryIds)->where('lang',$lang)->first();

        $articleTop= Post::whereIn('catid', $categoryIds)->where('lang',$lang)->first();
        if(isset($articleTop)){
        $listArticle= Post::whereIn('catid', $categoryIds)->where('id','><',$articleTop->id)->where('lang',$lang)->paginate(5);
        }
        $categories = Category::where('parentid', -1)->where("ismenu",2)->where('lang',$lang)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where("isfooter",2)->where('lang',$lang)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->take(1)->get();
        $setting = Setting::all()->where('lang',$lang)->first();
        return view('listArticle',compact('setting','categories','footers','abouts','articleTop','listArticle','listcategory','categoryRelated','category'));
    }
    public function detailsArticle (Request $request)
    {
        $lang=app()->getLocale();
        $id=$request->route('id');
        $catid=$request->route('catid');
        $category =Category::where('id',$catid)->where('lang',$lang)->first();
        $article= Post::where('id', $id)->where('catid',$catid)->where('lang',$lang)->first();
        $listcategory = Category::where('parentid', -1)->where("istype",1)->where('lang',$lang)->get();
        $categories = Category::where('parentid', -1)->where("ismenu",2)->orderBy('isorder')->where('lang',$lang)->get();
        $footers = Category::where('parentid', -1)->where("isfooter",2)->where('lang',$lang)->get();
        $abouts = Post::where('isshow', 1)->take(1)->where('lang',$lang)->get();
        $setting = Setting::where('lang',$lang)->first();
        $relatedArticles=Post::where('id', '<>',$id)->where('catid',$catid)->take(4)->where('lang',$lang)->get();
        return view('detailsArticle',compact('setting','categories','footers','abouts','listcategory','article','relatedArticles','category'));
    }
    public function listProduct(Request $request)
    {
        $lang=app()->getLocale();
        $catid=$request->route('id');
        $categoryIds = Category::where('lang',$lang)->where('lang',$lang)->where('parentid', $parentId = Category::where('id', $catid)
        ->value('id'))
        ->pluck('id')
        ->push($parentId)
        ->all();
        
        $category =Category::whereIn('id',$categoryIds)->where('lang',$lang)->first();
        $listProduct= Product::whereIn('catid', $categoryIds)->where('lang',$lang)->paginate(5);
        $categories = Category::where('parentid', -1)->where("ismenu",2)->where('lang',$lang)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where("isfooter",2)->where('lang',$lang)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->take(1)->get();
        $setting = Setting::where('lang',$lang)->first();
        return view('listProduct',compact('setting','categories','footers','abouts','listProduct','category'));
    }
    public function detailsProduct (Request $request)
    {
        $lang=app()->getLocale();
        $id=$request->route('id');
        $catid=$request->route('catid');
        $product= Product::where('id', $id)->where('catid',$catid)->where('lang',$lang)->first();
      
        $productImages=ProductImage::where('productid',$id)->get();
        $category =Category::where('id',$catid)->where('lang',$lang)->first();
        $listcategory = Category::where('parentid', -1)->where('lang',$lang)->where("istype",2)->get();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->take(1)->get();
        $setting = Setting::where('lang',$lang)->first();
        $relatedProduct=Product::where('id', '<>',$id)->where('lang',$lang)->where('catid',$catid)->take(4)->get();
        return view('detailsProduct',compact('setting','categories','footers','abouts','listcategory','product','relatedProduct','category','productImages'));
    }
    public function contact (Request $request)
    {
        $lang=app()->getLocale();
        $id=$request->route('id');
        $category =Category::where('id',$id)->where('lang',$lang)->first();
        $listcategory = Category::where('parentid', -1)->where('lang',$lang)->where("istype",2)->get();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->take(1)->get();
        $setting = Setting::where('lang',$lang)->first();
        $agents = Agent::all();
        $message="";
        return view('contact',compact('setting','categories','footers','abouts','listcategory','category','message','id','agents'));
    }
    public function agent (Request $request)
    {
        $lang=app()->getLocale();
        $id=$request->route('id');
        $listcategory = Category::where('parentid', -1)->where('lang',$lang)->where("istype",2)->get();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->take(1)->where('lang',$lang)->get();
        $setting = Setting::where('lang',$lang)->first();
        $agents = Agent::where('id',$id)->get();
        $message="";
        return view('agent',compact('setting','categories','footers','abouts','listcategory','message','id','agents'));
    }
    public function store (Request $request)
    {
        $lang=app()->getLocale();
        $id=$request->route('id');
        $category =Category::where('id',$id)->first();
        $listcategory = Category::where('parentid', -1)->where("istype",2)->get();
        $categories = Category::where('parentid', -1)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->take(1)->get();
        $setting = Setting::all()->first();
        $agents= Agent::where('isshow','2')->select('name','latitude','longitude')->get();
        return view('map',compact('setting','categories','footers','abouts','listcategory','category'));
    }
    function showmap(){
        $agents= Agent::where('isshow','2')->select('name','latitude','longitude','id')->get();
        return response()->json($agents);
    }
    public function getCitiesByCountry($id)
    {
        $cities= City::where("countryid",$id)->select('id','name')->get();
        return response()->json($cities);
    }
    public function cart()
    {
        $categories = Category::where('parentid', -1)->where("ismenu",2)->orderBy('isorder')->get();
        $setting = Setting::all()->first();
        return view('cart',compact('setting','categories'));
    }

    public function addToCart($id)
    {
        $product = Product::find($id);

        if(!$product) {

            abort(404);

        }

        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if(!$cart) {

            $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "photo" => $product->photo
                    ]
            ];

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');

        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {

            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }
    public function listCerfiticate (Request $request)
    {
        $lang=app()->getLocale();
        $catid=$request->route('id');
        $categoryIds = Category::where('lang',$lang)->where('lang',$lang)->where('parentid', $parentId = Category::where('id', $catid)
        ->value('id'))
        ->pluck('id')
        ->push($parentId)
        ->all();
        $cat= Category::where('id',$catid)->where('lang',$lang)->first();
        if($cat->parentid==-1){
            $listcategory = Category::where("istype",5)->where('lang',$lang)->where("id",'><',$catid)->get();
        }
        else{
            $listcategory = Category::where("parentid",$cat->id)->orwhere("istype",7)->where('lang',$lang)->get();
        }
        
        $category =Category::where('id',$catid)->where('lang',$lang)->first();
        $setting = Setting::where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where("ismenu",2)->orderBy('isorder')->get();
        $cerfiticates = Gallery::whereIn('catid',$categoryIds)->get();
        return view('listCerfiticate',compact('setting','category','categories','listcategory','cerfiticates'));
    }
    public function listConfirmCerfiticate (Request $request)
    {
        $lang=app()->getLocale();
        $catid=$request->route('id');
        $categoryIds = Category::where('lang',$lang)->where('lang',$lang)->where('parentid', $parentId = Category::where('id', $catid)
        ->value('id'))
        ->pluck('id')
        ->push($parentId)
        ->all();
        $cat= Category::where('id',$catid)->where('lang',$lang)->first();
        if($cat->parentid==-1){
            $listcategory = Category::where("istype",5)->where('lang',$lang)->where("id",$catid)->get();
        }
        else{
            $listcategory = Category::where('id','<>', $catid)->where("parentid",$cat->parentid)->where("istype",5)->where('lang',$lang)->get();
        }
        $category =Category::where('id',$catid)->where('lang',$lang)->first();
        $setting = Setting::where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where("ismenu",2)->orderBy('isorder')->get();
        $cerfiticates = Gallery::whereIn('catid',$categoryIds)->get();
        return view('listConfirmCerfiticate',compact('setting','category','categories','listcategory','cerfiticates'));
    }
    public function IntrolArticle(Request $request)
    {
        $lang=app()->getLocale();
        $catid=$request->route('id');
        $categoryIds = Category::where('lang',$lang)->where('parentid', $parentId = Category::where('id', $catid)
        ->value('id'))
        ->pluck('id')
        ->push($parentId)
        ->all();
        $cat= Category::where('id',$catid)->where('lang',$lang)->first();
        $listcategory = Category::where('parentid', $catid)->where("istype",1)->where('lang',$lang)->get();
        $category =Category::whereIn('id',$categoryIds)->where('lang',$lang)->first();
        $listArticle= Post::whereIn('catid', $categoryIds)->where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where("ismenu",2)->where('lang',$lang)->orderBy('isorder')->get();
        $setting = Setting::all()->where('lang',$lang)->first();
        return view('Introl',compact('setting','categories','listArticle','listcategory','category'));
    }
    public function SliderProduct(Request $request)
    {
        $lang=app()->getLocale();
        $catid=$request->route('id');
        $categoryIds = Category::where('lang',$lang)->where('parentid', $parentId = Category::where('id', $catid)
        ->value('id'))
        ->pluck('id')
        ->push($parentId)
        ->all();
        $cat= Category::where('id',$catid)->where('lang',$lang)->first();
        $listcategory = Category::where('parentid', $catid)->where("istype",2)->where('lang',$lang)->get();
        $category =Category::whereIn('id',$categoryIds)->where('lang',$lang)->first();
        $listProduct= Product::whereIn('catid', $categoryIds)->where('lang',$lang)->get();
        $categories = Category::where('parentid', -1)->where("ismenu",2)->where('lang',$lang)->orderBy('isorder')->get();
        $setting = Setting::all()->where('lang',$lang)->first();

        return view('SliderProduct',compact('setting','categories','listProduct','listcategory','category'));
    }
}