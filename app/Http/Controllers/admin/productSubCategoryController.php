<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\sub_category;
use Illuminate\Http\Request;

class productSubCategoryController extends Controller
{
    public function index(Request $request){
        if(!empty($request->category_id)){            
            $subCategories = sub_category::where('category_id',$request->category_id)
                            ->orderBy('name','asc')
                            ->get();
            return response()->json([
                'status' => true,
                'subCategories' => $subCategories    
            ]);
        }else{
            return response()->json([
                'status' => true,
                'subCategories' => []    
            ]);
        }
    }
    
}
