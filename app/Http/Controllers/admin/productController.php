<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\product;
use App\Models\productImage;
use App\Models\sub_category;
use App\Models\temp_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class productController extends Controller
{
    public function create(){
        $categories = Category::orderBy('id','desc')->get();
        $brands = Brand::orderBy('id','desc')->get();
        return view('admin.product.create',compact('categories','brands'));
    }


    public function store(Request $request){
        // dd($request->image_array);
        // exit();

        $rules = [
            'title' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'track_qty' => 'required|in:yes,no',
            // 'status' => 'required',
            'category' => 'required|numeric',
            // 'sub_category' => 'required',
            // 'brand' => 'required',
            'is_featured' => 'required|in:yes,no',
        ];

        if(!empty($request->track_qty) && $request->track_qty == 'yes'){
            $rules['qty'] = 'required|numeric';
        }
        $validator = Validator::make($request->all(),$rules);

        if($validator->passes()){
            $product = new product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compair_price = $request->compair_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id  = $request->category;
            $product->sub_category_id  = $request->sub_category;
            $product->brand_id  = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->shipping_return = $request->shipping_return;
            $product->short_description = $request->short_description;
            $product->related_product = (!empty($request->related_products)? implode(',',$request->related_products) : "");
            $product->save();

        // save gallery pics
            if(!empty($request->image_array)){
                foreach($request->image_array as $temp_image_id){
                    $tempImageInfo = temp_image::find($temp_image_id);
                    $extArray = explode('.',$tempImageInfo->name);
                    $ext = last($extArray);

                    $productImage = new productImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;

                    $productImage->image = $imageName;
                    $productImage->save();

                    // create image manager with desired driver
                    $manager = new ImageManager(new Driver());

                // generate large thumbnail
                        $source_path = public_path().'/temp/'.$tempImageInfo->name;
                        $dest_path = public_path().'/uploads/products/large/'.$imageName;
                         // read image from file system
                        $image = $manager->read($source_path);
                        $image = $image->resize(1400,null,function($Constraint){
                        $Constraint->aspectRatio();
                    });
                        $image->save($dest_path);

                // generate small thumbnail
                    $source_path = public_path().'/temp/'.$tempImageInfo->name;
                    $dest_path = public_path().'/uploads/products/small/'.$imageName;

                      // read image from file system
                      $image = $manager->read($source_path);
                      $image = $image->resize(300,300);
                     $image->save($dest_path);
                }
            }
            session()->flash('success','product added successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function list(Request $request){
        $products = product::orderBy('id','asc')->with('product_images');
        // dd($products);
        if(!empty($request->search)){
            $products->where('title','like','%'.$request->search.'%')
                       ->orwhere('title','like','%'.$request->search.'%');
        }
        $products = $products->paginate(7);
        return view('admin.product.list',compact('products'));
    }



    public function edit($id, Request $request ){
        $product = product::find($id);
        if(empty($product)){
            return redirect()->route('admin.product.list')->with('error','this product not found');
        }
        $productImages = productImage::where('product_id',$product->id)->get();
        $subCategories = sub_category::where('category_id',$product->category_id)->get();
        $categories = Category::orderBy('id','desc')->get();
        $brands = Brand::orderBy('id','desc')->get();

        // fetch related product
        $relatedProducts = [];
        if($product->related_product != ''){
            $productArray = explode(',',$product->related_product);
            $relatedProducts = product::whereIn('id',$productArray)->get();
        }

        return view('admin.product.edit',compact('categories','brands','product','subCategories','productImages','relatedProducts'));
    }



    public function update($id, Request $request ){
        $product = product::find($id);

        $rules = [
            'title' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'track_qty' => 'required|in:yes,no',
            // 'status' => 'required',
            'category' => 'required|numeric',
            // 'sub_category' => 'required',
            // 'brand' => 'required',
            'is_featured' => 'required|in:yes,no',
        ];

        if(!empty($request->track_qty) && $request->track_qty == 'yes'){
            $rules['qty'] = 'required|numeric';
        }
        $validator = Validator::make($request->all(),$rules);
        if($validator->passes()){
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compair_price = $request->compair_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id  = $request->category;
            $product->sub_category_id  = $request->sub_category;
            $product->brand_id  = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->shipping_return = $request->shipping_return;
            $product->short_description = $request->short_description;
            $product->related_product = (!empty($request->related_products)? implode(',',$request->related_products) : "");
            $product->save();

            session()->flash('success','product updated successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }



    public function destroy($id, Request $request){
        $product = Product::find($id);
        if(empty($product)){
            session()->flash('error','product not found');
            return response()->json([
                'status' => false,
                'errors' => ['Product not found']
            ]);
        }

        $productImages = productImage::where('product_id',$id);
        if(!empty($productImages)){
            foreach ($productImages as $productImage) {
                File::delete(public_path('/uploads/products/small/'.$productImage->image));
                File::delete(public_path('/uploads/products/large/'.$productImage->image));
            }
            productImage::where('product_id',$id)->delete();
        }
        $product->delete();
        session()->flash('success','product deleted successfully');
        return response()->json([
            'status' => true,
            'errors' => ['Product deleted successfully']
        ]);
    }


    public function getProduct(Request $request){

        $tempProduct = [];

        if($request->term != ''){
            $products = Product::where('title','like','%'.$request->term.'%')->get();

        if($products != null){
            foreach ($products as $product) {
                // $tempProduct[] = array(['id'=>$product->id , 'title'=>$product->title]);
                $tempProduct[] = array('id'=>$product->id , 'text'=>$product->title);
            }
        }
    }

     return response()->json([
        'tags' => $tempProduct,
        'status' => true
    ]);
//   print_r('tags');
}

}
