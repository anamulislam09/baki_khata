<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\Invoice;
use App\Models\Ledger;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Response;

class CollectionController extends Controller
{
    public function Index()
    {
        $data['users'] = User::where('customer_id', Auth::guard('admin')->user()->id)->get();
        $today = date('Y-m-d');
        $data['sales'] = Sales::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $today)->orderBy('id', 'DESC')->get();

        $data['total_amount'] = Sales::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $today)->sum('sales_amount');
        $data['total_collection'] = Sales::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $today)->sum('collection');
        $data['total_due'] = Sales::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $today)->sum('due');
        return view('admin.due_collection.index', compact('data'));
    }

    public function GetCustomer($id)
    {
        $data['users'] = User::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->first();
        $data['ledger'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->orderBy('id', 'DESC')->get();
        $data['total_amount'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->sum('amount');
        $data['total_collection'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->sum('collection');
        $data['total_due'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->sum('due');
        return response()->json($data);
    }

    public function GetTransaction($date)
    {
        $data['dateAmount'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('amount');
        $data['dateCollection'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('collection');
        $data['dateDue'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('due');
        return response()->json($data);
    }

    public function storeInvoice(Request $request)
    {
        // $data = $request->all();
       $amount = abs($request->amount);
       $collection = abs($request->collection);
        $v_id = 1;
        $isExist = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->exists();

        if ($isExist) {
            $invoice_id = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->max('invoice_id');
            $invoice_id = explode('-', $invoice_id)[1];
            $data['invoice_id'] = 'INV-' . $this->formatSrl(++$invoice_id);
        } else {
            $data['invoice_id'] = 'INV-' . $this->formatSrl($v_id);
        }
        $data['customer_id'] = Auth::guard('admin')->user()->id;
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        $data['user_id'] = $request->user_id;
        $data['amount'] = $amount;
        if ($collection != null) {
            $data['collection'] = $collection;
        }
        $data['due'] = $collection - $amount;
        $data['date'] = date('Y-m-d');
        $data['month'] = date('m');
        $data['year'] = date('Y');

        $ledger = Ledger::create($data);
        if ($ledger) {
            $ledgers = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->latest()->first();
            // $amountTK = $ledgers->amount;

            $sales['customer_id'] = $ledgers->customer_id;
            $sales['auth_id'] = $ledgers->auth_id;
            $sales['user_id'] = $ledgers->user_id;
            $sales['invoice_id'] = $ledgers->invoice_id;
            $sales['sales_amount'] = $ledgers->amount;
            $sales['collection'] = $ledgers->collection;
            $sales['due'] = $ledgers->due;
            $sales['date'] = date('Y-m-d');
            $sales['month'] = date('m');
            $sales['year'] = date('Y');
            Sales::create($sales);

            $data['customer_id'] = $ledgers->customer_id;
            $data['auth_id'] = $ledgers->auth_id;
            $data['user_id'] = $ledgers->user_id;
            $data['invoice_id'] = $ledgers->invoice_id;
            $data['amount'] = $ledgers->amount;
            $data['collection'] = $ledgers->collection;
            $data['due'] = $ledgers->due;
            $data['date'] = date('Y-m-d');
            $data['month'] = date('m');
            $data['year'] = date('Y');
            $inv = Invoice::create($data);
        }
        if ($inv) {
            $phones = User::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $request->user_id)->first();
            $ledgers = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->latest()->first();
            $total_due = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $request->user_id)->sum('due');

            $word = $this->numberToWords(abs($ledgers->amount));
            $dueword = $this->numberToWords(abs($total_due));
            $message = "Total seles amount is " . $word . " And Total due amount is " . $dueword . ".";

            $userNumber = $phones->phone;
            $this->sendMessage($userNumber, $message);
        }
        $message = 'Successfully Inserted.';
        return Response::json($message, 200);
    }

    public function sendMessage($userNumber, $message)
    {

        $post_url = "http://api.smsinbd.com/sms-api/sendsms";
        $post_values['api_token'] = "V8qsvGXfqBFhS4FozsQq7MyaeqTzXY2es6ufjQ3M";
        $post_values['senderid'] = "8801969908462";
        $post_values['message'] = $message;
        $post_values['contact_number'] = $userNumber;

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
        // dd($array);
    }

    public function dueCollection(Request $request)
    {
        $data = $request->all();
        $collection = abs($request->collection);
        $v_id = 1;
        $isExist = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->exists();
        if ($isExist) {
            $invoice_id = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->max('invoice_id');
            // $data['invoice_id'] = $this->formatSrl(++$invoice_id);
            $invoice_id = explode('-', $invoice_id)[1];
            $data['invoice_id'] = 'INV-' . $this->formatSrl(++$invoice_id);
        } else {
            $data['invoice_id'] = 'INV-' . $this->formatSrl($v_id);
        }

        $data['customer_id'] = Auth::guard('admin')->user()->id;
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        $data['user_id'] = $request->user_id;
        $data['collection'] = $collection;
        $data['due'] = $collection;
        $data['date'] = date('Y-m-d');
        $data['month'] = date('m');
        $data['year'] = date('Y');
        $ledger = Ledger::create($data);
        if ($ledger) {
            $ledgers = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->latest()->first();

            $data['customer_id'] = $ledgers->customer_id;
            $data['auth_id'] = $ledgers->auth_id;
            $data['user_id'] = $ledgers->user_id;
            $data['invoice_id'] = $ledgers->invoice_id;
            $data['amount'] = $ledgers->amount;
            $data['collection'] = $ledgers->collection;
            $data['due'] = $ledgers->due;
            $data['date'] = date('Y-m-d');
            $data['month'] = date('m');
            $data['year'] = date('Y');
            $dueInv = Invoice::create($data);
        }
        if ($dueInv) {
            $phones = User::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $request->user_id)->first();
            $ledgers = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->latest()->first();
            $total_due = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $request->user_id)->sum('due');

            $word = $this->numberToWords(abs($ledgers->collection));
            $dueword = $this->numberToWords(abs($total_due));
            $message = "Total Collection amount is " . $word . " And Total due amount is " . $dueword . ".";

            $userNumber = $phones->phone;
            $this->sendMessage($userNumber, $message);
        }
        $message = 'Successfully Inserted.';
        return Response::json($message, 200);
    }

    // unique id serial function
    public function formatSrl($srl)
    {
        switch (strlen($srl)) {
            case 1:
                $zeros = '00000';
                break;
            case 2:
                $zeros = '0000';
                break;
            case 3:
                $zeros = '000';
                break;
            case 4:
                $zeros = '00';
                break;
            default:
                $zeros = '0';
                break;
        }
        return $zeros . $srl;
    }

    // Income Management generate income voucher 
    public function GenerateInv($invoice_id)
    {
        $inv = Invoice::where('customer_id', Auth::guard('admin')->user()->id)->where('invoice_id', $invoice_id)->first();
        $user = User::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $inv->user_id)->first();
        $customer = Customer::where('id', Auth::guard('admin')->user()->id)->first();
        $custDetails = CustomerDetail::where('customer_id', $customer->id)->first();

        $data = [
            'inv' => $inv,
            'user' => $user,
            'customer' => $customer,
            'custDetails' => $custDetails,
        ];
        $pdf = PDF::loadView('admin.due_collection.collection_voucher', $data);
        return $pdf->stream('Due_Collection.pdf');
    }


    // Function which returns number to words

    function numberToWords($number)
    {
        $words = array("Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine");
        $number_str = strval($number);
        $result = '';
        for ($i = 0; $i < strlen($number_str); $i++) {
            $digit = $number_str[$i];
            if ($digit >= 0 && $digit <= 9) $result .= $words[$digit] . ' ';
            if ($digit == '.') $result .= 'Point ';
        }
        return trim($result);
    }
}
