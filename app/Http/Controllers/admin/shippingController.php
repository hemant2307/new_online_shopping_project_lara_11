<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\shippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class shippingController extends Controller
{
public function create(){
        $countries = Country::orderBy('name','asc')->get();

        $data['countries'] = $countries;
        return view('admin.shipping-management.shipping',$data);
}



public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'country' => 'required',
            'shipping_charge' => 'required',
        ]);
        if($validator->passes()){
            $count = shippingCharge::where('country_id' , $request->country )->count();
            if($count > 0){
                Session::flash('error','Shipping charge already exist for this country');
                return response()->json([
                    'status' => true,
                    'errors' => []
                ]);
            }
            $shippingCharge = new shippingCharge();
            $shippingCharge->country_id = $request->country;
            $shippingCharge->shipping_charge = $request->shipping_charge;
            // dd($shippingCharge);
            $shippingCharge->save();

            Session()->flash('success','shipping details saved succcessfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }else{
            Session()->flash('error','shipping details not saved ');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        return view('admin.shipping-management.list-shipping');
    }



public function list(){
        $shippingCharges = shippingCharge::select('shipping_charges.*','countries.name')
                                             ->leftjoin('countries','countries.id','shipping_charges.country_id')->paginate(10);

            //  dd($shippingCharges);
        return view('admin.shipping-management.list-shipping',compact('shippingCharges'));

}



public function edit($id){
    $countries = Country::orderBy('name','asc')->get();

    $shipping_charge = shippingCharge::find($id);

    return view('admin.shipping-management.edit-shipping',compact('countries','shipping_charge'));

}



public function update($id , Request $request){
    $shippingCharge =  shippingCharge ::find($id);
    $validator = Validator::make($request->all(),[
        'country' => 'required',
        'shipping_charge' => 'required',
    ]);
    if($validator->passes()){
        $count = shippingCharge::where('country_id' , $request->country )->count();
        if($count > 0){
            Session::flash('error','Shipping charge already exist for this country');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }
        $shippingCharge->country_id = $request->country;
        $shippingCharge->shipping_charge = $request->shipping_charge;
        // dd($shippingCharge);
        $shippingCharge->save();

        Session()->flash('success','shipping details saved succcessfully');
        return response()->json([
            'status' => true,
            'errors' => []
        ]);
    }else{
        Session()->flash('error','shipping details not saved ');
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
}




public function delete(Request $request){
    $id = $request->id;

    $shipping_charge = shippingCharge::find($id);

    if($shipping_charge == null){
        Session()->flash('error','shipping cart not found ');
        return response()->json([
            'status' => false,
            'message' => 'shipping charge not found'
        ]);
    }
    $shipping_charge->delete();
    Session()->flash('error','shipping charge deleted successfully ');
    return response()->json([
        'status' => true,
        'message' => 'shipping charge deleted successfully'
    ]);

}











}
