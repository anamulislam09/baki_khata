<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // login method start here 
    public function index()
    {
        return view('admin.pages.admin_login');
    } //end method

    public function Dashboard()
    {
        return view('admin.index');
    } //end method

    public function Login(Request $request)
    {
        $check = $request->all();
        $datas = Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password'], 'status' => 1]);
        if (!$datas) {
            return back()->with('message', 'Something Went Wrong! ');
        } else {
            $check = $request->all();
            if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
                return redirect()->route('admin.dashboard')->with('message', 'Login Successfully');
            } else {
                return back()->with('message', 'Invalid Email or Password! ');
            }
        }
    }
    // login method ends here 

    // register method start here
    public function AdminRegister()
    {
        return view('admin.pages.admin_register');
    } //end method

    public function store(Request $request)
    {
        // $email = Customer::where('email', $request->email)->exists();
        // if ($email) {
        //     return redirect()->back()->with('message', 'This Email already used!');
        // } 
        // else {
        // $id = UniqueIdGenerator::generate(['table' => 'customers', 'length' => 4]);
        $start_at = 1001;

        if ($start_at) {
            $customer = Customer::find($start_at);
            if (!$customer) {
                $data['id'] = $start_at;
            }
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $customer = Customer::create($data);

        if ($customer) {
            $customer = Customer::where('id', $customer->id)->first();

            $data['customer_id'] = $customer->id;
            $data['address'] = $request->address;
            $data['phone'] = $request->phone;
            $data['nid_no'] = $request->nid_no;
            $data['image'] = $request->image;
            CustomerDetail::create($data);
        }
        return redirect()->route('login_form')->with('message', 'Admin register Successfully');
    }

    // register method ends here

    // Logout method ends here
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('message', 'Admin Logout Successfully');
        //end method
    }
    // Logout method ends here

    /*-------------------Customers related method start here--------------*/
    public function Customer(Request $request)
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = Customer::where('role', 1)->get();
            return view('superadmin.customers.index', compact('data'));
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
        //end method
    }

    // CustomerEdit edit 
    public function CustomerEdit($id)
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = Customer::findOrFail($id);
            // $flat = Flat::where('customer_id', $data->id)->first();
            return view('superadmin.customers.edit', compact('data'));
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    // Customer update 
    public function CustomerUpdate(Request $request)
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = array();
            $data['status'] = $request->status;
            // dd($data);
            DB::table('customers')->where('id', $request->id)->update($data);

            $notification = array('message' => 'Customer status update successfully.', 'alert_type' => 'warning');
            return redirect()->route('customers.all')->with($notification);
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    /*-------------------Customers related method start here--------------*/

    /*-------------------Customers password method start here--------------*/
    // public function Forgot()
    // {
    //     return view('admin.pages.forgot_password');
    // }
    // // receive the email 
    // public function ForgotPassword(Request $request)
    // {
    //     $customer = Customer::where('email', '=', $request->email)->first();
    //     if (!empty($customer)) {
    //         $customer->remember_token = Str::random(40);
    //         $customer->save();
    //         Mail::to($customer->email)->send(new ForgotPasswordMail($customer));
    //         $notification = array('message' => 'Please check your email and forgot your password.', 'alert_type' => 'warning');
    //         return redirect()->back()->with($notification);
    //     } else {
    //         $notification = array('message' => 'Email not found in this system.', 'alert_type' => 'warning');
    //         return redirect()->back()->with($notification);
    //     }
    // }

    // public function reset($token)
    // {
    //     $customer = Customer::where('remember_token', '=', $token)->first();
    //     if (!empty($customer)) {
    //         $data['customer'] = $customer;
    //         return view('admin.pages.reset');
    //     } else {
    //         abort(404);
    //     }
    // }

    // public function PostReset($token, Request $request)
    // {
    //     $customer = Customer::where('remember_token', '=', $token)->first();
    //     if ($request->password == $request->confirm_password) {
    //         $customer->password = Hash::make($request->password);
    //         if (empty($customer->email_verified_at)) {
    //             $customer->email_verified_at = date('Y-m-d H:i:s');
    //         }
    //         $customer->remember_token = Str::random(40);
    //         $customer->save();
    //         $notification = array('message' => 'Password reset successfully.', 'alert_type' => 'warning');
    //         return redirect()->route('login_form')->with($notification);
    //     } else {
    //         $notification = array('message' => 'Password & Confirm Password does not match.', 'alert_type' => 'warning');
    //         return redirect()->back()->with($notification);
    //     }
    // }
    /*-------------------Customers password method ends here--------------*/
}
