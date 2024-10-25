<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\productImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class productImagecontroller extends Controller
{
    public function update(Request $request){

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $source_path = $image->getpathName();

        $productImage = new productImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id.'-'.$productImage->id.'-'.time().'.'.$ext;
        $productImage->image = $imageName;
        $productImage->save();

           // create image manager with desired driver
           $manager = new ImageManager(new Driver());

             // generate small thumbnail

             $dest_path = public_path().'/uploads/products/small/'.$imageName;
               // read image from file system
               $image = $manager->read($source_path);
               $image = $image->resize(300,300);
              $image->save($dest_path);


              return response()->json([
                'status' => true,
                'image_id' => $productImage->id,
                'path' => asset('uploads/products/small/'.$productImage->image),
                'message' => 'Image uploaded successfully',
              ]);
    }


    public function destroy(Request $request){
        $productImage = productImage::find($request->id);
        if(empty($productImage)){
            return response()->json([
                'status' => false,
                'message' => 'Product Image not found',
            ]);
        }

        File::delete(public_path('uploads/products/small/'.$productImage->image));
        File::delete(public_path('uploads/products/large/'.$productImage->image));

        $productImage->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product Image deleted successfully',

        ]);

    }
}
