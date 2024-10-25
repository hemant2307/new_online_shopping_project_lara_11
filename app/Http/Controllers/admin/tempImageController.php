<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\temp_image;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class tempImageController extends Controller
{
   public function create(Request $request){

    $image = $request->image;

    if(!empty($image)){
        $ext = $image->getClientOriginalExtension();
        $newName = time().'.'.$ext;

        $tempImage = new temp_image();
        $tempImage->name = $newName;
        $tempImage->save();
        $image->move(public_path().'/temp',$newName);

        // generate thumb-nail
        $path = public_path().'/temp/'.$newName;
        $dPath = public_path().'/temp/thumb/'.$newName;

        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
            $image = $manager->read($path);
            $image = $image->resize(300,300);
            $image->save($dPath);

        return response()->json([
            'status' => true,
            'image_id' => $tempImage->id,
            'imagePath' => asset('/temp/thumb/'.$newName),
            'message' => "image saved in temp folder successfully"
        ]);
     }
   }
}
