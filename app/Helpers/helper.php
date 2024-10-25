<?php
// echo "Hello there";

use App\Models\Category;
use App\Models\productImage;

function getCategories(){
    return  Category::orderBy('name','desc')
                    ->where('showHome','Yes')
                    ->where('status', 1)
                    ->with('sub_category')
                      ->get();
}



function getProductImage($productId){
    $productImage = productImage::where('product_id',$productId)->first();

}






?>
