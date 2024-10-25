<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\product;
use App\Models\sub_category;
use Illuminate\Http\Request;

class shopController extends Controller
{
    public function index(Request $request, $categoryslug = null , $subcategoryslug = null){

        $categorySelected = "";
        $subCategorySelected = "";
        $brandsArray = [];

        $categories = Category::where('status',1)->where('showHome','Yes')->with('sub_category')->orderBy('id','Asc')->get();

        $brands = Brand::where('status',1)->orderBy('id','Asc')->get();

        $products = product::where('status',1);
        // filter product process

        if(!empty($categoryslug)){
            $category = Category::where('slug',$categoryslug)->first();
            $products = $products->where('category_id',$category->id);
            $categorySelected = $category->id;
        }

        if(!empty($subcategoryslug)){
            $subcategory = sub_category::where('slug',$subcategoryslug)->first();
            $products = $products->where('sub_category_id',$subcategory->id);
            $subCategorySelected = $subcategory->id;
        }

        if(!empty($request->brand)){
            // $brandsArray = $request->get('brand');
            $brandsArray = explode(',',$request->brand);
            $products = $products->whereIn('brand_id' , $brandsArray);
        }

        if($request->get('price_min') != '' && ($request->get('price_max')) != '' ){
            if($request->get('price_max') == 1000){
                $products = $products->whereBetween('price',[intval($request->get('price_min')),100000]);
            }else{
                $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);
            }
        }

        if($request->get('sort')){
            if($request->get('sort') == 'latest'){
                $products = $products->orderBy('id','Desc');
            }else if($request->get('sort') == 'price_asc'){
                $products = $products->orderBy('price','Asc');
            }else{
                $products = $products->orderBy('price','Desc');
            }
        }else{
            $products = $products->orderBy('id','asc');
        }

        $products = $products->orderBy('id','Asc');
        $products = $products->paginate(4);


        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;
        $data['price_min'] = intval($request->get('price_min'));
        $data['price_max'] = (intval($request->get('price_max')) == 0) ? '1000' : $request->get('price_max');
        $data['sort'] = $request->get('sort');

        return view('front.shop',$data);

        // or  (both will work same)
        // return view('front.shop',compact('categories','brands','products','categorySelected','subCategorySelected'));
    }


    public function getProduct($slug){
        // dd($slug);
        $product = Product::where('slug',$slug)->with('product_images')->first();
        if($product == null){
            abort(404);
        }
        $relatedProducts = [];
        if($product->related_product != ''){
            $productArray = explode(',',$product->related_product);
            $relatedProducts = product::whereIn('id',$productArray)->with('product_images')->get();
        }

        $randomProducts = product::where('status',1)->with('product_images')->inRandomOrder()->where('slug', '!=', $slug)->take(4)->get();

        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        $data['randomProducts'] = $randomProducts;

        return view('front.product',$data);

    }
}
