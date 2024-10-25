<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\sub_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class subCategoryController extends Controller
{

    public function list(Request $request){
        $sub_categories = sub_category::orderBy('id','desc');
        if(!empty($request->search)){
            $sub_categories->where('name', 'LIKE','%'.$request->search.'%')
                              ->orWhere('slug','like','%'.$request->search.'%');
        }
            $sub_categories = $sub_categories->paginate(6);
            return view('admin.sub-category.list',compact('sub_categories'));
    }


    public function create(){
        $categories = Category::orderBy('name','desc')->get();
        return view('admin.sub-category.create',compact('categories'));
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
        ]);
        if($validator->passes()){
            $sub_category = new sub_category();
            $sub_category->name = $request->name;
            $sub_category->slug = $request->slug;
            $sub_category->status = $request->status;
            $sub_category->showHome = $request->showHome;
            $sub_category->category_id = $request->category;
            $sub_category->save();

            session()->flash('success','new sub category created successfully');
            return response()->json([
                'status' => true,
                'message' => 'new sub_category created',
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
        $categories = Category::orderBy('name','desc')->get();
        $sub_category = sub_category::find($id);
        return view('admin.sub-category.edit', compact('sub_category','categories'));
    }


    public function update($id, Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
        $sub_category = sub_category::find($id);
        $sub_category->name = $request->name;
        $sub_category->slug = $request->slug;
        $sub_category->status = $request->status;
        $sub_category->showHome = $request->showHome;
        $sub_category->category_id = $request->category;
        $sub_category->save();
        session()->flash('success','sub category updated successfully');
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
            $sub_category = sub_category::find($id);
            $sub_category->delete();
            session()->flash('success','sub category deleted successfully');
            return redirect()->back();
}



}
