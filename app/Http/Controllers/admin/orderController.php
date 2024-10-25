<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\order;
use App\Models\orderItem;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class orderController extends Controller
{

public function list(Request $request){
        // $orders = order::with(['countries','users'])->paginate(3);
        $orders = order::latest('orders.created_at')->select('orders.*','users.name','users.email');
        $orders = $orders->leftJoin('users','users.id','orders.user_id');

        if($request->get('search') != ''){
            $orders = $orders->where('users.name','like','%'.$request->search.'%');
            $orders = $orders->orWhere('users.email','like','%'.$request->search.'%');
            $orders = $orders->orWhere('orders.id','like','%'.$request->search.'%');
        }
        $orders = $orders->paginate(7);


// if($request->get('search') != ''){
//     $orders = $orders->where('id','like','%'.$request->search.'%')
//                       ->orWhere('email','like','%'.$request->search.'%');
// }
// $orders = $orders->paginate(3);

        return view('admin.orders.list',compact('orders'));
}





public function tableOrders(Request $request){
    $orders = order::with(['countries','users'])->paginate(3);
    // dd($orders);
    return view('admin.orders.order',compact('orders'));

}



public function Orderdetail($orderId){
    // $order = order::where('id',$orderId)->with('countries')->first();

    // by using with (relation of table) we can get the country name insted of using leftjoin  *********

    $order = order::where('orders.id',$orderId)->select('orders.*','countries.name as countryNmae')
                                        ->leftJoin('countries','countries.id','orders.country_id')
                                        ->first();

    $products = orderItem::where('order_id',$orderId)->get();

    return view('admin.orders.order-detail' ,['order'=>$order, 'products'=> $products]);
}



public function changeOrderStatus(Request $request , $orderId){
    $order = order::find($orderId);
    $order->status = $request->status;
    $order->shipped_date = $request->shipped_date;
    $order->save();
    session()->flash('success','order status and shipped date updated successfully');
    // return redirect()->back()->with('success','order status and shipped date updated successfully');
    return response()->json([
        'status' => true,
        'message' => 'order status and shipped date updated successfully'

    ]);

}





}
