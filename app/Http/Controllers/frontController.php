<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class frontController extends Controller
{
    public function index(){
        $isFeaturedProduct = product::where('is_featured','yes')
                                ->where('status',1)->take(5)
                                ->orderBy('id','Asc')->get();

        $latestProducts = product::where('status',1)
                                ->orderBy('id','desc')
                                ->take(5)->get();

        return view('front.home',compact('isFeaturedProduct','latestProducts'));
    }
}
