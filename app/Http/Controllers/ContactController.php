<?php

namespace App\Http\Controllers;

use Request;
use App\Contact;
use App\Category;
use App\Setting;
use App\Post;
use App\Http\Requests\StoreContactRequest;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     
    }
 
    public function CreateContact(StoreContactRequest $request)
    {
        
        $id= $request['id'];
        $contact = Contact::create($request->all() );
        $category =Category::where('id',$id)->where('lang',session('language'))->first();
        $listcategory = Category::where('parentid', -1)->where("istype",2)->where('lang',session('language'))->get();
        $categories = Category::where('parentid', -1)->where("ismenu",2)->where('lang',session('language'))->orderBy('isorder')->get();
        $footers = Category::where('parentid', -1)->where("isfooter",2)->where('lang',session('language'))->get();
        $abouts = Post::where('isshow', 1)->take(1)->where('lang',session('language'))->get();
        $setting = Setting::all()->where('lang',session('language'))->first();
        $message="Cám ơn bạn đã gửi câu hỏi.Chúng tôi sẽ trả lời bạn trong thời gian sớm nhất";
        return view('contact',compact('setting','categories','footers','abouts','listcategory','category','message','id'));
      
       
    }
}