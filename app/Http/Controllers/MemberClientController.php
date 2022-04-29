<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Setting;
use App\Post;
use App\AgentProduct;
use App\Agent;
use App\Slider;
use App\Country;
use App\MemberClient;
use DB;
use Auth;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\UpdateMemberClientRequest ;
use App\Http\Requests\StoreMemberClientRequest  ;
 
class MemberClientController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/member/profile';

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
    public function register()
    {
         $lang=app()->getLocale();
        $countries  = Country::all();
        $setting = Setting::where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->first()->get();
        $posts = Post::all()->take(5);
        
        $products = AgentProduct::all()->take(3);
        $sliders =Slider::where('position',0)->where('lang',$lang)->get();
        return view('register',compact('categories','setting','posts','products','sliders','abouts','footers','countries'));
    }
    public function create()
    {
         $lang=app()->getLocale();
        $setting = Setting::where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->first()->get();
        $posts = Post::where('lang',$lang)->take(5);
        $products = AgentProduct::all()->take(3);
        $sliders =Slider::where('position',0)->where('lang',$lang)->get();
        if( Auth::guard('member')->check()){
        return view('createMember',compact('categories','setting','posts','products','sliders','abouts','footers'));
        }
        return view('login',compact('categories','setting','posts','products','sliders','abouts','footers'));
    }
    public function list()
    {
       
       $lang=app()->getLocale();
        $setting = Setting::where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->first()->get();
        $posts = Post::where('lang',$lang)->take(5);
        $products = AgentProduct::where('lang',$lang)->take(3);
        $sliders =Slider::where('position',0)->where('lang',$lang)->get();
        if( Auth::guard('member')->check()){
        $id=Auth::guard('member')->user()->id;
        $members =MemberClient::where('Parrentid',$id)->get();
        return view('listMember',compact('categories','setting','posts','products','sliders','abouts','footers','members'));
        }
        return view('login',compact('categories','setting','posts','products','sliders','abouts','footers'));
        
    }
    public function login()
    {
         $lang=app()->getLocale();
        $setting = Setting::where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->first();
        $posts = Post::where('lang',$lang)->take(5);
        
        $products = AgentProduct::where('lang',$lang)->take(3);
        $sliders =Slider::where('position',0)->where('lang',$lang)->get();
        return view('login',compact('categories','setting','posts','products','sliders','abouts','footers'));
    }
    public function profile()
    {
         $lang=app()->getLocale();
        $countries  = Country::all();
        $setting = Setting::where('lang',$lang)->first();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->first()->get();
        $posts = Post::all()->take(5);
        
        $products = AgentProduct::where('lang',$lang)->take(3);
        $sliders =Slider::where('position',0)->where('lang',$lang)->get();
        if( Auth::guard('member')->check()){
        return view('profile',compact('categories','setting','posts','products','sliders','abouts','footers','countries'));
        }
        return view('login',compact('categories','setting','posts','products','sliders','abouts','footers'));
    }
    public function CreateMember(StoreMemberClientRequest $request)
    {
        $id= $request['id'];
         $lang=app()->getLocale();
        $category =Category::where('id',$id)->where('lang',$lang)->first();
        $listcategory = Category::where('parentid', -1)->where('lang',$lang)->where("istype",2)->get();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->take(1)->get();
        $setting = Setting::where('lang',$lang)->first();
        $countries  = Country::all();
        //check email tồn tại
        $ismember =MemberClient::where('email',$request['email'])->get();
        if(Count($ismember)){
            
            return redirect('member/register')->with('error', 'Email đã tồn tại,hãy nhập email khác');
        }
        $member = MemberClient::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'countryid' => $request['countryid'],
            'citiesid' => $request['countryid'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('member/login');
    }
    public function CreateChildMember(StoreMemberClientRequest $request)
    {
        $id= $request['id'];
         $lang=app()->getLocale();
        $category =Category::where('id',$id)->first();
        $listcategory = Category::where('parentid', -1)->where('lang',$lang)->where("istype",2)->get();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->take(1)->get();
        $setting = Setting::all()->first();
        
        $member = MemberClient::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'parrentid'=>$request['parrentid'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('member/list');
    }
    public function loginMember(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('member')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/member/profile');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();
        return redirect('/member/login');
      }
      public function UpdateMember(UpdateMemberClientRequest $request)
    {
        $id= $request['id'];
        $mid= $request['mid'];
         $lang=app()->getLocale();
        $category =Category::where('id',$id)->where('lang',$lang)->first();
        $listcategory = Category::where('parentid', -1)->where('lang',$lang)->where("istype",2)->get();
        $categories = Category::where('parentid', -1)->where('lang',$lang)->where("ismenu",2)->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where('lang',$lang)->where("isfooter",2)->get();
        $abouts = Post::where('isshow', 1)->where('lang',$lang)->take(1)->get();
        $setting = Setting::where('lang',$lang)->first();
        // File này có thực, bắt đầu đổi tên và move
        $fileExtension = $request->file('fileupload')->getClientOriginalExtension(); // Lấy . của file
        // Filename cực shock để khỏi bị trùng
        $fileName = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension;
        // Thư mục upload
        $uploadPath = public_path('/uploads'); // Thư mục upload
			
        // Bắt đầu chuyển file vào thư mục
        $request->file('fileupload')->move($uploadPath, $fileName);
		
        $member = MemberClient::where('id',$mid)->update(
            [
                'fullname' => $request['fullname'],
                'username' => $request['username'],
                'address' => $request['address'],
                'tel' => $request['tel'],
                'email' => $request['email'],
                'countryid' => $request['countryid'],
                'citiesid' => $request['countryid'],
                'fileupload' => '/uploads/'.$fileName,
                'password' => Hash::make($request['password']),
            ]
        );
        return redirect()->intended('member/profile')->with('success', 'Cập nhật thành công');
    }
}