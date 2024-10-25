<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\orderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
public function register(){
    return view('user.user-register');
}

public function saveUser(Request $request){

    $validator = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required',
        'password' => 'required|same:confirm_password',
        'confirm_password' => 'required'
    ]);
    if($validator->fails()){
        session()->flash('error',"there is a problem in data insertion");
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }else{
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        session()->flash('success',"you have registered successfully");
        return response()->json([
            'status' => true,
            'errors' => []
        ]);
    }
}



public function login(){
    return view('user.user-login');
}



public function authentication(Request $request){
    $validator = Validator::make($request->all(),[
        'email' => 'required|email',
        'password' => 'required|',
    ]);
    if($validator->passes()){
        if(Auth::attempt(['email' =>$request->email, 'password' => $request->password])){
            // if(session()->has('url.intended')){
            //     return redirect(session()->get('url.intended'));
            // }
            return response()->json([
                        'status' => true,
                        'errors' => []
                    ]);

            // if(Auth::user()->role == 2){
            //     // return redirect()->route('admin.admin-dashboard');
            //     return response()->json([
            //         'status' => true,
            //         'errors' => []
            //     ]);
            // }else{
            //     return redirect()->route('user.user-dashboard');
            // }
        }else{
            // return back()->with('check your email and password again');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }else{
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
}



public function dashboard(){
    return view('user.user-dashboard');
}



public function logout(){
    auth::logout();
    return redirect()->route('user.login')->with('success', 'you have loggedout successfully');
}


public function myOrders(){
    $user = Auth::user();
    $orders = order::where('user_id',$user->id)->get();

return view('user.myorders', compact('orders'));
}



public function orderDetail($orderId){

    // $order = order::where('user_id',Auth::user()->id)->where('id',$orderId)->first();
    $order = order::where(['user_id' => Auth::user()->id , 'id' => $orderId])->first();

    $orderItems = orderItem::where('order_id',$orderId)->get();
    $orderItemscount = orderItem::where('order_id',$orderId)->count();

    return view('user.order-detail',compact('order','orderItems','orderItemscount'));

}




}
