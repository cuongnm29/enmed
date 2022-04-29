<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Str;
use App\Product;
use App\ProductImage;
use App\Category;
use Image;
class ProductsController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('product_access'), 403);

        $products = Product::all();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('product_create'), 403);
        $categories = Category::where('parentid', -1)->where("istype",6)->where('lang',$lang)->get();
        return view('admin.products.create',compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validator = \Validator::make($request->all(), [
            'catid' => 'required',
            'name' => 'required',
            'description' => 'required',
            'content' => 'required',
            'contentPackage' => 'required',
            'images' => 'required|max:1024'

        ])->validate();
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('product_create'), 403);
        $request['slug']=Str::slug($request->name, '-');
        $request['lang']=$lang;
        $product = Product::create($request->all());
        if($request->hasFile('images')){
            $allowedfileExtension=['jpg','png'];
			$files = $request->file('images');
            // flag xem có thực hiện lưu DB không. Mặc định là có
			$exe_flg = true;
			// kiểm tra tất cả các files xem có đuôi mở rộng đúng không
			foreach($files as $file) {
				$extension = $file->getClientOriginalExtension();
				$check=in_array($extension,$allowedfileExtension);

				if(!$check) {
                    // nếu có file nào không đúng đuôi mở rộng thì đổi flag thành false
					$exe_flg = false;
					break;
				}
			} 
			// nếu không có file nào vi phạm validate thì tiến hành lưu DB
			if($exe_flg) {
                // duyệt từng ảnh và thực hiện lưu
				foreach ($request->images as $photo) {
                    $pathsmall='public/images/small/'.$product->id;
                    $filenamesmall = $photo->storeAs($pathsmall, $photo->getClientOriginalName());
                    //image small
                    $thumbnailpath_small = public_path('storage/images/small/'.$product->id.'/'.$photo->getClientOriginalName());
                    $imgsmall = Image::make($thumbnailpath_small)->resize(400,400, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imgsmall->save($thumbnailpath_small);
                    //image large
                    $pathlarge='public/images/large/'.$product->id;
                    $filenamelarge = $photo->storeAs($pathlarge, $photo->getClientOriginalName());

                    $thumbnailpath_large = public_path('storage/images/large/'.$product->id.'/'.$photo->getClientOriginalName());
                    $imglarge = Image::make($thumbnailpath_large)->resize(1000,1000, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imglarge->save($thumbnailpath_large);
                    ProductImage::create([
						'productid' => $product->id,
                        'image' => Str::substr($filenamesmall, 7),
                        'image_large' => Str::substr($filenamelarge, 7)
					]);
				}
				echo "Upload successfully";
			} else {
				echo "Falied to upload. Only accept jpg, png photos.";
			}
    }
        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('product_edit'), 403);
        $categories = Category::where('parentid', -1)->where("istype",6)->where('lang',$lang)->get();
        $productImages = ProductImage::where('productid', $product->id)->get();
        return view('admin.products.edit', compact('product','categories','productImages'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validator = \Validator::make($request->all(), [
            'catid' => 'required',
            'name' => 'required',
            'description' => 'required',
            'content' => 'required',
            'contentPackage' => 'required',
            'images' => 'required|max:1024'

        ])->validate();
        $lang=app()->getLocale();
        abort_unless(\Gate::allows('product_edit'), 403);
        $request['slug']=Str::slug($request->name, '-');
        $request['lang']=$lang;
        
        $product->update($request->all());
        ProductImage::where('productid',$product->id)->delete();
        if($request->hasFile('images')){
            $allowedfileExtension=['jpg','png'];
			$files = $request->file('images');
            // flag xem có thực hiện lưu DB không. Mặc định là có
			$exe_flg = true;
			// kiểm tra tất cả các files xem có đuôi mở rộng đúng không
			foreach($files as $file) {
				$extension = $file->getClientOriginalExtension();
				$check=in_array($extension,$allowedfileExtension);

				if(!$check) {
                    // nếu có file nào không đúng đuôi mở rộng thì đổi flag thành false
					$exe_flg = false;
					break;
				}
			} 
			// nếu không có file nào vi phạm validate thì tiến hành lưu DB
			if($exe_flg) {
                
                // duyệt từng ảnh và thực hiện lưu
				foreach ($request->images as $photo) {
                    $pathsmall='public/images/small/'.$product->id;
                    $filenamesmall = $photo->storeAs($pathsmall, $photo->getClientOriginalName());
                    //image small
                    $thumbnailpath_small = public_path('storage/images/small/'.$product->id.'/'.$photo->getClientOriginalName());
                    $imgsmall = Image::make($thumbnailpath_small)->resize(400,400, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imgsmall->save($thumbnailpath_small);
                    //image large
                    $pathlarge='public/images/large/'.$product->id;
                    $filenamelarge = $photo->storeAs($pathlarge, $photo->getClientOriginalName());

                    $thumbnailpath_large = public_path('storage/images/large/'.$product->id.'/'.$photo->getClientOriginalName());
                    $imglarge = Image::make($thumbnailpath_large)->resize(1000,1000, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imglarge->save($thumbnailpath_large);
                    ProductImage::create([
						'productid' => $product->id,
                        'image' => Str::substr($filenamesmall, 7),
                        'image_large' => Str::substr($filenamelarge, 7)
					]);
				}
				echo "Upload successfully";
			} else {
				echo "Falied to upload. Only accept jpg, png photos.";
            }
        }
        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        abort_unless(\Gate::allows('product_show'), 403);

        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_unless(\Gate::allows('product_delete'), 403);

        $product->delete();
        ProductImage::where('productid',$product->id)->delete();
        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();
        ProductImage::whereIn('id', request('ids'))->delete();
        return response(null, 204);
    }
}