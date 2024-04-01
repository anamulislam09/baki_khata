<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function Index(){
        $users = User::where('customer_id', Auth::guard('admin')->user()->id)->get();
        // dd($users);
        return view('admin.users.index' , compact('users'));
    }

    public function Create(){
        return view('admin.users.create');
    }

    public function Store(Request $request){
        $v_id = 1;
        $isExist = User::where('customer_id', Auth::guard('admin')->user()->id)->exists();
        if ($isExist) {
            $user_id = User::where('customer_id', Auth::guard('admin')->user()->id)->max('user_id');
            $data['user_id'] = $this->formatSrl(++$user_id);
        } else {
            $data['user_id'] = 'UID-' . $this->formatSrl($v_id);
        }

        $data['customer_id'] = Auth::guard('admin')->user()->id;
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['password'] = $request->phone;
        
        User::create($data);
        return redirect()->route('users.index')->with('message', 'User creted successfully');
    }

     // unique id serial function
     public function formatSrl($srl)
     {
         switch (strlen($srl)) {
             case 1:
                 $zeros = '000000';
                 break;
             case 2:
                 $zeros = '00000';
                 break;
             case 3:
                 $zeros = '0000';
                 break;
             case 4:
                 $zeros = '000';
                 break;
             case 5:
                 $zeros = '00';
                 break;
             default:
                 $zeros = '0';
                 break;
         }
         return $zeros . $srl;
     }

     public function Edit($id){
         $data = User::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->first();
        //  dd($data);
        //  return response()->json($data);
         return view('admin.users.edit', compact('data'));
    }

    public function Update(Request $request)
    {
        dd($request->status);
        $data = User::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $request->user_id)->first();
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['password'] = $request->phone;
        $data['status'] = $request->status;
        $data->save();

        return redirect()->route('users.index')->with('message', 'User Updated Successfully');
    }
}
