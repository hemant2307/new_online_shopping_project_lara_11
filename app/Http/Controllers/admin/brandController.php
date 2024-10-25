<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class brandController extends Controller
{
    public function list(Request $request){
        $brands = brand::orderBy('id','desc');
        if(!empty($request->search)){
            $brands->where('name', 'LIKE','%'.$request->search.'%')
                              ->orWhere('slug','like','%'.$request->search.'%');
        }
            $brands = $brands->paginate(6);
            return view('admin.brand.list',compact('brands'));
    }


    public function create(){       
        return view('admin.Brand.create');
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required',         
        ]);
        if($validator->passes()){
            $sub_category = new Brand();           
            $sub_category->name = $request->name;
            $sub_category->slug = $request->slug;
            $sub_category->status = $request->status;
            $sub_category->save();
          
            session()->flash('success','brand created successfully');
            return response()->json([
                'status' => true,
                'message' => 'new brand created',
                'errors' => []
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'there is a problem check again all fields',
            'errors' => $validator->errors()
        ]);
    }


    public function edit($id){
        $brand = brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }  


    public function update($id, Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',    
            'status' => 'required',
        ]);

        if($validator->passes()){      
        $sub_category = brand::find($id);
        $sub_category->name = $request->name;
        $sub_category->slug = $request->slug;
        $sub_category->status = $request->status;
        $sub_category->save();
        session()->flash('success','Brand updated successfully');
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


    public function delete($id){
            $brand = brand::find($id);
            $brand->delete();
            session()->flash('success','Brand deleted successfully');
            return redirect()->back();
}


}
