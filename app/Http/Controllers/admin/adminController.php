<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{

    public function login(){
        return view('admin.admin-login');
    }

    public function authentication(Request $request){
        $validator = Validator::make($request->all(),[            
            'email' => 'required',
            'password' => 'required|',            
        ]);

        if($validator->passes()){
            if(Auth::guard('admin')->attempt(['email' =>$request->email, 'password' => $request->password])){                
                if(Auth::guard('admin')->user()->role == 'admin'){                  
                    return redirect()->route('admin.admin-dashboard');                  
                }else{ 
                        Auth::guard('admin')->logout();                   
                    return redirect()->route('admin.login')->with('error','you have not admin permissions.');
                }
            }else{
                return redirect()->route('admin.login')->with('error','check your email and password again');               
            }
        }else{
          return redirect()->route('admin.login')
              ->withInput()
              ->withErrors($validator);
        }       
    }


    public function dashboard(){
        return view('admin.admin-dashboard');
    }   


    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'you have loggedout successfully');
    }
    
}
