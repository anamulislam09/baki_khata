<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\Invoice;
use App\Models\Ledger;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use PDF;
use Illuminate\Support\Facades\Response;

class CollectionController extends Controller
{
    public function Index()
    {
        $users = User::where('customer_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.due_collection.index', compact('users'));
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
        // dd($date);
        $data['dateAmount'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('amount');
        $data['dateCollection'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('collection');
        $data['dateDue'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('due');
        return response()->json($data);
    }

    public function storeInvoice(Request $request)
    {
        // $data = $request->all();
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
        $data['amount'] = $request->amount;
        if ($request->collection != null) {
            $data['collection'] = $request->collection;
        }
        $data['due'] = $request->collection - $request->amount;
        $data['date'] = date('Y-m-d');
        $data['month'] = date('m');
        $data['year'] = date('Y');

        $ledger = Ledger::create($data);
        if ($ledger) {
            $ledgers = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->latest()->first();
            $amountTK = $ledgers->amount;

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

            $amountTK = $ledgers->amount;
            $word = $this->numberToWord($amountTK);
            $message = "Total seles amount is $word";

            $userNumber = $phones->phone;
           $this->sendMessage($userNumber, $message);
        }
        return Response::json(true, 200);
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
        dd($array);
    }




    public function dueCollection(Request $request)
    {
        $data = $request->all();
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
        $data['collection'] = $request->collection;
        $data['due'] = $request->collection;
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
            Invoice::create($data);
        }
        return Response::json(true, 200);
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

    // function numberToWord($num = '') {
    //     switch ($num) {
    //       case "0":
    //         return "Zerro";
    //       case "1":
    //         return "One";
    //       case "2":
    //         return "Two";
    //       case "3":
    //         return "Three";
    //       case "4":
    //         return "Four";
    //       case "5":
    //         return "Five";
    //       case "6":
    //         return "Six";
    //       case "7":
    //         return "Seven";
    //       case "8":
    //         return "Eight";
    //         default:
    //         return "Seven";
    //     }
    //   }

    function numberToWord($number)
    {
        foreach (str_split($number) as $char) {
            if ($char >= 0 && $char < 10 && (is_int($char) || ctype_digit($char))) {
                $numbers = array("Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine");
                return $numbers[$char];
            } else return $char;
        }
    }


    // function numberToWord($num = '')
    // {
    //     $num = (string) ((int) $num);

    //     if ((int) $num && ctype_digit($num)) {
    //         $words = [];

    //         $num = str_replace([',', ' '], '', trim($num));

    //         $list1 = [
    //             '',
    //             'one',
    //             'two',
    //             'three',
    //             'four',
    //             'five',
    //             'six',
    //             'seven',
    //             'eight',
    //             'nine',
    //             'ten',
    //             'eleven',
    //             'twelve',
    //             'thirteen',
    //             'fourteen',
    //             'fifteen',
    //             'sixteen',
    //             'seventeen',
    //             'eighteen',
    //             'nineteen',
    //         ];

    //         $list2 = [
    //             '',
    //             'ten',
    //             'twenty',
    //             'thirty',
    //             'forty',
    //             'fifty',
    //             'sixty',
    //             'seventy',
    //             'eighty',
    //             'ninety',
    //             'hundred',
    //         ];

    //         $list3 = [
    //             '',
    //             'thousand',
    //             'million',
    //             'billion',
    //             'trillion',
    //             'quadrillion',
    //             'quintillion',
    //             'sextillion',
    //             'septillion',
    //             'octillion',
    //             'nonillion',
    //             'decillion',
    //             'undecillion',
    //             'duodecillion',
    //             'tredecillion',
    //             'quattuordecillion',
    //             'quindecillion',
    //             'sexdecillion',
    //             'septendecillion',
    //             'octodecillion',
    //             'novemdecillion',
    //             'vigintillion',
    //         ];

    //         $num_length = strlen($num);
    //         $levels = (int) (($num_length + 2) / 3);
    //         $max_length = $levels * 3;
    //         $num = substr('00' . $num, -$max_length);
    //         $num_levels = str_split($num, 3);

    //         foreach ($num_levels as $num_part) {
    //             $levels--;
    //             $hundreds = (int) ($num_part / 100);
    //             $hundreds = $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '';
    //             $tens = (int) ($num_part % 100);
    //             $singles = '';

    //             if ($tens < 20) {
    //                 $tens = $tens ? ' ' . $list1[$tens] . ' ' : '';
    //             } else {
    //                 $tens = (int) ($tens / 10);
    //                 $tens = ' ' . $list2[$tens] . ' ';
    //                 $singles = (int) ($num_part % 10);
    //                 $singles = ' ' . $list1[$singles] . ' ';
    //             }
    //             $words[] =
    //                 $hundreds . $tens . $singles . ($levels && (int) $num_part ? ' ' . $list3[$levels] . ' ' : '');
    //         }
    //         $commas = count($words);
    //         if ($commas > 1) {
    //             $commas = $commas - 1;
    //         }

    //         $words = implode(', ', $words);

    //         $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
    //         if ($commas) {
    //             $words = str_replace(',', ' and', $words);
    //         }

    //         return $words;
    //     } elseif (!((int) $num)) {
    //         return 'Zero';
    //     }
    //     return '';
    // }
}
