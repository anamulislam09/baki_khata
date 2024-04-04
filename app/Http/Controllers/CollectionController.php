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
        $data['ledger'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->get();
        $data['total_amount'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->sum('amount');
        $data['total_collection'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->sum('collection');
        $data['total_due'] = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $id)->sum('due');
        return response()->json($data);
        // $data = [$users, $invoice];
        // return Response::json($data,200);
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
        if($request->collection != null){$data['collection'] = $request->collection;}
        $data['due'] = $request->collection - $request->amount;
        $data['date'] = date('d');
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
            $data['date'] = date('d');
            $data['month'] = date('m');
            $data['year'] = date('Y');
            Invoice::create($data);
        }
        return Response::json(true, 200);
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


            // $total_due = Ledger::where('customer_id', Auth::guard('admin')->user()->id)->where('user_id', $request->user_id)->sum('due');
        // $due =$total_due - $request->collection;

        $data['customer_id'] = Auth::guard('admin')->user()->id;
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        $data['user_id'] = $request->user_id;
        $data['collection'] = $request->collection;
        $data['due'] = $request->collection;
        $data['date'] = date('d');
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
            $data['date'] = date('d');
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
}
