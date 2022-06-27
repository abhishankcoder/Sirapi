<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function login(Request $request){

        // return $request->password;
        $user = User::where('email',$request->username)->first();

        $data = [
         'status'=>false,
         'message'=> 'user not exits'
        ];

         if(!$data){

             return response()->json($data);

         }

        if (Hash::check($request->password,$user->password)) {
            return response()->json([
                'status'=>true,
                'user'=>$user,
                'message'=>'user login successfully'
            ]);
        }else{
            $data['message']='password not match';
            return response()->json($data);
        }


    }

    public function create(Request $request){

        $request->validate([
            'username'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);

        $hashPashword = Hash::make($request->newPassword);

        $user = new User;
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = $hashPashword;
        $user->save();

        return response()->json(['status'=>200,'user'=>$user]);



    }


}
