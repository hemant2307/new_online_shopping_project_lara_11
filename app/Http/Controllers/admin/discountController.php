<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class discountController extends Controller
{


public function list(){
        $discounts = Discount::paginate(4);
        return view('admin.discount.list',compact('discounts'));
}



public function create(){
        return view('admin.discount.create');
}



public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code'=> 'required',
            'name'=> 'required',
            'type'=> 'required',
            'status'=> 'required',
            'starts_at' => 'required',
            'expires_at' => 'required'
        ]);

        if($validator->passes()){
// starts_at date should not less then currant time
        if(!empty($request->starts_at)){
            $now = Carbon::now();
            $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
            if($startAt->lte($now) == true){
                return response()->json([
                    'status' => false,
                    // 'errors' => ['starts_at' => 'starts_at date should not less then currant time']
                    // 'errors' => $validator->errors()
                    'message' => 'starts_at date should not less then currant time'
                ]);
            }
        }

// expires_at time must be greater then starts_at time
        if(!empty($request->starts_at)  && !empty($request->expires_at)){
            $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
            $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);
            if($expiresAt->gt($startAt) == false){
                return response()->json([
                    'status' => false,
                    // 'errors' => ['expires_at' => 'expires_at date should not less then strats_at time']
                    // 'errors' => $validator->errors()
                    'message' => 'expires_at date should not less then strats_at time'
                ]);
            }
        }


            $discount = new Discount();
            $discount->code = $request->code;
            $discount->name = $request->name;
            $discount->description = $request->description;
            $discount->max_user = $request->max_user;
            $discount->max_uses_user = $request->max_uses_user;
            $discount->type = $request->type;
            $discount->discount_amount = $request->discount_amount;
            $discount->min_amount = $request->min_amount;
            $discount->status = $request->status;
            $discount->starts_at = $request->starts_at;
            $discount->expires_at = $request->expires_at;
            $discount->save();

            session()->flash('success','discount coupon created successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        }else{
            session()->flash('error','discount coupon NOT created ,some ERROR occured');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);

        }

        // return view('admin.discount.create');
}



public function edit($id,Request $request){
    $discount = Discount::find($id);
    // dd($discount);
    return view('admin.discount.edit',compact('discount'));

}




public function update($id,Request $request){
    $discount =  Discount::find($request->id);
    // dd($discount);

    $validator = Validator::make($request->all(), [
        'code'=> 'required',
        'name'=> 'required',
        'type'=> 'required',
        'status'=> 'required'
    ]);
    if($validator->passes()){

        $discount->code = $request->code;
        $discount->name = $request->name;
        $discount->description = $request->description;
        $discount->max_user = $request->max_user;
        $discount->max_uses_user = $request->max_uses_user;
        $discount->type = $request->type;
        $discount->discount_amount = $request->discount_amount;
        $discount->min_amount = $request->min_amount;
        $discount->status = $request->status;
        $discount->starts_at = $request->starts_at;
        $discount->expires_at = $request->expires_at;
        $discount->save();

        session()->flash('success','discount coupon Updated successfully');
        return response()->json([
            'status' => true,
            'errors' => []
        ]);

    }else{
        session()->flash('error','discount coupon NOT updated ,some ERROR occured');
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);

    }

}




public function delete($id,Request $request){
    $id = $request->id;
    $discount =  Discount::find($id);
    if($discount == null){
        session()->flash('error','discount coupon not found in database');
        return response()->json([
            'status' => false,
            'message' => 'coupon not found'

        ]);
    }else{
        $discount->delete();
        session()->flash('error','discount coupon deleted successfully from database');
        return response()->json([
            'status' => true,
            'message' => 'coupon deleted successfully'
        ]);
    }

}












}
