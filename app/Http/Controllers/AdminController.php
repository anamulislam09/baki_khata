<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\Invoice;
use App\Models\Ledger;
use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;


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
    }

    public function Login(Request $request)
    {
        // $today = Carbon::today()->toDateString();
        // $datetime1 = new DateTime($item->package_start_date); 
        // $datetime2 = new DateTime($today);
        // $difference = $datetime1->diff($datetime2);

        $check = $request->all();
        $datas = Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password'], 'status' => 1, 'isVerified' => 1]);
        if (!$datas) {
            return back()->with('message', 'Something Went Wrong! Please contact our head office for any need, Sorry for the temporary inconvenience.');
        } else {
            $check = $request->all();
            if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
                return redirect()->route('admin.dashboard')->with('message', 'Login Successfully');
            } else {
                return back()->with('message', 'Invalid Email or Password!');
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
        $customer = CustomerDetail::where('phone', '=', $request->phone)->first();
        if ($customer) {
            return redirect()->back()->with('message', 'This phone Number Already Used. Please Try Another Phone Number');
        } else {
            $start_at = 1001;
            if ($start_at) {
                $customer = Customer::find($start_at);
                if (!$customer) {
                    $data['id'] = $start_at;
                }
            }

            $data['name'] = $request->name;
            $data['shop_name'] = $request->shop_name;
            $data['email'] = $request->email;
            $data['password'] = Hash::make($request->password);
            $otp = Str::random(4);
            $data['otp'] = $otp;
            $customer = Customer::create($data);

            if ($customer) {
                $customer = Customer::where('id', $customer->id)->first();

                $data['customer_id'] = $customer->id;
                $data['address'] = $request->address;
                $data['phone'] = $request->phone;
                $data['nid_no'] = $request->nid_no;
                $data['image'] = $request->image;
                $data = CustomerDetail::create($data);
            }
            if ($data) {
                $phone = CustomerDetail::latest()->first()->phone;
                $otp = Customer::latest()->first()->otp;

                $post_url = "http://api.smsinbd.com/sms-api/sendsms";
                $post_values['api_token'] = "V8qsvGXfqBFhS4FozsQq7MyaeqTzXY2es6ufjQ3M";
                $post_values['senderid'] = "8801969908462";
                $post_values['message'] = "Your OPT Code is: " . $otp;
                $post_values['contact_number'] = $phone;

                $post_string = "";
                foreach ($post_values as $key => $value) {
                    $post_string .= "$key=" . urlencode($value) . "&";
                }
                $post_string = rtrim($post_string, "& ");

                $request = curl_init($post_url);
                curl_setopt($request, CURLOPT_HEADER, 0);
                curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
                curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
                $post_response = curl_exec($request);
                curl_close($request);
                $array =  json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true);

                return redirect()->route('admin.verfy')->with('message', 'Registration Successfully');
            }
        }
    }
    // register method ends here

    // Verify method ends here
    public function Verify()
    {
        $customer = Customer::latest()->first();
        return view('admin.pages.admin_register_verify', compact('customer'));
    }
    // Verify method ends here

    // Verify store method ends here
    public function VerifyStore(Request $request)
    {
        $customer = Customer::where('id', $request->customer_id)->first();
        if ($customer->otp == $request->otp) {
            $customer['isVerified'] = 1;
            $customer->save();
            return redirect()->route('admin.verfied');
        } else {
            return redirect()->back()->with('message', 'OTP is Invalied! please, Submit Valied OTP.');
        }
    }
    // Verify store method ends here

    // Verified method ends here
    public function Verified(Request $request)
    {
        $customer = Customer::latest()->first();
        return view('admin.pages.admin_register_verified', compact('customer'));
    }
    // Verified method ends here

    // Logout method ends here
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('message', 'Admin Logout Successfully');
        //end method
    }
    // Logout method ends here

    /*-------------------Customers related method start here--------------*/
    public function Client(Request $request)
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
    public function ClientEdit($id)
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = Customer::findOrFail($id);
            return view('superadmin.customers.edit', compact('data'));
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    // Customer update 
    public function ClientUpdate(Request $request)
    {
        $isverify = DB::table('customers')->where('id', $request->id)->first();
        $package_amount = Package::where('id', $request->package)->first();
        if (Auth::guard('admin')->user()->role == 0) {
            if ($isverify->isVerified == 1) {
                $data = array();
                // $data['status'] = $request->status;
                $data['package_id'] = $request->package;
                $data['package_start_date'] = date('Y-m-d');
                $data['customer_balance'] = $package_amount->amount;
                DB::table('customers')->where('id', $request->id)->update($data);

                $notification = array('message' => 'Customer Update Successfully.', 'alert_type' => 'warning');
                return redirect()->route('client.all')->with($notification);
            } else {
                $notification = array('message' => 'OPS! This Client Was Not Verified.', 'alert_type' => 'danger');
                return redirect()->back()->with($notification);
            }
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }


    // active status method 
    public function ClientActive($id)
    {

        if (Auth::guard('admin')->user()->role == 0) {
            $data = Customer::findOrFail($id);
            $status = $data->update(['status' => 1]);

            if ($status) {
                $customer = Customer::where('id', $id)->first();
                $phone = CustomerDetail::where('customer_id', $customer->id)->first()->phone;

                $post_url = "http://api.smsinbd.com/sms-api/sendsms";
                $post_values['api_token'] = "V8qsvGXfqBFhS4FozsQq7MyaeqTzXY2es6ufjQ3M";
                $post_values['senderid'] = "8801969908462";
                $post_values['message'] = "Welcome Mr/Ms " . $customer->name . "." . " We have approved you as our client, So you can now record regular balance account transactions through \"Baki-Batta\" software. Thanks for Stay with us.";
                $post_values['contact_number'] = $phone;

                $post_string = "";
                foreach ($post_values as $key => $value) {
                    $post_string .= "$key=" . urlencode($value) . "&";
                }
                $post_string = rtrim($post_string, "& ");

                $request = curl_init($post_url);
                curl_setopt($request, CURLOPT_HEADER, 0);
                curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
                curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
                $post_response = curl_exec($request);
                curl_close($request);
                json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true);

                return response()->json('Customer Activated Successfully');
            } else {
                return redirect()->back()->with('message', 'Something Went Wrong.');
            }
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }


    // not Active Status method 
    public function ClientNotActive($id)
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = Customer::findOrFail($id);
            $status = $data->update(['status' => 0]);

            if ($status) {
                $customer = Customer::where('id', $id)->first();
                $phone = CustomerDetail::where('customer_id', $customer->id)->first()->phone;

                $post_url = "http://api.smsinbd.com/sms-api/sendsms";
                $post_values['api_token'] = "V8qsvGXfqBFhS4FozsQq7MyaeqTzXY2es6ufjQ3M";
                $post_values['senderid'] = "8801969908462";
                $post_values['message'] = "Hi Mr/Ms " . $customer->name . "." . " We have temporarily disabled you as our client,So you can no longer record transactions through the \"Baki-Batta\" software. Please contact our head office for any need, Sorry for the temporary inconvenience.";
                $post_values['contact_number'] = $phone;

                $post_string = "";
                foreach ($post_values as $key => $value) {
                    $post_string .= "$key=" . urlencode($value) . "&";
                }
                $post_string = rtrim($post_string, "& ");

                $request = curl_init($post_url);
                curl_setopt($request, CURLOPT_HEADER, 0);
                curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
                curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
                $post_response = curl_exec($request);
                curl_close($request);
                json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true);

                return response()->json('Customer Not Activated Successfully');
            } else {
                return redirect()->back()->with('message', 'Something Went Wrong.');
            }
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }
    // status method ends here


    /*-------------------Customers related method start here--------------*/

    /*-------------------Customers password method start here--------------*/
    public function Forgot()
    {
        return view('admin.pages.forgot_password');
    }
    // receive the email 
    public function ForgotPassword(Request $request)
    {
        $customer = Customer::where('email', '=', $request->email)->first();
        if (!empty($customer)) {
            $customer->remember_token = Str::random(40);
            $customer->save();
            Mail::to($customer->email)->send(new ForgotPasswordMail($customer));
            $notification = array('message' => 'Please check your email and forgot your password.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        } else {
            $notification = array('message' => 'Email not found in this system.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    public function reset($token)
    {
        $customer = Customer::where('remember_token', '=', $token)->first();
        if (!empty($customer)) {
            $data['customer'] = $customer;
            return view('admin.pages.reset');
        } else {
            abort(404);
        }
    }

    public function PostReset($token, Request $request)
    {
        $customer = Customer::where('remember_token', '=', $token)->first();
        if ($request->password == $request->confirm_password) {
            $customer->password = Hash::make($request->password);
            if (empty($customer->email_verified_at)) {
                $customer->email_verified_at = date('Y-m-d H:i:s');
            }
            $customer->remember_token = Str::random(40);
            $customer->save();
            $notification = array('message' => 'Password reset successfully.', 'alert_type' => 'warning');
            return redirect()->route('login_form')->with($notification);
        } else {
            $notification = array('message' => 'Password & Confirm Password does not match.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    public function ClientDelete($id)
    {
        Customer::where('id', $id)->delete();
        CustomerDetail::where('customer_id', $id)->delete();
        Invoice::where('customer_id', $id)->delete();
        Ledger::where('customer_id', $id)->delete();
        Payment::where('customer_id', $id)->delete();
        User::where('customer_id', $id)->delete();

        return redirect()->back()->with('message', 'Customer deleted successfully.');
    }
    /*-------------------Customers password method ends here--------------*/
}
