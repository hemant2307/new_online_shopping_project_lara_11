<?php

namespace App\Http\Controllers\admin;

use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\temp_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

// use image;

class categoryController extends Controller
{

    public function create()    {
        return view('admin.category.create');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
        ]);

        if($validator->passes()){
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->showHome = $request->showHome;
            $category->status = $request->status;
            // $category->save();

            if(!empty($request->image_id)){
                $tempImage = temp_image::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);
                $newImageName = $category->id.'.'.$ext;

                 $spath = public_path().'/temp/'.$tempImage->name;
                 $dpath = public_path().'/uploads/category/'.$newImageName;

                File::copy($spath,$dpath);

                // create new manager instance with desired driver
                // $ImageManager = new ImageManager(new Driver());

                // $thumbImage = $ImageManager->read('/uploads/category/'.$newImageName);
                // $thumbImage->resize(200,200);
                // $thumbImage->save('/uploads/category/thumb/'.$newImageName);


                $category->image = $newImageName;
                $category->save();

            }

            session()->flash('success','new category created successfully');
            return response()->json([
                'status' => true,
                'message' => 'new category created',
                'errors' => []
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'there is a problem check again all fields',
            'errors' => $validator->errors()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function list(Request $request){
        $categories = Category::oldest();
        if(!empty($request->search)){
            $categories->where('name','like','%'.$request->search.'%')
                         ->orWhere('slug','like','%'.$request->search.'%');
        }
        $categories = $categories->paginate(9);
        return view('admin.category.list',compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id , Request $request){
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request ){
        // $category = Category::find($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required'

        ]);

        if($validator->passes()){
            $category = Category::find($id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->showHome = $request->showHome;
            $category->status = $request->status;
            $category->save();

            $oldImage = $category->image;

            if(!empty($request->image_id)){
                $tempImage = temp_image::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);
                $newImageName = $category->id.'-'.time().'.'.$ext;

                 $spath = public_path().'/temp/'.$tempImage->name;
                $dpath = public_path().'/uploads/category/'.$newImageName;

                File::copy($spath,$dpath);

                // create new manager instance with desired driver
                // $ImageManager = new ImageManager(new Driver());

                // $thumbImage = $ImageManager->read('/uploads/category/'.$newImageName);
                // $thumbImage->resize(200,200);
                // $thumbImage->save('/uploads/category/thumb/'.$newImageName);

                $category->image = $newImageName;
                $category->save();

                File::delete(public_path().'/uploads/category/'.$oldImage);

            }

            session()->flash('success','category updated successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }else{
            session()->flash('error','something went wrong');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request){
        $category = category::find($request->id);
        // if(!empty($request->id)){
        //     $category->delete();
        //     session()->flash('success','category deleted successfully');

        // }
        $category->delete();
        // session()->flash('success','category has deleted successfully');
        // return response()->json([
        //     'status' => true,
        // ]);

        File::delete(public_path().'/uploads/category/'.$category->image);

        return back()->with('success','category has deleted successfully');
    }
}
