<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\customerAddress;
use App\Models\Discount;
use App\Models\order;
use App\Models\orderItem;
use App\Models\product;
use App\Models\shippingCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class cartController extends Controller
{


public function addToCart(Request $request){

    $product = product::with('product_images')->find($request->id);
    if($product == null){
        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ]);
    }

    if(Cart:: count() > 0){
// if product is not in cart
        $cartContent = Cart::content();
        $productAlreadyExist = false;

        foreach($cartContent as $item){
            if($item->id == $product->id){
                // product already availabel in the cart
                $productAlreadyExist = true;
            }
        }
        if($productAlreadyExist == false){
            $cart =  Cart::add($product->id, $product->title, 1, $product->price,['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
            $status = true;
            $message = $product->title." added into the cart";
            session()->flash('success',$message);
        }else{
            $status = false;
            $message = $product->title." already into the cart";
            session()->flash('error',$message);
        }
    }else{
        // if product is not in cart,product added in cart
        $cart =  Cart::add($product->id, $product->title, 1, $product->price,['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
        $status = true;
        $message = $product->title." added into the cart";
        session()->flash('success',$message);
    }
    return response()->json([
        'status' => $status,
        'message' => $message
    ]);
}



public function cart(){
        $cartContent = Cart::content();
        // dd($cartContent);
        return view('front.cart',compact('cartContent'));
}




public function updatecart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;

        $cartInfo = Cart::get($rowId);
        $product = product::find($cartInfo->id);
        // dd($product);

        if($product->track_qty == 'yes'){
            if($qty <= $product->qty){
                Cart::update($rowId,$qty);

                $message = 'cart updated successfully';
                $status = true;
                session()->flash('success',$message);
            }else{
                $message = "Sorry, we are out of stock for this product";
                $status = false;
                session()->flash('error',$message);
            }
        }else{
            Cart::update($rowId,$qty);

            $message = 'cart updated successfully';
            $status = true;
            session()->flash('success',$message);
        }
        // session()->flash('success',$message);
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
}




public function deleteCartItem(Request $request){
    $cartItemInfo = Cart::get($request->rowId);

    if($cartItemInfo == null){
        $message = 'cart item not found';
        session()->flash('error',$message);

        return response()->json([
            'status' => false,
            'message' => $message
        ]);
    }
    Cart::remove($request->rowId);
    $message = 'cart item removed successfully';
    session()->flash('error',$message);

    return response()->json([
        'status' => true,
        'message' => $message
    ]);
}



public function checkout(){
    $discount = 0;
    $totalQty = 0;
        $totalShipping = 0;
        $grand_total = 0;
        $subtotal = Cart::subtotal(2,'.','');
            // if cart is empty
            if(Cart::count()  == 0){
                return redirect()->route('shop.cart');
            }
            // if user not logged in
            if(Auth::check() == false){
                // if(!session()->has('url.intended')){
                //     session(['url.intended' => url()->current()]);
                // }
                return redirect()->route('user.login');
            }
        $countries = Country::orderBy('name','asc')->get();
        $customer_address = customerAddress::where('user_id',Auth::user()->id)->first();
                    // session()->forgot(url.intended);

                    $subTotal = Cart::subtotal(2,'.','');
    // calculate discount
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percentage'){
                $discount = ($code->discount_amount/100)*$subTotal;
            }else{
                $discount = $code->discount_amount;
            }
        }

    if($customer_address != ''){
                // now calculate shipping charges here
                $userCountry = $customer_address->country_id;
                $shippingInfo = shippingCharge::where('country_id' , $userCountry)->first();

            // count total shipping on all product availabel into the cart
                    foreach (Cart::content() as $item) {
                        $totalQty += $item->qty;
                    }
            $totalShipping = $totalQty*$shippingInfo->shipping_charge;
            $grand_total = ($subtotal-$discount)+$totalShipping;
    }
    return view("front.checkout",compact('countries','customer_address','totalShipping','grand_total','discount'));
}




public function checkOutProcess(Request $request){
        // validation of the form
            $validator = Validator::make($request->all(),[
                'first_name' => 'required|min:3|max:15',
                'last_name' => 'required|min:3|max:15',
                'email' => 'required|email',
                'country' => 'required',
                'address' => 'required|max:150',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
                'mobile' => 'required',
            ]);
        if($validator->fails() ){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }else{
// save the value into the customer Addresses table
            customerAddress:: updateOrCreate(
                ['user_id' => Auth::user()->id],
                [
                    'user_id' => Auth::user()->id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'country_id' => $request->country,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                    'mobile' => $request->mobile,
                    'order_note' => $request->order_note,
                ]
            );

// save the Order values into the orders tabel
            if($request->payment_method == 'cod'){

    // calculating shipping to save the order detail here
                $subTotal = Cart::subtotal(2,'.','');
                $shipping = 0;
                $coupon_code = 0;
                $discount_id = null;
                $discount = 0;

    // calculate discount
            if(session()->has('code')){
                $code = session()->get('code');
                if($code->type == 'percentage'){
                    $discount = ($code->discount_amount/100)*$subTotal;
                }else{
                    $discount = $code->discount_amount;
                }

                $coupon_code = $code->code;
                $discount_id = $code->id;
            }
    // calculation of discount end here

                $shippingChargeInfo = shippingCharge::where('country_id',$request->country)->first();
                $totalQty = 0;
                foreach(Cart::content() as $item){
                    $totalQty += $item->qty;
                }

                if($shippingChargeInfo != null){
                    $shippingCharge = $shippingChargeInfo->shipping_charge;
                    $shipping = $totalQty*$shippingCharge;
                    $grand_total = ($subTotal-$discount)+$shipping;
                    // dd($grand_total);

            }else{
                $shippingChargeInfo = shippingCharge::where('country_id','rest_of_world')->first();
                $shippingCharge = $shippingChargeInfo->shipping_charge;
                $shipping = $totalQty*$shippingCharge;
                $grand_total = ($subTotal-$discount)+$shipping;
            }

// order detail
                $order = new order();
                $order->user_id = Auth::user()->id;
                $order->subtotal = $subTotal;
                $order->shipping = $shipping;
                $order->coupon_code = $coupon_code;
                $order->discount = $discount;
                $order->discount_id = $discount_id;
                $order->grand_total = $grand_total;
                $order->payment_status = 'not Paid';
                $order->status = 'pending';
// customer shipping details
                $order->first_name = $request->first_name;
                $order->last_name = $request->last_name;
                $order->email = $request->email;
                $order->country_id = $request->country;
                $order->address = $request->address;
                $order->apartment = $request->apartment;
                $order->city = $request->city;
                $order->state = $request->state;
                $order->zip = $request->zip;
                $order->mobile = $request->mobile;
                $order->order_note = $request->order_note;
                $order->save();

// save cart_item into the cart table
                foreach(Cart::content() as $item){
                    $order_iten = new orderItem();
                    $order_iten->order_id = $order->id;
                    $order_iten->product_id = $item->id;
                    $order_iten->name = $item->name;
                    $order_iten->qty = $item->qty;
                    $order_iten->price = $item->price;
                    $order_iten->total = $item->price*$item->qty;
                    $order_iten->save();
                }
                session()->flash('success','you have successfull placed your order  "Thank-You..!"');
                Cart::destroy();
                session()->forget('code');
                 return response()->json([
                        'orderId' => $order->id,
                        'status' => true,
                        'errors' => []
                    ]);
            }else{
        }
    }
}



public function thankyou(Request $request){
    $id = $request->orderId;
    return view('front.thankyou',compact('id'));
}




public function getOrderSummery(Request $request){
    $subTotal = Cart::subtotal(2,'.','');
    $discount = 0;
    $discountString = '';
    // calculate discount
    if(session()->has('code')){
        $code = session()->get('code');
        if($code->type == 'percentage'){
            $discount = ($code->discount_amount/100)*$subTotal;
        }else{
            $discount = $code->discount_amount;
        }
        $discountString = '<div mt-4 id="discount-response">
        <strong>'.Session::get("code")->code.'</strong>
        <a class="btn btn-sm btn-danger" id="remove-discount" href=""><i class="fa fa-times"></i></a>
        </div>';
    }

    if($request->country_id > 0){
        $shippingChargeInfo = shippingCharge::where('country_id',$request->country_id)->first();
        $subTotal = Cart::subtotal(2,'.','');
            $totalQty = 0;
            foreach(Cart::content() as $item){
                $totalQty += $item->qty;
            }

                if($shippingChargeInfo != null){
                            $shippingCharge = $shippingChargeInfo->shipping_charge;
                            $totalShippingCharge = $totalQty*$shippingCharge;
                            $grand_total = ($subTotal-$discount)+$totalShippingCharge;
                            // dd($grand_total);
                            return response()->json([
                                'status' => true,
                                'discount' => number_format($discount,2),
                                'discountString' => $discountString,
                                'totalShippingCharge' => number_format($totalShippingCharge,2),
                                'grand_total' => number_format($grand_total,2)
                            ]);
                    }else{
                        $shippingChargeInfo = shippingCharge::where('country_id','rest_of_world')->first();
                        $shippingCharge = $shippingChargeInfo->shipping_charge;
                        $totalShippingCharge = $totalQty*$shippingCharge;
                        $grand_total = ($subTotal-$discount)+$totalShippingCharge;
                        return response()->json([
                            'status' => true,
                           'discount' => number_format($discount,2),
                            'discountString' => $discountString,
                            'totalShippingCharge' => number_format($totalShippingCharge,2),
                            'grand_total' => number_format($grand_total,2)
                        ]);
                    }
   }else{
        return response()->json([
            'status' => true,
            'discount' => number_format($discount,2),
            'discountString' => $discountString,
            'totalShippingCharge' => number_format(0,2),
            'grand_total' => number_format(($subTotal-$discount),2)
        ]);

   }
}




public function applyDiscount(Request $request){
    // dd($request->code);
    $code = Discount::where('code',$request->code)->first();

    if($code ==  null){
        return response()->json([
            'status'=> false,
            'message' => 'Invalid Coupon Code or not found'
        ]);
    }

    $now = Carbon::now();
// check starts At time of the coupon
    if($code->starts_at != ''){
        $start_at = Carbon::createFromFormat('Y-m-d H:i:s',$code->starts_at);
        if($now->lt($start_at)){
            return response()->json([
                'status'=> false,
                'message' => 'Invalid Coupon Code 1'
            ]);
        }
    }

// check expires At time of the coupon
    if($code->expires_at != ''){
        $ends_at = Carbon::createFromFormat('Y-m-d H:i:s',$code->expires_at);
        if($now->gt($ends_at)){
            return response()->json([
                'status'=> false,
                'message' => 'Invalid Coupon Code 2'
            ]);
        }
    }

// max uses check
            if($code->max_user > 0){
                $couponUsed = order::where('discount_id',$code->id)->count();
                if($couponUsed >= $code->max_user){
                    return response()->json([
                        'status'=> false,
                        'message' => 'Coupon Code has expired'
                        ]);
                    }
                }

// max  uses user check
            if($code->max_uses_user > 0){
                $couponUsedByUser = order::where(['discount_id'=>$code->id , 'user_id'=> Auth::user()->id])->count();
                if($couponUsed >= $code->max_uses_user){
                    return response()->json([
                        'status'=> false,
                        'message' => 'Coupon Code has been used'
                        ]);
                    }
                }

// min amount check
    $subtotal = Cart::subtotal(2,'.','');
            if($code->min_amount > 0){
                if($subtotal < $code->min_amount){
                    return response()->json([
                        'status'=> false,
                        'message' => 'Minimum amount should be $'.$code->min_amount.'Rupees'
                        ]);
                    }
                }

    session()->put('code',$code);
    return $this->getOrderSummery($request);
}



public function removeCoupon(Request $request){
    session()->forget('code');
    return $this->getOrderSummery($request);

}


}
